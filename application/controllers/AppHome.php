<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AppHome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        $this->load->model('ModelDashboard');
        $this->load->model('ModelToko');
    }

    public function index()
    {
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        $data = [
            'title' => '',
            'content' => $this->session->userdata('sessionLevel') == "ADMIN" ? 'app/dashboard' : 'app/dashboardKasir',
        ];

        if ($this->session->userdata('sessionLevel') == "ADMIN") {
            $data['PRofMonth'] = $this->ModelDashboard->getPRofMonth($month, $year);
            $data['POofMonth'] = $this->ModelDashboard->getPOofMonth($month, $year);
            $data['omzetofMonth'] = $this->ModelDashboard->omzetofMonth($month, $year);
            $data['invoiceofMonth'] = $this->ModelDashboard->invoiceofMonth($month, $year);
            $data['kreditofMonth'] = $this->ModelDashboard->kreditofMonth($month, $year);
            $data['kreditCum'] = $this->ModelDashboard->kreditCum();
            $data['debitofMonth'] = $this->ModelDashboard->debitofMonth($month, $year);
            $data['poComplete'] = $this->ModelDashboard->poComplete();
            $data['poPending'] = $this->ModelDashboard->poPending();
            $data['jatuhTempo'] = $this->ModelDashboard->jatuhTempo($today);
            $data['chartOrder'] = $this->ModelDashboard->getOrderChart($year);
            $data['chartInvoice'] = $this->ModelDashboard->getInvoiceChart($year);
            $data['chartPiutang'] = $this->ModelDashboard->getPiutangChart($year);
            $data['chartDebit'] = $this->ModelDashboard->getDebitChart($year);
            $data['lowStock'] = $this->ModelDashboard->lowStock();
            $data['omzetTokoToday'] = $this->ModelDashboard->omzetToko($today);
            $data['omzetTokoMonth'] = $this->ModelDashboard->omzetToko('', '', $month);
            $data['transaksiTokoToday'] = $this->ModelDashboard->transaksiToko($today);
            $data['transaksiTokoMonth'] = $this->ModelDashboard->transaksiToko('', '', $month);
        } else {
            $data['toko'] = $this->ModelToko->getTokoById($this->session->userdata('sessionToko'));
            $data['omzetTokoToday'] = $this->ModelDashboard->omzetToko($today, $this->session->userdata('sessionToko'));
            $data['omzetTokoMonth'] = $this->ModelDashboard->omzetToko('', $this->session->userdata('sessionToko'), $month);
            $data['transaksiTokoToday'] = $this->ModelDashboard->transaksiToko($today, $this->session->userdata('sessionToko'));
            $data['transaksiTokoMonth'] = $this->ModelDashboard->transaksiToko('', $this->session->userdata('sessionToko'), $month);
        }
        $this->load->view('app/index', $data);
        // echo json_encode($data);
    }

    function getTempo()
    {
        $this->load->model('ModelInvoice');
        $today = date('Y-m-d');
        $data = $this->ModelDashboard->getTempo($today);
        foreach ($data as $key => $value) {
            $value->sumTotal = $this->ModelInvoice->getSumTotal($value->idInvoice);
        }
        echo json_encode($data);
    }
}

/* End of file AppHome.php */
