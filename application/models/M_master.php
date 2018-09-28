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
        $masterID     = 0;
        $prospectData = [
            'strategyNo'     => 1,
            "icDate"         => $data['icDate'],
            "DateModified"   => date("Y-m-d"),
            'prospectTextID' => str_replace(" ", "",
                strtolower($data['icDate'] . '-' . $data['ticker'] . '-' . $data['country'])),
            "ticker"         => $data['ticker'],
            "RIC"            => $data['RIC'],
            "name"           => $data['name'],
            "country"        => $data['country'],
            "sector"         => $data['sector'],
            "machineScore"   => $data['machineScore'],
            "machineRank"    => $data['machineRank'],
            "machineScore2"  => $data['machineScore2'],
            "machineRank2"   => $data['machineRank2'],
            "machineScore3"  => $data['machineScore3'],
            "machineRank3"   => $data['machineRank3'],
            "tag"            => $data['tag'],
            "memberNo"       => $member['memberNo'],
            "memberName"     => $member['memberName'],
            "bWeight"        => $member['bWeight'],
            "isActive"       => array_key_exists('isActive', $member )? $member['isActive'] :  1
        ];

        //check if we have already inserted
        //check if prospect exist in database
        $query = $this->db
            ->select("masterID")
            ->where('strategyNo', 1)
            ->where('ticker', $prospectData['ticker'])
            ->where('icDate', $prospectData['icDate'])
            ->where('country', $prospectData['country'])
            ->where('memberNo', $member['memberNo'])
            ->from('master')
            ->get();

        if ($query->num_rows() == 0) {
            if ($this->db->insert('master', $prospectData)) {
                $masterID = $this->db->insert_id();
            }
        } else {
            $result   = $query->result_array();
            $masterID = $result[0]['masterID'];

            $this->db
                ->set("strategyNo", $prospectData['strategyNo'])
                ->set("icDate", $prospectData['icDate'])
                ->set("DateModified", $prospectData['DateModified'])
                ->set("prospectTextID", $prospectData['prospectTextID'])
                ->set("ticker", $prospectData['ticker'])
                ->set("RIC", $prospectData['RIC'])
                ->set("name", $prospectData['name'])
                ->set("country", $prospectData['country'])
                ->set("sector", $prospectData['sector'])
                ->set("machineScore", $prospectData['machineScore'])
                ->set("machineRank", $prospectData['machineRank'])
                ->set("machineScore2", $prospectData['machineScore2'])
                ->set("machineRank2", $prospectData['machineRank2'])
                ->set("machineScore3", $prospectData['machineScore3'])
                ->set("machineRank3", $prospectData['machineRank3'])
                ->set("memberNo", $prospectData['memberNo'])
                ->set("memberName", $prospectData['memberName'])
                ->set("bWeight", $prospectData['bWeight'])
                ->set("isActive", $prospectData['isActive'])
                ->set("tag", $prospectData['rag'])
                ->where('masterID', $masterID)
                ->update('master');
        }

        return $masterID;
    }

    public function setVetoFlag($user_id, $masterID, $ic_date)
    {
        $setVetoFlagValue = 0;
        $oldVetoFlag      = $this->db->select('vetoFlag')
                                     ->where('memberNo', $user_id)
                                     ->where('masterID', $masterID)
                                     ->where('icDate', $ic_date)
                                     ->where('strategyNo', 1)
                                     ->from('master')
                                     ->get()->result_array();
        if (count($oldVetoFlag) > 0) {
            $setVetoFlagValue = ($oldVetoFlag[0]['vetoFlag'] == 1) ? 0 : 1;
            $this->db
                ->set('vetoFlag', $setVetoFlagValue)
                ->set('DateModified', date('Y-m-d'))
                ->where(['memberNo' => $user_id, 'masterID' => $masterID, 'icDate' => $ic_date])
                ->update('master');
        }

        return $setVetoFlagValue;
    }

    public function setVetoComment($user_id, $ticker, $ic_date, $setVetoCommentValue)
    {
        return $this->db
            ->set('vetoComment', $setVetoCommentValue)
            ->set('DateModified', date('Y-m-d'))
            ->where(['memberNo' => $user_id, 'ticker' => $ticker, 'icDate' => $ic_date])
            ->update('master');

    }


    public function setFinaliseFlag($user_id, $masterID, $ic_date)
    {
        $setFinaliseValue = 0;
        $oldVetoFlag      = $this->db->select('isFinalised')
                                     ->where('strategyNo', 1)
                                     ->where('memberNo', $user_id)
                                     ->where('masterID', $masterID)
                                     ->where('icDate', $ic_date)
                                     ->from('master')
                                     ->get()->result_array();
        if (count($oldVetoFlag) > 0) {
            $setFinaliseValue = ($oldVetoFlag[0]['isFinalised'] == 1) ? 0 : 1;
            $this->db
                ->set('isFinalised', $setFinaliseValue)
                ->set('DateModified', date('Y-m-d'))
                ->where(['memberNo' => $user_id, 'masterID' => $masterID, 'icDate' => $ic_date])
                ->update('master');
        }

        return $setFinaliseValue;
    }

    public function setAllFinaliseFlag($user_id, $ic_date, $finalized)
    {
        $finalized = ($finalized == 100) ? 0 : 1;

        $this->db
            ->set('isFinalised', $finalized)
            ->set('DateModified', date('Y-m-d'))
            ->where(['memberNo' => $user_id, 'icDate' => $ic_date])
            ->update('master');
        return true;
    }


    public function finalised($user_id, $icDate)
    {
        $data = [
            'overall' => 0,
            'percent' => 0.00
        ];
        $return = 0;
        $final  = $this->db->select('isFinalised')
                           ->where('isActive', 1)
                           ->where('isFinalised', 1)
                           ->where('memberNo', $user_id)
                           ->where('icDate', $icDate)
                           ->from('master')
                           ->get()
                           ->num_rows();

        $overall = $this->db->select('isFinalised')
                            ->where('isActive', 1)
                            ->where('memberNo', $user_id)
                            ->where('icDate', $icDate)
                            ->from('master')
                            ->get()
                            ->num_rows();
        if ($final > 0 && $overall > 0) {
            $return = ($final / $overall) * 100;
        }

        $data = [
            'overall' => $overall,
            'percent' => $return
        ];
        return $data;
    }

    public function updateActiveStatus($icDate)
    {
        $this->db
            ->set("isActive", 0)
            ->where('strategyNo', 1)
            ->where('icDate', $icDate)
            ->update('master');

        return true;

    }

    /**
     * @param $veto
     * @param $comment
     * @param $user_id
     * @param $ticker
     * @param $ic_date
     */
    public function updateVetoAndComment($vote, $comment, $user_id, $masterID, $ic_date ){
        $this->db
            ->set('vetoFlag', $vote)
            ->set('vetoComment', $comment)
            ->set('DateModified', date('Y-m-d'))
            ->where(['memberNo' => $user_id, 'masterID' => $masterID, 'icDate' => $ic_date])
            ->update('master');
    }
/**
     * @param $veto
     * @param $comment
     * @param $user_id
     * @param $ticker
     * @param $ic_date
     */
    public function updateDeepDiveAndComment($vote, $comment, $user_id, $masterID, $ic_date ){
        $this->db
            ->set('isDeepDive', $vote)
            ->set('deepDiveComment', $comment)
            ->set('DateModified', date('Y-m-d'))
            ->where(['memberNo' => $user_id, 'masterID' => $masterID, 'icDate' => $ic_date])
            ->update('master');
    }

    public function updateFinalise($user_id, $masterID, $ic_date, $finalised)
    {
       $this->db
            ->set('isFinalised', $finalised)
            ->set('DateModified', date('Y-m-d'))
            ->where(['memberNo' => $user_id, 'masterID' => $masterID, 'icDate' => $ic_date])
            ->update('master');
    }

}