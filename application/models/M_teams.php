<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
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
            ->where('strategyNo', 1)
            ->get()
            ->result_array();
        return $teams;
    }

    public function getTeamsForPortfolio()
    {
        $teams= $this->db
            ->select("teamID as memberNo")
            ->select("teamName as memberName")
            ->where('strategyNo', 1)
            ->from('teams')
            ->get()
            ->result_array();
        return $teams;
    }

}