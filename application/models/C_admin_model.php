<?php


class C_admin_model extends CI_Model
{
    public $table = 'prospects';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_users()
    {
        return $this->db->get('ic')->result_array();
    }

    public function get_admin()
    {
        return $this->db->get_where('ic', ['memberNo' => $_SESSION['admin_id']])->result_array()[0];
    }

    public function load_prospects()
    {
        return $this->db->get('prospects')->result_array();
    }

    public function load_returns()
    {
        return $this->db->get('returns')->result_array();
    }

    public function insert_prospects_from_csv($data)
    {
        return $this->db->insert('prospects', $data);
    }

    public function insert_returns_from_csv($data)
    {
        return $this->db->insert('returns', $data);
    }


}