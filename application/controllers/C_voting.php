<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  Ci_input input
 * @property  M_voting m_voting
 * @property  M_master m_master
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
        $this->load->model(['m_voting', 'm_master']);
    }

    public function voting($icDate, $ticker)
    {

        $data           = [];
        $data['icdate'] = $icDate;
        $data['ticker'] = $ticker;
        $data['user']   = $this->session->userdata('user');
        $data['url']    = $this->m_voting->getSWSurl($data['user']['memberNo'], $ticker);
        $data['admin']  = ( ! $data['user']['isAdmin']) ? false : $data['user'];
        $this->load->template('v_voting', $data);
    }

    public function submit_voting()
    {
        if ( ! $this->input->is_ajax_request()) {
            show_404();
            die();
        }
        $results  = json_decode($this->input->post('results'));
        $user_id  = $this->input->post('user_id');
        $ticker   = $this->input->post('ticker');
        $veto     = json_decode($this->input->post('veto'), true);
        $finalise = json_decode($this->input->post('finalise'));
        foreach ($results as $index => $value) {
            if ( ! is_null($value) && $index != 5) {
                $this->m_voting->updateFactor($user_id, $ticker, $index + 1, $value);
            } else {
                $risk = json_decode($value, true);
                $this->m_voting->updateFactor($user_id, $ticker, 6, $risk['risk']['answer']);
            }
        }
        $this->m_master->setVetoFlag($user_id, $ticker, $veto['answer']);
        $this->m_master->setFinaliseFlag($user_id, $ticker, $finalise);
    }
}
