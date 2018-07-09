<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  Ci_input input
 * @property  M_admin m_admin
 * @property  M_prospects m_prospects
 * @property  M_voting m_voting
 * @property  M_ic m_ic
 * @property  M_factors m_factors
 * @property  M_master m_master
 * @property  M_icdate m_icdate
 */
class C_admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_admin',
            'm_prospects',
            'm_master',
            'm_voting',
            'm_ic',
            'm_factors',
            'm_icdate',
        ]);
    }


    public function dashboard()
    {
        $data['user']     = $this->session->userdata('user');
        $data['admin']    = ( ! $data['user']['isAdmin']) ? false : $data['user'];
        $data['users']    = $this->m_ic->getMembers();
        $data['ic_dates'] = $this->m_icdate->getIcDates();
        $this->load->template('v_admin_dashboard', $data);
    }

    public function import_prospect()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        //$master = $this->m_admin->getMasterTable();
        $members = $this->m_ic->getMembers();
        $factors = $this->m_factors->getAllFactors();

        $ic_date = $this->input->post('ic_date');
        $data    = fopen($_FILES['file']['tmp_name'], 'r');
        $row     = fgetcsv($data);
        if ( ! isset($row[9]) || ! isset($ic_date)) {
            http_response_code(400);
            die();
        } else {

            // mark all record as unprocessed. we need at the end unprocessed to mark ad not active in voting table
            $this->m_prospects->updateProcessedStatus($ic_date);

            while ($row = fgetcsv($data)) {
                if ($row[1] !== 'ticker') {
                    $info            = [
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
                    $prospectCreated = $this->m_prospects->insert_prospects_from_csv($info);

                    if ($prospectCreated) {
                        foreach ($members as $member) {
                            $masterId = $this->m_master->insertProspect($info, $member);
                            foreach ($factors as $factor) {
                                $this->m_voting->insertProspect($info, $masterId, $member, $factor);
                            }
                        }
                    } else {
                        #TODO  we can;t insert in prospect table, need to implement admin notification
                    }
                }
            }
            echo true; // for closing modal on frontend
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
