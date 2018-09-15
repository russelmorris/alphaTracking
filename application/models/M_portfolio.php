<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_portfolio extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function buildPortfolioMasterStep1($ic_date)
    {
        $sql = <<<EOT
        delete from portfolio_temp2 where 1=1
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
            alter table portfolio_temp2 auto_increment = 1
EOT;
        $this->db->query($sql);


        $query = $this->db->select ('bWeight')
            ->where('memberName', "machine" )
            ->from('ic')
            ->get();
        $result = $query->result_array();
        $bWeight = $result[0]['bWeight'] ;

        $sql = <<<EOT
        SELECT icd.icDate,  icd.portfolioCount  
            FROM icdate icd 
            where icd.icDate = '{$ic_date}';
EOT;
        $query = $this->db->query($sql);

        $result = $query->result();

        $analysisDate = $result[0]->icDate;
        $portfolioCount = $result[0]->portfolioCount;
        $sql = <<<EOT
        insert into portfolio_temp2
            
            SELECT
            `master`.strategyNo,
            "master" as memberName,
            0 as memberNo,
            `master`.prospectTextID,
            `master`.icDate,
            `master`.ticker,
            `master`.RIC,
            `master`.`name`,
            `master`.country,
            `master`.sector,
            sum(if(`master`.vetoFlag,1,0)) as vetoCount,
            `master`.machineScore,
            `master`.machineRank,
            Sum(`master`.bWeightedHumanScore) as humanScore,
            0 as humanRank,
            Sum(`master`.bWeightedHumanScore) + {$bWeight} * machineScore as finalScore,
            0 as finalRank,
            DATE_ADD(icDate, INTERVAL 
                            IF(DAYNAME(icDate)  = 'Saturday', 2, 
                                    IF(DAYNAME(icDate)  = 'Friday', 3, 1)
                                            ) DAY) as planExecDate,
            DATE_ADD(icDate, INTERVAL 
                            IF(DAYNAME(icDate)  = 'Saturday', 2, 
                                    IF(DAYNAME(icDate)  = 'Friday', 3, 1)
                                            ) DAY) as actualExecDate																
            
            
            FROM
            `master`
            
            WHERE
            `master`.isActive = 1 and icDate = '{$analysisDate}'
            
            GROUP BY
            `master`.icDate,
            `master`.prospectTextID,
            `master`.ticker,
            `master`.RIC,
            `master`.`name`,
            `master`.country,
            `master`.sector,
            `master`.machineScore,
            `master`.machineRank,
            `master`.strategyNo
            
            having ifnull(vetoCount,0) = 0
            
            order by humanScore desc, machineRank asc
            limit {$portfolioCount};
EOT;
        $this->db->query($sql);
    }

    public function buildPortfolioMasterStep2($ic_date)
    {


        $sql = <<<EOT
        DELETE FROM portfolio_temp1 where 1=1
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
        ALTER TABLE portfolio_temp1 AUTO_INCREMENT = 1
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
        SELECT icd.icDate,  icd.portfolioCount
            FROM icdate icd
            where icd.icDate = '{$ic_date}';
EOT;
        $query = $this->db->query($sql);

        $result = $query->result();

        $analysisDate = $result[0]->icDate;
        $portfolioCount = $result[0]->portfolioCount;

        $sql = <<<EOT
        insert into portfolio_temp1
            SELECT
                strategyNo,
                memberName,
                memberNo,
                prospectTextID,
                icDate,
                ticker,
                RIC,
                `name`,
                country,
                sector,
                vetoCount,
                machineScore,
                machineRank,
                humanScore,
                humanRank,
                finalScore,
                0 as finalRank,
                planExecDate,
                actualExecDate
            
            FROM
                portfolio_temp2
            
            where portfolio_temp2.humanRank <= {$portfolioCount}
            
            order by finalScore desc, machineScore desc

EOT;
        $this->db->query($sql);
    }



    public function buildPortfolioMasterStep3($ic_date)
    {
        $sql = <<<EOT
      delete from portfolio where portfolio.icDate = '{$ic_date}' and portfolio.memberName = "master"
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
      insert into portfolio select * from portfolio_temp1
EOT;
        $this->db->query($sql);
    }



    public function buildPortfolioMasterALL($ic_date, $members)
    {
        foreach ($members as $member) {

            $sql = <<<EOT
            DELETE FROM portfolio_temp1 WHERE 1=1
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
		ALTER TABLE portfolio_temp1 auto_increment = 1
EOT;
        $this->db->query($sql);


            $sql = <<<EOT
        SELECT icd.icDate,  icd.portfolioCount
            FROM icdate icd
            where icd.icDate = '{$ic_date}';
EOT;
            $query = $this->db->query($sql);

            $result = $query->result();

            $analysisDate = $result[0]->icDate;
            $portfolioCount = $result[0]->portfolioCount;


        $sql = <<<EOT
			INSERT INTO portfolio_temp1  (
					strategyNo,
					memberName,
					memberNo,
					prospectTextID,
					icDate,
					ticker,
					RIC,
					`name`,
					country,
					sector,
					vetoCount,
					machineScore,
					machineRank,
					humanScore,
					humanRank,
					finalScore,
					finalRank,
					planExecDate,
					actualExecDate
		)
		SELECT
				strategyNo,
				memberName,
				memberNo,
				prospectTextID,
				icDate,
				ticker,
				RIC,
				`name`,
				country,
				sector,
				vetoFlag as vetoCount,
				machineScore,
				machineRank,
				humanScore,
				humanRank,
				humanScore as finalScore,
				0 as finalRank,
				DATE_ADD(icDate, INTERVAL 
                IF(DAYNAME(icDate)  = 'Saturday', 2, 
                        IF(DAYNAME(icDate)  = 'Friday', 3, 1)
                                ) DAY) as planExecDate,
				DATE_ADD(icDate, INTERVAL 
                IF(DAYNAME(icDate)  = 'Saturday', 2, 
                        IF(DAYNAME(icDate)  = 'Friday', 3, 1)
                                ) DAY) as actualExecDate							
		
			FROM
				`master`
			WHERE
				`master`.isActive = 1 AND
				ifnull(vetoFlag,0) = 0 AND
				memberNo = {$member['memberNo']} AND
				icDate = '{$analysisDate}'
			ORDER BY
				humanScore DESC, machineRank asc
				
				limit {$portfolioCount}
EOT;
            $this->db->query($sql);


            $sql = <<<EOT
            DELETE FROM  portfolio WHERE icDate = '{$ic_date}' and memberNo = {$member['memberNo']}
EOT;
            $this->db->query($sql);

            $sql = <<<EOT
			INSERT INTO portfolio
			(
					strategyNo,
					memberName,
					memberNo,
					prospectTextID,
					icDate,
					ticker,
					RIC,
					`name`,
					country,
					sector,
					vetoCount,
					machineScore,
					machineRank,
					humanRank,
					humanScore,
					finalRank,
					finalScore,
					planExecDate,
					actualExecDate
			)
				SELECT
					strategyNo,
					memberName,
					memberNo,
					prospectTextID,
					icDate,
					ticker,
					RIC,
					`name`,
					country,
					sector,
					vetoCount,
					machineScore,
					machineRank,
					finalRank as humanRank,
					humanScore,
					finalRank,
					finalScore,
					planExecDate,
					actualExecDate
				
				FROM 
					portfolio_temp1
EOT;
            $this->db->query($sql);

        }

    }
}
