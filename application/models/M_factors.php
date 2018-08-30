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
        $orderArray = [
            1, //'Business model',
            4,//'Growth Sustainability',
            2,//'Business valuation',
            3,//'Digital Footprint',
            5,//'Overall Momentum Likely to Continue',
            6,//'Risk (execution, roll out, operational)'
           ];
        $query = $this->db
            ->select("*")
            ->where('strategyNo', 1)
            ->where('memberNo', $user)
            ->where('icDate', $icDate)
            ->from('factorWeights')
            ->get();
        $result = $query->result_array();
            $ordered = [];
            foreach ($orderArray as $key){
                foreach ($result as $factor){
                    if($factor['factorNo'] == $key){
                        $ordered[]=$factor;

                    }
                }

            }
        return $ordered;

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

    public function getAllActiveFactors()
    {

        $query = $this->db
            ->select("*")
            ->where('strategyNo', 1)
            ->where('isActive', 1)
            ->where('includeDashboard', 1)
            ->order_by('factorOrder', 'asc')
            ->from('factors')
            ->get();
        return $query->result_array();
    }

}