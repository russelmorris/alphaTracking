<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  Ci_input input
 * @property  C_admin_model c_admin_model
 * @property  C_user_model c_user_model
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('c_user_model');
        $user = $this->session->userdata('user');

        if (!$user) {

            redirect(base_url('login'));
        } else {

            $user = $this->c_user_model->getUserByID($user['memberNo']);
            if ($user) {
                $this->session->set_userdata('user', $user);
            } else {
                redirect(base_url('login'));
            }
        }
    }
}