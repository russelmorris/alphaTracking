<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_create_csv extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProspectKeywordCompare($prospect)
    {
         return $query = $this->db
            ->select("keyword")
            ->select("RICType")
            ->from('prospectsAndPeers')
            ->join ("ricKeywords",  "prospectsAndPeers.RIC = ricKeywords.RIC" )
            ->group_start()
            ->where('prospectsAndPeers.RIC', $prospect )
            ->where('prospectsAndPeers.RICtype', 'prospect' )
            ->group_end()
            ->or_where('	prospectsAndPeers.RICProspect',$prospect )
            ->get()
            ->result_array();
    }
    public function getProspectDomainCompare($prospect)
    {
        return $query = $this->db
            ->select("domain")
            ->select("RICType")
            ->from('prospectsAndPeers')
            ->join ("ricDomains",  "prospectsAndPeers.RIC = ricDomains.RIC" )
            ->group_start()
            ->where('prospectsAndPeers.RIC', $prospect )
            ->where('prospectsAndPeers.RICtype', 'prospect' )
            ->group_end()
            ->or_where('	prospectsAndPeers.RICProspect',$prospect )
            ->get()
            ->result_array();
    }
}