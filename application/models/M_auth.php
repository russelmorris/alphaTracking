<?php if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_auth extends CI_Model
{
    /**
     * Holds an array of tables used
     *
     * @var array
     **/

    public function __construct()
    {
        parent::__construct();
    }

    public function check_credentials($email, $password)
    {
        $return      = false;
        $credentials = [
            'email'    => $email,
            'password' => $password,
            'isActive' => 1
        ];


        $user = $this->db
            ->select('memberNo, bWeight, email')
            ->select('isAdmin, isComittee, memberName')
            ->get_where('ic', $credentials)
            ->result_array();

        if (count($user) > 0) {
            $return = $user[0];
        }

        return $return;
    }
}
