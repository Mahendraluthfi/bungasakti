<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
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
    }

    public function index()
    {
        $data = array(
            'content' => 'app/toko',
            'getAllToko' => $this->ModelToko->getAllToko(),
        );
        $this->load->view('app/index', $data);
    }

    function saveToko()
    {
        $idToko = substr($this->uuid->v4(), 0, 8);
        $namaToko = $this->input->post('namaToko');
        $address = $this->input->post('address');

        $data = array(
            'idToko' => $idToko,
            'namaToko' => $namaToko,
            'address' => $address,
            'createdAt' => date('Y-m-d H:i:s')
        );


        $insertRow = $this->ModelToko->insertToko($data);
        if ($insertRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Simpan Berhasil !</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Error. Gagal Simpan!</strong>
            </div>');
            echo json_encode(false);
        }
    }

    function getTokoById()
    {
        $idToko = $this->input->post('idToko');
        $data = $this->ModelToko->getTokoById($idToko);
        echo json_encode($data);
    }

    function updateToko()
    {
        $idToko = $this->input->post('idToko');
        $namaToko = $this->input->post('namaToko');
        $address = $this->input->post('address');

        $data = array(
            'namaToko' => $namaToko,
            'address' => $address,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        $updateRow = $this->ModelToko->updateToko($data, $idToko);
        if ($updateRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Update Berhasil !</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Error. Gagal Update!</strong>
            </div>');
            echo json_encode(false);
        }
    }

    function deleteToko()
    {
        $idToko = $this->input->post('idToko');
        $deleteRow = $this->ModelToko->deleteToko($idToko);
        // echo ($deleteRow) ? json_encode(true) : json_encode(false);
        if ($deleteRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Hapus Berhasil !</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Error. Gagal Hapus!</strong>
            </div>');
            echo json_encode(false);
        }
    }
}

/* End of file Toko.php */
