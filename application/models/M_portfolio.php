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
        DELETE FROM portfolio_temp2 WHERE 1=1;
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
            ALTER TABLE portfolio_temp2 AUTO_INCREMENT = 1;
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
        SELECT bWeight INTO @a
            FROM ic
            WHERE memberName = "machine";
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
        INSERT INTO portfolio_temp2
          SELECT temp.* from (
            SELECT
                    master.strategyNo, master.memberName AS memberName,
                    0 AS memberNo,
                    master.prospectTextID,
                    master.icDate,
                    master.ticker,
                    master.RIC,
                    master.name,
                    master.country,
                    master.sector, SUM(IF(master.vetoFlag,1,0)) AS vetoCount,
                    master.machineScore,
                    master.machineRank, SUM(master.bWeightedHumanScore) AS humanScore,
                    0 AS humanRank, SUM(master.bWeightedHumanScore) + @a * machineScore AS finalScore,
                    0 AS finalRank, 
                    DATE_ADD(icDate, INTERVAL IF(DAYNAME(icDate) = 'Saturday', 2, IF(DAYNAME(icDate) = 'Friday', 3, 1)) DAY) AS planExecDate, 
                    DATE_ADD(icDate, INTERVAL IF(DAYNAME(icDate) = 'Saturday', 2, IF(DAYNAME(icDate) = 'Friday', 3, 1)) DAY) AS actualExecDate
                FROM master
                WHERE
                    master.isActive = 1 AND icDate = '{$analysisDate}'
                GROUP BY
                    master.icDate,
                    master.prospectTextID,
                    master.ticker,
                    master.RIC,
                    master.name,
                    master.country,
                    master.sector,
                    master.machineScore,
                    master.machineRank,
                    master.strategyNo,
                    master.DateModified
                HAVING vetoCount = 0
                ORDER BY humanScore DESC
          ) as temp
          limit  {$portfolioCount};
EOT;
        $this->db->query($sql);
    }

    public function buildPortfolioMasterStep2($ic_date)
    {
        $sql = <<<EOT
        DELETE FROM portfolio_temp1 where 1=1; 
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
        ALTER TABLE portfolio_temp1 AUTO_INCREMENT = 1;
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
        INSERT INTO portfolio_temp1
          SELECT temp.* from (
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
                0 AS finalRank,
                planExecDate,
                actualExecDate
            FROM
                portfolio_temp2
            GROUP BY
                icDate,
                prospectTextID,
                ticker,
                RIC,
                `name`,
                country,
                sector,
                machineScore,
                machineRank,
                strategyNo
            ORDER BY finalScore 
            DESC
          ) as temp
          limit  {$portfolioCount};
EOT;
        $this->db->query($sql);
    }

    public function buildPortfolioMasterStep3($ic_date)
    {
        $sql = <<<EOT
        SELECT icdate INTO @analysisDate	
            FROM portfolio_temp1
            GROUP BY icDate
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
       DELETE
            FROM portfolio
            WHERE portfolio.icDate = @analysisDate AND portfolio.memberName = "master"
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
       INSERT INTO portfolio
            SELECT *
                FROM portfolio_temp1;
EOT;
        $this->db->query($sql);
    }

    public function buildPortfolioMasterALL($ic_date, $members)
    {
        foreach ($members as $member) {

            $sql = <<<EOT
            DELETE FROM portfolio_temp1 WHERE 1=1;
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
		ALTER TABLE portfolio_temp1 auto_increment = 1;
EOT;
        $this->db->query($sql);


        $sql = <<<EOT
		INSERT INTO portfolio_temp1  (
					strategyNo,
					memberName,
					memberNo,
					prospectTextID,
					icDate,
					ticker,
					RIC,
					name,
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
				0 as humanRank,
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
				master
		
			WHERE
				master.isActive = 1 AND
				vetoFlag is null AND
				memberNo = {$member['memberNo']} AND
				master.icDate = '{$ic_date}'
			ORDER BY
				humanScore DESC;
EOT;
            $this->db->query($sql);


            $sql = <<<EOT
            DELETE FROM  portfolio WHERE icDate = '{$ic_date}' and memberNo = {$member['memberNo']};
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
					name,
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
					name,
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
					portfolio_temp1;
EOT;
            $this->db->query($sql);

        }

    }
}
