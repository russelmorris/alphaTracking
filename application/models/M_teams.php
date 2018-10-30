<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 * @property  M_icdate m_icdate
 */
class M_teams extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTeams()
    {
        $teams= $this->db
            ->select("*")
            ->from('teams')
            ->get()
            ->result_array();
        return $teams;
    }

}