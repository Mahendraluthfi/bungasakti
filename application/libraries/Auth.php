<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth
{
    var $ci = NULL;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    function is_logged_in()
    {
        if ($this->ci->session->userdata('sessionIdUser') == '' && $this->ci->session->userdata('sessionLevel') == '' && $this->ci->session->userdata('sessionApp') == '' && $this->ci->session->userdata('sessionToko') == '' && $this->ci->session->userdata('sessionName') == '' && $this->ci->session->userdata('sessionUsername') == '') {
            return false;
        }
        return true;
    }

    function is_logged_in_customer()
    {
        if ($this->ci->session->userdata('sessionIdCustomer') == '' && $this->ci->session->userdata('sessionLoged') == '' && $this->ci->session->userdata('sessionUsernameCustomer') == '') {
            return false;
        }
        return true;
    }

    function restrict()
    {
        if ($this->is_logged_in() == false) {
            redirect(base_url());
        }
    }
}

/* End of file Auth.php */
/* Location: ./application/libraries/Auth.php */
