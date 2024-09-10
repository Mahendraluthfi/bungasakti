<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientPurchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in_customer() == false) {
            redirect('login', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Uuid');
        $this->load->model('ModelPurchase');
        $this->load->model('ModelCustomer');
        $this->load->model('ModelBarang');
    }

    public function index()
    {
        $idCustomer = $this->session->userdata('sessionIdCustomer');
        $data = array(
            'content' => 'client/purchase',
            'getAllPurchaseByCustomer' => $this->ModelPurchase->getAllPurchaseByCustomer($idCustomer),
        );
        $this->load->view('client/index', $data);
    }

    function addDetBarang()
    {
        $idPR = $this->input->post('idPR');
        $uom = $this->input->post('uom');
        $inputCustom = $this->input->post('inputCustom');
        $remark = $this->input->post('remark');
        $idBarang = $this->input->post('idBarang');
        if ($inputCustom) {
            $descriptionCustom = $this->input->post('descriptionCustom');
            $inputIdBarang = null;
        } else {
            $descriptionCustom = null;
            $inputIdBarang = $idBarang;
        }
        $qtyOrder = $this->input->post('qtyOrder');
        $data = array(
            'idPR' => $idPR,
            'qtyOrder' => $qtyOrder,
            'uom' => $uom,
            'remark' => $remark,
            'createdAt' => date('Y-m-d H:i:s'),
            'idBarang' => $inputIdBarang,
            'descriptionCustom' => $descriptionCustom,
        );

        $insertRow = $this->ModelPurchase->addDetBarang($data);
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

    function updateDetBarang()
    {
        $idDetPR = $this->input->post('idDetPR');
        $remark = $this->input->post('remark');
        $idBarang = $this->input->post('idBarang');
        $uom = $this->input->post('uom');
        $inputCustom = $this->input->post('inputCustom');
        if ($inputCustom) {
            $descriptionCustom = $this->input->post('descriptionCustom');
            $inputIdBarang = null;
        } else {
            $descriptionCustom = null;
            $inputIdBarang = $idBarang;
        }
        $qtyOrder = $this->input->post('qtyOrder');
        $data = array(
            'idBarang' => $inputIdBarang,
            'descriptionCustom' => $descriptionCustom,
            'qtyOrder' => $qtyOrder,
            'uom' => $uom,
            'remark' => $remark,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        $updateRow = $this->ModelPurchase->updateDetBarang($idDetPR, $data);
        if ($updateRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Update barang berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal update barang!</strong>
            </div>');
            echo json_encode(false);
        }
        // echo json_encode($data);
    }

    function form()
    {
        $idCustomer = $this->session->userdata('sessionIdCustomer');
        $isPending = $this->ModelPurchase->isPending($idCustomer);
        if (!$isPending) {
            $array = array(
                'idCustomer' => $idCustomer,
                'idPR' => substr($this->uuid->v4(), 0, 8),
                'createdAt' => date('Y-m-d H:i:s'),
                'status' => 'PENDING',
            );
            $this->ModelPurchase->insertNewPurchase($array);
        }
        $getCurrentPurchase = $this->ModelPurchase->getCurrentPurchase($idCustomer);
        $getDetailPurchase = $this->ModelPurchase->getDetailPurchase($getCurrentPurchase->idPR);

        $data = array(
            'content' => 'client/purchaseForm',
            'getCurrentPurchase' => $getCurrentPurchase,
            'getDetailPurchase' => $getDetailPurchase,
            'getAllBarang' => $this->ModelBarang->getAllBarang(),
        );
        $this->load->view('client/index', $data);
    }

    function formEdit($idPR)
    {
        $getPRbyId = $this->ModelPurchase->getPRbyId($idPR);
        $getDetailPurchase = $this->ModelPurchase->getDetailPurchase($idPR);
        $data = array(
            'content' => 'client/purchaseFormEdit',
            'getCurrentPurchase' => $getPRbyId,
            'getDetailPurchase' => $getDetailPurchase,
            'getAllBarang' => $this->ModelBarang->getAllBarang(),
        );
        $this->load->view('client/index', $data);
    }

    function updateForm()
    {

        $idPR = $this->input->post('idPR');
        $priority = $this->input->post('priority');
        // $datePR = $this->input->post('datePR');
        $remark = $this->input->post('remark');
        $data = array(
            // 'datePR' => $datePR,
            'remark' => $remark,
            'priority' => $priority,
            'updatedAt' => date('Y-m-d H:i:s'),
        );

        $updateForm  = $this->ModelPurchase->updateForm($idPR, $data);
        if ($updateForm) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Update berhasil !</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Update gagal !</strong>
            </div>');
            echo json_encode(false);
        }
    }

    function deleteDetPR()
    {
        $idDetPR = $this->input->post('idDetPR');
        $deleteRow = $this->ModelPurchase->deleteDetPR($idDetPR);
        if ($deleteRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Hapus barang berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal hapus barang!</strong>
            </div>');
            echo json_encode(false);
        }
    }

    function getDetPRbyID()
    {
        $idDetPR = $this->input->post('idDetPR');
        $data = $this->ModelPurchase->getDetPRbyID($idDetPR);
        echo json_encode($data);
    }

    function submitPR($idPR)
    {
        $submitPR = $this->ModelPurchase->submitPR($idPR);
        if ($submitPR) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Submit PR berhasil!</strong>
            </div>');
            // echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal submit PR!</strong>
            </div>');
            // echo json_encode(false);
        }
        redirect('clientPurchase');
    }

    function getDetailPR()
    {
        $idPR = $this->input->post('idPR');
        $data = array(
            'getPRbyId' => $this->ModelPurchase->getPRbyId($idPR),
            'getDetailPurchase' => $this->ModelPurchase->getDetailPurchase($idPR),
        );
        echo json_encode($data);
    }

    function hapusPR()
    {
        $idPR = $this->input->post('idPR');
        $status = $this->input->post('status');
        $hapusPR = $this->ModelPurchase->hapusPR($idPR, $status);
        if ($hapusPR) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Hapus PR berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal hapus PR!</strong>
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
}

/* End of file ClientPurchase.php */
