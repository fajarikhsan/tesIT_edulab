<?php

class Payment_model extends CI_Model
{
    public function insertPayment($data)
    {
        $this->db->insert('payment', $data);
    }

    public function updatePayment($data, $id)
    {
        $this->db->where('student_id', $id)
            ->update('payment', $data);
    }

    public function getPayment($order_id)
    {
        return $this->db->get_where('payment', ['order_id' => $order_id])->row_array();
    }

    public function isExist($user_id)
    {
        return $this->db->from('students')
            ->join('payment', 'students.id = payment.student_id', 'inner')
            ->where('user_id', $user_id)
            ->get()
            ->row_array();
    }
}
