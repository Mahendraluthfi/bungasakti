<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
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
        $this->load->model('ModelCustomer');
        $this->load->model('ModelBarang');
        $this->load->model('ModelOrder');
    }

    public function index()
    {
        $data = array(
            'content' => 'app/purchase',
            'getAllPurchase' => $this->ModelPurchase->getAllPurchase(),
            'getAllCustomer' => $this->ModelCustomer->getAllCustomer(),
        );
        $this->load->view('app/index', $data);
    }

    function form($idCustomer = '')
    {
        if ($idCustomer) {
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
                'content' => 'app/purchaseForm',
                'getCurrentPurchase' => $getCurrentPurchase,
                'getDetailPurchase' => $getDetailPurchase,
                'getAllBarang' => $this->ModelBarang->getAllBarang(),
            );
            $this->load->view('app/index', $data);
            // echo json_encode($data);
        } else {
            redirect('purchase', 'refresh');
        }
    }

    function formEdit($idPR)
    {
        $getPRbyId = $this->ModelPurchase->getPRbyId($idPR);
        $getDetailPurchase = $this->ModelPurchase->getDetailPurchase($idPR);
        $data = array(
            'content' => 'app/purchaseFormEdit',
            'getCurrentPurchase' => $getPRbyId,
            'getDetailPurchase' => $getDetailPurchase,
            'getAllBarang' => $this->ModelBarang->getAllBarang(),
        );
        $this->load->view('app/index', $data);
    }

    function updateForm()
    {
        $idPR = $this->input->post('idPR');
        $priority = $this->input->post('priority');
        $datePR = $this->input->post('datePR');
        $remark = $this->input->post('remark');
        $data = array(
            'datePR' => $datePR,
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

    function addDetBarang()
    {
        $idPR = $this->input->post('idPR');
        $remark = $this->input->post('remark');
        $idBarang = $this->input->post('idBarang');
        if ($idBarang == "CUSTOM") {
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
        if ($idBarang == "CUSTOM") {
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
        redirect('purchase');
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

    function proccedOrder()
    {
        $idPR = $this->input->post('idPR');
        $getPRbyId = $this->ModelPurchase->getPRbyId($idPR);
        $idMasterOrder = substr($this->uuid->v4(), 0, 8);
        $objectOrder = array(
            'idMasterOrder' => $idMasterOrder,
            'idCustomer' => $getPRbyId->idCustomer,
            'idPR' => $idPR,
            'status' => 'PROSES',
            'createdAt' => date('Y-m-d H:i:s'),
        );

        $insertOrder = $this->ModelOrder->insertOrderbyPR($objectOrder);
        $getDetailPurchase = $this->ModelPurchase->getDetailPurchase($idPR);

        foreach ($getDetailPurchase as $key => $value) {
            if ($value->idBarang !== null) {
                $total = $value->qtyOrder * $value->basePrice;

                $this->db->insert('det_master_order', [
                    'idMasterOrder' => $idMasterOrder,
                    'idBarang' => $value->idBarang,
                    'qtyOrder' => $value->qtyOrder,
                    'qtyBalance' => $value->qtyOrder,
                    'fixedPrice' => $value->basePrice,
                    'total' => $total,
                    'createdAt' => date('Y-m-d H:i:s')
                ]);
            }
        }

        $this->db->update('purchase_request', ['status' => 'ORDER'], ['idPR' => $idPR]);

        if ($insertOrder) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Proses order berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Gagal proses order!</strong>
            </div>');
            echo json_encode(false);
        }
    }
}

/* End of file Purchase.php */
