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
        $data = [
            'title' => '',
            'content' => 'app/tokoPage',
        ];

        $this->load->view('app/index', $data);
    }
}

/* End of file Laporan.php */
