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


}