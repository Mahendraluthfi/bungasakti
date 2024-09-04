<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('ModelPembelian');
        $this->load->library('Uuid');
    }


    public function index()
    {
        $data = [
            'title' => '',
            'content' => 'app/pembelian'
        ];

        $this->load->view('app/index', $data);
    }

    function editForm($idPembelian = '')
    {
        $data = [
            'title' => '',
            'content' => 'app/pembelianEdit',
        ];
        if ($idPembelian) {
            $isPending = $this->ModelPembelian->isPending();
            if (!$isPending) {
                $array = array(
                    'idPembelian' => substr($this->uuid->v4(), 0, 8),
                    'createdAt' => date('Y-m-d H:i:s'),
                    'status' => 'PENDING',
                );
                $this->ModelPembelian->insertNewPembelian($array);
            }

            $getPending = $this->ModelPembelian->getPending();
            $getItemPending = $this->ModelPembelian->getItemPembelian($getPending->idPembelian);
        } else {
            $getPending = $this->ModelPembelian->getPembelianById($idPembelian);
            $getItemPending = $this->ModelPembelian->getItemPembelian($idPembelian);
        }
        $data['getPending'] = $getPending;
        $data['getItem'] = $getItemPending;

        $this->load->view('app/index', $data);
    }
}

/* End of file Pembelian.php */
