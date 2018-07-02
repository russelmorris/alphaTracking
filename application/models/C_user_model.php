<?php


class C_user_model extends CI_Model
{
    public $table = 'prospects';

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserByID($id = 0)
    {
        $return = false;
        $user = $this->db
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