<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Uuid');
        $this->load->model('ModelBarang');
    }

    public function index()
    {
        $data = array(
            'content' => 'app/barang',
            'getAllBarang' => $this->ModelBarang->getAllBarang(),
        );

        $this->load->view('app/index', $data);
    }

    function addBarang()
    {
        $idBarang = substr($this->uuid->v4(), 0, 8);
        $description = $this->input->post('description');
        $basePrice = $this->input->post('basePrice');
        $uom = $this->input->post('uom');
        $type = $this->input->post('type');
        $mcRefrence = $this->input->post('mcRefrence');
        $barcode = $this->input->post('barcode');
        $data = array(
            'idBarang' => $idBarang,
            'description' => $description,
            'barcode' => $barcode,
            'basePrice' => $basePrice,
            'uom' => $uom,
            'type' => $type,
            'mcRefrence' => $mcRefrence,
            'createdAt' => date('Y-m-d H:i:s'),
        );

        $insertRow = $this->ModelBarang->insertBarang($data);
        if ($insertRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Tambah Data Berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal Tambah Data!</strong>
            </div>');
            echo json_encode(false);
        }
    }

    function updateBarang()
    {
        $idBarang = $this->input->post('idBarang');
        $description = $this->input->post('description');
        $basePrice = $this->input->post('basePrice');
        $uom = $this->input->post('uom');
        $type = $this->input->post('type');
        $mcRefrence = $this->input->post('mcRefrence');
        $barcode = $this->input->post('barcode');
        $data = array(
            'description' => $description,
            'basePrice' => $basePrice,
            'barcode' => $barcode,
            'uom' => $uom,
            'type' => $type,
            'mcRefrence' => $mcRefrence,
            'updatedAt' => date('Y-m-d H:i:s'),
        );

        $updateRow = $this->ModelBarang->updateBarang($data, $idBarang);
        if ($updateRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Update Data Berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal Update Data!</strong>
            </div>');
            echo json_encode(false);
        }
    }

    function getBarangById()
    {
        $idBarang = $this->input->post('idBarang');
        $data = $this->ModelBarang->getBarangById($idBarang);
        echo json_encode($data);
    }

    function deleteBarang()
    {
        $idBarang = $this->input->post('idBarang');
        $deleteRow = $this->ModelBarang->deleteBarang($idBarang);
        if ($deleteRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Hapus Data Berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal Hapus Data!</strong>
            </div>');
            echo json_encode(false);
        }
    }
}

/* End of file Barang.php */
