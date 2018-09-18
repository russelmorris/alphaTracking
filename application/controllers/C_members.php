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
class C_members extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_admin',
            'm_ic',
        ]);
    }

    public function members()
    {
        $data['user'] = $this->session->userdata('user');
        if ($data['user']['isAdmin'] == 1) {
            $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
            $data['users'] = $this->m_ic->getAllMembers();

            $this->load->template('v_members', $data);
        }else{
            redirect('dashboard');
        }
    }

    public function addMember()
    {
        $data = [];
        $data['user'] = $this->session->userdata('user');
        if($data['user']['isAdmin'] != 1) {
            redirect('dashboard');
        }
        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
        $data['users'] = $this->m_ic->getAllMembers();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $isActive = ($this->input->post('isActive') == '') ? 0:1;
            $isAdmin = ($this->input->post('isAdmin') == '') ? 0:1;
            $isComittee = ($this->input->post('isComittee') == '') ? 0:1;
            $userData = array(
                'strategyNo' => $this->input->post('strategyNo'),
                'memberName' => $this->input->post('memberName'),
                'bWeight' => $this->input->post('bWeight')/100,
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'isActive' => $isActive,
                'isAdmin' => $isAdmin,
                'isComittee' => $isComittee,
            );

           $data['addMember'] = $this->m_ic->addMember($userData);
           redirect('members');
        }
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->template('v_addMember' ,$data);

    }
}