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
        $this->load->model('ModelPurchase');
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

    function editOrder($idMasterOrder)
    {
        if ($idMasterOrder) {
            $getOrderById = $this->ModelOrder->getOrderById($idMasterOrder);
            $getListOrderById = $this->ModelOrder->getOrderListById($idMasterOrder);
            // foreach ($getListOrderById as $key => $value) {
            //     $value->isIssued = $this->ModelOrder->isIssuedStock($value->idDetOrder);
            // }
            $getPR = $getOrderById->idPR;
            $data = array(
                'content' => 'app/orderEdit',
                'getOrderById' => $getOrderById,
                'getListOrderById' => $getListOrderById,
                'checkBarangNotInMaster' => $this->ModelOrder->checkBarangNotInMaster($getPR, $idMasterOrder),
                'getAllBarang' => $this->ModelBarang->getAllBarang(),
            );
            $this->load->view('app/index', $data);
            // echo json_encode($data);
        } else {
            redirect('order', 'refresh');
        }
    }

    function updatePO()
    {
        $idMasterOrder = $this->input->post('idMasterOrder');
        $poRefrence = $this->input->post('poRefrence');
        $this->db->update('master_order', ['poRefrence' => $poRefrence, 'updatedAt' => date('Y-m-d H:i:s')], ['idMasterOrder' => $idMasterOrder]);
        echo json_encode(true);
    }

    function getIdDetPR()
    {
        $idDetPR = $this->input->post('idDetPR');
        $data = $this->ModelPurchase->getDetPRById($idDetPR);
        echo json_encode($data);
    }

    function addNewBarang()
    {
        $idBarang = substr($this->uuid->v4(), 0, 8);
        $description = $this->input->post('description');
        $basePrice = $this->input->post('basePrice');
        $uom = $this->input->post('uom');
        $type = $this->input->post('type');
        $mcRefrence = $this->input->post('mcRefrence');
        $barcode = $this->input->post('barcode');
        $idDetPR = $this->input->post('idDetPR');
        $qtyOrder = $this->input->post('qtyOrder');
        $idMasterOrder = $this->input->post('idMasterOrderHide');

        $dataBarang = array(
            'idBarang' => $idBarang,
            'description' => $description,
            'barcode' => $barcode,
            'basePrice' => $basePrice,
            'uom' => $uom,
            'type' => $type,
            'mcRefrence' => $mcRefrence,
            'createdAt' => date('Y-m-d H:i:s'),
        );

        $insertRow = $this->ModelBarang->insertBarang($dataBarang);
        $total = $qtyOrder * $basePrice;

        $this->db->insert('det_master_order', [
            'idMasterOrder' => $idMasterOrder,
            'idBarang' => $idBarang,
            'qtyOrder' => $qtyOrder,
            'qtyBalance' => $qtyOrder,
            'fixedPrice' => $basePrice,
            'total' => $total,
            'createdAt' => date('Y-m-d H:i:s')
        ]);
        $dataDetPR = array(
            'idBarang' => $idBarang,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        $updateRow = $this->ModelPurchase->updateDetBarang($idDetPR, $dataDetPR);
        if ($insertRow && $updateRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Simpan barang berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal simpan barang!</strong>
            </div>');
            echo json_encode(false);
        }
    }

    function addOrderBarang()
    {
        $idMasterOrder = $this->input->post('idMasterOrderAdd');
        $idBarang = $this->input->post('idBarang');
        $qtyOrder = $this->input->post('qtyOrder');
        $getBarangById = $this->ModelBarang->getBarangById($idBarang);
        $total = $qtyOrder * $getBarangById->basePrice;
        $dataDetMasterOrder = array(
            'idMasterOrder' => $idMasterOrder,
            'idBarang' => $idBarang,
            'qtyOrder' => $qtyOrder,
            'qtyBalance' => $qtyOrder,
            'fixedPrice' => $getBarangById->basePrice,
            'total' => $total,
            'createdAt' => date('Y-m-d H:i:s')
        );
        $insertRow = $this->ModelOrder->insertDetMasterOrder($dataDetMasterOrder);
        if ($insertRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Tambah barang berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal tambah barang!</strong>
            </div>');
            echo json_encode(false);
        }
    }
}

/* End of file Order.php */
