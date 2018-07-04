<?php


class M_admin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_users()
    {
        return $this->db->get('ic')->result_array();
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