<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  Ci_input input
 * @property  M_voting m_voting
 * @property  M_master m_master
 * @property  M_factors m_factors
 * @property  M_prospects m_prospects
 * @property  M_ic m_ic
 * @property  M_teams m_teams
 * @property  M_icdate m_icdate
 * @property  M_portfolio m_portfolio
 */
class C_portfolio extends MY_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['m_ic']);
        $this->load->model(['m_teams']);
        $this->load->model(['m_icdate']);
        $this->load->model(['m_portfolio']);
    }

    public function portfolio_view($selectedIcDate = '')
    {
        $data = [];
        $data['user'] = $this->session->userdata('user');
        if ($data['user']['isAdmin'] != 1) {
            redirect('dashboard');
        }
        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
        $teams = $this->m_teams->getTeamsForPortfolio();
        $ic = $this->m_ic->getMembersForPortfolio();
        $data['members'] = array_merge($ic, $teams);
//        print_r($data['members']);
//        exit;
        $data['icDates'] = $this->m_icdate->getIcDates();
        if ($selectedIcDate === '') {
            $data['selectedIcDate'] = find_latest_date($data['icDates']);
        } else {
            $data['selectedIcDate'] = $selectedIcDate;
        }
        $data['portfolios'] = $this->m_portfolio->getPortfoliosByIcDate($data['selectedIcDate'],  $data['members']);

//        print_r($data['lastIcDate']);
//        print_r($data['icDates']);
//        print_r($data['portfolios']);
        $this->load->twigTemplate('v_portfolio_view', $data);
    }


}
