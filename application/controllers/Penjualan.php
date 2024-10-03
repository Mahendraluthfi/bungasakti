<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Uuid');
        $this->load->model('ModelPenjualan');
    }
    public function index()
    {
        $getAll = $this->ModelPenjualan->getAllPenjualan();
        foreach ($getAll as $key => $value) {
            $value->total = $this->ModelPenjualan->getTotalBayar($value->idPenjualan);
        }
        $data = [
            'title' => '',
            'content' => 'app/penjualan',
            'get' => $getAll
        ];

        $this->load->view('app/index', $data);
    }

    function newTrans()
    {
        $idPenjualan = date('mdHis');
        $getToko = $this->db->get_where('master_toko', ['idToko' => $this->session->userdata('sessionToko')])->row();
        $data = [
            'title' => '',
            'content' => 'app/newPenjualan',
            'namaToko' => $getToko->namaToko,
            'getBarang' => $this->ModelPenjualan->getBarangReady($this->session->userdata('sessionToko'))
        ];
        $isNew  = $this->db->get_where('master_penjualan', ['status' => 0])->row();
        if ($isNew) {
            $data['idPenjualan'] = $isNew->idPenjualan;
        } else {
            $this->db->insert('master_penjualan', [
                'idPenjualan' => $idPenjualan,
                'idToko' => $this->session->userdata('sessionToko'),
                'idUser' => $this->session->userdata('sessionIdUser'),
                'createdAt' => date('Y-m-d H:i:s'),
                'status' => '0'
            ]);
            $data['idPenjualan'] = $idPenjualan;
        }

        $this->load->view('app/index', $data);
        // echo json_encode($data);
    }

    function checkBarcode()
    {
        $id = $this->input->post('id');
        $idPenjualan = $this->input->post('idPenjualan');
        $idToko = $this->session->userdata('sessionToko');
        $isBarcode = $this->ModelPenjualan->findBarcode($idToko, $id);
        // echo json_encode([
        //     'id' => $id,
        //     'idPenjualan' => $idPenjualan,
        //     'idToko' => $idToko,
        //     'isBarcode' => $isBarcode->result(),
        // ]);
        if ($isBarcode->num_rows() > 1) {
            // echo json_encode(2);
            $fetchBarcode = $isBarcode->result();
            echo json_encode([
                'status' => 200,
                'value' => 2,
                'message' => 'Pilih Barang Dahulu !',
                'data' => $fetchBarcode
            ]);
        } elseif ($isBarcode->num_rows() == 1) {
            // echo json_encode(1);

            $rowBarcode = $isBarcode->row();
            if ($rowBarcode->qtyStock > 0) {
                $object = [
                    'idPenjualan' => $idPenjualan,
                    'idStock' => $rowBarcode->idStock,
                    'qty' => 1,
                    'price' => $rowBarcode->basePrice,
                    'total' => $rowBarcode->basePrice,
                ];
                $this->db->insert('det_master_penjualan', $object);

                $this->db->set('qtyStock', 'qtyStock - 1', FALSE);
                $this->db->where('idStock', $rowBarcode->idStock);
                $this->db->update('toko_stock');

                echo json_encode([
                    'status' => 200,
                    'value' => 1,
                    'message' => 'Success add item',
                    'data' => ''
                ]);
            } else {
                echo json_encode([
                    'status' => 404,
                    'value' => 0,
                    'message' => 'Stock Barang Kosong ! Gagal Menambahkan Barang',
                    'data' => ''
                ]);
            }
        } else {
            // echo json_encode(0);
            echo json_encode([
                'status' => 404,
                'value' => 0,
                'message' => 'Barcode barang tidak ditemukan !',
                'data' => ''
            ]);
        }
    }

    function showItems()
    {
        $idPenjualan = $this->input->post('idPenjualan');
        $listItems = $this->ModelPenjualan->getDetailTransaksi($idPenjualan);
        $totalBayar = $this->ModelPenjualan->getTotalBayar($idPenjualan);
        $totalItems = $this->ModelPenjualan->getTotalItems($idPenjualan);
        $data = [
            'listItems' => $listItems,
            'totalBayar' => $totalBayar,
            'totalItems' => $totalItems,
        ];
        echo json_encode($data);
    }

    function pilihBarang()
    {
        $idStock = $this->input->post('id');
        $idPenjualan = $this->input->post('idPenjualan');
        $price = $this->input->post('price');
        $object = [
            'idPenjualan' => $idPenjualan,
            'idStock' => $idStock,
            'qty' => 1,
            'price' => $price,
            'total' => $price,
        ];
        $this->db->insert('det_master_penjualan', $object);

        $this->db->set('qtyStock', 'qtyStock - 1', FALSE);
        $this->db->where('idStock', $idStock);
        $this->db->update('toko_stock');

        echo json_encode(true);
    }

    function reduceQty()
    {
        $id = $this->input->post('id');
        $idStock = $this->input->post('idStock');
        $getId = $this->db->get_where('det_master_penjualan', ['idDetPenjualan' => $id])->row();
        $qty = $getId->qty - 1;
        $total = $getId->price * $qty;
        $this->db->update('det_master_penjualan', [
            'qty' => $qty,
            'total' => $total
        ], ['idDetPenjualan' => $id]);

        $this->db->set('qtyStock', 'qtyStock + 1', FALSE);
        $this->db->where('idStock', $idStock);
        $this->db->update('toko_stock');

        echo json_encode(true);
    }

    function addQty()
    {
        $id = $this->input->post('id');
        $idStock = $this->input->post('idStock');
        $getStock = $this->db->get_where('toko_stock', ['idStock' => $idStock])->row();
        $qtyStock = $getStock->qtyStock;
        if ($qtyStock == 0) {
            echo json_encode(['status' => false]);
        } else {
            $getId = $this->db->get_where('det_master_penjualan', ['idDetPenjualan' => $id])->row();
            $qty = $getId->qty + 1;
            $total = $getId->price * $qty;
            $this->db->update('det_master_penjualan', [
                'qty' => $qty,
                'total' => $total
            ], ['idDetPenjualan' => $id]);

            $this->db->set('qtyStock', 'qtyStock - 1', FALSE);
            $this->db->where('idStock', $idStock);
            $this->db->update('toko_stock');

            echo json_encode(['status' => true]);
        }

        // 
        // echo json_encode($getStock);
    }

    function hapusItem()
    {
        $idDetPenjualan = $this->input->post('id');
        $getId = $this->db->get_where('det_master_penjualan', ['idDetPenjualan' => $idDetPenjualan])->row();
        $idStock = $getId->idStock;

        $this->db->set('qtyStock', 'qtyStock + ' . $getId->qty, FALSE);
        $this->db->where('idStock', $idStock);
        $this->db->update('toko_stock');

        $this->db->delete('det_master_penjualan', ['idDetPenjualan' => $idDetPenjualan]);

        echo json_encode(true);
    }

    function selectedBarang()
    {
        $idStock = $this->input->post('idStock');
        $idPenjualan = $this->input->post('idPenjualan');
        $isThere = $this->db->get_where('det_master_penjualan', ['idPenjualan' => $idPenjualan, 'idStock' => $idStock])->row();
        $get = $this->db->get_where('toko_stock', ['idStock' => $idStock])->row();
        $price = $this->db->get_where('master_barang', ['idBarang' => $get->idBarang])->row();
        if ($isThere) {
            $qty = $isThere->qty + 1;
            $total = $isThere->price * $qty;
            $this->db->update('det_master_penjualan', [
                'qty' => $qty,
                'total' => $total
            ], ['idDetPenjualan' => $isThere->idDetPenjualan]);
        } else {
            $object = [
                'idPenjualan' => $idPenjualan,
                'idStock' => $idStock,
                'qty' => 1,
                'price' => $price->basePrice,
                'total' => $price->basePrice,
            ];
            $this->db->insert('det_master_penjualan', $object);
        }

        $this->db->set('qtyStock', 'qtyStock - 1', FALSE);
        $this->db->where('idStock', $idStock);
        $this->db->update('toko_stock');

        echo json_encode(true);
    }

    function simpanPenjualan()
    {
        $remark = $this->input->post('remark');
        $idPenjualan = $this->input->post('idPenjualan');
        $customer = $this->input->post('customer');

        $this->db->update('master_penjualan', [
            'customerName' => $customer,
            'remark' => $remark,
            'updatedAt' => date('Y-m-d H:i:s'),
            'status' => '1'
        ], ['idPenjualan' => $idPenjualan]);

        echo json_encode($idPenjualan);
    }

    function printNota($idPenjualan)
    {
        $totalBayar = $this->ModelPenjualan->getTotalBayar($idPenjualan);
        $totalItems = $this->ModelPenjualan->getTotalItems($idPenjualan);
        $data = [
            'getPenjualan' => $this->ModelPenjualan->getPenjualanById($idPenjualan),
            'getDetailTransaksi' => $this->ModelPenjualan->getDetailTransaksi($idPenjualan),
            'totalBayar' => $totalBayar,
            'totalItems' => $totalItems,
        ];
        $this->load->view('app/printNota', $data);
        // echo json_encode($data);
    }

    function getPenjualan()
    {
        $idPenjualan = $this->input->post('idPenjualan');
        $data = [
            'listItems' => $this->ModelPenjualan->getDetailTransaksi($idPenjualan),
        ];
        echo json_encode($data);
    }

    function hapusPenjualan()
    {
        $idPenjualan = $this->input->post('idPenjualan');
        $getDetail = $this->db->get_where('det_master_penjualan', ['idPenjualan' => $idPenjualan])->result();
        foreach ($getDetail as $data) {
            $idStock = $data->idStock;
            $this->db->set('qtyStock', 'qtyStock + ' . $data->qty, FALSE);
            $this->db->where('idStock', $idStock);
            $this->db->update('toko_stock');
        }
        $this->db->delete('master_penjualan', ['idPenjualan' => $idPenjualan]);
        $this->db->delete('det_master_penjualan', ['idPenjualan' => $idPenjualan]);
        echo json_encode(true);
    }
}

/* End of file Penjualan.php */
