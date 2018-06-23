<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function login()
	{
	    // check if request is POST
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $this->session->set_userdata('authenticated', 1);
            redirect('/dashboard');
        }

        $this->session->unset_userdata('authenticated');

        $data = [];
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
		$this->load->view('v_login', $data);
	}

    public function logout()
    {
        $this->session->unset_userdata('authenticated');
        redirect(base_url('login'));
    }
}
