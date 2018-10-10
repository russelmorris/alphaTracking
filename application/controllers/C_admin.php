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
 * @property  M_master m_masterF
 * @property  M_icdate m_icdate
 * @property  M_master m_master
 * @property  M_portfolio m_portfolio
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
            'm_portfolio'
        ]);
    }

    public function dashboard()
    {
        $data['user']                      = $this->session->userdata('user');
        if($data['user']['isAdmin'] == 1){
        $data['admin']                     = ( ! $data['user']['isAdmin']) ? false : $data['user'];
        $data['users']                     = $this->m_ic->getMembers();
        $data['ic_dates']                  = $this->m_icdate->getIcDates();
        $data['closest_icDate_from_today'] = find_next_ic_date(array_column($data['ic_dates'], 'icDate'));
        $this->load->template('v_admin_dashboard', $data);
        }else{
            redirect('dashboard');
        }

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
        $csv     = array_map('str_getcsv', file($_FILES['file']['tmp_name']));
        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);

        if ( ! isset($csv[0]['ticker']) || ! isset($csv[0]['ric']) || ! isset($csv[0]['name']) ||
             ! isset($csv[0]['country']) || ! isset($csv[0]['sector']) ||
             ! isset($csv[0]['machineScore']) || ! isset($ic_date)) {
            http_response_code(400);
            die();
        } else {

            // mark all record as unprocessed. we need at the end unprocessed to mark ad not active in voting table
            $this->m_prospects->updateProcessedStatus($ic_date, 0);
            $this->m_master->updateActiveStatus($ic_date);

            // die();


            foreach ($csv as $key => $value) {
                $info   = [
                    'strategyNo'    => 1,
                    'icDate'        => date($ic_date),
                    'ticker'        => $value['ticker'],
                    'sedol '        => $value['sedol'],
                    'cusip'         => $value['cusip'],
                    'isin'          => $value['isin'],
                    'RIC'           => $value['ric'],
                    'name'          => $value['name'],
                    'country'       => $value['country'],
                    'sector'        => $value['sector'],
                    'machineScore'  => (float)$value['machineScore'],
                    'machineRank'   => $value['machineRank'],
                    'machineScore2' => $value['machineScore2'],
                    'machineRank2'  => $value['machineRank2'],
                    'machineScore3' => $value['machineScore3'],
                    'machineRank3'  => $value['machineRank3'],
                    'tag'           => $value['tag'],
                ];
                $prospectCreated = $this->m_prospects->insert_prospects_from_csv($info);

                if ($prospectCreated) {

                    foreach ($members as $member) {
                        $masterId = $this->m_master->insertProspect($info, $member);
                        if ($masterId > 0) {
                            foreach ($factors as $factor) {
                                $this->m_voting->insertProspect($info, $masterId, $member, $factor);
                            }
                        }
                    }
                }
            }
            echo true;
        }
    }

    public function import_returns()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $data = fopen($_FILES['file']['tmp_name'], 'r');
        $csv  = array_map('str_getcsv', file($_FILES['file']['tmp_name']));
        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);
        foreach ($csv as $item) {
            $info = [
                'dateFrom' => ( ! (int)$item['dateFrom']) ? null : date($item['dateFrom']),
                'dateTo'   => ( ! (int)$item['dateTo']) ? null : date($item['dateTo']),
                'ticker'   => $item['ticker'],
                'RIC'      => $item['ric'],
                'name'     => $item['name'],
                'country'  => $item['country'],
                'sector'   => $item['sector'],
                'return'   => (float)$item['return'],
            ];

            $this->m_admin->insert_returns_from_csv($info);
        }
    }



}
