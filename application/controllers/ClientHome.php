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
        $this->load->model('ModelCustomer');
    }

    public function index()
    {
        $idCustomer = $this->session->userdata('sessionIdCustomer');

        $data = array(
            'content' => 'client/dashboard',
            'getPRbyId' => $this->ModelCustomer->getPRbyId($idCustomer),
            'getPRpending' => $this->ModelCustomer->getPRbyStatus($idCustomer, 'PENDING'),
            'getPRsubmit' => $this->ModelCustomer->getPRbyStatus($idCustomer, 'SUBMIT'),
        );
        $this->load->view('client/index', $data);
    }
}

/* End of file ClientHome.php */
