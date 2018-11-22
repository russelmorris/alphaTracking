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


    public function getPortfoliosByIcDate($icDate, $members){
        $this->db->select('p.name');
        $this->db->select('p.RIC');
        $this->db->select('p.sector');
        $this->db->select('p.country');

        foreach($members as $member) {
            $this->db->select("(select  p".$member['memberNo'].".humanRank   from portfolio as  p".$member['memberNo']." where p".$member['memberNo'].".RIC= p.RIC and p".$member['memberNo'].".`icDate` = '".$icDate."' and p".$member['memberNo'].".memberNo = ".$member['memberNo']."  ) AS member_".$member['memberNo'], false);
        }
        $this->db->where('p.icDate', $icDate);
        $this->db->from('portfolio as p');
        $this->db->group_by('p.RIC');
        $query = $this->db->get();

        $result = $query->result_array();
        return $result;
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
            `master`.tag,
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
            `master`.tag,
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
                tag,
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
					tag,
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
				tag,
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
					tag,
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
					tag,
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

    public function buildTeamsPortfoliosLoop($ic_date, $teams)
    {

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
        SELECT count(RIC) as prospectCount 
            FROM prospects
            where prospects.icDate = '{$ic_date}';
EOT;
        $query = $this->db->query($sql);

        $result = $query->result();

        $prospectCount = $result[0]->prospectCount;

        foreach ($teams as $team) {

            $sql = <<<EOT
            DELETE FROM portfolio_temp1 WHERE 1=1
EOT;
            $this->db->query($sql);


            $sql = <<<EOT
		ALTER TABLE portfolio_temp1 auto_increment = 1
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
					`name`,
					country,
					sector,
					tag,
					vetoCount,
					machine1Weight,
					machine2Weight,
					machine3Weight,
					humanWeight,
					machineScore,
					machineRank,
					m1RankScore,
					machineScore2,
					machineRank2,
					m2RankScore,
					machineScore3,
					machineRank3,
					m3RankScore,
					humanScore,
					humanRank,
					finalScore,
					finalRank,
					planExecDate,
					actualExecDate
		)
		SELECT
				`master`.strategyNo,
                teams.teamName as memberName,
                teams.teamID as memberNo,
                `master`.prospectTextID,
                `master`.icDate,
                `master`.ticker,
                `master`.RIC,
                `master`.`name`,
                `master`.country,
                `master`.sector,
                `master`.tag,
                sum(if(`master`.vetoFlag,1,0)) as vetoCount,
                teams.machine1Weight,
                teams.machine2Weight,
                teams.machine3Weight,
                teams.humanWeight,
                `master`.machineScore,
                `master`.machineRank,
                ({$prospectCount} - `master`.machineRank) / {$prospectCount} as m1RankScore,
                `master`.machineScore2,
                `master`.machineRank2,
                ({$prospectCount} - `master`.machineRank2) / {$prospectCount} as m2RankScore,
                `master`.machineScore3,
                `master`.machineRank3,
                ({$prospectCount} - `master`.machineRank3) / {$prospectCount} as m3RankScore,
                Sum(`master`.humanScore * teamMembers.bWeight) / sum(teamMembers.bWeight) as humanScore,
                0 as humanRank,
                ((ifnull(teams.machine1Weight * ({$prospectCount} -`master`.machineRank)/{$prospectCount},0)
                  + ifnull(teams.machine2Weight * ({$prospectCount} -`master`.machineRank2) /{$prospectCount},0)
                    + ifnull(teams.machine3Weight * ({$prospectCount} -`master`.machineRank3) /{$prospectCount},0)
                    + ifnull(teams.humanWeight * Sum(`master`.humanScore * teamMembers.bWeight)/sum(teamMembers.bWeight),0)) / (machine1Weight + machine2Weight + machine3Weight + humanWeight)) as finalScore,
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
                (teams inner join teamMembers on teams.teamID = teamMembers.teamID)
                inner join `master` on (`master`.memberNo  = teamMembers.memberNo)
			  
			WHERE
				`master`.isActive = 1 
				AND icDate = '{$analysisDate}' 
				AND (teams.teamID = {$team['teamID']})
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
                `master`.strategyNo,
                teams.teamName
            order by finalScore desc, machineRank asc
			limit {$portfolioCount}
EOT;
            $this->db->query($sql);


            $sql = <<<EOT
            DELETE FROM  portfolio WHERE icDate = '{$ic_date}' and memberNo = {$team['teamID']}
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
					tag,
					vetoCount,
					machine1Weight,
					machine2Weight,
					machine3Weight,
					humanWeight,
					machineScore,
					machineRank,
					m1RankScore,
					machineScore2,
					machineRank2,
					m2RankScore,
					machineScore3,
					machineRank3,
					m3RankScore,
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
					tag,
					vetoCount,
					machine1Weight,
					machine2Weight,
					machine3Weight,
					humanWeight,
					machineScore,
					machineRank,
					m1RankScore,
					machineScore2,
					machineRank2,
					m2RankScore,
					machineScore3,
					machineRank3,
					m3RankScore,
					humanScore,
					humanRank,
					finalScore,
					finalRank,
					planExecDate,
					actualExecDate
				
				FROM 
					portfolio_temp1
EOT;
            $this->db->query($sql);

        }

    }

    public function buildICPortfolioAll($ic_date, $members)
    {

        $sql = <<<EOT
        SELECT icd.icDate,  icd.portfolioCount
            FROM icdate icd
            where icd.icDate = '{$ic_date}';
EOT;
        $query = $this->db->query($sql);

        $result = $query->result();

        $analysisDate = $result[0]->icDate;
        $portfolioCount = $result[0]->portfolioCount;

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
					tag,
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
				tag,
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
					tag,
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
					tag,
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
