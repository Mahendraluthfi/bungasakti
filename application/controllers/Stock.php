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
        $this->load->library('Uuid');
        $this->load->model('ModelToko');
        $this->load->model('ModelBarang');
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
            'getNamaToko' => $getTokoById->namaToko,
            'getStockByToko' => $this->ModelToko->getStockByToko($idToko),
            'getAllBarang' => $this->ModelBarang->getAllBarang(),
        );
        $this->load->view('app/index', $data);
    }

    function addStock()
    {
        $idBarang = $this->input->post('idBarang');
        $qtyStock = $this->input->post('qtyStock');
        $idToko = $this->input->post('idToko');
        $idStock = substr($this->uuid->v4(), 0, 8);

        $data = array(
            'idStock' => $idStock,
            'idToko' => $idToko,
            'idBarang' => $idBarang,
            'qtyStock' => $qtyStock,
            'createdAt' => date('Y-m-d H:i:s'),
        );

        $checkStockExist = $this->ModelToko->stockExist($idToko, $idBarang);
        if ($checkStockExist) {
            $updateStock = $this->ModelToko->updateStock($idToko, $idBarang, $qtyStock);
            echo ($updateStock) ? json_encode(true) : json_encode(false);
        } else {
            $addStock = $this->ModelToko->addStock($data);
            echo ($addStock) ? json_encode(true) : json_encode(false);
        }
        // echo json_encode(true);
    }
}

/* End of file Stock.php */
