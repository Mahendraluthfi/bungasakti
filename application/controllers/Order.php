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
        $this->load->model('ModelToko');
        $this->load->model('ModelCustomer');
        $this->load->model('ModelInvoice');
    }

    public function index()
    {
        $getAllOrder = $this->ModelOrder->getAllOrder();
        foreach ($getAllOrder as $key => $value) {
            $value->totalOrder = $this->db->query("SELECT SUM(total) as totalOrder FROM det_master_order WHERE idMasterOrder = '$value->idMasterOrder'")->row();
        }
        $data = array(
            'content' => 'app/order',
            'getAllCustomer' => $this->ModelCustomer->getAllCustomer(),
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
            foreach ($getListOrderById as $key => $value) {
                $value->getStockIssuedByDetOrder = $this->ModelOrder->getStockIssuedByDetOrder($value->idDetOrder);
            }
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
            'statusQty' => ($type == "CUSTOM") ? 1 : 0,
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
                <strong>Simpan master barang berhasil!</strong>
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
            'statusQty' => ($getBarangById->type == "CUSTOM") ? 1 : 0,
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

    function aturStock()
    {
        $idDetOrder = $this->input->post('idDetOrder');
        $getDetOrderById = $this->ModelOrder->getDetOrderById($idDetOrder);
        $getStockByIdBarang = $this->ModelToko->getStockByIdBarang($getDetOrderById->idBarang);
        $data = [
            'getDetOrderById' => $getDetOrderById,
            'getStockByIdBarang' => $getStockByIdBarang,
        ];
        echo json_encode($data);
    }

    function stockIssued()
    {
        $idDetOrder = $this->input->post('idDetOrder');
        $idStock = $this->input->post('pilihStock');
        $qtyIssued = $this->input->post('ambilStock');
        $data = [
            'idStock' => $idStock,
            'qtyIssued' => $qtyIssued,
            'idDetOrder' => $idDetOrder,
            'createdAt' => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('stock_issued', $data);

        // $this->db->set("updateAt", date('Y-m-d H:i:s'));
        $this->db->set("qtyStock", "qtyStock - $qtyIssued", FALSE);
        $this->db->where('idStock', $idStock);
        $this->db->update('toko_stock');

        echo json_encode(['idDetOrder' => $idDetOrder]);
    }

    function showStockIssued()
    {
        $idDetOrder = $this->input->post('idDetOrder');
        // $idDetOrder = $id;
        $getStockIssuedByDetOrder = $this->ModelOrder->getStockIssuedByDetOrder($idDetOrder);
        echo json_encode($getStockIssuedByDetOrder);
    }

    function hapusAtur()
    {
        $id = $this->input->post('id');
        $get = $this->db->get_where('stock_issued', ['id' => $id])->row();

        // $this->db->set("updateAt", date('Y-m-d H:i:s'));
        $this->db->set('qtyStock', 'qtyStock + ' . $get->qtyIssued, FALSE);
        $this->db->where('idStock', $get->idStock);
        $this->db->update('toko_stock');

        $this->db->delete('stock_issued', ['id' => $id]);
        echo json_encode(true);
    }

    function stockValidation()
    {
        $idDetOrder = $this->input->post('idDetOrder');
        $getDetOrderById = $this->ModelOrder->getDetOrderById($idDetOrder);
        $getSumStockIssued  = $this->ModelOrder->getSumStockIssued($idDetOrder);
        $qtyOrder = $getDetOrderById->qtyOrder;
        $sumIssued  = $getSumStockIssued;
        if ($sumIssued == $qtyOrder) {
            //OK
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Atur stok berhasil!</strong>
            </div>');
            $this->db->update('det_master_order', ['statusQty' => '1', 'updatedAt' => date('Y-m-d H:i:s')], ['idDetOrder' => $idDetOrder]);
            $status = true;
        } elseif ($sumIssued > $qtyOrder) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Atur stok lebih besar daripada qty order!</strong>
            </div>');
            $this->db->update('det_master_order', ['statusQty' => '2', 'updatedAt' => date('Y-m-d H:i:s')], ['idDetOrder' => $idDetOrder]);
            $status = true;
        } else {
            $this->db->update('det_master_order', ['statusQty' => '0', 'updatedAt' => date('Y-m-d H:i:s')], ['idDetOrder' => $idDetOrder]);
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Atur stok gagal! Mohon cek lagi atur stock</strong>
            </div>');
            $status = false;
        }

        echo json_encode(true);
    }

    function getDetOrderById()
    {
        $idDetOrder = $this->input->post('idDetOrder');
        $data = $this->ModelOrder->getDetOrderById($idDetOrder);
        echo json_encode($data);
    }

    function simpanEditOrder()
    {
        $qtyOrder = $this->input->post('qtyOrder');
        $fixedPrice = $this->input->post('fixedPrice');
        $idDetOrder = $this->input->post('idDetEdit');
        $total = $qtyOrder * $fixedPrice;
        $data = [
            'qtyOrder' => $qtyOrder,
            'fixedPrice' => $fixedPrice,
            'total' => $total,
            'updatedAt' => date('Y-m-d H:i:s'),
        ];
        $this->db->update('det_master_order', $data, ['idDetOrder' => $idDetOrder]);
        $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Edit Order berhasil!</strong>
            </div>');
        echo json_encode(true);
    }

    function addNewOrder()
    {
        $idCustomer = $this->input->post('idCustomer');
        $poRefrence = $this->input->post('poRefrence');
        $idMasterOrder = substr($this->uuid->v4(), 0, 8);
        $data = [
            'idMasterOrder' => $idMasterOrder,
            'idCustomer' => $idCustomer,
            'poRefrence' => $poRefrence,
            'status' => 'PROSES',
            'createdAt' => date('Y-m-d H:i:s'),
        ];

        $insertRow = $this->ModelOrder->insertNewOrder($data);
        if ($insertRow) {
            redirect('order/editOrder/' . $idMasterOrder);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Gagal Simpan Data!</strong>
            </div>');
            redirect('order');
        }
    }

    function genInvoice($idMasterOrder)
    {
        $today = date('Y-m-d');
        $idInvoice = substr($this->uuid->v4(), 0, 8);
        $idSuratJalan = substr($this->uuid->v4(), 0, 8);
        $oneMonthAfter = date('Y-m-d', strtotime("+30 days"));
        if ($this->input->is_ajax_request()) {
            $selectedOrders = $this->input->post('idDetOrder');
            $quantities = $this->input->post('qtyInvoice');
            $responseArray = [];

            // Check if selectedOrders contain any values            
            if ($selectedOrders && is_array($selectedOrders)) {
                $dataInvoice = [
                    'idInvoice' => $idInvoice,
                    'idSuratJalan' => $idSuratJalan,
                    'idMasterOrder' => $idMasterOrder,
                    'dueDate' => $oneMonthAfter,
                    'createdAt' => date('Y-m-d H:i:s'),
                    'status' => "PENDING"
                ];
                $this->ModelInvoice->insertNewInvoice($dataInvoice);
                foreach ($selectedOrders as $id) {
                    $quantity = isset($quantities[$id]) ? $quantities[$id] : 0;
                    if ($quantity) {
                        $responseArray[] = [
                            'idInvoice' => $idInvoice,
                            'idDetOrder' => $id,
                            'qtyInvoice' => $quantity,
                            'createdAt' => date('Y-m-d H:i:s'),
                        ];
                        echo json_encode(true);
                    } else {
                        echo json_encode(false);
                    }
                }
                $this->db->insert_batch('det_invoice', $responseArray);
            } else {
                echo json_encode(false);
            }
        }
    }
}

/* End of file Order.php */
