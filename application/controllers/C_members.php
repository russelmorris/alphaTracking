<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property  CI_Input input
 * @property  M_auth m_auth
 * @property  M_ic m_ic
 * @property  M_icdate m_icdate
 * @property  M_prospects m_prospects
 * @property  M_factors m_factors
 * @property  M_master m_master
 * @property  M_voting m_voting
 * @property  CI_Security security
 */
class C_members extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_admin',
            'm_ic',
            'm_factors',
            'm_icdate',
            'm_prospects',
            'm_master',
            'm_voting'
        ]);
    }

    public function members()
    {
        $data['user'] = $this->session->userdata('user');
        if ($data['user']['isAdmin'] == 1) {
            $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
            $data['users'] = $this->m_ic->getAllMembers();

            $this->load->template('v_members', $data);
        } else {
            redirect('dashboard');
        }
    }

    public function addMember()
    {
        $data = [];
        $data['user'] = $this->session->userdata('user');
        if ($data['user']['isAdmin'] != 1) {
            redirect('dashboard');
        }
        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
        $data['users'] = $this->m_ic->getAllMembers();
        $this->formValidation();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            if ($this->form_validation->run() == TRUE) {

                $isActive = ($this->input->post('isActive') == '') ? 0 : 1;
                $isAdmin = ($this->input->post('isAdmin') == '') ? 0 : 1;
                $isComittee = ($this->input->post('isComittee') == '') ? 0 : 1;
                $userData = array(
                    'strategyNo' => $this->input->post('strategyNo'),
                    'memberName' => $this->input->post('memberName'),
                    'bWeight' => $this->input->post('bWeight') / 100,
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'isActive' => $isActive,
                    'isAdmin' => $isAdmin,
                    'isComittee' => $isComittee,
                );

                $data['memberId'] = $this->m_ic->addMember($userData);

                $data['ic_dates'] = $this->m_icdate->getICDates();
                $data['closest_icDate_from_today'] = find_next_ic_date(array_column($data['ic_dates'], 'icDate'));

                if($userData['isComittee'] == 1) {
                    /*if (!$this->m_factors->createFactors($data['memberId'], $data['closest_icDate_from_today'])) {
                        echo 'Someting is wrong when we creaete factor weights';
                    }*/

                    $prospects = $this->m_prospects->getProspectsByDate($data['closest_icDate_from_today']);


                    foreach ($prospects as $prospect) {
                        $info = [
                            'strategyNo' => 1,
                            'icDate' => $data['closest_icDate_from_today'],
                            'ticker' => $prospect['ticker'],
                            'country' => $prospect['country'],
                            'RIC' => $prospect['RIC'],
                            'name' => $prospect['name'],
                            'sector' => $prospect['sector'],
                            'machineScore' => $prospect['machineScore'],
                            'machineRank' => $prospect['machineRank'],
                            'machineScore2' => $prospect['machineScore2'],
                            'machineRank2' => $prospect['machineRank2'],
                            'machineScore3' => $prospect['machineScore3'],
                            'machineRank3' => $prospect['machineRank3']
                        ];
                        $member = [
                            'memberNo' => $data['memberId'],
                            'memberName' => $userData['memberName'],
                            'bWeight' => $userData['bWeight'],
                            'isActive' => $userData['isActive'],
                        ];


                        $factors = $this->m_factors->getAllFactors();

                        $masterId = $this->m_master->insertProspect($info, $member);
                        if ($masterId > 0) {
                            foreach ($factors as $factor) {
                                $this->m_voting->insertProspect($info, $masterId, $member, $factor);
                            }
                        }
                    }
                }

                redirect('members');
            }
        }
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->template('v_addMember', $data);

    }

    public function editMember($memberNo) {
        $data = [];
        $data['user'] = $this->session->userdata('user');
        if ($data['user']['isAdmin'] != 1) {
            redirect('dashboard');
        }

        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
        $data['users'] = $this->m_ic->getAllMembers();
        $data['member'] = $this->m_ic->getMemberByMemberNo($memberNo);

        $this->editFormValidation();


        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            if ($this->form_validation->run() == TRUE) {

                $isActive = ($this->input->post('isActive') == '') ? 0 : 1;
                $isAdmin = ($this->input->post('isAdmin') == '') ? 0 : 1;
                $isComittee = ($this->input->post('isComittee') == '') ? 0 : 1;
                $userData = array(
                    'strategyNo' => $this->input->post('strategyNo'),
                    'memberName' => $this->input->post('memberName'),
                    'bWeight' => $this->input->post('bWeight') / 100,
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'isActive' => $isActive,
                    'isAdmin' => $isAdmin,
                    'isComittee' => $isComittee,
                );

                $this->m_ic->updateMember($memberNo, $userData);

                redirect('members');
            }
        }

        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->template('v_editMember', $data);
    }

    public function formValidation() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('memberName', 'Member Name', 'required');
        $this->form_validation->set_rules('bWeight', 'bWeight', 'required');
        $this->form_validation->set_rules('email', 'email', 'required|is_unique[ic.email]');
        $this->form_validation->set_rules('password', 'password', 'required');

    }

    public function editFormValidation(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('memberName', 'Member Name', 'required');
        $this->form_validation->set_rules('bWeight', 'bWeight', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
    }

}