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
        $result = [];
        if ($id != 0 && strlen($date)) {
            $result = $this->db
                ->select('p.*')
                ->select('m1.factorComments as fc1, m2.factorComments as fc2')
                ->select('m3.factorComments as fc3, m4.factorComments as fc4')
                ->select('m5.factorComments as fc5, m6.factorComments as fc6')
                ->select('m7.factorComments as fc7, m7.veto as veto')
                ->select('m7.isFinalised as isfinalised')
                ->from('prospects p')
                ->join("master m1",
                    "m1.icDate = p.icDate and m1.ticker = p.ticker and m1.factorNo = 1 and m1.memberNo = $id",
                    "inner")
                ->join("master m2",
                    "m2.icDate = p.icDate and m2.ticker = p.ticker and m2.factorNo = 2 and m2.memberNo =  $id",
                    "inner")
                ->join("master m3",
                    "m3.icDate = p.icDate and m3.ticker = p.ticker and m3.factorNo = 3 and m3.memberNo = $id",
                    "inner")
                ->join("master m4",
                    "m4.icDate = p.icDate and m4.ticker = p.ticker and m4.factorNo = 4 and m4.memberNo = $id",
                    "inner")
                ->join("master m5",
                    "m5.icDate = p.icDate and m5.ticker = p.ticker and m5.factorNo = 5 and m5.memberNo = $id",
                    "inner")
                ->join("master m6",
                    "m6.icDate = p.icDate and m6.ticker = p.ticker and m6.factorNo = 6 and m6.memberNo = $id",
                    "inner")
                ->join("master m7",
                    "m7.icDate = p.icDate and m7.ticker = p.ticker and m7.factorNo = 7 and m7.memberNo = $id",
                    "inner")
                ->where('p.icDate', $date)
                ->get()->result_array();
        } elseif ($id != 0) {
            $result = $this->db
                ->select('p.*')
                ->select('m1.factorComments as fc1, m2.factorComments as fc2')
                ->select('m3.factorComments as fc3, m4.factorComments as fc4')
                ->select('m5.factorComments as fc5, m6.factorComments as fc6')
                ->select('m7.factorComments as fc7, m7.veto as veto')
                ->select('m7.isFinalised as isfinalised')
                ->from('prospects p')
                ->join("master m1",
                    "m1.icDate = p.icDate and m1.ticker = p.ticker and m1.factorNo = 1 and m1.memberNo = $id",
                    "inner")
                ->join("master m2",
                    "m2.icDate = p.icDate and m2.ticker = p.ticker and m2.factorNo = 2 and m2.memberNo =  $id",
                    "inner")
                ->join("master m3",
                    "m3.icDate = p.icDate and m3.ticker = p.ticker and m3.factorNo = 3 and m3.memberNo = $id",
                    "inner")
                ->join("master m4",
                    "m4.icDate = p.icDate and m4.ticker = p.ticker and m4.factorNo = 4 and m4.memberNo = $id",
                    "inner")
                ->join("master m5",
                    "m5.icDate = p.icDate and m5.ticker = p.ticker and m5.factorNo = 5 and m5.memberNo = $id",
                    "inner")
                ->join("master m6",
                    "m6.icDate = p.icDate and m6.ticker = p.ticker and m6.factorNo = 6 and m6.memberNo = $id",
                    "inner")
                ->join("master m7",
                    "m7.icDate = p.icDate and m7.ticker = p.ticker and m7.factorNo = 7 and m7.memberNo = $id",
                    "inner")
                ->limit(10)
                ->get()->result_array();
        } else {
            $result = [];
        }

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