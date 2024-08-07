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
        $this->load->model('ModelOrder');
    }

    public function index()
    {
        $getAllOrder = $this->ModelOrder->getAllOrder();
        foreach ($getAllOrder as $key => $value) {
            $value->totalOrder = $this->db->query("SELECT SUM(total) as totalOrder FROM det_master_order WHERE idMasterOrder = '$value->idMasterOrder'")->row();
        }
        $data = array(
            'content' => 'app/order',
            'getAllOrder' => $getAllOrder,
        );
        $this->load->view('app/index', $data);
        // echo json_encode($data);
    }
}

/* End of file Order.php */
