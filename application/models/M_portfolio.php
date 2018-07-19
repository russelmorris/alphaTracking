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

    public function buildPorfolioMasterStep1($ic_date)
    {
        $query = "delete from portfolio_temp2;

alter table portfolio_temp2 auto_increment = 1;

select bWeight into @a from ic where memberName = \"machine\";
select max(icDate) into @analysisDate from icdate;

insert into portfolio_temp2

SELECT
`master`.strategyNo,
\"master\" as memberName,
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
Sum(`master`.bWeightedHumanScore) + @a * machineScore as finalScore,
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
`master`.isActive = 1 and icDate = @analysisDate

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
`master`.DateModified

having vetoCount = 0

order by humanScore desc
";
    }

    public function buildPorfolioMasterStep2($ic_date)
    {
        $query = "delete from portfolio_temp1;

alter table portfolio_temp1 auto_increment = 1;

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


order by finalScore desc;
";
    }

    public function buildPorfolioMasterStep3($ic_date)
    {
        $query = "select icdate into @analysisDate from portfolio_temp1 group by icDate;

delete from portfolio where portfolio.icDate = @analysisDate and portfolio.memberName = \"master\";

insert into portfolio select * from portfolio_temp1;";
    }

    public function buildPorfolioMaster($ic_date)
    {
        echo $ic_date;

        $query = "DELIMITER $$
DROP PROCEDURE IF EXISTS ic_loop;
CREATE PROCEDURE ic_loop()
BEGIN

	DECLARE v_finished INTEGER DEFAULT 0;
	DECLARE member INT ;  
	DECLARE analysisDate DATE;
	
 	-- declare cursor for icMember
	DECLARE ic_members CURSOR 
		FOR SELECT memberNo as member FROM ic where isActive = 1 and strategyNo = 1;

   -- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
      FOR NOT FOUND SET v_finished = 1;
  -- Open Cursor        
	OPEN ic_members;
      -- Create loop
		get_icMember: LOOP
			-- fetch next row from ic cursor
			FETCH ic_members INTO member;
			
			-- Chek if end of the loop
			IF v_finished = 1 THEN 
			 	LEAVE get_icMember;
			END IF;
			select member;	

 /*
      Your coge START here
      You can use 'member' variable from the loop
 */
 	
		SELECT max(icDate) INTO analysisDate FROM icdate;
		select analysisDate;
	
		DELETE FROM portfolio_temp1;
		
		ALTER TABLE portfolio_temp1 auto_increment = 1;
	
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
				vetoFlag is null AND
				memberNo = member
			ORDER BY
				humanScore DESC;


			DELETE FROM  portfolio WHERE icDate = analysisDate and memberNo = member;
	
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
					portfolio_temp1;


 /*
      Your coge END here
 */	
      -- End of the loop		
		END LOOP get_icMember;
 
   -- close Cursor
	CLOSE ic_members;
	
END $$

call ic_loop();

-- DROP PROCEDURE ic_loop;
";
    }
}
