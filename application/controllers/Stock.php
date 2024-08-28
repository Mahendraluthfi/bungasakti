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
        $getNotToko = $this->db->query("SELECT * FROM master_toko WHERE NOT idToko = '$idToko' AND isActive='1'")->result();
        $data = array(
            'content' => 'app/stockView',
            'getNamaToko' => $getTokoById->namaToko,
            'getStockByToko' => $this->ModelToko->getStockByToko($idToko),
            'getAllBarang' => $this->ModelBarang->getAllBarangReady(),
            'tokoDestination' => $getNotToko
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

    function detailStock()
    {
        $idBarang = $this->input->post('idBarang');
        $data = $this->ModelBarang->getBarangById($idBarang);
        $valueStock = $this->db->query("SELECT SUM(qtyStock) as qty from toko_stock where idBarang='$idBarang'")->row();

        echo json_encode(['data' => $data, 'qty' => $valueStock]);
    }

    function getIdStock()
    {
        $idStock = $this->input->post('idStock');
        $get = $this->ModelToko->getIdStock($idStock);
        echo json_encode($get);
    }

    function transferStock()
    {
        //get isi idStock dulu, ambil idBarang, then check whether tokotujuan already have that idBarang,
        //if not insert new, if yes adding stock qty

        $idStock = $this->input->post('idStock');
        $stockFrom = $this->input->post('stockFrom');
        $qtyTransfer = $this->input->post('qtyTransfer');
        $tokoTujuan = $this->input->post('tokoTujuan');
        $idStockNew = substr($this->uuid->v4(), 0, 8);
        $get = $this->ModelToko->getIdStock($idStock);
        $data = array(
            'idStock' => $idStockNew,
            'idToko' => $tokoTujuan,
            'idBarang' => $get->idBarang,
            'qtyStock' => $qtyTransfer,
            'createdAt' => date('Y-m-d H:i:s'),
        );

        $checkStockExist = $this->ModelToko->stockExist($tokoTujuan, $get->idBarang);
        if ($checkStockExist) {
            $this->ModelToko->updateStock($tokoTujuan, $get->idBarang, $qtyTransfer);
        } else {
            $this->ModelToko->addStock($data);
        }

        $this->ModelToko->reduceQty($idStock, $qtyTransfer);
        $this->session->set_flashdata('msg', '
        <div class="alert alert-success" role="alert">
            <strong>Transfer Stock berhasil!</strong>
        </div>');
        echo json_encode(true);
        redirect('stock/toko/' . $stockFrom);
        // $insertPembelian = [
        //     'idPembelian' => $idPembelian,
        //     'idToko' => $tokoTujuan,
        //     'issuingDate' => $date,
        //     'idUser' => $idUser,
        //     'remark' => 'Transfer Stock dari idToko' . $stockFrom,
        //     'createdAt' => date('Y-m-d H:i:s'),
        //     'status' => '1'
        // ];
        // $insertDetPembelian =[
        // ];

    }
}

/* End of file Stock.php */
