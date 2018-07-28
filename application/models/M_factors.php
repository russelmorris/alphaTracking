<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_factors extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllFactors()
    {

        $query = $this->db
            ->select("*")
            ->where('strategyNo', 1)
            ->where('isActive', 1)
            ->from('factors')
            ->get();
        return $query->result_array();
    }

}