<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  CI_URI uri
 * @property  M_ic m_ic
 * @property  M_icdate m_icdate
 * @property  M_master m_master
 * @property  M_voting m_voting
 * @property  M_prospects m_prospects
 */
class C_dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_admin',
            'm_ic',
            'm_icdate',
            'm_master',
            'm_voting',
            'm_prospects'
        ]);
    }


    public function dashboard()
    {
        $data['user']  = $this->session->userdata('user');
        $data['admin'] = ( ! $data['user']['isAdmin']) ? false : $data['user'];
        if ($data['user']['isAdmin']) {
            $data['admin_users'] = $this->m_ic->getMembers();
        }
        $data['ic_dates']     = $this->m_icdate->getICDates();
        $data['ic_dashboard'] = $this->m_prospects->getProspectsByDateAndId(
            $data['user']['memberNo'],
            end($data['ic_dates'])['icDate']
        );
        $data['ic_dashboard'] = [];
//        print_r($data['ic_dashboard']);
        $this->load->template('v_dashboard', $data);
    }

    public function dashboard_ajax()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $data                 = [];
        $data['selectedDate'] = $this->input->post('ic_date');
        $data['selectedUser'] = $this->input->post('user_id');
//        $limit = json_decode($this->input->post('limit'));
        $sessionUser          = $this->session->userdata('user');
        if ($data['selectedUser'] == $sessionUser['memberNo']) {
            $data['user']         = $sessionUser;
            $data['ic_dates']     = $this->m_icdate->getICDates();
            $data['ic_dashboard'] = (isset($limit)) ? $this->m_prospects->getProspectsByDateAndId($sessionUser['memberNo'],
                $data['selectedDate'], $limit) : $this->m_prospects->getProspectsByDateAndId($sessionUser['memberNo'],
                $data['selectedDate']);
            $this->load->view('partial/v_dashboard', $data);
        } else {
            $data['user']         = $this->m_ic->getUserByID($data['selectedUser']);
            $data['ic_dates']     = $this->m_icdate->getICDates();
            $data['ic_dashboard'] = (isset($limit)) ? $this->m_prospects->getProspectsByDateAndId($sessionUser['memberNo'],
                $data['selectedDate'], $limit) : $this->m_prospects->getProspectsByDateAndId($sessionUser['memberNo'],
                $data['selectedDate']);
            $this->load->view('partial/v_dashboard', $data);
        }
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
            'master'    => $this->input->post('master'),
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
        var_dump($populate_master_data);
        if ( ! is_null($populate_master_data['ticker']) && ! is_null($populate_master_data['master'])) {
            if ( ! is_null($populate_master_data['fc1'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['master'], 1, $populate_master_data['fc1']);
            }
            if ( ! is_null($populate_master_data['fc2'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['master'], 2, $populate_master_data['fc2']);
            }
            if ( ! is_null($populate_master_data['fc3'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['master'], 3, $populate_master_data['fc3']);
            }
            if ( ! is_null($populate_master_data['fc4'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['master'], 4, $populate_master_data['fc4']);
            }
            if ( ! is_null($populate_master_data['fc5'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['master'], 5, $populate_master_data['fc5']);
            }
            if ( ! is_null($populate_master_data['fc6'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['master'], 6, $populate_master_data['fc6']);
            }
        } else {
            if ( ! is_null($populate_master_data['veto']) && $populate_master_data['flag'] == 'veto' && ! is_null($populate_master_data['master'])) {
                $this->m_master->setVetoFlag($user['memberNo'], $populate_master_data['master'],
                    $populate_master_data['veto']);
            }
            if ( ! is_null($populate_master_data['finalised']) && $populate_master_data['flag'] == 'finalised' && ! is_null($populate_master_data['master'])) {
                $this->m_master->setFinaliseFlag($user['memberNo'], $populate_master_data['master'],
                    $populate_master_data['finalised']);
            }
        }

    }
}
