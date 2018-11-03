<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  Ci_input input
 * @property  M_voting m_voting
 * @property  M_master m_master
 * @property  M_factors m_factors
 * @property  M_prospects m_prospects
 */
class C_voting extends MY_Controller
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
        $this->load->model(['m_voting', 'm_master', 'm_prospects', 'm_factors']);
    }

    public function voting($icDate, $masterID)
    {
        $data = [];
        $data['icdate'] = $icDate;
        $data['masterID'] = $masterID;
        $data['prospect'] = $this->m_prospects->getProspectByMasterID($data['masterID']);
        $data['user'] = $this->session->userdata('user');
        $data['sub_user'] = $this->session->userdata('admin_subuser') ?
            $this->session->userdata('admin_subuser') : false;

        $data['voting_values'] = $this->m_voting->getLatestVotingValues(
            $data['sub_user'] ? $data['sub_user']['memberNo'] : $data['user']['memberNo'],
            $data['prospect'], $icDate);



        $data['admin'] = (!$data['user']['isAdmin']) ? false : $data['user'];
        $data['dateModified'] = date('d M Y', strtotime($data['voting_values'][0]['DateModified']));


        $data['infoSheetURL'] = "bottomUp/infoSheets/" . $icDate . "/" . strtolower(str_replace(" ", '', $data['voting_values'][0]['prospectTextID'])) . ".htm";
        $data['infoSheetURL'] = base_url($data['infoSheetURL']);
        $data['infoSheetURLExist'] = file_exists($data['infoSheetURL']) ? true : false;


        $data['alexaImageURL'] = "/bottomUp/digiFootprint/alexa/" . $icDate . "/" . $icDate . "-" . strtolower(str_replace(" ", "", $data['prospect']['ticker'] . "-" . $data['prospect']['country'])) . "-alexa.jpg";
//        $data['alexaImageURL'] = base_url($data['alexaImageURL']);
        $data['alexaImageURLExist'] = file_exists(FCPATH.$data['alexaImageURL']) ? true : false;


        $data['googleImageURL'] = "/bottomUp/digiFootprint/googletrends/{$icDate}/$icDate-" . strtolower(str_replace(" ", "", $data['prospect']['ticker'] . "-" . $data['prospect']['country'])) . "-googletrends.jpg";
//        $data['googleImageURL'] = base_url($data['googleImageURL']);
        $data['googleImageURLExist'] = file_exists(FCPATH.$data['googleImageURL']) ? true : false;

        $data['prev'] = $this->m_prospects->getPreviousProspectByDateAndTicker(
            $data['sub_user'] ? $data['sub_user']['memberNo'] : $data['user']['memberNo'],
            $data['icdate'], $data['prospect']['prospectID']);

        if( $data['prev']) {
            $data['prevUrl'] = base_url('/voting/' . $data['icdate'] . '/' . $data['prev']);
        } else {
            $data['prevUrl'] = '';
        }
        $data['next'] = $this->m_prospects->getNextProspectByDateAndTicker(
            $data['sub_user'] ? $data['sub_user']['memberNo'] : $data['user']['memberNo'],
            $data['icdate'], $data['prospect']['prospectID']);
        if($data['next']) {
            $data['nextUrl'] = base_url('/voting/' . $data['icdate'] . '/' . $data['next']);
        } else {
            $data['nextUrl'] = '';
        }
        $data['allowEdit'] = 0;
        $data['enableFinalised'] = (strtotime(date("Y-m-d") . ' 23:59.59 ') <= strtotime($data['icdate'] . ' 23:59.59 '))? 1 : 0;
        if ($data['user']['isAdmin'] == '1') {
            $data['enableFinalised'] = 1;
            if ($data['voting_values'][0]['isFinalised'] == 1) {
                $data['allowEdit'] = 0;
            } else {
                $data['allowEdit'] = 1;
            }
        } else {
            if ($data['voting_values'][0]['isFinalised'] == 1) {
                $data['allowEdit'] = 0;
            } else {
                    $data['allowEdit'] = 1;
            }
        }
        if($data['enableFinalised'] == 0){
            $data['allowEdit'] = 0;
        }
        $this->load->twigTemplate('v_voting', $data);
    }

    /**
     *
     */
    public function submit_voting()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            die();
        }


        $populate_voting_data = [];
        $populate_voting_data['ic_date'] = $this->input->post('ic_date');
        $populate_voting_data['masterID'] = $this->input->post('masterID');
        $populate_voting_data['user_id'] = $this->input->post('user_id');
        $populate_voting_data['factor'] = $this->input->post('factor');
        $populate_voting_data['vote'] = $this->input->post('vote');

        $this->m_voting->updateFactor(
            $populate_voting_data['user_id'],
            $populate_voting_data['masterID'],
            $populate_voting_data['ic_date'],
            $populate_voting_data['factor'],
            $populate_voting_data['vote']
        );
    }

    public function submit_master_veto()
    {
        $populate_voting_data = [];
        $populate_voting_data['ic_date'] = $this->input->post('ic_date');
        $populate_voting_data['masterID'] = $this->input->post('masterID');
        $populate_voting_data['user_id'] = $this->input->post('user_id');
        $populate_voting_data['factor'] = $this->input->post('factor');
        $populate_voting_data['vote'] = $this->input->post('vote');
        $populate_voting_data['comment'] = $this->input->post('comment');
        $this->m_master->updateVetoAndComment(
            $populate_voting_data['vote'],
            trim($populate_voting_data['comment']),
            $populate_voting_data['user_id'],
            $populate_voting_data['masterID'],
            $populate_voting_data['ic_date']
        );
    }

    public function submit_master_deep_dive()
    {
        $populate_voting_data = [];
        $populate_voting_data['ic_date'] = $this->input->post('ic_date');
        $populate_voting_data['masterID'] = $this->input->post('masterID');
        $populate_voting_data['user_id'] = $this->input->post('user_id');
        $populate_voting_data['factor'] = $this->input->post('factor');
        $populate_voting_data['vote'] = $this->input->post('vote');
        $populate_voting_data['comment'] = $this->input->post('comment');

        $this->m_master->updateDeepDiveAndComment(
            $populate_voting_data['vote'],
            trim($populate_voting_data['comment']),
            $populate_voting_data['user_id'],
            $populate_voting_data['masterID'],
            $populate_voting_data['ic_date']
        );
    }

    public function submit_master_finalise()
    {
        $populate_voting_data = [];
        $populate_voting_data['ic_date'] = $this->input->post('ic_date');
        $populate_voting_data['masterID'] = $this->input->post('masterID');
        $populate_voting_data['user_id'] = $this->input->post('user_id');
        $populate_voting_data['finalised'] = $this->input->post('finalised');

        $this->m_master->updateFinalise(
            $populate_voting_data['user_id'],
            $populate_voting_data['masterID'],
            $populate_voting_data['ic_date'],
            $populate_voting_data['finalised']
        );
    }
}
