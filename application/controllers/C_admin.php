<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  Ci_input input
 * @property  C_prospect_model c_prospect_model
 */
class C_admin extends CI_Controller
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
        $this->load->model('c_prospect_model');
    }


    public function dashboard()
    {
        $data = [];
        $this->load->template('v_admin_dashboard', $data);
    }

    public function import_prospect()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }

        $data = fopen($_FILES['file']['tmp_name'], 'r');

        $heading = fgetcsv($data);

        while ($row = fgetcsv($data)) {

            $data = [
                'strategyNo'   => (int)$row[0],
                'icDate'       => date($row[1]),
                'ticker'       => $row[2],
                'RIC'          => $row[3],
                'name'         => $row[4],
                'country'      => $row[5],
                'sector'       => $row[6],
                'machineScore' => (float)$row[7],
                'machineRank'  => (int)$row[8],
            ];

            $this->c_prospect_model->insert_prospects_from_csv($data);
//            die();
        }
    }
}
