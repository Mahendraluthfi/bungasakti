<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AppHome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
    }

    public function index()
    {
        $data = array(
            'content' => 'app/dashboard',
        );
        $this->load->view('app/index', $data);
    }
}

/* End of file AppHome.php */
