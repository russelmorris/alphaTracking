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
        if (isset($_SESSION['admin_id']) && is_numeric($_SESSION['admin_id'])) {
            redirect('/admin_dashboard', 'location');
        } elseif (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
            redirect('/dashboard', 'location');
        } else {
            $data         = [];
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );

            $this->load->view('v_login', $data);
        }

    }

    public function login()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $remember_me = (isset($_POST['remember'])) ? true : false;
            $credentials = [
                'email'    => $_POST['email'],
                'password' => $_POST['password']
            ];
            if ($this->c_auth_model->check_credentials($credentials)) {
                if ($this->c_auth_model->is_admin($credentials)) {
                    $this->session->set_userdata('admin_id', $this->c_auth_model->get_user_id($credentials));
                    if ($remember_me) {
                        $params = session_get_cookie_params();
                        setcookie('email', $_COOKIE[$credentials['email']], time() + 60 * 60 * 24 * 2,
                            $params["path"], $params["domain"], $params["secure"]);
                    }
                    redirect('/admin_dashboard', 'location');
                } else {
                    $this->session->set_userdata('user_id', $this->c_auth_model->get_user_id($credentials));
                    redirect('/dashboard', 'location');
                }
            } else {
                redirect('/', 'location');
            }
        }
    }

    public function logout()
    {
        if ($this->session->has_userdata('admin_id')) {
            $this->session->unset_userdata('admin_id');
        }
        if ($this->session->has_userdata('user_id')) {
            $this->session->unset_userdata('user_id');
        }
        redirect('/');
    }
}
