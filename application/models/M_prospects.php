<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 * @property  M_countrysymbolmap m_countrysymbolmap
 */
class M_prospects extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_prospects_from_csv($data)
    {

        $this->load->model([
            'm_countrysymbolmap'
        ]);
        $return = true;

        // prepare data for update
        $ricExchangeCode     = substr($data['RIC'], strpos($data['RIC'], '.') + 1);
        $swsExchangeTicker   = $this->m_countrysymbolmap->getSWSExchangeTickerByCountryAndRICExchangeField($data['country'],
            $ricExchangeCode);
        $data['SWSurl']      = 'https://simplywall.st/stocks/hk/capital-goods/' . $swsExchangeTicker . '-' . strtolower($data['ticker']);
        $data['SWSurl_test'] = 'https://simplywall.st/stocks/us/software/symbolCountryMap.' . $swsExchangeTicker . '-prospects.' . $data['ticker'] . '/';

        $prospectData = [
            'strategyNo'      => 1,
            'prospectTextID'  => $data['icDate'] . '-' . $data['ticker'] . '-' . $data['country'],
            'icDate'          => $data['icDate'],
            'ticker'          => $data['ticker'],
            'RIC'             => $data['RIC'],
            'RICExchangeCode' => $ricExchangeCode,
            'name'            => $data['name'],
            'country'         => $data['country'],
            'sector'          => $data['sector'],
            'machineScore'    => $data['machineScore'],
            'machineRank'     => $data['machineRank'],
            'peerRIC1'        => $data['peerRIC1'],
            'peerRIC2'        => $data['peerRIC2'],
            'peerRIC3'        => $data['peerRIC3'],
            'peerRIC4'        => $data['peerRIC4'],
            'peerRIC5'        => $data['peerRIC5'],
            'SWSurl'          => $data['SWSurl'],
            'SWSurl_test'     => $data['SWSurl_test'],
            'processed'       => 1,
        ];

        //check if prospect exist in database
        $total = $this->db
            ->select("COUNT(prospectID) as total")
            ->where('strategyNo', 1)
            ->where('ticker', $prospectData['ticker'])
            ->where('country', $prospectData['country'])
            ->where('icDate', $prospectData['icDate'])
            ->from('prospects')
            ->count_all_results();

        if ($total == 0) {
            if ( ! $this->db->insert('prospects', $prospectData)) {
                $return = false;
            }
        } else {
            $query = $this->db
                ->set('strategyNo', $prospectData['strategyNo'])
                ->set('prospectTextID', $prospectData['prospectTextID'])
                ->set('icDate', $prospectData['icDate'])
                ->set('ticker', $prospectData['ticker'])
                ->set('RIC', $prospectData['RIC'])
                ->set('RICExchangeCode', $prospectData['RICExchangeCode'])
                ->set('name', $prospectData['name'])
                ->set('country', $prospectData['country'])
                ->set('sector', $prospectData['sector'])
                ->set('machineScore', $prospectData['machineScore'])
                ->set('machineRank', $prospectData['machineRank'])
                ->set('peerRIC1', $prospectData['peerRIC1'])
                ->set('peerRIC2', $prospectData['peerRIC2'])
                ->set('peerRIC3', $prospectData['peerRIC3'])
                ->set('peerRIC4', $prospectData['peerRIC4'])
                ->set('peerRIC5', $prospectData['peerRIC5'])
                ->set('SWSurl', $prospectData['SWSurl'])
                ->set('SWSurl_test', $prospectData['SWSurl_test'])
                ->set('processed', $prospectData['processed'])
                ->where('strategyNo', 1)
                ->where('ticker', $data['ticker'])
                ->where('country', $data['country'])
                ->where('icDate', $data['icDate'])
                ->update('prospects');
        }

        return $return;
    }

    public function updateProcessedStatus($icDate, $status = 0)
    {
        $this->db
            ->set("processed", $status)
            ->where('strategyNo', 1)
            ->where('icDate', $icDate)
            ->update('prospects');

        return true;
    }

    public function getProspectsByDateAndId($id = 0, $icDate = '', $limit = null)
    {
        //todo
        /*
         * Chenck if is addmin and allow to use ID passeed  in function
         * If not is admin get user from session and owerwrite  passed admin
         */
        $result = [];
        $this->db->select('m.masterID');
        $this->db->select('m.ticker');
        $this->db->select('m.name');
        $this->db->select('m.country');
        $this->db->select('m.sector');
        $this->db->select('m.machineRank');
        $this->db->select('m.isActive');
        $this->db->select('m.isFinalised');
        $this->db->select('m.vetoFlag');
        $this->db->select('m.icDate');
        $this->db->select("vo1.factorScore as factorScore1");
        $this->db->select("vo2.factorScore as factorScore2");
        $this->db->select("vo3.factorScore as factorScore3");
        $this->db->select("vo4.factorScore as factorScore4");
        $this->db->select("vo5.factorScore as factorScore5");
        $this->db->select("vo6.factorScore as factorScore6");
        $this->db->select("vo7.factorScore as factorScore7");
        $this->db->select("'N/A' as factorScoreOld1");
        $this->db->select("'N/A' as factorScoreOld2");
        $this->db->select("'N/A' as factorScoreOld3");
        $this->db->select("'N/A' as factorScoreOld4");
        $this->db->select("'N/A' as factorScoreOld5");
        $this->db->select("'N/A' as factorScoreOld6");
        $this->db->select("'N/A' as factorScoreOld7");
        $this->db->from('master m');
        $this->db->join('voting vo1', "vo1.masterID = m.masterID and vo1.factorNo = 1", "inner");
        $this->db->join('voting vo2', "vo2.masterID = m.masterID and vo2.factorNo = 2", "inner");
        $this->db->join('voting vo3', "vo3.masterID = m.masterID and vo3.factorNo = 3", "inner");
        $this->db->join('voting vo4', "vo4.masterID = m.masterID and vo4.factorNo = 4", "inner");
        $this->db->join('voting vo5', "vo5.masterID = m.masterID and vo5.factorNo = 5", "inner");
        $this->db->join('voting vo6', "vo6.masterID = m.masterID and vo6.factorNo = 6", "inner");
        $this->db->join('voting vo7', "vo7.masterID = m.masterID and vo7.factorNo = 7", "inner");
        $this->db->where('m.strategyNo', 1);
        $this->db->where('m.isActive', 1);
        $this->db->where('m.memberNo', $id);
        $this->db->where('m.icDate', $icDate);
        $this->db->order_by('m.masterID', 'ASC');
//        $this->db->limit($limit);
        $result = $this->db->get()->result_array();

        return $result;
    }


    public function getProspectByDateAndTicker($icDate = '', $ticker)
    {
        $return = [];
        $this->db->select('*');
        $this->db->from('prospects p');

        $this->db->where('p.strategyNo', 1);
        $this->db->where('p.icDate', $icDate);
        $this->db->where('p.ticker', $ticker);
        $result = $this->db->get()->result_array();
        if (count($result) > 0) {
            $return = $result[0];
        }

        return $return;
    }
}
