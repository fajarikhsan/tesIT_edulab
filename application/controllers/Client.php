<?php

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;

defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Student_model');
        $this->load->model('Payment_model');
        $this->load->library('Pdf');
        // Set your Merchant Server Key
        Config::$serverKey = 'SB-Mid-server-Zy_Cg31Mlhkp1CHZrMCVWS67';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = false;
    }

    public function index($user_id)
    {
        $getStudent = $this->Student_model->getStudentById($user_id);
        $getStudent['arp'] = $getStudent['dp'] + $getStudent['angsuran_1'] + $getStudent['angsuran_2'];
        $getStudent['sisa_tagihan'] = ($getStudent['total_biaya'] - $getStudent['potongan']) - ($getStudent['dp'] + $getStudent['angsuran_1'] + $getStudent['angsuran_2']);
        if (!empty($this->Payment_model->isExist($getStudent['user_id']))) {
            if ($this->getTransactionStatus($this->Payment_model->isExist($getStudent['user_id'])['order_id']) == 'capture' || $this->getTransactionStatus($this->Payment_model->isExist($getStudent['user_id'])['order_id']) == 'settlement') {
                $status = 'PAID';
            } else {
                $status = 'UNPAID';
            }
        } else if ($getStudent['sisa_tagihan'] == 0) {
            $status = 'PAID';
        } else {
            $status = 'UNPAID';
        }
        $data = [
            'title' => 'Client Area',
            'student' => $getStudent,
            'order_id' => (empty($this->Payment_model->isExist($getStudent['user_id']))) ? '1234-5678-' . $getStudent['user_id'] : $this->Payment_model->isExist($getStudent['user_id'])['order_id'],
            'isPaid' => $status
        ];
        $this->load->view('pages/client', $data);
    }

    public function client_options()
    {
        $data = [
            'title' => 'Pilihan tampilan client',
            'students' => $this->Student_model->getAllStudents()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('pages/client_opt', $data);
        $this->load->view('templates/footer', $data);
    }

    public function paymentProccess()
    {
        // cek history transaksi
        if ($this->getTransactionStatus($this->input->post('order_id')) != false) {
            if ($this->getTransactionStatus($this->input->post('order_id')) != 'capture' || $this->getTransactionStatus($this->input->post('order_id')) != 'settlement') {
                $order_id = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . $this->input->post('user_id');
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $order_id,
                        'gross_amount' => (int) $this->input->post('gross_amount'),
                    ),
                    'customer_details' => array(
                        'first_name' => $this->input->post('user_id')
                    )
                );
                // create transaction
                $snapToken = Snap::getSnapToken($params);
                echo json_encode($snapToken);
            }
        } else {
            $params = array(
                'transaction_details' => array(
                    'order_id' => $this->input->post('order_id'),
                    'gross_amount' => (int) $this->input->post('gross_amount'),
                ),
                'customer_details' => array(
                    'first_name' => $this->input->post('user_id')
                )
            );
            // create transaction
            $snapToken = Snap::getSnapToken($params);
            echo json_encode($snapToken);
        }
    }

    public function getTransactionStatus($order_id)
    {
        try {
            $status = (object) Transaction::status($order_id);
            return $status->transaction_status;
        } catch (Exception $e) {
            return false;
        }
    }

    public function recordOrder()
    {
        if (empty($this->Payment_model->isExist($this->input->post('user_id')))) {
            $data = [
                'order_id' => $this->input->post('order_id'),
                'student_id' => $this->input->post('student_id'),
                'token' => $this->input->post('token')
            ];
            $this->Payment_model->insertPayment($data);
        } else {
            $data = [
                'order_id' => $this->input->post('order_id'),
                'token' => $this->input->post('token')
            ];
            $this->Payment_model->updatePayment($data, $this->input->post('student_id'));
        }
    }

    public function printPayment()
    {
        $pdf = new FPDF('L', 'mm', 'Letter');

        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 15);

        $pdf->AddPage();
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->Cell(200, 5, 'INVOICE', 0, 0);
        $pdf->SetFillColor(25, 135, 84);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Helvetica', 'B', 16);
        $pdf->MultiCell(50, 10, 'PAID', 0, 'C', true);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(140, 5, 'Nomor Invoice : ' . $this->input->post('nomor_invoice'), 2, 0);
        $pdf->Ln();
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(140, 5, 'Due Date : ' . date('d/m/Y', strtotime('+ 7 days')), 2, 0);
        $pdf->Ln(10);
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(140, 5, 'Tagihan Untuk : ', 2, 0);
        $pdf->Ln();
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(140, 5, $this->input->post('user_id'), 2, 0);
        $pdf->Ln(10);
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(140, 5, 'Detail Invoice', 2, 0);
        $pdf->Ln(10);
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(130, 10, 'Biaya', 'B', 0, 'L');
        $pdf->Cell(130, 10, 'Rp ' .  number_format($this->input->post('total_biaya')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->Cell(130, 10, 'Potongan', 'B', 0, 'L');
        $pdf->Cell(130, 10, 'Rp ' . number_format($this->input->post('potongan')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->Cell(130, 10, 'Sudah Dibayar', 'B', 0, 'L');
        $pdf->Cell(130, 10, 'Rp ' . number_format($this->input->post('sudah_dibayar')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->Cell(130, 10, 'Sisa Tagihan', 'B', 0, 'L');
        $pdf->Cell(130, 10, 'Rp ' . number_format($this->input->post('sisa_tagihan')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->Cell(130, 10, 'Total Pembayaran', 'B', 0, 'L');
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->Cell(130, 10, 'Rp ' . number_format($this->input->post('sisa_tagihan')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->Output('D', $this->input->post('user_id') . '_BUKTI PEMBAYARAN.pdf');
    }
}
