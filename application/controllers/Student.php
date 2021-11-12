<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Student_model');
        $this->load->library('Pdf');
    }

    public function index()
    {
        $getStudents = $this->Student_model->getAllStudents();
        $students = [];
        foreach ($getStudents as $row) {
            $temp = [];
            $temp['user_id'] = $row['user_id'];
            $temp['cabang_belajar'] = $row['cabang_belajar'];
            $temp['total_biaya'] = $row['total_biaya'];
            $temp['potongan'] = $row['potongan'];
            $temp['dp'] = $row['dp'];
            $temp['angsuran_1'] = $row['angsuran_1'];
            $temp['angsuran_2'] = $row['angsuran_2'];
            $temp['price'] = $row['total_biaya'] - $row['potongan'];
            $temp['arp'] = $row['dp'] + $row['angsuran_1'] + $row['angsuran_2'];
            $temp['aro'] = $temp['price'] - $temp['arp'];
            if ($temp['aro'] == 0) {
                $temp['status'] = 'SUDAH LUNAS';
            } else {
                $temp['status'] = 'BELUM LUNAS';
            }
            $temp['persentase'] = round(($temp['arp'] / $temp['price']) * 100, 2);
            $students[] = $temp;
        }
        $data = [
            'title' => 'Data Murid',
            'students' => $students
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('pages/students', $data);
        $this->load->view('templates/footer', $data);
    }

    public function upload_data()
    {
        $config['upload_path'] = './assets/uploads';
        $config['allowed_types'] = 'xls|xlsx|xlsm|xlsb';

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('uploadExcel')) {
            // GAGAL UPLOAD
            $this->session->set_flashdata('upload-failed', 'Upload');
            redirect(base_url('Student'));
        } else {
            // BERHASIL UPLOAD
            $path = $this->upload->data('full_path');
            $extension = $this->upload->data('file_ext');
            if ($extension == '.csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ($extension == '.xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }
            $spreadsheet = $reader->load($path);
            $dataSheet = $spreadsheet->getActiveSheet();
            $highestRow = $dataSheet->getHighestRow();
            for ($row = 3; $row <= $highestRow; $row++) {
                $user_id = $dataSheet->getCellByColumnAndRow(1, $row)->getValue();
                $cabang_belajar = $dataSheet->getCellByColumnAndRow(2, $row)->getValue();
                $total_biaya = $dataSheet->getCellByColumnAndRow(3, $row)->getValue();
                $potongan = $dataSheet->getCellByColumnAndRow(4, $row)->getValue();
                $dp = $dataSheet->getCellByColumnAndRow(5, $row)->getValue();
                $angsuran_1 = $dataSheet->getCellByColumnAndRow(6, $row)->getValue();
                $angsuran_2 = $dataSheet->getCellByColumnAndRow(7, $row)->getValue();

                if ($user_id != null || $user_id != '') {
                    $data[] = [
                        'user_id' => $user_id,
                        'cabang_belajar' => $cabang_belajar,
                        'total_biaya' => ($total_biaya == null || $total_biaya == '') ? '0' : $total_biaya,
                        'potongan' => ($potongan == null || $potongan == '') ? '0' : $potongan,
                        'dp' => ($dp == null || $dp == '') ? '0' : $dp,
                        'angsuran_1' => ($angsuran_1 == null || $angsuran_1 == '') ? '0' : $angsuran_1,
                        'angsuran_2' => ($angsuran_2 == null || $angsuran_2 == '') ? '0' : $angsuran_2
                    ];
                }
            }
            // var_dump($data);
            $this->Student_model->import($data);
        }
        $this->session->set_flashdata('upload-success', 'Upload');
        redirect(base_url('Student'));
    }

    public function cekInvoice()
    {
        $this->load->view('invoice/invoice');
    }

    public function invoice()
    {
        $pdf = new FPDF('L', 'mm', 'Letter');

        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 15);

        $pdf->AddPage();
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->Cell(140, 5, 'TAGIHAN KEPADA', 0, 0);
        $pdf->Cell(140, 5, 'TANGGAL', 0, 2);
        $pdf->Ln();
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(140, 5, $this->input->post('user_id'), 0, 0);
        $pdf->Cell(140, 5, date('d-m-Y'), 2, 0);
        $pdf->Line(10, 80, 279.4 - 10, 80);
        $pdf->Ln(15);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(20, 10, 'No', 'B', 0, 'C');
        $pdf->Cell(120, 10, 'Deskripsi', 'B', 0, 'C');
        $pdf->Cell(120, 10, 'Harga', 'B', 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(20, 10, '1', 'B', 0, 'C');
        $pdf->Cell(120, 10, 'Paket Pembelajaran Edulab', 'B', 0, 'C');
        $pdf->Cell(120, 10, 'Rp ' . number_format($this->input->post('total_biaya')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(140, 10, 'Subtotal', 'B', 0, 'R');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(120, 10, 'Rp ' . number_format($this->input->post('total_biaya')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(140, 10, 'Potongan', 'B', 0, 'R');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(120, 10, 'Rp ' . number_format($this->input->post('potongan')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(140, 10, 'Total', 'B', 0, 'R');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(120, 10, 'Rp ' . number_format($this->input->post('total')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(140, 10, 'Pembayaran Diterima', 'B', 0, 'R');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(120, 10, 'Rp ' . number_format($this->input->post('sudah_dibayar')), 'B', 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(140, 10, 'Sisa Tagihan', 'B', 0, 'R');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(120, 10, 'Rp ' . number_format($this->input->post('sisa_tagihan')), 'B', 0, 'R');
        $pdf->Output('D', $this->input->post('user_id') . '_INVOICE.pdf');
    }
}
