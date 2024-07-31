<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('ModelToko');
    }

    public function index()
    {
        $data = array(
            'content' => 'app/stock',
            'getAllToko' => $this->ModelToko->getAllToko(),
        );
        $this->load->view('app/index', $data);
    }

    function toko($idToko)
    {
        $getTokoById = $this->ModelToko->getTokoById($idToko);
        $data = array(
            'content' => 'app/stockView',
            'getNamaToko' => $getTokoById->namaToko
        );
        $this->load->view('app/index', $data);
    }
}

/* End of file Stock.php */
