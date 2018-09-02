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

    public function voting($icDate, $ticker)
    {
        $data                  = [];
        $data['icdate']        = $icDate;
        $data['ticker']        = $ticker;
        $data['prospect']      = $this->m_prospects->getProspectByDateAndTicker($data['icdate'], $data['ticker']);
        $data['user']          = $this->session->userdata('user');
        $data['sub_user']      = $this->session->userdata('admin_subuser') ?
            $this->session->userdata('admin_subuser') : false;
        $data['voting_values'] = $this->m_voting->getLatestVotingValues(
            $data['sub_user'] ? $data['sub_user']['memberNo'] : $data['user']['memberNo'],
            $ticker, $icDate);
        $data['admin']         = ( ! $data['user']['isAdmin']) ? false : $data['user'];
        $data['dateModified']  = date('d M Y', strtotime($data['voting_values'][0]['DateModified']));


        $data['infoSheetURL'] = "bottomUp/infoSheets/" . $icDate . "/" . strtolower(str_replace(" " , '',$data['voting_values'][0]['prospectTextID'])) . ".htm";
        $data['infoSheetURLExist'] = file_exists($data['infoSheetURL']) ?  true : false;


        $data['alexaImageURL'] = "bottomUp/digiFootprint/alexa/".$icDate."/".$icDate."-".strtolower(str_replace(" ", "",$ticker."-".$data['prospect']['country']))."-alexa.jpg";
        $data['alexaImageURLExist'] = file_exists($data['alexaImageURL']) ?  true : false;


        $data['googleImageURL'] = "bottomUp/digiFootprint/googletrends/{$icDate}/$icDate-".strtolower(str_replace(" ", "",$ticker."-".$data['prospect']['country']))."-googletrends.jpg";
        $data['googleImageURLExist'] = file_exists($data['googleImageURL'])?  true : false;

        $data['prev'] = $this->m_prospects->getPreviousProspectByDateAndTicker($data['icdate'], $data['prospect']['prospectID']);
        $data['next'] = $this->m_prospects->getNextProspectByDateAndTicker($data['icdate'], $data['prospect']['prospectID']);
        print_f($data['voting_values']);
        $this->load->template('v_voting', $data);
    }

    /**
     *
     */
    public function submit_voting()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }


        $populate_voting_data = [];
        $populate_voting_data['ic_date'] = $this->input->post('ic_date');
        $populate_voting_data['ticker'] = $this->input->post('ticker');
        $populate_voting_data['user_id'] =  $this->input->post('user_id');
        $populate_voting_data['factor'] = $this->input->post('factor');
        $populate_voting_data['vote'] = $this->input->post('vote');

        $this->m_voting->updateFactor(
            $populate_voting_data['user_id'],
            $populate_voting_data['ticker'],
            $populate_voting_data['ic_date'],
            $populate_voting_data['factor'],
            $populate_voting_data['vote']
        );
    }

    public function submit_master_veto(){
        $populate_voting_data = [];
        $populate_voting_data['ic_date'] = $this->input->post('ic_date');
        $populate_voting_data['ticker'] = $this->input->post('ticker');
        $populate_voting_data['user_id'] =  $this->input->post('user_id');
        $populate_voting_data['factor'] = $this->input->post('factor');
        $populate_voting_data['vote'] = $this->input->post('vote');
        $populate_voting_data['comment'] = $this->input->post('comment');
        $this->m_master->updateVetoAndComment(
            $populate_voting_data['vote'],
            trim($populate_voting_data['comment']),
            $populate_voting_data['user_id'],
            $populate_voting_data['ticker'],
            $populate_voting_data['ic_date']
        );
    }

    public function submit_master_deep_dive(){
        $populate_voting_data = [];
        $populate_voting_data['ic_date'] = $this->input->post('ic_date');
        $populate_voting_data['ticker'] = $this->input->post('ticker');
        $populate_voting_data['user_id'] =  $this->input->post('user_id');
        $populate_voting_data['factor'] = $this->input->post('factor');
        $populate_voting_data['vote'] = $this->input->post('vote');
        $populate_voting_data['comment'] = $this->input->post('comment');

        $this->m_master->updateDeepDiveAndComment(
            $populate_voting_data['vote'],
            trim($populate_voting_data['comment']),
            $populate_voting_data['user_id'],
            $populate_voting_data['ticker'],
            $populate_voting_data['ic_date']
        );
    }

    public function submit_master_finalise(){
        $populate_voting_data = [];
        $populate_voting_data['ic_date'] = $this->input->post('ic_date');
        $populate_voting_data['ticker'] = $this->input->post('ticker');
        $populate_voting_data['user_id'] =  $this->input->post('user_id');
        $populate_voting_data['finalised'] = $this->input->post('finalised');

        $this->m_master->updateFinalise(
            $populate_voting_data['user_id'],
            $populate_voting_data['ticker'],
            $populate_voting_data['ic_date'],
            $populate_voting_data['finalised']
        );
    }
}
