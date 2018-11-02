<?php

/**
 * @property  CI_Model model
 * @property  CI_db db
 */
class M_conviction extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getConviction($user, $icDate)
    {
        $query = $this->db
            ->select("*")
            ->where('memberNo', $user['memberNo'])
            ->where('icDate', $icDate)
            ->from('conviction')
            ->get();
        $convictionData = $query->row_array();

        // record exist
        if (count($convictionData) == 0 ){
            $convictionData= [
                'memberNo' => $user['memberNo'],
                'memberName' => $user['memberName'],
                'icDate' => $icDate,
                'conviction' => 1,
                'mktReturn' => 0,
            ];
            $this->db->insert('conviction', $convictionData);
            // get last inserted in
            $convictionData['convictionID'] = $this->db->insert_id();
        }
        return $convictionData;
    }

    public function updateConviction($data){
        return $this->db
            ->set('mktReturn', $data['mktReturn']/100)
            ->set('conviction', $data['conviction']/100)
            ->where('memberNo', $data['memberNo'])
            ->where('icDate',  $data['icDate'])
            ->update('conviction');
    }
}