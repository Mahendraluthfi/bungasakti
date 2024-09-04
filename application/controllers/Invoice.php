<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Uuid');
        $this->load->model('ModelInvoice');
        $this->load->model('ModelOrder');
    }
    public function index()
    {
        $getAllInvoice = $this->ModelInvoice->getAllInvoice();
        foreach ($getAllInvoice as $key => $value) {
            $value->sumTotal = $this->ModelInvoice->getSumTotal($value->idInvoice);
        }
        $data = [
            'title' => '',
            'content' => 'app/invoice',
            'getAllInvoice' => $getAllInvoice
        ];
        // echo json_encode($data);
        $this->load->view('app/index', $data);
    }

    function cetakInvoice($idInvoice)
    {
        if ($idInvoice) {
            $totalBayar = $this->ModelInvoice->getSumTotal($idInvoice);
            $terbilang = ucwords($this->terbilang($totalBayar->totalBayar));
            $data = [
                'title' => 'Invoice ' . $idInvoice . ' - BungaSakti',
                'content' => 'app/cetakInvoice',
                'terbilang' => $terbilang,
                'getInvoiceItemById' => $this->ModelInvoice->getInvoiceItemById($idInvoice),
                'getInvoiceById' => $this->ModelInvoice->getInvoiceById($idInvoice),
            ];
            $this->load->view('app/index', $data);
            // echo json_encode($data);
        } else {
            redirect('invoice');
        }
    }

    function cetakSuratJalan($idInvoice)
    {
        if ($idInvoice) {
            $data = [
                'title' => 'SuratJalan Invoice-' . $idInvoice . ' - BungaSakti',
                'content' => 'app/cetakSuratJalan',
                'getInvoiceItemById' => $this->ModelInvoice->getInvoiceItemById($idInvoice),
                'getInvoiceById' => $this->ModelInvoice->getInvoiceById($idInvoice),
                'content' => 'app/cetakSuratJalan',
                'getInvoiceItemById' => $this->ModelInvoice->getInvoiceItemById($idInvoice),
                'getInvoiceById' => $this->ModelInvoice->getInvoiceById($idInvoice),
            ];
            $this->load->view('app/index', $data);
            // echo json_encode($data);
        } else {
            redirect('invoice');
        }
    }

    function viewOrder()
    {
        $idMasterOrder  = $this->input->post('idMasterOrder');
        $getListOrderById = $this->ModelOrder->getOrderListById($idMasterOrder);
        foreach ($getListOrderById as $key => $value) {
            # code...
            $value->getQtyInvoice = $this->db->get_where('det_invoice', ['idDetOrder' => $value->idDetOrder])->row();
        }
        $data = [
            'getOrderById' => $this->ModelOrder->getOrderById($idMasterOrder),
            'getListOrderById' => $getListOrderById,

        ];
        echo json_encode($data);
    }

    function editInvoice($idInvoice)
    {
        if ($idInvoice) {

            $data = [
                'title' => '',
                'content' => 'app/invoiceEdit',
                'getInvoiceById' => $this->ModelInvoice->getInvoiceById($idInvoice),
                'getInvoiceItemById' => $this->ModelInvoice->getInvoiceItemById($idInvoice),
                'total' => $this->ModelInvoice->getSumTotal($idInvoice)
            ];
            $this->load->view('app/index', $data);
            // echo json_encode($data);
        } else {
            redirect('invoice');
        }
    }

    function konfirmasiInvoice($idInvoice)
    {

        $tglInvoice = strtotime($this->input->post('createdAt'));
        $paymentDate = $this->input->post('paymentDate');
        $dueDate = date('Y-m-d', strtotime("+30 days", $tglInvoice));

        $this->db->update('master_invoice', [
            'paymentDate' => $paymentDate,
            'createdAt' => date('Y-m-d H:i:s', $tglInvoice),
            'dueDate' => $dueDate,
            'status' => 'LUNAS',
            'updatedAt' => date('Y-m-d H:i:s')
        ], ['idInvoice' => $idInvoice]);
        $this->session->set_flashdata('msg', '
        <div class="alert alert-success" role="alert">
            <strong>Konfirmasi Berhasil!</strong>
        </div>');
        redirect('invoice/editInvoice/' . $idInvoice);
    }

    function getItemById()
    {
        $idDetInvoice = $this->input->post('IdDetInvoice');
        $data = $this->db->get_where('det_invoice', ['idDetInvoice' => $idDetInvoice])->row();
        $getIdDetOrder = $this->db->get_where('det_master_order', ['idDetOrder' => $data->idDetOrder])->row();
        $qtyOrder = $getIdDetOrder->qtyOrder;
        $getSumQtyInvoice = $this->db->query("SELECT SUM(qtyInvoice) as totalInvoice FROM det_invoice WHERE idDetOrder = $data->idDetOrder")->row();
        $sisaAfterCount = ($qtyOrder - $getSumQtyInvoice->totalInvoice) + $data->qtyInvoice;
        $dataArray = [
            'datas' => $data,
            'sisaMaxOrder' => $sisaAfterCount
        ];
        echo json_encode($dataArray);
    }

    function hapusInvoice()
    {
        $idInvoice = $this->input->post('idInvoice');
        $getInvoice  = $this->db->get_where('master_invoice', ['idInvoice' => $idInvoice])->row();
        $this->db->update('master_order', ['status' => 'INVOICE'], ['idMasterOrder' => $getInvoice->idMasterOrder]);
        $this->db->delete('master_invoice', ['idInvoice' => $idInvoice]);
        $this->db->delete('det_invoice', ['idInvoice' => $idInvoice]);
        $this->session->set_flashdata('msg', '
        <div class="alert alert-success" role="alert">
            <strong>Hapus Berhasil!</strong>
        </div>');
        echo json_encode(true);
    }

    function hapusItem()
    {
        $idDetInvoice = $this->input->post('idDetInvoice');
        $this->db->delete('det_invoice', ['idDetInvoice' => $idDetInvoice]);
        $this->session->set_flashdata('msg', '
        <div class="alert alert-success" role="alert">
            <strong>Hapus Berhasil!</strong>
        </div>');
        echo json_encode(true);
    }

    function editItemInvoice()
    {
        $idDetInvoice = $this->input->post('idDetInvoice');
        $idInvoice = $this->input->post('idInvoice');
        $qtyInvoice = $this->input->post('qtyInvoiceEdit');
        $remark = $this->input->post('remark');
        $this->db->update('det_invoice', [
            'qtyInvoice' => $qtyInvoice,
            'remark' => $remark
        ], ['idDetInvoice' => $idDetInvoice]);
        $this->session->set_flashdata('msg', '
        <div class="alert alert-success" role="alert">
            <strong>Edit Berhasil!</strong>
        </div>');

        redirect('invoice/editInvoice/' . $idInvoice);
        // $data = [
        //     'idDetInvoice' => $idDetInvoice,
        //     'qtyInvoice' => $qtyInvoice,
        //     'remark' => $remark,
        //     'idInvoice' => $idInvoice
        // ];

        // echo json_encode($data);
    }

    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }

    function tes()
    {
        $angka = 1530093;
        echo ucwords($this->terbilang($angka));
    }
}

/* End of file Invoice.php */
