<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 10/10/2018
 * Time: 9:15 PM
 */
/**
 * @property  CI_Session session
 * @property  Ci_input input
 * @property  M_admin m_admin
 * @property  M_prospects m_prospects
 * @property  M_voting m_voting
 * @property  M_ic m_ic
 * @property  M_factors m_factors
 * @property  M_master m_masterF
 * @property  M_icdate m_icdate
 * @property  M_master m_master
 * @property  M_portfolio m_portfolio
 */
class C_example extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_admin',
            'm_ic',
            'm_factors',
            'm_icdate',
            'm_prospects',
            'm_master',
            'm_voting'
        ]);
    }

    public function pivotTable(){
        $this->load->helper('string');
        $data = [];
        $data['user']                      = $this->session->userdata('user');
        $data['admin']                     = ( ! $data['user']['isAdmin']) ? false : $data['user'];
        $data['members'] = $this->m_ic->getMembers();
        $this->load->template('v_pivot_table', $data);
    }

}