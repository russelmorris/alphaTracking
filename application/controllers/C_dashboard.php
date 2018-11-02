<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  CI_URI uri
 * @property  M_ic m_ic
 * @property  M_icdate m_icdate
 * @property  M_master m_master
 * @property  M_voting m_voting
 * @property  M_prospects m_prospects
 * @property  M_conviction m_conviction
 */
class C_dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_admin',
            'm_ic',
            'm_icdate',
            'm_master',
            'm_voting',
            'm_prospects',
            'm_conviction'
        ]);
    }


    public function dashboard($memberNo = 0)
    {
        $data['user'] = $this->session->userdata('user');
        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
        if ($data['user']['isAdmin']) {
            $data['admin_users'] = $this->m_ic->getMembers();
        }
        $data['ic_dates'] = $this->m_icdate->getICDates();
        $data['closest_icDate_from_today'] = find_next_ic_date(array_column($data['ic_dates'], 'icDate'));
        $data['ic_dashboard'] = [];
        if($memberNo != 0 && $data['user']['isAdmin']){
            $data['selectedMemberNo'] = $memberNo;
        } else {
            $data['selectedMemberNo'] = $data['user']['memberNo'];
        }
        $this->load->template('v_dashboard', $data);
    }

    public function dashboard_ajax()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $data = [];

        $data['selectedDate'] = $this->input->post('ic_date');
        $data['orderBy'] = $this->input->post('orderBy');
        $data['selectedUser'] = json_decode($this->input->post('user_id'));
        $sessionUser = [];
        if (!$data['selectedUser']) {

            $sessionUser = $this->session->userdata('user');
            $data['user'] = $sessionUser;
            $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
            if ($data['user']['isAdmin']) {
                $data['admin_users'] = $this->m_ic->getMembers();
            }

            $data['ic_dates'] = $this->m_icdate->getICDates();

            $data['closest_icDate_from_today'] = find_closest_date(array_column($data['ic_dates'], 'icDate'));


            $data['ic_dashboard'] = $this->m_prospects->getProspectsByDateAndId($sessionUser['memberNo'], $data['selectedDate']);
        } else {
            $data['user'] = $this->m_ic->getUserByID($data['selectedUser']);
            $this->session->set_userdata('admin_subuser', $data['user']);
            $data['ic_dashboard'] = $this->m_prospects->getProspectsByDateAndId($data['user']['memberNo'],
                $data['selectedDate']);
        }

        $portfolioCount = $this->m_icdate->getPortfolioCount($data['selectedDate']);
        $icDashboard = $data['ic_dashboard'];
        usort($icDashboard,"cmp_humanScore");

        foreach($icDashboard as $key => &$element){
            if ($key > $portfolioCount-1) {
                $element['inPortfolio'] = 0;
            } else {
                $element['inPortfolio'] = 1;
            }
        }
        usort($icDashboard,"cmp_masterID");

        $data['ic_dashboard'] = $icDashboard ;
//        print_r( $data['ic_dashboard']);

         $this->load->view('partial/v_dashboard_table', $data);
    }

    public function finalised_value()
    {

        $returnArray = [
            'percent' => '0.00',
            'prospectCount' => '111',
            'portfolioCount' => '230',
        ];

        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $selectedDate = $this->input->post('ic_date');
        $selectedUser = json_decode($this->input->post('user_id'));
        $sessionUser = [];
        if (!$selectedUser) {
            $sessionUser = $this->session->userdata('user');
        }

        if (!$selectedUser) {
            $return =  $this->m_master->finalised($sessionUser['memberNo'],
                $selectedDate);
            $user = $this->m_ic->getUserByID($sessionUser);
            $convictionData = $this->m_conviction->getConviction($user, $selectedDate );
        } else {
            $return =  $this->m_master->finalised($selectedUser,
                $selectedDate);
            $user = $this->m_ic->getUserByID($selectedUser);
            $convictionData = $this->m_conviction->getConviction($user, $selectedDate );
        }
        $returnArray['percent'] = number_format($return['percent'], 2,'.', '');
        $returnArray['prospectCount'] = $return['overall'];

        $returnArray['portfolioCount'] = $this->m_icdate->getPortfolioCount($selectedDate);
        $returnArray['convictionData'] = $convictionData;

        $returnArray['editable'] =  (strtotime($selectedDate . ' 23:59:59') > strtotime('now'));
        echo json_encode($returnArray);
    }

    public function updateFactor()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $postData = $this->input->post();
        $userData = $this->session->userdata('user');

        if ($userData['isAdmin'] == 0) {
            $memberNo = $userData['memberNo'];
        } else {
            $memberNo = $postData['user_id'];
        }


        $this->m_voting->updateFactor(
            $memberNo,
            $postData['masterID'],
            $postData['ic_date'],
            $postData['factor'],
            $postData['value']
        );

        return;
    }


    public function updateVeto()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $postData = $this->input->post();
        $userData = $this->session->userdata('user');

        if ($userData['isAdmin'] == 0) {
            $memberNo = $userData['memberNo'];
        } else {
            $memberNo = $postData['user_id'];
        }

        $newVetoValue = $this->m_master->setVetoFlag(
            $memberNo,
            $postData['masterID'],
            $postData['ic_date']
        );
        echo $newVetoValue;

        return;
    }

    public function updateFinalise()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $postData = $this->input->post();
        $userData = $this->session->userdata('user');

        if ($userData['isAdmin'] == 0) {
            $memberNo = $userData['memberNo'];
        } else {
            $memberNo = $postData['user_id'];
        }
        $newFinalisedValue = $this->m_master->setFinaliseFlag(
            $memberNo,
            $postData['masterID'],
            $postData['ic_date']
        );
        echo $newFinalisedValue;

        return;
    }

    public function updateFinaliseAll()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }

        $icDate = $this->input->post('ic_date');
        $user_id = $this->input->post('ic_user');
        $finalized = $this->input->post('finalized');

        $userData = $this->session->userdata('user');

        if ($userData['isAdmin'] == 0) {
            $user_id = $userData['memberNo'];
        }
        $newFinalisedValue = $this->m_master->setAllFinaliseFlag(
            $user_id,
            $icDate,
            $finalized
        );
        return;
    }

    public function updateConviction(){
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }
        if (!(strtotime($this->input->post('icDate') . ' 23:59:59') > strtotime('now'))) {
            show_404();
            die();
        }

        $userData = $this->session->userdata('user');

        $data['mktReturn'] = $this->input->post('mktReturn');
        $data['conviction'] = $this->input->post('conviction');
        $data['memberNo'] = $this->input->post('memberNo');
        $data['icDate'] = $this->input->post('icDate');

        if ($userData['isAdmin'] == 0) {
            $data['memberNo'] = $userData['memberNo'];
        }
        return $this->m_conviction->updateConviction($data);

    }

}
