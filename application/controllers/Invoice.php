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
    }
    public function index()
    {
        $getAllInvoice = $this->ModelInvoice->getAllInvoice();
        foreach ($getAllInvoice as $key => $value) {
            $value->sumTotal = $this->ModelInvoice->getSumTotal($value->idInvoice);
        }
        $data = [
            'content' => 'app/invoice',
            'getAllInvoice' => $getAllInvoice
        ];

        $this->load->view('app/index', $data);
    }

    function cetakInvoice($idInvoice)
    {
        if ($idInvoice) {
            $data = [
                'content' => 'app/cetakInvoice',
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
}

/* End of file Invoice.php */
