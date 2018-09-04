<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  CI_Input input
 * @property  M_auth m_auth
 * @property  M_ic m_ic
 * @property  M_icdate m_icdate
 * @property  CI_Security security
 */
class C_ic_dates extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_admin',
            'm_ic',
            'm_icdate'
        ]);

    }

    public function icDates(){
        $data['user']                      = $this->session->userdata('user');
        $data['admin']                     = ( ! $data['user']['isAdmin']) ? false : $data['user'];
        $data['users']                     = $this->m_ic->getMembers();
        $data['ic_dates']                  = $this->m_icdate->getIcDates();
        $this->load->template('v_ic_dates', $data);

//        print_f($data['ic_dates']);
    }

    public function addNewIcDate(){
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $data = array(
                'icDate'                => $this->input->post('icDateDatePicker'),
                'strategyNo'            => $this->input->post('strategyNo'),
                'planExecDate'          => $this->input->post('planExecDateDataPicer'),
                'planNextExecDate'      => $this->input->post('planNextExecDateDatePicker'),
                'portfolioCount'        => $this->input->post('portfolioCount'),
                'machineRunDate'        => $this->input->post('machineRunDateDatePicker'),
                'nextMachineRunDate'    => $this->input->post('NextMachineRunDateDatePicker')
            );

            $this->db->insert('icdate',$data);
            redirect("ic-dates", 'refresh');
        }
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['user']                      = $this->session->userdata('user');
        $data['admin']                     = (! $data['user']['isAdmin']) ? false : $data['user'];
        $data['users']                     = $this->m_ic->getMembers();
        $data['ic_dates']                  = $this->m_icdate->getIcDates();

        $this->load->template('v_add_new_ic_date',$data);

    }


}
