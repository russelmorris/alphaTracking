<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_admin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function insert_returns_from_csv($data)
    {
        $this->db->insert('returns', $data);
    }

    public function getMasterTable()
    {
        return $this->db->select('icDate')
                        ->select('ticker')
                        ->from('master')
                        ->group_by('icDate')
                        ->get()->result_array();
    }

    public function populateMaster($data)
    {
        $this->db->insert('master', $data);
    }

    public function isActiveUpdate($flag = 1, $icDate)
    {
        $this->db->set('isActive', $flag)
                 ->where('icDate', $icDate)
                 ->update('master');
    }




}