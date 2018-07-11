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
        $total  = $this->db
            ->select("COUNT(prospectID) as total")
            ->where('strategyNo', 1)
            ->where('ticker', $data['ticker'])
            ->where('country', $data['country'])
            ->where('icDate', $data['icDate'])
            ->from('prospects')
            ->count_all_results();

        if ($total == 0) {
            $insertData = [
                'strategyNo'     => 1,
                'prospectTextID' => $data['ticker'] . '-' . $data['country'] . '-' . $data['icDate'],
                'icDate'         => $data['icDate'],
                'ticker'         => $data['ticker'],
                'RIC'            => $data['RIC'],
                'name'           => $data['name'],
                'country'        => $data['country'],
                'sector'         => $data['sector'],
                'machineScore'   => $data['machineScore'],
                'SWSurl'         => $data['SWSurl'],
            ];
            if ( ! $this->db->insert('prospects', $insertData)) {
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

    public function getProspectsByDateAndId($id = 0, $icDate = '', $limit = 100)
    {
        //todo
        /*
         * Chenck if is addmin and allow to use ID passeed  in function
         * If not is admin get user from session and owerwrite  passed admin
         */
        $result = [];
        $result = $this->db
            ->select('m.masterID')
            ->select('m.ticker')
            ->select('m.name')
            ->select('m.country')
            ->select('m.sector')
            ->select('m.machineRank')
            ->select('m.isActive')
            ->select('m.isFinalised')
            ->select('m.vetoFlag')
            ->select('m.icDate')
            ->select("vo1.factorScore as factorScore1")
            ->select("vo2.factorScore as factorScore2")
            ->select("vo3.factorScore as factorScore3")
            ->select("vo4.factorScore as factorScore4")
            ->select("vo5.factorScore as factorScore5")
            ->select("vo6.factorScore as factorScore6")
            ->select("vo7.factorScore as factorScore7")
            ->select("'N/A' as factorScoreOld1")
            ->select("'N/A' as factorScoreOld2")
            ->select("'N/A' as factorScoreOld3")
            ->select("'N/A' as factorScoreOld4")
            ->select("'N/A' as factorScoreOld5")
            ->select("'N/A' as factorScoreOld6")
            ->select("'N/A' as factorScoreOld7")
            ->from('master m')
            ->join('voting vo1', "vo1.masterID = m.masterID and vo1.factorNo = 1", "inner")
            ->join('voting vo2', "vo2.masterID = m.masterID and vo2.factorNo = 2", "inner")
            ->join('voting vo3', "vo3.masterID = m.masterID and vo3.factorNo = 3", "inner")
            ->join('voting vo4', "vo4.masterID = m.masterID and vo4.factorNo = 4", "inner")
            ->join('voting vo5', "vo5.masterID = m.masterID and vo5.factorNo = 5", "inner")
            ->join('voting vo6', "vo6.masterID = m.masterID and vo6.factorNo = 6", "inner")
            ->join('voting vo7', "vo7.masterID = m.masterID and vo7.factorNo = 7", "inner")
            ->where('m.strategyNo', 1)
            ->where('m.isActive', 1)
            ->where('m.memberNo', $id)
            ->where('m.icDate', $icDate)
            ->order_by('m.masterID','ASC')
            ->limit($limit)
            ->get()
            ->result_array();

        return $result;
    }
}
