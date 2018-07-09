<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_ic extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMembers()
    {
        $query = $this->db
            ->select("*")
            ->where('strategyNo', 1)
            ->where('isActive', 1)
            ->where('isComittee', 1)
            ->from('ic')
            ->get();

        return $query->result_array();
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


}