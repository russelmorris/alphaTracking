<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertProspect($data, $member)
    {
        $masterID   = 0;
        $insertData = [
            'strategyNo'     => 1,
            "icDate"         => $data['icDate'],
            "DateModified"   => date("Y-m-d"),
            'prospectTextID' => $data['ticker'] . '-' . $data['country'] . '-' . $data['icDate'],
            "ticker"         => $data['ticker'],
            "RIC"            => $data['RIC'],
            "name"           => $data['name'],
            "country"        => $data['country'],
            "sector"         => $data['sector'],
            "machineScore"   => $data['machineScore'],
            "memberNo"       => $member['memberNo'],
            "memberName"     => $member['memberName'],
            "bWeight"        => $member['bWeight'],
            "isActive"       => 1
        ];
        if ($this->db->insert('master', $insertData)) {
            $masterID = $this->db->insert_id();
        }

        return $masterID;
    }

    public function setVetoFlag($user_id, $ticker, $veto)
    {
        $this->db->set('vetoFlag', $veto)
                 ->where(['memberNo' => $user_id, 'ticker' => $ticker])
                 ->update('master');

    }

    public function setFinaliseFlag($user_id, $ticker, $finalised)
    {
        $this->db->set('isFinalised', $finalised)
                 ->where(['memberNo' => $user_id, 'ticker' => $ticker])
                 ->update('master');

    }

    public function finalised($user_id)
    {
        $return  = false;
        $final   = $this->db->select('isFinalised')
                            ->where('isFinalised', 1)
                            ->where('memberNo', $user_id)
                            ->from('master')
                            ->get()
                            ->num_rows();

        $overall = $this->db->select('isFinalised')
                            ->where('memberNo', $user_id)
                            ->from('master')
                            ->get()
                            ->num_rows();
        if ($final > 0 && $overall > 0) {
            $return = ($final / $overall) * 100;
        }

        return $return;
    }


}