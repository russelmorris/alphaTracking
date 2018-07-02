<?php


class C_user_model extends CI_Model
{
    public $table = 'prospects';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_user()
    {
        return $this->db->get_where('ic', ['memberNo' => $_SESSION['user_id']])->result_array()[0];
    }

    public function ic_dashboard()
    {
        return $this->db->get_where('master', ['memberNo' => $_SESSION['user_id']], 100)->result_array();
    }

    public function count_finalised()
    {

        $finalised = $this->db->get_where('master',
            ['memberNo' => $_SESSION['user_id'], 'isFinalised' => 'IS NOT NULL'])->result_array();
        $all       = count($this->ic_dashboard());
        if (count($finalised)) {
            return (count($finalised) / $all) * 100;
        } else {
            return 0;
        }

    }


}