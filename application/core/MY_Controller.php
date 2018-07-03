<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  Ci_input input
 * @property  M_admin m_admin
 * @property  M_user m_user
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('m_user');
        $user = $this->session->userdata('user');

        if (!$user) {

            redirect(base_url('login'));
        } else {

            $user = $this->m_user->getUserByID($user['memberNo']);
            if ($user) {
                $this->session->set_userdata('user', $user);
            } else {
                redirect(base_url('login'));
            }
        }
    }
}