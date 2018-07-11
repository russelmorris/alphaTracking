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
        $data['ic_dates']                  = $this->m_icdate->getICDates();
        $data['closest_icDate_from_today'] = $this->find_closest_date(array_column($data['ic_dates'], 'icDate'),
            time());
        $data['ic_dashboard']              = [];
        $data['finalised']                 = $this->m_master->finalised($data['user']['memberNo']);

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
        $data['selectedUser'] = json_decode($this->input->post('user_id'));
        $sessionUser          = [];
        if ( ! $data['selectedUser']) {
            $sessionUser = $this->session->userdata('user');
        }
//        $limit = json_decode($this->input->post('limit'));

        if ( ! $data['selectedUser']) {
            $data['user']  = $sessionUser;
            $data['admin'] = ( ! $data['user']['isAdmin']) ? false : $data['user'];
            if ($data['user']['isAdmin']) {
                $data['admin_users'] = $this->m_ic->getMembers();
            }
            $data['ic_dates']                  = $this->m_icdate->getICDates();
            $data['closest_icDate_from_today'] = $this->find_closest_date(array_column($data['ic_dates'], 'icDate'),
                time());
            $data['ic_dashboard']              = (isset($limit)) ? $this->m_prospects->getProspectsByDateAndId($sessionUser['memberNo'],
                $data['selectedDate'], $limit) : $this->m_prospects->getProspectsByDateAndId($sessionUser['memberNo'],
                $data['selectedDate']);
            $data['finalised']                 = $this->m_master->finalised($data['user']['memberNo']);
        } else {
            $data['user'] = $this->m_ic->getUserByID($data['selectedUser']);
            $this->session->set_userdata('admin_subuser', $data['user']);
            $data['admin'] = ( ! $data['user']['isAdmin']) ? false : $data['user'];
            if ($data['user']['isAdmin']) {
                $data['admin_users'] = $this->m_ic->getMembers();
            }
            $data['ic_dates']                  = $this->m_icdate->getICDates();
            $data['closest_icDate_from_today'] = $this->find_closest_date(array_column($data['ic_dates'], 'icDate'),
                time());
            $data['ic_dashboard']              = (isset($limit)) ? $this->m_prospects->getProspectsByDateAndId($data['user']['memberNo'],
                $data['selectedDate'], $limit) : $this->m_prospects->getProspectsByDateAndId($data['user']['memberNo'],
                $data['selectedDate']);
            $data['finalised']                 = $this->m_master->finalised($data['user']['memberNo']);
        }
        $this->load->view('partial/v_dashboard', $data);
    }

    public function addDataToMaster()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
//        $user                 = $this->session->userdata('user');
        $populate_master_data = [
            'ticker'    => $this->input->post('ticker'),
            'user_id'   => json_decode($this->input->post('user_id')),
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
        if ( ! $populate_master_data['user_id']) {
            $user = $this->session->userdata('user');
        } else {
            $user = $this->m_ic->getUserByID($populate_master_data['user_id']);
        }
        if ( ! is_null($populate_master_data['ticker'])) {
            if ( ! is_null($populate_master_data['fc1'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    1, $populate_master_data['fc1']);
            }
            if ( ! is_null($populate_master_data['fc2'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    2, $populate_master_data['fc2']);
            }
            if ( ! is_null($populate_master_data['fc3'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    3, $populate_master_data['fc3']);
            }
            if ( ! is_null($populate_master_data['fc4'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    4, $populate_master_data['fc4']);
            }
            if ( ! is_null($populate_master_data['fc5'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    5, $populate_master_data['fc5']);
            }
            if ( ! is_null($populate_master_data['fc6'])) {
                $this->m_voting->updateFactor($user['memberNo'], $populate_master_data['ticker'],
                    6, $populate_master_data['fc6']);
            }
            if ( ! is_null($populate_master_data['veto']) && $populate_master_data['flag'] == 'veto') {
                $this->m_master->setVetoFlag($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['veto']);
            }
            if ( ! is_null($populate_master_data['finalised']) && $populate_master_data['flag'] == 'finalised') {
                $this->m_master->setFinaliseFlag($user['memberNo'], $populate_master_data['ticker'],
                    $populate_master_data['finalised']);
            }
        }
    }


    private function find_closest_date($array, $date)
    {
        foreach ($array as $day) {
            $interval[] = abs(strtotime($date) - strtotime($day));
        }
        asort($interval);
        $closest = key($interval);

        return $array[$closest + 1];
    }
}
