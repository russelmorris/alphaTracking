<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  CI_Input input
 * @property  C_auth_model c_auth_model
 * @property  CI_Security security
 */
class C_login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('c_auth_model');

    }

    public function index()
    {
        redirect(base_url('/login'));
    }

    public function login()
    {
        $redirect = '';
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $user = $this->c_auth_model->check_credentials(
                $this->input->post('email'),
                $this->input->post('password')
            );
            if ($user) {
                $this->session->set_userdata('user', $user);

                if ($user['isAdmin'] == 1) {
                    $redirect = 'admin_dashboard';
                } else {
                    $redirect = 'dashboard';
                }
            }
            return redirect (base_url($redirect));
        }
        $data = [];
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('v_login', $data);
    }

    public function logout()
    {
        if ($this->session->has_userdata('user')) {
            $this->session->unset_userdata('user');
        }
        redirect('/');
    }
}
