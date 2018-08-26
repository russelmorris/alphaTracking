<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 * @property  M_icdate m_icdate
 */
class M_ic extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'm_icdate',
        ]);
    }

    public function getMembers()
    {
        $ic_dates                  = $this->m_icdate->getIcDates();
        $closest_icDate_from_today = find_closest_date(array_column($ic_dates, 'icDate'));

        $query = $this->db
            ->select("*")
            ->where('strategyNo', 1)
            ->where('isActive', 1)
            ->where('isComittee', 1)
            ->from('ic')
            ->get()
            ->result_array();


        foreach ($query as $index => $value) {
            $query[$index]['finalise_overall'] = number_format($this->finalised_overall($value['memberNo'], $closest_icDate_from_today),
                2, '.', '');
            $query[$index]['last_edited']      = $this->last_edited($value['memberNo']);
        }
        return $query;
    }

    public function getUserByID($id = 0)
    {
        $return = false;
        $user   = $this->db
            ->select('memberNo, bWeight, email')
            ->select('isAdmin, isComittee, memberName')
            ->where('memberNo', $id)
            ->where('isActive', 1)
            ->from('ic')
            ->get()
            ->result_array();

        if (count($user) > 0) {
            $return = $user[0];
        }

        return $return;
    }

    public function finalised_overall($user_id, $icDate)
    {


        $return = 0;
        $final  = $this->db->select('isFinalised')
                           ->where('isActive', 1)
                           ->where('isFinalised', 1)
                           ->where('memberNo', $user_id)
                           ->where('icDate', $icDate)
                           ->from('master')
                           ->get()
                           ->num_rows();

        $overall = $this->db->select('isFinalised')
                            ->where('isActive', 1)
                            ->where('memberNo', $user_id)
                            ->where('icDate', $icDate)
                            ->from('master')
                            ->get()
                            ->num_rows();
        if ($final > 0 && $overall > 0) {
            $return = ($final / $overall) * 100;
        }

        return $return;
    }

    public function last_edited($user_id)
    {
        $return = false;
        $ledit  = $this->db->select('DateModified')
                           ->where('isActive', 1)
                           ->where('memberNo', $user_id)
                           ->from('master')
                           ->order_by('DateModified', 'DESC')
                           ->get()
                           ->result_array();


        if (count($ledit) > 0) {
            $return = array_column($ledit, 'DateModified')[0];
        }

        return $return;
    }


}