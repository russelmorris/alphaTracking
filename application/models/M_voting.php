<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_voting extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertProspect($data, $masterID, $member, $factor)
    {
        $return = false;

        $insertData = [
            'strategyNo' => 1,
            "masterID" => $masterID,
            'prospectTextID' =>$data['ticker'].'-'.$data['country'].'-'.$data['icDate'],
            "icDate" => $data['icDate'],
            "ticker"  => $data['ticker'],
            "memberNo"  => $member['memberNo'],
            "memberName"  => $member['memberName'],
            "factorNo"  => $factor['factorNo'],
            "factorDesc"  => $factor['factorDesc'],
            "factorScore"  => 5,
            "zScore"  => 0,
            "dateModified" => date("Y-m-d H:i:s"),
        ];
        if ( $this->db->insert('voting', $insertData ) ){
            $return =  true;
        }
        return $return;
    }

    public function updateFactor($user_id, $ticker, $masterID, $factorNo, $factorVal)
    {
        $this->db->set('factorScore', $factorVal)
            ->where([
                'memberNo' => $user_id,
                'ticker'   => $ticker,
                'masterID' => $masterID,
                'factorNo' => $factorNo
            ])
            ->update('voting');
    }

}