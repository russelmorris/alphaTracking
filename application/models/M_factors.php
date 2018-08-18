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

    /**
     * @param $user
     * @param $icDate
     * @return array
     */
    public function getFactorWeights($user, $icDate)
    {

        $query = $this->db
            ->select("*")
            ->where('strategyNo', 1)
            ->where('memberNo', $user)
            ->where('icDate', $icDate)
            ->from('factorWeights')
            ->get();
        return $query->result_array();
    }

    /**
     * @param $factorNo
     * @param $memberNo
     * @param $icDate
     * @param $factorWeight
     */
    public function updateFactorWeights($factorNo, $memberNo, $icDate, $factorWeight){
        $this->db
            ->set('factorWeight',$factorWeight)
            ->where([
                'memberNo'   => $memberNo,
                'icDate'     => $icDate,
                'factorNo'   => $factorNo
            ])
            ->limit(1)
            ->update('factorWeights');

    }

}