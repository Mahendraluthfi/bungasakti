<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientPurchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in_customer() == false) {
            redirect('login', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Uuid');
        $this->load->model('ModelPurchase');
        $this->load->model('ModelCustomer');
        $this->load->model('ModelBarang');
    }

    public function index()
    {
        $data = array(
            'content' => 'client/purchase',
            'getAllPurchase' => $this->ModelPurchase->getAllPurchase(),
            'getAllCustomer' => $this->ModelCustomer->getAllCustomer(),
        );
        $this->load->view('client/index', $data);
    }
}

/* End of file ClientPurchase.php */
