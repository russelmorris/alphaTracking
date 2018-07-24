<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  M_calculation m_calculation
 * @property  M_icdate m_icdate
 * @property  M_portfolio m_portfolio
 */
class C_calculation extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_calculation',
            'm_icdate',
            'm_portfolio'
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
        $this->m_calculation->updateVotingWithZScore();
        $this->m_calculation->writeTempAggZScore();
        $this->m_calculation->updateMasterWithHumanScores();

        echo 'Human Score has been created';
        return;

    }

    public function buildPortfolio()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $ic_date = $this->input->post('date');

        $this->m_portfolio->buildPortfolioMasterStep1($ic_date);
        $this->m_portfolio->buildPortfolioMasterStep2($ic_date);
        $this->m_portfolio->buildPortfolioMasterStep3($ic_date);
        $this->m_portfolio->buildPortfolioMasterALL($ic_date);
        echo 'Portfolio has been builded';
        return;
    }


}
