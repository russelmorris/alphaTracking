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
            "factorScore"    => 5,
            "zScore"         => 0,
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

    public function updateFactor($user_id, $ticker, $ic_date, $factorNo, $factorVal)
    {
        $this->db
            ->set('dateModified', date("Y-m-d H:i:s"))
            ->set('factorScore', $factorVal)
            ->where([
                'strategyNo' => 1,
                'memberNo'   => $user_id,
                'ticker'     => $ticker,
                'icDate'     => $ic_date,
                'factorNo'   => $factorNo
            ])
            ->limit(1)
            ->update('voting');
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

    public function getLatestVotingValues($user_id, $ticker, $ic_date)
    {
        $return = false;
        $values = $this->db->select('v.factorNo')
                           ->select('v.factorScore')
                           ->select('m.prospectTextID')
                           ->select('m.vetoFlag')
                           ->select('m.vetoComment')
                           ->select('m.isFinalised')
                           ->select('m.DateModified')
                           ->select('m.country')
                           ->from('voting v')
                           ->join('master m', 'v.memberNo = m.memberNo AND v.ticker = m.ticker AND v.icDate = m.icDate',
                               'inner')
                           ->where('v.memberNo', $user_id)
                           ->where('v.ticker', $ticker)
                           ->where('v.icDate', $ic_date)
                           ->order_by('factorNo', 'ASC')
                           ->get()
                           ->result_array();

        if (count($values) > 0) {
            $return = $values;
        }

        return $return;
    }
}