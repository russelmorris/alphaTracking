<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  CI_Input input
 * @property  M_ic m_ic
 * @property  M_icdate m_icdate
 * @property  M_factors m_factors
 * @property  CI_Security security
 */
class C_factors extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_ic',
            'm_icdate',
            'm_factors'
        ]);
    }

    public function factorWeights()
    {
        $data['user'] = $this->session->userdata('user');
        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
        if ($data['user']['isAdmin']) {
            $data['admin_users'] = $this->m_ic->getMembers();
        }
        $data['ic_dates'] = $this->m_icdate->getICDates();
        $data['closest_icDate_from_today'] = find_closest_date(array_column($data['ic_dates'], 'icDate'));
        $data['factorWeights'] = $this->m_factors->getFactorWeights($data['user']['memberNo'],$data['closest_icDate_from_today']);
        $this->load->template('v_factor_weights', $data);
    }

}
