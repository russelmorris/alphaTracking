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
            'prospectTextID'  => str_replace(" ", "", strtolower($data['icDate'] . '-' . $data['ticker'] . '-' . $data['country'])),
            'icDate'          => $data['icDate'],
            'ticker'          => $data['ticker'],
            'RIC'             => $data['RIC'],
            'RICExchangeCode' => $ricExchangeCode,
            'name'            => $data['name'],
            'country'         => $data['country'],
            'sector'          => $data['sector'],
            'machineScore'    => $data['machineScore'],
            'machineRank'     => $data['machineRank'],
            'machineScore2'   => $data['machineScore2'],
            'machineRank2'    => $data['machineRank2'],
            'machineScore3'   => $data['machineScore3'],
            'machineRank3'    => $data['machineRank3'],
            'processed'       => 1,
            'SWSurl_test'     => $data['SWSurl_test'],
            'SWSurl'          => $data['SWSurl'],
            'tag'             => $data['tag'],


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
                ->set('machineScore2', $prospectData['machineScore2'])
                ->set('machineRank2', $prospectData['machineRank2'])
                ->set('machineScore3', $prospectData['machineScore3'])
                ->set('machineRank3', $prospectData['machineRank3'])
                ->set('SWSurl', $prospectData['SWSurl'])
                ->set('SWSurl_test', $prospectData['SWSurl_test'])
                ->set('processed', $prospectData['processed'])
                ->set('tag', $prospectData['tag'])
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
         * Check if is admin and allow to use ID passed  in function
         * If not is admin get user from session and overwrite  passed admin
         */
        $result = [];

        $this->db->select('coalesce(p.strategyNo, 0) as inPortfolio' );
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
        $this->db->select('m.humanZScore');
        $this->db->select('m.humanRank');
        $this->db->select("vo5.factorScore as factorScore5");
        $this->db->from('master m');
        $this->db->join('voting vo5', "vo5.masterID = m.masterID and vo5.factorNo = 5", "inner");
        $this->db->join('portfolio p',  "p.memberNo = ".$id."  and p.icDate = '".$icDate."' and p.ticker = m.ticker", 'left');
        $this->db->where('m.strategyNo', 1);
        $this->db->where('m.isActive', 1);
        $this->db->where('m.memberNo', $id);
        $this->db->where('m.icDate', $icDate);
        $this->db->order_by('m.masterID', 'ASC');
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

    public function getProspectByMasterID($masterID)
    {
        $return = [];

        $masterRecord = $this->db->select('*')
                ->where('masterID', $masterID)
                ->from('master')
                ->get()
                ->result_array();
        if (count($masterRecord) > 0 ){

            $masterRecord = $masterRecord[0];
        } else {
            return [];
        }


        $this->db->select('*');
        $this->db->from('prospects p');

        $this->db->where('p.strategyNo', 1);
        $this->db->where('p.icDate', $masterRecord['icDate']);
        $this->db->where('p.ticker', $masterRecord['ticker']);
        $this->db->where('p.RIC', $masterRecord['RIC']);
        $result = $this->db->get()->result_array();
        if (count($result) > 0) {
            $return = $result[0];
        }

        return $return;
    }



    public function getPreviousProspectByDateAndTicker($userId, $icDate = '', $prospectId)
    {
        $return = [];
        $this->db->select('ticker, RIC');
        $this->db->from('prospects p');

        $this->db->where('p.strategyNo', 1);
        $this->db->where('p.icDate', $icDate);
        $this->db->where('p.prospectId < ', $prospectId);
        $this->db->limit(1);
        $this->db->order_by('p.prospectId', 'desc');
        $prospect = $this->db->get()->result_array();
        if (count($prospect) > 0) {
            $masterRecord = $this->db->select('*')
                ->where('ticker', $prospect[0]['ticker'])
                ->where('RIC', $prospect[0]['RIC'])
                ->where('icDate', $icDate)
                ->where('memberNo', $userId)
                ->from('master')
                ->get()
                ->result_array();
            if (count($masterRecord) > 0 ){
                $return = $masterRecord[0]['masterID'];
            }
        }
        return $return;
    }
    public function getNextProspectByDateAndTicker($userId, $icDate = '', $prospectId)
    {
        $return = [];
        $this->db->select('ticker, RIC');
        $this->db->from('prospects p');

        $this->db->where('p.strategyNo', 1);
        $this->db->where('p.icDate', $icDate);
        $this->db->where('p.prospectId > ', $prospectId);
        $this->db->limit(1);
        $this->db->order_by('p.prospectId', 'asc');
        $prospect = $this->db->get()->result_array();
        if (count($prospect) > 0) {
            $masterRecord = $this->db->select('*')
                ->where('ticker', $prospect[0]['ticker'])
                ->where('RIC', $prospect[0]['RIC'])
                ->where('icDate', $icDate)
                ->where('memberNo', $userId)
                ->from('master')
                ->get()
                ->result_array();
            if (count($masterRecord) > 0 ){
                $return = $masterRecord[0]['masterID'];
            }
        }

        return $return;
    }



    public function getProspectsByDate($icDate){
         return $this->db
            ->select('*')
            ->where("icDate",$icDate)
            ->from ("prospects")
            ->get()->result_array();
    }

    public function getGoogletrendsFilePaths(){
        $sql = <<<EOT
       SELECT
            concat("http://disrupterfund.com.au/bottomUp/digiFootprint/googletrends/",
                date_format(icDate,'%Y-%m-%d'),
                    "/", date_format(icDate,'%Y-%m-%d'),
                        "-",lower(ticker),"-",lower(replace(country," ","")),"-googletrends.csv") as inputFile,
            concat("http://disrupterfund.com.au/bottomUp/digiFootprint/googletrends/",
                date_format(icDate,'%Y-%m-%d'),
                    "/", date_format(icDate,'%Y-%m-%d'),
                        "-",lower(ticker),"-",lower(replace(country," ","")),"-googletrends.jpg") as outputFile
            FROM
            prospects inner join peerRIC on (prospects.RIC = peerRIC.RIC)
            where ((icDate = (select currentICdate.currentICdate from currentICdate)) and peerRIC1<>'')
	;
EOT;
        $this->db->query($sql);

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function getAlexaFilePaths(){
        $sql = <<<EOT
              SELECT
                concat("http://disrupterfund.com.au/bottomUp/digiFootprint/alexa/",
                    date_format(icDate,'%Y-%m-%d'),
                        "/", date_format(icDate,'%Y-%m-%d'),
                            "-",lower(ticker),"-",lower(replace(country," ","")),"-alexa.csv") as inputFile,
                concat("http://disrupterfund.com.au/bottomUp/digiFootprint/alexa/",
                    date_format(icDate,'%Y-%m-%d'),
                        "/", date_format(icDate,'%Y-%m-%d'),
                            "-",lower(ticker),"-",lower(replace(country," ","")),"-alexa.jpg") as outputFile
                FROM
                prospects inner join peerRIC on (prospects.RIC = peerRIC.RIC)
                where ((icDate = (select currentICdate.currentICdate from currentICdate)) and peerRIC1<>'')
                
                ;

EOT;
        $this->db->query($sql);

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}
