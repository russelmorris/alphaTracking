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
        $data['user'] = $this->session->userdata('user');
        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
        if ($data['user']['isAdmin']) {
            $data['admin_users'] = $this->m_ic->getMembers();
        }
        $data['ic_dates'] = $this->m_icdate->getICDates();
        $data['closest_icDate_from_today'] = $this->find_closest_date(array_column($data['ic_dates'], 'icDate'),
            time());
        $data['ic_dashboard'] = [];
        $data['finalised'] = $this->m_master->finalised($data['user']['memberNo']);

        $this->load->template('v_dashboard', $data);
    }

    public function dashboard_ajax()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $data = [];
        $data['selectedDate'] = $this->input->post('ic_date');
        $data['selectedUser'] = json_decode($this->input->post('user_id'));
        $sessionUser = [];
        if (!$data['selectedUser']) {
            $sessionUser = $this->session->userdata('user');
        }
//        $limit = json_decode($this->input->post('limit'));

        if (!$data['selectedUser']) {
            $data['user'] = $sessionUser;
            $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
            if ($data['user']['isAdmin']) {
                $data['admin_users'] = $this->m_ic->getMembers();
            }
            $data['ic_dates'] = $this->m_icdate->getICDates();
            $data['closest_icDate_from_today'] = $this->find_closest_date(array_column($data['ic_dates'], 'icDate'),
                time());
            $data['ic_dashboard'] = (isset($limit)) ? $this->m_prospects->getProspectsByDateAndId($sessionUser['memberNo'],
                $data['selectedDate'], $limit) : $this->m_prospects->getProspectsByDateAndId($sessionUser['memberNo'],
                $data['selectedDate']);
            $data['finalised'] = $this->m_master->finalised($data['user']['memberNo']);
        } else {
            $data['user'] = $this->m_ic->getUserByID($data['selectedUser']);
            $this->session->set_userdata('admin_subuser', $data['user']);
            $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
            if ($data['user']['isAdmin']) {
                $data['admin_users'] = $this->m_ic->getMembers();
            }
            $data['ic_dates'] = $this->m_icdate->getICDates();
            $data['closest_icDate_from_today'] = $this->find_closest_date(array_column($data['ic_dates'], 'icDate'),
                time());
            $data['ic_dashboard'] = $this->m_prospects->getProspectsByDateAndId($data['user']['memberNo'],$data['selectedDate']);
            $data['finalised'] = $this->m_master->finalised($data['user']['memberNo']);
        }

        $this->load->view('partial/v_dashboard_table', $data);
    }

    public function updateFactor()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $postData = $this->input->post();
        $userData = $this->session->userdata('user');

        if ($userData['isAdmin'] == 0){
            $memberNo = $userData['memberNo'];
        } else {
            $memberNo = $postData['user_id'];
        }


        $this->m_voting->updateFactor(
            $memberNo,
            $postData['ticker'],
            $postData['ic_date'],
            $postData['factor'],
            $postData['value']
        );
        return;
    }


    public function updateVeto()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $postData = $this->input->post();
        $userData = $this->session->userdata('user');

        if ($userData['isAdmin'] == 0){
            $memberNo = $userData['memberNo'];
        } else {
            $memberNo = $postData['user_id'];
        }

        $newVetoValue = $this->m_master->setVetoFlag(
            $memberNo,
            $postData['ticker'],
            $postData['ic_date']
        );
        echo $newVetoValue;
        return;
    }

    public function updateFinalise()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $postData = $this->input->post();
        $userData = $this->session->userdata('user');

        if ($userData['isAdmin'] == 0){
            $memberNo = $userData['memberNo'];
        } else {
            $memberNo = $postData['user_id'];
        }
        $newFinalisedValue = $this->m_master->setFinaliseFlag(
            $memberNo,
            $postData['ticker'],
            $postData['ic_date']
        );
        echo $newFinalisedValue;
        return;
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
