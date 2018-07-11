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

    public function setVetoFlag($user_id, $ticker, $ic_date)
    {
        $setVetoFlagValue = 0;
        $oldVetoFlag = $this->db->select('vetoFlag')
            ->where('memberNo', $user_id)
            ->where('ticker', $ticker)
            ->where('icDate', $ic_date)
            ->where('strategyNo', 1)
            ->from('master')
            ->get()->result_array();
        if (count($oldVetoFlag) > 0){
            $setVetoFlagValue = ($oldVetoFlag[0]['vetoFlag'] == 1) ? 0: 1;
            $this->db->set('vetoFlag', $setVetoFlagValue)
                ->where(['memberNo' => $user_id, 'ticker' => $ticker, 'icDate' => $ic_date])
                ->update('master');
        }
        return $setVetoFlagValue;
    }

    public function setFinaliseFlag($user_id, $ticker, $ic_date)
    {
        $setFinaliseValue = 0;
        $oldVetoFlag = $this->db->select('isFinalised')
            ->where('memberNo', $user_id)
            ->where('ticker', $ticker)
            ->where('icDate', $ic_date)
            ->where('strategyNo', 1)
            ->from('master')
            ->get()->result_array();
        if (count($oldVetoFlag) > 0){
            $setFinaliseValue = ($oldVetoFlag[0]['isFinalised'] == 1) ? 0: 1;
            $this->db->set('isFinalised', $setFinaliseValue)
                ->where(['memberNo' => $user_id, 'ticker' => $ticker, 'icDate' => $ic_date])
                ->update('master');
        }
        return $setFinaliseValue;
    }


    public function finalised($user_id)
    {
        $return = false;
        $final  = $this->db->select('isFinalised')
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