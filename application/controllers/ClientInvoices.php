<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientInvoices extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in_customer() == false) {
            redirect('login', 'refresh');
        }

        $this->load->model('ModelInvoice');
    }
    public function index()
    {

        $idCustomer = $this->session->userdata('sessionIdCustomer');
        $get = $this->ModelInvoice->clientInvoices($idCustomer);
        foreach ($get as $key => $value) {
            $value->sumTotal = $this->ModelInvoice->getSumTotal($value->idInvoice);
        }
        $data = array(
            'content' => 'client/invoices',
            'get' => $get
        );
        $this->load->view('client/index', $data);
        // echo json_encode($data);
    }

    function cetakInvoice($idInvoice)
    {
        if ($idInvoice) {
            $totalBayar = $this->ModelInvoice->getSumTotal($idInvoice);
            $terbilang = ucwords($this->terbilang($totalBayar->totalBayar));
            $data = [
                'title' => 'Invoice ' . $idInvoice . ' - BungaSakti',
                'content' => 'client/cetakInvoice',
                'terbilang' => $terbilang,
                'getInvoiceItemById' => $this->ModelInvoice->getInvoiceItemById($idInvoice),
                'getInvoiceById' => $this->ModelInvoice->getInvoiceById($idInvoice),
            ];
            $this->load->view('client/index', $data);
            // echo json_encode($data);
        } else {
            redirect('invoice');
        }
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

    function getInvoiceItemById($idInvoice)
    {
        $data = $this->ModelInvoice->getInvoiceItemById($idInvoice);
        echo json_encode($data);
    }
}

/* End of file ClientInvoices.php */
