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
        $data['user']     = $this->session->userdata('user');
        $data['users']    = $this->m_admin->get_users();
        $data['ic_dates'] = $this->m_user->getICDates();
        $this->load->template('v_admin_dashboard', $data);
    }

    public function import_prospect()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $master = $this->m_admin->getMasterTable();

        $ic_date = $this->input->post('ic_date');
        $data    = fopen($_FILES['file']['tmp_name'], 'r');
        while ($row = fgetcsv($data)) {
            if ($row[1] !== 'ticker') {
                $info = [
                    'strategyNo'   => 1,
                    'icDate'       => date($ic_date),
                    'ticker'       => $row[1],
                    'RIC'          => $row[5],
                    'name'         => $row[6],
                    'country'      => $row[7],
                    'sector'       => $row[8],
                    'machineScore' => (float)$row[9],
                    'SWSurl'       => 'https://url.com'
                ];
                $this->m_admin->insert_prospects_from_csv($info);
                /*
                 *  I'm going with this option for checking (I'm pulling certain data from master table)
                 *  so I don't make a lot of requests to the server but
                 *  some of the logic is not working in the if else statements (need help)
                 */
                foreach ($master as $value) {
                    if ($value['icDate'] == $ic_date && $info['ticker'] == $value['ticker']) { // Old Data
                        echo 'old' . "\n";
                        // $this->m_admin->isActiveUpdate(0, $ic_date);
                    } elseif ($value['icDate'] != $ic_date && $info['ticker'] == $value['ticker']) { // New icDate but existing data
                        //   $this->m_admin->isActiveUpdate(1, $ic_date);
                        echo 'new old' . "\n";
                    } elseif ($value['icDate'] != $ic_date && $info['ticker'] != $value['ticker']) { // New Data
                        echo 'new' . "\n";
                        // the code below works only for the current signed in user
                        /*$user = $this->session->userdata('user');

                        unset($info['SWSurl']);
                        $info['memberNo']   = $user['memberNo'];
                        $info['memberName'] = $user['memberName'];
                        $info['bWeight']    = $user['bWeight'];
                        $info['isActive']   = 1;
                        $this->m_admin->populateMaster($info);*/
                    }
                }
            }
        }
        echo true; // for closing modal on frontend
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
