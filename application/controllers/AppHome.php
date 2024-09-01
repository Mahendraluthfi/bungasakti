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
        }
        $this->load->view('app/index', $data);
        // echo json_encode($data);
    }
}

/* End of file AppHome.php */
