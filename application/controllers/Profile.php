<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
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
        $idCustomer = $this->session->userdata('sessionIdCustomer');
        $data = array(
            'get' => $this->db->get_where('customer', ['idCustomer' => $idCustomer])->row(),
            'content' => 'client/profile',
        );
        $this->load->view('client/index', $data);
        // echo json_encode($data);
    }

    function update() {}
}

/* End of file Profile.php */
