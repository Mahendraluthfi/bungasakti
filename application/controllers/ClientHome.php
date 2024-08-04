<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientHome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in_customer() == false) {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data = array(
            'content' => 'client/dashboard',
        );
        $this->load->view('client/index', $data);
    }
}

/* End of file ClientHome.php */
