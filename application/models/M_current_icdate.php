<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_current_icdate extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCurrentIcDate()
    {
        $query = $this->db
            ->select("*")
            ->from('currentICdate')
            ->get();
        $return = $query->row_array();
        return $return['currentICdate'];
    }

    public function updateCurrentIcDate($icDate)
    {
        $this->db->set("currentICdate", $icDate )->update('currentICdate');

        return true;
    }
}