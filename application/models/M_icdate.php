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

    public function getIcDates($order = 'ASC')
    {
        $query = $this->db
            ->select("*")
            ->where ('strategyNo', 1)
            ->from('icdate')
            ->order_by('icDate', $order)
            ->get();
        return $query->result_array();
    }

    /**
     * @param $icDate
     * @return int
     */
    public function checkIfIcDateExist($icDate)
    {
        $query = $this->db
            ->select("icDateID")
            ->where ('strategyNo', 1)
            ->where ('icDate', $icDate)
            ->from('icdate')
            ->get();
        return $query->num_rows();
    }

    /**
     * @param $icDate
     * @return int
     */
    public function getPortfolioCount($icDate)
    {
        $return = 0;
        $query = $this->db
            ->select("portfolioCount")
            ->where ('strategyNo', 1)
            ->where ('icDate', $icDate)
            ->from('icdate')
            ->get();
        if($query->num_rows() > 0){
            $result = $query->result_array();
            $return = $result[0]['portfolioCount'];
        }
        return $return;
    }

}