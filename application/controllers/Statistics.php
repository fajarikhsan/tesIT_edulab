<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Statistics extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Student_model');
    }
    public function index()
    {
        $data = [
            'title' => 'Resume Statistik'
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('pages/statistics', $data);
        $this->load->view('templates/footer', $data);
    }

    public function userCountByBranch()
    {
        $res = $this->Student_model->getUserCountByBranch();
        $data = [];
        foreach ($res as $row) {
            $temp = [];
            $temp['label'] = $row['cabang_belajar'];
            $temp['y'] = (int)$row['banyak_user'];
            $data[] = $temp;
        }
        echo json_encode($data);
    }

    public function paidUserByBranch()
    {
        $res = $this->Student_model->getPaidUserByBranch();
        $data = [];
        foreach ($res as $row) {
            $temp = [];
            $temp['label'] = $row['cabang_belajar'];
            $temp['y'] = (int)$row['sudah_lunas'];
            $data[] = $temp;
        }
        echo json_encode($data);
    }

    public function unpaidUserByBranch()
    {
        $res = $this->Student_model->getUnpaidUserByBranch();
        $data = [];
        foreach ($res as $row) {
            $temp = [];
            $temp['label'] = $row['cabang_belajar'];
            $temp['y'] = (int)$row['belum_lunas'];
            $data[] = $temp;
        }
        echo json_encode($data);
    }

    public function totalAfterDiscount()
    {
        $res = $this->Student_model->getTotalAfterDiscount();
        $data = [];
        foreach ($res as $row) {
            $temp = [];
            $temp['label'] = $row['cabang_belajar'];
            $temp['y'] = (int)$row['total_yang_harus_dibayar'];
            $temp['indexLabel'] = 'Rp ' . $row['total_yang_harus_dibayar'];
            $data[] = $temp;
        }
        echo json_encode($data);
    }

    public function totalPaid()
    {
        $res = $this->Student_model->getTotalPaid();
        $data = [];
        foreach ($res as $row) {
            $temp = [];
            $temp['label'] = $row['cabang_belajar'];
            $temp['y'] = (int)$row['total_yang_sudah_dibayar'];
            $temp['indexLabel'] = 'Rp ' . $row['total_yang_sudah_dibayar'];
            $data[] = $temp;
        }
        echo json_encode($data);
    }

    public function totalUnpaid()
    {
        $res = $this->Student_model->getTotalUnpaid();
        $data = [];
        foreach ($res as $row) {
            $temp = [];
            $temp['label'] = $row['cabang_belajar'];
            $temp['y'] = (int)$row['total_yang_belum_dibayar'];
            $temp['indexLabel'] = 'Rp ' . $row['total_yang_belum_dibayar'];
            $data[] = $temp;
        }
        echo json_encode($data);
    }

    public function paidPercentage()
    {
        $getStudents = $this->Student_model->getAllStudents();
        $moreThan = [];
        $lessThan = [];
        foreach ($getStudents as $row) {
            $temp = [];
            $temp['price'] = $row['total_biaya'] - $row['potongan'];
            $temp['arp'] = $row['dp'] + $row['angsuran_1'] + $row['angsuran_2'];
            $temp['persentase'] = round(($temp['arp'] / $temp['price']) * 100, 2);
            if ($temp['persentase'] >= 50) {
                $moreThan[] = $temp;
            } else {
                $lessThan[] = $temp;
            }
        }
        $data = [];
        $data[] = [
            'label' => '> 50%',
            'y' => sizeof($moreThan)
        ];
        $data[] = [
            'label' => '< 50%',
            'y' => sizeof($lessThan)
        ];
        echo json_encode($data);
    }

    public function export()
    {
        $userCount = $this->Student_model->getUserCountByBranch();
        $paidUser = $this->Student_model->getPaidUserByBranch();
        $unpaidUser = $this->Student_model->getUnpaidUserByBranch();
        $totalDisc = $this->Student_model->getTotalAfterDiscount();
        $totalPaid = $this->Student_model->getTotalPaid();
        $totalUnpaid = $this->Student_model->getTotalUnpaid();
        $paidPercentage = $this->Student_model->getPaidPercentage();
        $arrayTemp = array_map(null, $userCount, $paidUser, $unpaidUser, $totalDisc, $totalPaid, $totalUnpaid, $paidPercentage);
        $data = [];
        foreach ($arrayTemp as $row) {
            $temp = [];
            $temp[] = array_merge($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
            $data[] = $temp[0];
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $column_header = ['Cabang Belajar', 'Banyak User', 'Sudah Lunas', 'Belum Lunas', 'Total Biaya - Potongan', 'Sudah Dibayar', 'Belum Dibayar', 'Bayar >= 50%', 'Bayar < 50%'];
        // Write header
        $i = 1;
        foreach ($column_header as $row) {
            $sheet->setCellValueByColumnAndRow($i, 1, $row);
            $i++;
        }
        // Write content
        $j = 2;
        foreach ($data as $row) {
            $x = 1;
            foreach ($row as $col_value) {
                $sheet->setCellValueByColumnAndRow($x, $j, $col_value);
                $x++;
            }
            $j++;
        }
        // export 
        $writer = new Xlsx($spreadsheet);

        // Save .xlsx file to the files directory 
        $writer->save('laporan/laporan.xlsx');

        $this->session->set_flashdata('export-success', 'Export');
        redirect(base_url('statistics'));
    }
}
