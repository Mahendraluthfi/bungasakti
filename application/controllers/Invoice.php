<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Uuid');
    }
    public function index()
    {
        $data = [
            'content' => 'app/invoice'
        ];

        $this->load->view('app/index', $data);
    }
}

/* End of file Invoice.php */
