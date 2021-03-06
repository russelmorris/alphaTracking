<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  CI_Input input
 * @property  M_ic m_ic
 * @property  M_icdate m_icdate
 * @property  M_factors m_factors
 * @property  CI_Security security
 */
class C_factors extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_ic',
            'm_icdate',
            'm_factors'
        ]);
    }

//    public function factorWeights($specificDate = null)
//    {
//
//        $data['user'] = $this->session->userdata('user');
//        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
//        if ($data['user']['isAdmin']) {
//            $data['admin_users'] = $this->m_ic->getMembers();
//        }
//        $data['ic_dates'] = $this->m_icdate->getICDates();
//        if ($specificDate){
//            $data['closest_icDate_from_today'] = $specificDate;
//        } else {
//            $data['closest_icDate_from_today'] = find_next_ic_date(array_column($data['ic_dates'], 'icDate'));
//        }
//
//        $currentDate = new DateTime(unix_to_human(time()));
//
//        if($data['closest_icDate_from_today'] !== null &&
//            strtotime($currentDate->format('Y-m-d')) <= strtotime($data['closest_icDate_from_today']) )
//        {
//            $data['enableEditing'] = true;
//        } else {
//            $data['enableEditing'] = false;
//        }
//
//        $data['factorWeights'] = $this->m_factors->getFactorWeights($data['user']['memberNo'], $data['closest_icDate_from_today']);
//
//        $this->load->template('v_factor_weights', $data);
//
//    }

//    public function submitFactorsWeight() {
//        $factors = $this->input->post('factors');
//        $memberNo =$this->input->post('ic_user');
//        $icDate = $this->input->post('ic_date');
//        foreach ($factors as $factor){
//           $this->m_factors->updateFactorWeights(
//               $factor['factor_id'],
//               $memberNo,
//               $icDate,
//               $factor['factor_value']
//           );
//
//
//        }
//
//    }

//    public function getFactorWeights($memberNo, $icDate){
//        $factors = $this->m_factors->getFactorWeights(
//            $memberNo,
//            $icDate
//        );
//        echo json_encode($factors);
//    }


}
