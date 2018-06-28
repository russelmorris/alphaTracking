<?php


class C_prospect_model extends CI_Model
{
    public $table = 'prospects';

    public function __construct()
    {
        parent::__construct();
    }

    public function load_data()
    {
        return $this->db->get('prospects', 10)->result_array();
    }

    public function insert_prospects_from_csv($data)
    {
        return $this->db->insert('prospects', $data);
    }
}