<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  C_user_model c_user_model
 */
class C_dashboard extends CI_Controller
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


    public function dashboard()
    {
        $data['user'] = $this->c_user_model->get_user();
        $data['ic_dash'] = $this->c_user_model->ic_dashboard();
        $data['finalised'] = $this->c_user_model->count_finalised();

        $this->load->template('v_dashboard', $data);
    }
}
