<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  M_calculation m_calculation
 * @property  M_icdate m_icdate
 */
class C_calculation extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_calculation',
            'm_icdate'
        ]);
    }

    public function create_human_score()
    {
        sleep(5);
        $icDate = $this->input->post('ic_date', '');
        $currentDateTimestamp = strtotime(date('Y-m-d'));
        $icDateTimestamp = strtotime($icDate);

        if ($icDate == ''){
            echo 'No IcDate is selected';
            return;
        }
        if ($this->m_icdate->checkIfIcDateExist($icDate) == 0 ) {
            echo 'Wrong IcDate';
            return;
        }

        if ($currentDateTimestamp >  $icDateTimestamp ) {
            echo 'icDate from the past';
            return;
        }

        $this->m_calculation->writeToFactorStats($icDate);
        $this->m_calculation->updateFactoryStats();
        $this->m_calculation->updateFactoryStats();
        $this->m_calculation->writeTempAggZScore();
        $this->m_calculation->updateMasterWithHumanScores();

        echo 'Human Score has been created';
        return;

    }


}
