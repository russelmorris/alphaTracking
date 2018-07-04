<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  M_user m_user
 */
class C_dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');
    }


    public function dashboard()
    {
        $user                 = $this->session->userdata('user');
        $data['ic_dashboard'] = $this->m_user->getProspectsByDateAndId($user['memberNo'], '2018-08-01');
        $data['user']         = $user;
        $data['ic_dates']     = array_unique(array_column($data['ic_dashboard'], 'icDate'));
//        $data['finalised'] = $this->m_user->count_finalised($user['memberNo']);

        $this->load->template('v_dashboard', $data);
    }

    public function addDataToMaster()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $user                 = $this->session->userdata('user');
        $populate_master_data = [
            'ticker'    => $this->input->post('ticker'),
            'fc1'       => $this->input->post('fc1'),
            'fc2'       => $this->input->post('fc2'),
            'fc3'       => $this->input->post('fc3'),
            'fc4'       => $this->input->post('fc4'),
            'fc5'       => $this->input->post('fc5'),
            'fc6'       => $this->input->post('fc6'),
            'veto'      => json_decode($this->input->post('veto')),
            'finalised' => json_decode($this->input->post('finalised')),
            'flag'      => $this->input->post('flag')
        ];
        if ( ! is_null($populate_master_data['ticker'])) {
            if ( ! is_null($populate_master_data['fc1'])) {
                $this->m_user->updateFactorsMasterData($user['memberNo'], $populate_master_data['ticker'], 1,
                    $populate_master_data['fc1']);
            }
            if ( ! is_null($populate_master_data['fc2'])) {
                $this->m_user->updateFactorsMasterData($user['memberNo'], $populate_master_data['ticker'], 2,
                    $populate_master_data['fc2']);
            }
            if ( ! is_null($populate_master_data['fc3'])) {
                $this->m_user->updateFactorsMasterData($user['memberNo'], $populate_master_data['ticker'], 3,
                    $populate_master_data['fc3']);
            }
            if ( ! is_null($populate_master_data['fc4'])) {
                $this->m_user->updateFactorsMasterData($user['memberNo'], $populate_master_data['ticker'], 4,
                    $populate_master_data['fc4']);
            }
            if ( ! is_null($populate_master_data['fc5'])) {
                $this->m_user->updateFactorsMasterData($user['memberNo'], $populate_master_data['ticker'], 5,
                    $populate_master_data['fc5']);
            }
            if ( ! is_null($populate_master_data['fc6'])) {
                $this->m_user->updateFactorsMasterData($user['memberNo'], $populate_master_data['ticker'], 6,
                    $populate_master_data['fc6']);
            }
            if ( ! is_null($populate_master_data['veto']) && $populate_master_data['flag'] == 'veto') {
                $this->m_user->setVetoFlag($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['veto']);
            }
            if ( ! is_null($populate_master_data['finalised']) && $populate_master_data['flag'] == 'finalised') {
                $this->m_user->setFinaliseFlag($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['finalised']);
            }
        }

    }
}
