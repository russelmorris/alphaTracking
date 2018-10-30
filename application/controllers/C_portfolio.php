<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  Ci_input input
 * @property  M_voting m_voting
 * @property  M_master m_master
 * @property  M_factors m_factors
 * @property  M_prospects m_prospects
 * @property  M_ic m_ic
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
    }

    public function portfolio_view()
    {
        $data = [];
        $data['user'] = $this->session->userdata('user');
        $data['sub_user'] = $this->session->userdata('admin_subuser') ?
            $this->session->userdata('admin_subuser') : false;
        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
        $data['members'] = $this->m_ic->getMembers();
        $this->load->twigTemplate('v_portfolio_view', $data);
    }


}
