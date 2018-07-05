<?php


/**
 * @property  CI_Session sesion
 */
class M_user extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserByID($id = 0)
    {
        $return = false;
        $user   = $this->db
            ->select('memberNo, bWeight, email')
            ->select('isAdmin, isComittee, memberName')
            ->where('memberNo', $id)
            ->where('isActive', 1)
            ->from('ic')
            ->get()
            ->result_array();

        if (count($user) > 0) {
            $return = $user[0];
        }

        return $return;
    }

    public function getICDates()
    {
        return $this->db
            ->select('icDate')
            ->from('icDate')
            ->get()
            ->result_array();
    }

    public function getProspectsByDateAndId($id = 0, $dateFrom = '', $dateTo = '')
    {
        //todo
        /*
         * Chenck if is addmin and allow to use ID passeed  in function
         * If not is admin get user from session and owerwrite  passed admin
         */
        $user = $this->session->userdata('user');
        $result = [];
        $result = $this->db
            ->select('m.masterID')
            ->select('m.ticker')
            ->select('m.name')
            ->select('m.country')
            ->select('m.sector')
            ->select('m.machineRank')
            ->select('m.isActive')
            ->select('m.isFinalised')
            ->select('m.vetoFlag')
            ->select('v1.votingID as votingID')
            ->select('IFNULL(v1.factorScore, 0) as factorScore1')
            ->select('IFNULL(v2.factorScore, 0) as factorScore2')
            ->select('IFNULL(v3.factorScore, 0) as factorScore3')
            ->select('IFNULL(v4.factorScore, 0) as factorScore4')
            ->select('IFNULL(v5.factorScore, 0) as factorScore5')
            ->select('IFNULL(v6.factorScore, 0) as factorScore6')
            ->select('IFNULL(v7.factorScore, 0) as factorScore7')
            ->select("IFNULL(vo1.factorScore, 'N/A') as factorScoreOld1")
            ->select("IFNULL(vo2.factorScore, 'N/A') as factorScoreOld2")
            ->select("IFNULL(vo3.factorScore, 'N/A') as factorScoreOld3")
            ->select("IFNULL(vo4.factorScore, 'N/A') as factorScoreOld4")
            ->select("IFNULL(vo5.factorScore, 'N/A') as factorScoreOld5")
            ->select("IFNULL(vo6.factorScore, 'N/A') as factorScoreOld6")
            ->select("IFNULL(vo7.factorScore, 'N/A') as factorScoreOld7")
            ->from('master m')
            ->join('voting v1', "v1.factorNo = 1 and v1.memberNo=$id and v1.icDate='$dateTo'", "left")
            ->join('voting v2', "v2.factorNo = 2 and v2.memberNo=$id and v2.icDate='$dateTo'", "left")
            ->join('voting v3', "v3.factorNo = 3 and v3.memberNo=$id and v3.icDate='$dateTo'", "left")
            ->join('voting v4', "v4.factorNo = 4 and v4.memberNo=$id and v4.icDate='$dateTo'", "left")
            ->join('voting v5', "v5.factorNo = 5 and v5.memberNo=$id and v5.icDate='$dateTo'", "left")
            ->join('voting v6', "v6.factorNo = 6 and v6.memberNo=$id and v6.icDate='$dateTo'", "left")
            ->join('voting v7', "v7.factorNo = 7 and v7.memberNo=$id and v7.icDate='$dateTo'", "left")
            ->join('voting vo1', "vo1.factorNo = 1 and vo1.memberNo=$id and vo1.icDate='$dateTo'", "left")
            ->join('voting vo2', "vo2.factorNo = 2 and vo2.memberNo=$id and vo2.icDate='$dateTo'", "left")
            ->join('voting vo3', "vo3.factorNo = 3 and vo3.memberNo=$id and vo3.icDate='$dateTo'", "left")
            ->join('voting vo4', "vo4.factorNo = 4 and vo4.memberNo=$id and vo4.icDate='$dateTo'", "left")
            ->join('voting vo5', "vo5.factorNo = 5 and vo5.memberNo=$id and vo5.icDate='$dateTo'", "left")
            ->join('voting vo6', "vo6.factorNo = 6 and vo6.memberNo=$id and vo6.icDate='$dateTo'", "left")
            ->join('voting vo7', "vo7.factorNo = 7 and vo7.memberNo=$id and vo7.icDate='$dateTo'", "left")
            ->where('m.strategyNo', 1)
            ->where('m.isActive', 1)
            ->where('m.memberNo', $id)
            ->where('m.icDate', $dateFrom)
            ->get()
            ->result_array();

        return $result;
    }

    public function updateFactorsMasterData($user_id, $ticker, $masterID, $factorNo, $factorVal)
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

    public function setVetoFlag($user_id, $masterID, $veto)
    {
        $this->db->set('vetoFlag', $veto)
                 ->where(['memberNo' => $user_id, 'masterID' => $masterID])
                 ->update('master');

    }

    public function setFinaliseFlag($user_id, $masterID, $finalised)
    {
        $this->db->set('isFinalised', $finalised)
                 ->where(['memberNo' => $user_id, 'masterID' => $masterID])
                 ->update('master');

    }
    /*public function count_finalised($id)
    {
        $finalised = $this->db->get_where('master',
            ['memberNo' => $id, 'isFinalised' => 'IS NOT NULL'])->result_array();
        $all       = count($this->getProspectsByDateAndId($id));
        if (count($finalised)) {
            return (count($finalised) / $all) * 100;
        } else {
            return 0;
        }

    }*/


}