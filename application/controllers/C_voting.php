<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  Ci_input input
 * @property  M_voting m_voting
 * @property  M_master m_master
 */
class C_voting extends MY_Controller
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
        $this->load->model(['m_voting', 'm_master']);
    }

    public function voting($icDate, $ticker)
    {
        $data                  = [];
        $data['icdate']        = $icDate;
        $data['ticker']        = $ticker;
        $data['user']          = $this->session->userdata('user');
        $data['sub_user']      = $this->session->userdata('admin_subuser') ?
            $this->session->userdata('admin_subuser') : false;
        $data['voting_values'] = $this->m_voting->getLatestVotingValues(
            $data['sub_user'] ? $data['sub_user']['memberNo'] : $data['user']['memberNo'],
            $ticker, $icDate);
        $data['url']           = $this->m_voting->getSWSurl(
            $data['sub_user'] ? $data['sub_user']['memberNo'] : $data['user']['memberNo'],
            $ticker);
        $data['admin']         = ( ! $data['user']['isAdmin']) ? false : $data['user'];
        $this->load->template('v_voting', $data);
    }

    public function submit_voting()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }

        $populate_voting_data            = [
            'ticker'    => $this->input->post('ticker'),
            'ic_date'   => $this->input->post('ic_date'),
            'user_id'   => $this->input->post('user_id'),
            'fc1'       => $this->input->post('fc1'),
            'fc2'       => $this->input->post('fc2'),
            'fc3'       => $this->input->post('fc3'),
            'fc4'       => $this->input->post('fc4'),
            'fc5'       => $this->input->post('fc5'),
            'fc6'       => $this->input->post('fc6'),
            'veto'      => json_decode($this->input->post('veto')),
            'finalised' => json_decode($this->input->post('finalised')),
        ];
        $admin                           = $this->session->userdata('user');
        $admin_subuser                   = $this->session->userdata('admin_subuser');
        $populate_voting_data['user_id'] = ($populate_voting_data['user_id'] == $admin['memberNo']) ?
            $admin['memberNo'] : $admin_subuser['memberNo'];
        if ( ! is_null($populate_voting_data['ticker']) && ! is_null($populate_voting_data['user_id'])) {
            if ( ! is_null($populate_voting_data['fc1'])) {
                $this->m_voting->updateFactor($populate_voting_data['user_id'], $populate_voting_data['ticker'],
                    $populate_voting_data['ic_date'], 1, $populate_voting_data['fc1']);
            }
            if ( ! is_null($populate_voting_data['fc2'])) {
                $this->m_voting->updateFactor($populate_voting_data['user_id'], $populate_voting_data['ticker'],
                    $populate_voting_data['ic_date'], 2, $populate_voting_data['fc2']);
            }
            if ( ! is_null($populate_voting_data['fc3'])) {
                $this->m_voting->updateFactor($populate_voting_data['user_id'], $populate_voting_data['ticker'],
                    $populate_voting_data['ic_date'], 3, $populate_voting_data['fc3']);
            }
            if ( ! is_null($populate_voting_data['fc4'])) {
                $this->m_voting->updateFactor($populate_voting_data['user_id'], $populate_voting_data['ticker'],
                    $populate_voting_data['ic_date'], 4, $populate_voting_data['fc4']);
            }
            if ( ! is_null($populate_voting_data['fc5'])) {
                $this->m_voting->updateFactor($populate_voting_data['user_id'], $populate_voting_data['ticker'],
                    $populate_voting_data['ic_date'], 5, $populate_voting_data['fc5']);
            }
            if ( ! is_null($populate_voting_data['fc6'])) {
                $this->m_voting->updateFactor($populate_voting_data['user_id'], $populate_voting_data['ticker'],
                    $populate_voting_data['ic_date'], 6, $populate_voting_data['fc6']);
            }
            if ( ! is_null($populate_voting_data['veto'])) {
                $this->m_master->setVetoFlag($populate_voting_data['user_id'], $populate_voting_data['ticker'],
                    $populate_voting_data['ic_date'], $populate_voting_data['veto']);
            }
            if ( ! is_null($populate_voting_data['finalised'])) {
                $this->m_master->setFinaliseFlag($populate_voting_data['user_id'], $populate_voting_data['ticker'],
                    $populate_voting_data['ic_date'], $populate_voting_data['finalised']);
            }
        }
    }
}
