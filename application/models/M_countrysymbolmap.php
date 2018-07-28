<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_countrysymbolmap extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $country
     * @param $ric
     * @return bool
     */
    public function getSWSExchangeTickerByCountryAndRICExchangeField($country, $ric)
    {
        $query = $this->db
            ->select("SWSExchangeTicker")
            //->where('Country', $country) // We exclude for now because i found cases where countr don;t match with Ric
            ->where('RICExchangeField', $ric)
            ->from('countrySymbolMap')
            ->get();
        $result = $query->result_array();
        if($query->num_rows() > 0){
            $return = $result[0]['SWSExchangeTicker'];

        } else {
            $return = false;
        }
        return $return;
    }
}