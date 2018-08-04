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
        DROP TABLE if exists factorstatsTemp;
EOT;
        $this->db->query($sql);

        $sql = <<<EOT
        CREATE TABLE  factorstatsTemp
          SELECT
            voting.strategyNo,
            voting.memberNo,
            voting.memberName,
            voting.icDate,
            voting.factorNo,
            voting.factorDesc,
            AVG(voting.factorScore) AS factorMean,
            STDDEV_SAMP(voting.factorScore) AS factorStDev
          FROM voting
            INNER JOIN `master` on voting.masterID = `master`.masterID
	      WHERE `master`.isActive = 1
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
        delete factorstats
            FROM factorstats
              INNER JOIN factorstatsTemp ON
                (factorstatsTemp.factorNo = factorstats.factorNo)
                AND (factorstatsTemp.memberNo = factorstats.memberNo)
                AND (factorstats.strategyNo = factorstatsTemp.strategyNo)
                AND (factorstats.icDate = factorstatsTemp.icDate)
            WHERE 1=1;
EOT;
        $this->db->query($sql);

        $sql = <<<EOT
        insert into factorstats select * from factorstatsTemp;
EOT;
        $this->db->query($sql);
        return true;
    }

    public function updateVotingWithZScore()
    {
        $sql = <<<EOT
        update voting as v
            INNER JOIN factorstats ON factorstats.factorNo = v.factorNo AND factorstats.icDate = v.icDate AND factorstats.memberNo = v.memberNo
            set v.zScore = if (factorstats.factorStDev >0,(factorScore - factorstats.factorMean)/factorstats.factorStDev,factorstats.factorMean);
EOT;
        $this->db->query($sql);
        return true;
    }

    public function writeTempAggZScore()
    {
        $sql = <<<EOT
        drop table if exists tempAggZScore;;
EOT;
        $this->db->query($sql);

        $sql = <<<EOT
        create table tempAggZScore
            SELECT
                voting.memberNo,
                voting.memberName,
                voting.icDate,
                voting.ticker,
                Sum(factors.factorWeight * voting.zScore) as aggZScore,
                voting.masterID,
                voting.strategyNo
            FROM
              factors
            INNER JOIN voting ON factors.factorNo = voting.factorNo
            GROUP BY
            voting.masterID;
EOT;
        $this->db->query($sql);
        return true;
    }

    public function updateMasterWithHumanScores()
    {
        $sql = <<<EOT
        update `master` as m
            INNER JOIN tempAggZScore ON tempAggZScore.masterID = m.masterID
            set m.humanScore = if(m.vetoFlag = 1,-100,tempAggZScore.aggZScore),
            m.bWeightedHumanScore = tempAggZScore.aggZScore * m.bWeight
            where m.isActive = 1;
		
EOT;
        $this->db->query($sql);
        return true;
    }
}


