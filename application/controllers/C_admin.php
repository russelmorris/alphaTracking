<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  Ci_input input
 * @property  M_admin m_admin
 */
class C_admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['m_user', 'm_admin']);
    }


    public function dashboard()
    {
        $data['user'] = $this->session->userdata('user');
        $data['users'] = $this->m_admin->get_users();
        $data['ic_dates']     = $this->m_user->getICDates();
        $this->load->template('v_admin_dashboard', $data);
    }

    public function import_prospect()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $data = fopen($_FILES['file']['tmp_name'], 'r');
        while ($row = fgetcsv($data)) {
            $info = [
                'strategyNo'   => ( ! (int)$row[0]) ? null : (int)$row[0],
                'icDate'       => date($row[1]),
                'ticker'       => $row[2],
                'RIC'          => $row[3],
                'name'         => $row[4],
                'country'      => $row[5],
                'sector'       => $row[6],
                'machineScore' => (float)$row[7],
                'machineRank'  => (int)$row[8],
            ];

            $this->m_admin->insert_prospects_from_csv($info);
        }
    }

    public function import_returns()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $data = fopen($_FILES['file']['tmp_name'], 'r');
        while ($row = fgetcsv($data)) {
            $info = [
                'dateFrom' => ( ! (int)$row[0]) ? null : date($row[0]),
                'dateTo'   => ( ! (int)$row[1]) ? null : date($row[1]),
                'ticker'   => $row[2],
                'RIC'      => $row[3],
                'name'     => $row[4],
                'country'  => $row[5],
                'sector'   => $row[6],
                'return'   => (float)$row[7],
            ];

            $this->m_admin->insert_returns_from_csv($info);
        }
    }
}
