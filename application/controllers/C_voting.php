<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  Ci_input input
 */
class C_voting extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('authenticated') !== 1) {
            redirect('/login');
        }
    }

    public function voting()
    {
        $user_data = [];
        $this->load->template('v_voting', $user_data);
    }

    public function submit_voting()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $results = json_decode($this->input->post('results'));
        var_dump($results);
    }
}
