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

    public function getProspectsByDateAndId($id = 0, $date = '')
    {

        #toso
        /*
         * Chenck if is addmin and allow to use ID passeed  in function
         * If not is admin get user from session and owerwrite  passed admin
         */
        $result = [];
        $result = $this->db
            ->select('m.*')
            ->select('v1.factorScore as fc1')
            ->select('v2.factorScore as fc2')
            ->select('v3.factorScore as fc3')
            ->select('v4.factorScore as fc4')
            ->select('v5.factorScore as fc5')
            ->select('v6.factorScore as fc6')
            ->select('v7.factorScore as fc7')
            ->from('master m')
            ->join("voting v1", "v1.masterID = m.masterID and v1.factorNo = 1", "inner")
            ->join("voting v2", "v2.masterID = m.masterID and v2.factorNo = 2", "inner")
            ->join("voting v3", "v3.masterID = m.masterID and v3.factorNo = 3", "inner")
            ->join("voting v4", "v4.masterID = m.masterID and v4.factorNo = 4", "inner")
            ->join("voting v5", "v5.masterID = m.masterID and v5.factorNo = 5", "inner")
            ->join("voting v6", "v6.masterID = m.masterID and v6.factorNo = 6", "inner")
            ->join("voting v7", "v7.masterID = m.masterID and v7.factorNo = 7", "inner")
            ->where('m.strategyNo', 1)
            ->where('m.isActive', 1)
            ->where('m.memberNo', $id)
           ->where('m.icDate', $date)
            ->get()
            ->result_array();
        return $result;
    }

    public function updateFactorsMasterData($user_id, $ticker, $factorNo, $factorVal)
    {
        $this->db->set('factorComments', $factorVal)
                 ->where(['memberNo' => $user_id, 'ticker' => $ticker, 'factorNo' => $factorNo])
                 ->update('master');
    }

    public function setVetoFlag($user_id, $ticker, $veto)
    {
        $this->db->set('veto', $veto)
                 ->where(['memberNo' => $user_id, 'ticker' => $ticker])
                 ->update('master');

    }

    public function setFinaliseFlag($user_id, $ticker, $finalised)
    {
        $this->db->set('isFinalised', $finalised)
                 ->where(['memberNo' => $user_id, 'ticker' => $ticker])
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