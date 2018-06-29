<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  Ci_input input
 * @property  C_user_model c_user_model
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
        if ( ! isset($_SESSION['user_id'])) {
            redirect('/');
        }
        $this->load->model('c_user_model');
    }

    public function voting($icDate, $ticker)
    {
        $data = [];
        $data['icdate'] = $icDate;
        $data['ticker'] = $ticker;
        $data['user'] = $this->c_user_model->get_user();
        $this->load->template('v_voting', $data);
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
