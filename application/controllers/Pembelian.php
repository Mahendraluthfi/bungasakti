<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('ModelPembelian');
        $this->load->model('ModelToko');
        $this->load->model('ModelBarang');
        $this->load->library('Uuid');
    }


    public function index()
    {
        $get = $this->ModelPembelian->getAllPembelian();
        foreach ($get as $key => $value) {
            $value->total = $this->ModelPembelian->getTotalPembelian($value->idPembelian);
        }
        $data = [
            'title' => '',
            'content' => 'app/pembelian',
            'getAllPembelian' => $get,
        ];

        // echo json_encode($data);
        $this->load->view('app/index', $data);
    }

    function editForm($idPembelian = '')
    {
        $data = [
            'title' => '',
            'content' => 'app/pembelianEdit',
        ];
        if (!$idPembelian) {
            $isPending = $this->ModelPembelian->isPending();
            if (!$isPending) {
                $array = array(
                    'idPembelian' => substr($this->uuid->v4(), 0, 8),
                    'createdAt' => date('Y-m-d H:i:s'),
                    'status' => 'PENDING',
                );
                $this->ModelPembelian->insertNewPembelian($array);
            }

            $getPending = $this->ModelPembelian->getPending();
            $getItemPending = $this->ModelPembelian->getItemPembelian($getPending->idPembelian);
        } else {
            $getPending = $this->ModelPembelian->getPembelianById($idPembelian);
            $getItemPending = $this->ModelPembelian->getItemPembelian($idPembelian);
        }
        $data['getAllToko'] = $this->ModelToko->getAllToko();
        $data['getPending'] = $getPending;
        $data['getItem'] = $getItemPending;
        $data['idPembelian'] = $idPembelian ? $idPembelian : $getPending->idPembelian;
        $data['readyBarang'] = $this->ModelBarang->getAllBarangReady();
        $this->load->view('app/index', $data);
        // echo json_encode($data);
    }

    function addItem()
    {
        $idPembelian = $this->input->post('idPembelianItem');
        $idBarang = $this->input->post('idBarang');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        $total = $qty * $price;
        $idStock = substr($this->uuid->v4(), 0, 8);

        $getPembelian = $this->ModelPembelian->getPembelianById($idPembelian);

        if ($getPembelian->status == 'PENDING') {
            $this->db->insert('det_master_pembelian', [
                'idPembelian' => $idPembelian,
                'idBarang' => $idBarang,
                'qty' => $qty,
                'price' => $price,
                'total' => $total,
            ]);
        } else {
            $getStock = $this->db->get_where('toko_stock', ['idBarang' => $idBarang, 'idToko' => $getPembelian->idToko])->row();
            if ($getStock) {
                $this->db->set('qtyStock', 'qtyStock + ' . $qty, FALSE);
                $this->db->where('idStock', $getStock->idStock);
                $this->db->update('toko_stock');
            } else {
                $data = array(
                    'idStock' => $idStock,
                    'idToko' => $getPembelian->idToko,
                    'idBarang' => $idBarang,
                    'qtyStock' => $qty,
                    'createdAt' => date('Y-m-d H:i:s'),
                );
                $this->ModelToko->addStock($data);
            }
            $this->db->insert('det_master_pembelian', [
                'idPembelian' => $idPembelian,
                'idBarang' => $idBarang,
                'qty' => $qty,
                'price' => $price,
                'total' => $total,
            ]);
        }
        echo json_encode(true);
    }

    function updatePembelian()
    {
        $idPembelian = $this->input->post('idPembelian');
        $idToko = $this->input->post('idToko');
        $remark = $this->input->post('remark');
        $idUser = $this->session->userdata('sessionIdUser');
        $issuingDate = $this->input->post('issuingDate');
        $notaRefrence = $this->input->post('notaRefrence');
        $this->db->update('master_pembelian', [
            'idToko' => $idToko,
            'remark' => $remark,
            'idUser' => $idUser,
            'issuingDate' => $issuingDate,
            'notaRefrence' => $notaRefrence,
            'updatedAt' => date('Y-m-d H:i:s'),
        ], ['idPembelian' => $idPembelian]);

        echo json_encode(true);
    }

    function submitPembelian()
    {
        $idPembelian = $this->input->post('idPembelian');
        $getItemPembelian = $this->ModelPembelian->getItemPembelian($idPembelian);
        $getPembelianById = $this->ModelPembelian->getPembelianById($idPembelian);
        $idToko = $getPembelianById->idToko;


        if ($getPembelianById->status == 'PENDING') {
            foreach ($getItemPembelian as $key => $value) {
                $idStock = substr($this->uuid->v4(), 0, 8);
                $isStock = $this->db->get_where('toko_stock', ['idToko' => $idToko, 'idBarang' => $value->idBarang])->row();
                $object = array(
                    'idStock' => $idStock,
                    'idToko' => $idToko,
                    'idBarang' => $value->idBarang,
                    'qtyStock' => $value->qty,
                    'createdAt' => date('Y-m-d H:i:s'),
                );

                if ($isStock) {
                    $this->db->where('idStock', $isStock->idStock);
                    $this->db->set('qtyStock', 'qtyStock +' . $value->qty, FALSE);
                    $this->db->set('updatedAt', date('Y-m-d H:i:s'));
                    $this->db->update('toko_stock');
                } else {
                    $this->ModelToko->addStock($object);
                }
            }
            $this->db->update('master_pembelian', [
                'status' => 'SUBMIT',
                'updatedAt' => date('Y-m-d H:i:s')
            ], ['idPembelian' => $idPembelian]);
        } else {
            $this->db->update('master_pembelian', [
                'updatedAt' => date('Y-m-d H:i:s')
            ], ['idPembelian' => $idPembelian]);
        }
        // redirect('pembelian');
        echo json_encode(true);
    }

    function hapusItem()
    {
        $idDetPembelian = $this->input->post('idDetPembelian');
        $idPembelian = $this->input->post('idPembelian');

        $getDetPembelian = $this->db->get_where('det_master_pembelian', ['idDetPembelian' => $idDetPembelian])->row();

        $getPembelian = $this->ModelPembelian->getPembelianById($idPembelian);
        if ($getPembelian->status == 'PENDING') {
            $this->db->delete('det_master_pembelian', ['idDetPembelian' => $idDetPembelian]);
        } else {
            $getStock = $this->db->get_where('toko_stock', ['idBarang' => $getDetPembelian->idBarang, 'idToko' => $getPembelian->idToko])->row();
            if ($getStock) {
                $this->db->set('qtyStock', 'qtyStock - ' . $getDetPembelian->qty, FALSE);
                $this->db->where('idStock', $getStock->idStock);
                $this->db->update('toko_stock');

                $this->db->delete('det_master_pembelian', ['idDetPembelian' => $idDetPembelian]);
            }
        }
        echo json_encode(true);
    }
}

/* End of file Pembelian.php */
