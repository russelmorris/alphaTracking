<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_prospects extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_prospects_from_csv($data)
    {
        $return = true;
        $total = $this->db
            ->select("COUNT(prospectID) as total")
            ->where('strategyNo', 1)
            ->where('ticker', $data['ticker'])
            ->where('country', $data['country'])
            ->where('icDate', $data['icDate'])
            ->from('prospects')
            ->count_all_results();

        if ($total == 0) {
            $insertData = [
                'strategyNo' => 1,
                'prospectTextID' => $data['ticker'] . '-' . $data['country'] . '-' . $data['icDate'],
                'icDate' => $data['icDate'],
                'ticker' => $data['ticker'],
                'RIC' => $data['RIC'],
                'name' => $data['name'],
                'country' => $data['country'],
                'sector' => $data['sector'],
                'machineScore' => $data['machineScore'],
                'machineRank' => $data['machineRank'],
                'SWSurl' => $data['SWSurl'],
            ];
            if (!$this->db->insert('prospects', $insertData)) {
                $return = false;
            }
        }

        return $return;
    }

    public function updateProcessedStatus($icDate)
    {
        $this->db
            ->set("processed", 0)
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
}
