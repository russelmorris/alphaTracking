<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_calculation extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function writeToFactorStats($icDate)
    {
        $sql = <<<EOT
        DROP TABLE IF EXISTS factorstatsTemp;
EOT;
        $this->db->query($sql);

        $sql = <<<EOT
        CREATE TABLE factorstatsTemp SELECT
            voting.strategyNo,
            voting.memberNo,
            voting.memberName,
            voting.icDate,
            voting.factorNo,
            voting.factorDesc,
            AVG( voting.factorScore ) AS factorMean,
            STDDEV_SAMP( voting.factorScore ) AS factorStDev 
        FROM
            voting
            INNER JOIN `master` ON voting.masterID = `master`.masterID 
        WHERE
            `master`.isActive = 1 
        GROUP BY
            voting.strategyNo,
            voting.memberNo,
            voting.memberName,
            voting.icDate,
            voting.factorNo,
            voting.factorDesc 
		  HAVING voting.icDate = '$icDate';
EOT;
        $this->db->query($sql);

        return true;
    }

    public function updateFactoryStats()
    {
        $sql = <<<EOT
       DELETE factorstats 
            FROM
                factorstats
                INNER JOIN factorstatsTemp ON ( factorstatsTemp.factorNo = factorstats.factorNo ) 
                AND ( factorstatsTemp.memberNo = factorstats.memberNo ) 
                AND ( factorstats.strategyNo = factorstatsTemp.strategyNo ) 
                AND ( factorstats.icDate = factorstatsTemp.icDate )
            WHERE 1=1;
EOT;
        $this->db->query($sql);

        $sql = <<<EOT
        INSERT INTO factorstats SELECT * FROM factorstatsTemp;
EOT;
        $this->db->query($sql);
        return true;
    }

    public function updateVotingWithZScore()
    {
        $sql = <<<EOT
       update voting as v
          INNER JOIN factorstats ON factorstats.factorNo = v.factorNo AND factorstats.icDate = v.icDate AND factorstats.memberNo = v.memberNo
          set v.zScore = if (factorstats.factorStDev >0,(factorScore - factorstats.factorMean)/factorstats.factorStDev,null);

EOT;
        $this->db->query($sql);
        return true;
    }

    public function writeTempAggZScore($icDate)
    {
        $sql = <<<EOT
       drop table if exists tempAggZScore;
EOT;
        $this->db->query($sql);

        $sql = <<<EOT
        create table tempAggZScore
            SELECT
                voting.memberNo,
                voting.memberName,
                voting.icDate,
                voting.ticker,
                sum(voting.zScore * factors.factorWeight) / sum(case when voting.zScore is not null then factors.factorWeight else 0 end) as aggZScore,
                voting.masterID,
                voting.strategyNo
            FROM
                voting
            INNER JOIN factors ON voting.strategyNo = factors.strategyNo AND voting.factorNo = factors.factorNo
            
            where
              voting.icDate = '$icDate'
            GROUP BY
              voting.masterID;
EOT;
        $this->db->query($sql);
        return true;
    }

    public function updateMasterWithHumanScores($icDate)
    {
        $sql = <<<EOT
       update `master` as m
            INNER JOIN tempAggZScore ON tempAggZScore.masterID = m.masterID
            INNER JOIN ic ON ic.memberNo = m.memberNo
            set m.humanZScore = tempAggZScore.aggZScore, m.bWeight = ic.bWeight
            where m.isActive = 1 and m.icDate = '$icDate';
		
EOT;
        $this->db->query($sql);
        return true;
    }

    public function updateMasterWithHumanRank($ic_date, $members)
    {
        foreach ($members as $member) {
            $query = $this->db->select('masterID')
                    ->where('icDate',$ic_date )
                    ->where('memberNo',$member['memberNo'] )
                    ->order_by('humanZScore', 'desc')
                    ->order_by('machineRank', 'asc')
                    ->from('master')
                    ->get();
            $masterOrdered = $query->result_array();
            foreach($masterOrdered as $key => $row){
                $this->db->set('humanRank',$key+1 );
                $this->db->where('masterID', $row['masterID']);
                $this->db->limit(1);
                $this->db->update('master');
            }
        }
        return true;
    }

    public function  updateMasterWithHumanScore ($icDate)
    {
        // get number of prospects for tht IC date
        $query = $this->db->select('prospectID')
            ->where ('icdate', $icDate)
            ->from ('prospects')
            ->get();
        $prospectCount = $query->num_rows();


        $sql = <<<EOT
        update `master` as m
            set m.humanScore = (1 - m.humanRank/$prospectCount),
             m.bWeightedHumanScore = (1 - m.humanRank/$prospectCount) * m.bWeight
             where m.isActive = 1 and m.icDate = '$icDate';
EOT;
        $this->db->query($sql);
        return true;
    }
}


