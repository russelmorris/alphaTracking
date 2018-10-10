<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  CI_Input input
 * @property  M_auth m_auth
 * @property  M_ic m_ic
 * @property  M_icdate m_icdate
 * @property  CI_Security security
 * @property  M_current_ic_date m_current_ic_date
 */
class C_ic_dates extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_admin',
            'm_ic',
            'm_icdate',
            'm_factors',
            'm_current_ic_date'
        ]);

    }

    public function icDates()
    {

        $data['user'] = $this->session->userdata('user');
        $data['currentICDate'] = $this->m_current_ic_date->getCurrentIcDate();

        if ($data['user']['isAdmin'] == 1) {
            $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
            $data['users'] = $this->m_ic->getMembers();
            $data['ic_dates'] = $this->m_icdate->getIcDates($order = 'DESC');
            $this->load->template('v_ic_dates', $data);
        } else {
            redirect('dashboard');
        }
    }

    public function addNewIcDate()
    {
        $data['user'] = $this->session->userdata('user');
        if ($data['user']['isAdmin'] == 1) {
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = array(
                    'icDate' => $this->input->post('icDateDatePicker'),
                    'strategyNo' => $this->input->post('strategyNo'),
                    'planExecDate' => $this->input->post('planExecDateDataPicer'),
                    'planNextExecDate' => $this->input->post('planNextExecDateDatePicker'),
                    'portfolioCount' => $this->input->post('portfolioCount'),
                    'machineRunDate' => $this->input->post('machineRunDateDatePicker'),
                    'nextMachineRunDate' => $this->input->post('NextMachineRunDateDatePicker')
                );

                $this->db->insert('icdate', $data);

                $data['users'] = $this->m_ic->getMembers();

                foreach ($data['users'] as $user) {
                    $data['factors'] = $this->m_factors->createFactors($user['memberNo'], $this->input->post('icDateDatePicker'));
                }

                redirect("ic-dates", 'refresh');


            }
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $data['user'] = $this->session->userdata('user');
            $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
            $data['users'] = $this->m_ic->getMembers();
            $data['ic_dates'] = $this->m_icdate->getIcDates();

            $this->load->template('v_add_new_ic_date', $data);
        } else {
            redirect('dashboard');
        }
    }

    public function updateCurrentIcDate() {
        $data['user'] = $this->session->userdata('user');
        if ($data['user']['isAdmin'] == 1) {
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data['users'] = $this->m_current_ic_date->updateCurrentIcDate($this->input->post('currentIcDate'));
                redirect("ic-dates", 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }


}
