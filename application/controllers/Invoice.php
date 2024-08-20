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
}

/* End of file Invoice.php */
