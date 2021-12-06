<?php

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Student_model');
        $this->load->model('Payment_model');
        // Set your Merchant Server Key
        Config::$serverKey = 'SB-Mid-server-Zy_Cg31Mlhkp1CHZrMCVWS67';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = false;
    }

    public function index()
    {
        $getData = $this->Student_model->getStudentPayments();
        $payments = [];
        foreach ($getData as $row) {
            $temp = [];
            $temp['user_id'] = $row['user_id'];
            $temp['sisa_tagihan'] = ($row['total_biaya'] - $row['potongan']) - ($row['dp'] + $row['angsuran_1'] + $row['angsuran_2']);
            if ($row['order_id'] == '' || $row['order_id'] == null) {
                $temp['invoice'] = '-';
                $temp['total_pembayaran'] = '-';
                $temp['status_transaksi'] = '-';
                if ($temp['sisa_tagihan'] == 0) {
                    $temp['status'] = 'PAID';
                } else {
                    $temp['status'] = 'UNPAID';
                }
            } else {
                $status = (object) Transaction::status($row['order_id']);
                $temp['invoice'] = $status->order_id;
                $temp['status_transaksi'] = $status->transaction_status;
                if ($status->transaction_status == 'capture' || $status->transaction_status == 'settlement') {
                    $temp['total_pembayaran'] = $status->gross_amount;
                    $temp['status'] = 'PAID';
                } else {
                    $temp['total_pembayaran'] = '-';
                    $temp['status'] = 'UNPAID';
                }
            }
            $payments[] = $temp;
        }
        $data = [
            'title' => 'Tampilan Admin',
            'payments' => $payments
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('pages/admin', $data);
        $this->load->view('templates/footer', $data);
    }

    public function test() {
        echo "THIS IS A TEST";
    }
}
