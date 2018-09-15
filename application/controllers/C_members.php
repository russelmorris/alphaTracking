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

    public function Members()
    {
        $data['user'] = $this->session->userdata('user');
        if ($data['user']['isAdmin'] == 1) {
            $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
            $data['users'] = $this->m_ic->getMembers();

            $this->load->template('v_members', $data);
        }else{
            redirect('dashboard');
        }
    }

    public function AddMember()
    {
        $data['user'] = $this->session->userdata('user');
        if($data['user']['isAdmin'] == 1){
            $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
            $data['users'] = $this->m_ic->getMembers();

            $this->load->template('v_addMember' ,$data);
        }else{
            redirect('dashboard');
        }
    }
}