<?php if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class C_auth_model extends CI_Model
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

    public function is_admin($credentials)
    {
        $flag = $this->db->select('isAdmin')->get_where('ic', $credentials)->result_array()[0];

        return (bool)$flag['isAdmin'];
    }

    public function check_credentials($credentials)
    {
        $user = $this->db->get_where('ic', $credentials)->result_array();

        if (is_array($user) && ! empty($user)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_user_id($credentials)
    {
        $user = $this->db->select('memberNo')->get_where('ic', $credentials)->result_array()[0];

        return (int)$user['memberNo'];
    }

}
