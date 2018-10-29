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
            ->set('factorScore', $factorVal === '' ? null : $factorVal )
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
        $factors = $this->db
            ->select('f.factorNo')
            ->select('f.factorOrder')
            ->select('f.factorDesc')
            ->select('f.factorSlider')
            ->select('f.factorDashboardName')
            ->order_by('f.factorOrder', 'ASC')
            ->from('factors f')
            ->where('f.isActive', 1)
            ->get()
            ->result_array();


        $master = $this->db
            ->select('m.masterID')
            ->select('m.prospectTextID')
            ->select('m.vetoFlag')
            ->select('m.vetoComment')
            ->select('m.isFinalised')
            ->select('m.DateModified')
            ->select('m.country')
            ->select('m.isFinalised')
            ->from('prospects p')
            ->join('master m', 'p.icDate = m.icDate AND p.RIC = m.RIC', 'inner')
            ->where('p.icDate', $ic_date)
            ->where('p.RIC', $prospect['RIC'])
            ->where('m.memberNo', $user_id)
            ->get()
            ->result_array();

        foreach($factors as $factor){

            $voting = $this->db
                ->select( $factor['factorNo'].' as "factorNo"')
                ->select('v.factorScore')
                ->select('v.factorDesc')
                ->from('voting v')
                ->where('v.masterID', $master[0]['masterID'])
                ->where('v.factorNo', $factor['factorNo'])
                ->get()
                ->result_array();

            if (count($voting) == 0) {
                $voting[0] = array(
                    "factorNo" => $factor['factorNo'],
                    "factorScore" => null,
                    "factorExist" => 0
                );
            } else {
                $voting[0]["factorExist"] = 1;
            }
            $mergedArray = array_merge($factor, $master[0], $voting[0]);

            $return[] = $mergedArray;

        }

        return $return;
    }
}