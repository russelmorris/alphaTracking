<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_icdate extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIcDates()
    {
        $query = $this->db
            ->select("*")
            ->where ('strategyNo', 1)
            ->from('icdate')
            ->order_by('icDate', 'ASC')
            ->get();
        return $query->result_array();
    }

}