<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_voting extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertProspect($data, $masterID, $member, $factor)
    {
        $return = false;

        $prospectData = [
            'strategyNo'     => 1,
            "masterID"       => $masterID,
            'prospectTextID' => $data['ticker'] . '-' . $data['country'] . '-' . $data['icDate'],
            "icDate"         => $data['icDate'],
            "ticker"         => $data['ticker'],
            "memberNo"       => $member['memberNo'],
            "memberName"     => $member['memberName'],
            "factorNo"       => $factor['factorNo'],
            "factorDesc"     => $factor['factorDesc'],
            "factorScore"    => null,
            "zScore"         => null,
            "dateModified"   => date("Y-m-d H:i:s"),
        ];

        //check if we have already inserted
        //check if prospect exist in database
        $query = $this->db
            ->select("votingID")
            ->where('strategyNo', 1)
            ->where('masterID', $masterID)
            ->where('ticker', $prospectData['ticker'])
            ->where('icDate', $prospectData['icDate'])
            ->where('memberNo', $member['memberNo'])
            ->where('factorNo', $factor['factorNo'])
            ->from('voting')
            ->get();
        if ($query->num_rows() == 0) {
            if ($this->db->insert('voting', $prospectData)) {
                $return = true;
            }
        }

        return $return;
    }

    /**
     * @param $user_id
     * @param $ticker
     * @param $ic_date
     * @param $factorNo
     * @param $factorVal
     */
    public function updateFactor($user_id, $masterID, $ic_date, $factorNo, $factorVal)
    {
        $this->db
            ->set('dateModified', date("Y-m-d H:i:s"))
            ->set('factorScore', $factorVal == 0 ? null : $factorVal )
            ->where([
                'strategyNo' => 1,
                'memberNo'   => $user_id,
                'masterID'     => $masterID,
                'icDate'     => $ic_date,
                'factorNo'   => $factorNo
            ])
            ->limit(1)
            ->update('voting');
       // echo $this->db->last_query();
    }

    public function getSWSurl($user_id, $ticker)
    {
        $return = false;

        $url = $this->db->select('p.SWSurl')
                        ->distinct('p.SWSurl')
                        ->from('prospects p')
                        ->join('voting v', 'v.prospectTextID = p.prospectTextID and v.ticker = p.ticker', 'inner')
                        ->where('v.memberNo', $user_id)
                        ->where('p.ticker', $ticker)
                        ->get()
                        ->result_array();

        if (count($url) > 0) {
            $return = $url[0];
        }

        return $return;
    }

    public function getLatestVotingValues($user_id, $prospect, $ic_date)
    {
//        print_f($user_id);
//        print_f($prospect);
//        print_f($ic_date);

        $return = false;
        $values = $this->db
            ->select('f.factorOrder')
            ->select('f.factorDesc')
            ->select('f.factorSlider')
            ->select('f.factorDashboardName')
            ->select('m.prospectTextID')
            ->select('m.vetoFlag')
            ->select('m.vetoComment')
            ->select('m.isDeepDive')
            ->select('m.deepDiveComment')
            ->select('m.isFinalised')
            ->select('m.DateModified')
            ->select('v.factorNo')
            ->select('v.factorScore')
            ->select('v.factorDesc')
            ->select('v.factorDesc')
            ->select('m.country')
            ->from('prospects p')
            ->join('master m', 'p.icDate = m.icDate AND p.RIC = m.RIC',
               'inner')
            ->join('voting v', 'v.masterID = m.masterID',
                'inner')
            ->join('factors f', 'f.factorNo = v.factorNo',
                'inner')
            ->where('p.icDate', $ic_date)
            ->where('p.RIC', $prospect['RIC'])
            ->where('v.memberNo', $user_id)
            ->order_by('f.factorOrder', 'ASC')
            ->get()
            ->result_array();

        if (count($values) > 0) {
            $return = $values;
        }

        return $return;
    }
}