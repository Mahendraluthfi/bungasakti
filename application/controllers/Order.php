<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Uuid');
        $this->load->model('ModelToko');
        $this->load->model('ModelBarang');
    }

    public function index()
    {
        $data = array(
            'content' => 'app/order',
        );
        $this->load->view('app/index', $data);
    }
}

/* End of file Order.php */
