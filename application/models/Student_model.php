<?php

class Student_model extends CI_Model
{
    public function import($data)
    {
        $this->db->insert_batch('students', $data);
    }

    public function getAllStudents()
    {
        return $this->db->query('SELECT * FROM students')->result_array();
    }

    public function getUserCountByBranch()
    {
        return $this->db->query('SELECT cabang_belajar,count(user_id) AS banyak_user FROM students GROUP BY cabang_belajar')->result_array();
    }

    public function getPaidUserByBranch()
    {
        return $this->db->query('SELECT cabang_belajar, COUNT(user_id) AS sudah_lunas
        FROM students
        WHERE (total_biaya-(potongan+dp+angsuran_1+angsuran_2)) = 0
        GROUP BY cabang_belajar')->result_array();
    }

    public function getUnpaidUserByBranch()
    {
        return $this->db->query('SELECT cabang_belajar, COUNT(user_id) AS belum_lunas
        FROM students
        WHERE (total_biaya-(potongan+dp+angsuran_1+angsuran_2)) != 0
        GROUP BY cabang_belajar')->result_array();
    }

    public function getTotalAfterDiscount()
    {
        return $this->db->query('SELECT cabang_belajar, SUM(total) AS total_yang_harus_dibayar
        FROM (SELECT (total_biaya-potongan) AS total, cabang_belajar
        FROM students) AS totals
        GROUP BY cabang_belajar')->result_array();
    }

    public function getTotalPaid()
    {
        return $this->db->query('SELECT cabang_belajar, SUM(total) AS total_yang_sudah_dibayar
        FROM (SELECT (dp+angsuran_1+angsuran_2) AS total, cabang_belajar
        FROM students) AS totals
        GROUP BY cabang_belajar')->result_array();
    }

    public function getTotalUnpaid()
    {
        return $this->db->query('SELECT cabang_belajar, SUM(total) AS total_yang_belum_dibayar
        FROM (SELECT (total_biaya-(potongan+dp+angsuran_1+angsuran_2)) AS total, cabang_belajar
        FROM students) AS totals
        GROUP BY cabang_belajar')->result_array();
    }

    public function getPaidPercentage()
    {
        return $this->db->query('SELECT t1.cabang_belajar, t1.more_than, t2.less_than
        FROM
        (SELECT COUNT(user_id) AS more_than, cabang_belajar
        FROM students
        WHERE (((dp+angsuran_1+angsuran_2)/(total_biaya-potongan))*100) >= 50
        GROUP BY cabang_belajar) t1
        JOIN 
        (SELECT COUNT(user_id) AS less_than, cabang_belajar
        FROM students
        WHERE (((dp+angsuran_1+angsuran_2)/(total_biaya-potongan))*100) < 50
        GROUP BY cabang_belajar) t2
        ON t1.cabang_belajar = t2.cabang_belajar')->result_array();
    }

    public function getStudentById($user_id)
    {
        return $this->db->get_where('students', ['user_id' => $user_id])->row_array();
    }

    public function getStudentPayments()
    {
        return $this->db->select('*')
            ->from('students')
            ->join('payment', 'students.id = payment.student_id', 'left')
            ->get()
            ->result_array();
    }
}
