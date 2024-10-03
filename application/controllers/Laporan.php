<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('ModelLaporan');
    }

    public function index() {}

    function vendor()
    {
        $data = [
            'title' => '',
            'content' => 'app/vendorPage',
        ];

        $this->load->view('app/index', $data);
    }

    function vendorSubmit()
    {
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');

        echo json_encode([
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    function vendorResult($df, $dt)
    {
        $this->load->model('ModelInvoice');
        $getAllOrder = $this->ModelLaporan->getAllOrder($df, $dt);
        foreach ($getAllOrder as $key => $value) {
            $value->totalOrder = $this->db->query("SELECT SUM(total) as totalOrder FROM det_master_order WHERE idMasterOrder = '$value->idMasterOrder'")->row();
        }
        $getAllInvoice = $this->ModelLaporan->getAllInvoice($df, $dt);
        foreach ($getAllInvoice as $key => $value) {
            $value->sumTotal = $this->ModelInvoice->getSumTotal($value->idInvoice);
        }
        $data = [
            'omzetOrder' => $this->ModelLaporan->omzetOrder($df, $dt),
            'invoiceRelease' => $this->ModelLaporan->invoiceRelease($df, $dt),
            'piutangPeriode' => $this->ModelLaporan->piutangPeriode($df, $dt),
            'debitPeriode' => $this->ModelLaporan->debitPeriode($df, $dt),
            'getAllOrder' => $getAllOrder,
            'getAllInvoice' => $getAllInvoice,
            'dateFrom' => $df,
            'dateTo' => $dt,
        ];
        $this->load->view('app/vendorResult', $data);
    }

    function toko()
    {
        $idToko = $this->session->userdata('sessionToko');

        if ($this->session->userdata('sessionLevel') == "ADMIN") {
            $getToko = $this->db->get_where('master_toko', ['isActive' => 1])->result();
        } else {
            $getToko = $this->db->get_where('master_toko', ['idToko' => $idToko])->result();
        }
        $data = [
            'title' => '',
            'content' => 'app/tokoPage',
            'getToko' => $getToko,
        ];

        $this->load->view('app/index', $data);
    }

    function tokoSubmit()
    {
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');
        $idToko = $this->input->post('idToko');

        echo json_encode([
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'idToko' => $idToko,
        ]);
    }

    function tokoResult($df, $dt, $idToko)
    {
        $getToko = $this->db->get_where('master_toko', ['idToko' => $idToko])->row();

        $data = [
            'dateFrom' => $df,
            'dateTo' => $dt,
            'namaToko' => $getToko->namaToko,
            'getTotalPenjualan' => $this->ModelLaporan->getTotalPenjualan($df, $dt, $idToko),
            'getTotalItems' => $this->ModelLaporan->getTotalItems($df, $dt, $idToko),
            'getTotalTransaksi' => $this->ModelLaporan->getTotalTransaksi($df, $dt, $idToko),
            'topFive' => $this->ModelLaporan->topFive($df, $dt, $idToko),
        ];
        $this->load->view('app/tokoResult', $data);
    }
}

/* End of file Laporan.php */
