<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Uuid');
        $this->load->model('ModelCustomer');
    }

    public function index()
    {
        $data = array(
            'title' => '',
            'content' => 'app/customer',
            'getAllCustomer' => $this->ModelCustomer->getAllCustomer(),
        );
        $this->load->view('app/index', $data);
    }

    public function addCustomer()
    {
        $idCustomer = substr($this->uuid->v4(), 0, 8);
        $companyName = $this->input->post('companyName');
        $username = $this->input->post('username');
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $contactNumber = $this->input->post('contactNumber');
        $address = $this->input->post('address');
        $email = $this->input->post('email');
        $data = array(
            'idCustomer' => $idCustomer,
            'companyName' => $companyName,
            'username' => $username,
            'password' => $password,
            'contactNumber' => $contactNumber,
            'address' => $address,
            'email' => $email,
            'createdAt' => date('Y-m-d H:i:s'),
        );

        $insertRow = $this->ModelCustomer->insertCustomer($data);
        if ($insertRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Tambah Data Berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Error. Tambah Data Gagal!</strong>
            </div>');
            echo json_encode(false);
        }
        // echo json_encode($data);
    }

    function getCustomerById()
    {
        $idCustomer = $this->input->post('idCustomer');
        $customer = $this->ModelCustomer->getCustomerById($idCustomer);
        echo json_encode($customer);
    }

    function updateCustomer()
    {
        $idCustomer = $this->input->post('idCustomer');
        $companyName = $this->input->post('companyName');
        $username = $this->input->post('username');
        $contactNumber = $this->input->post('contactNumber');
        $address = $this->input->post('address');
        $email = $this->input->post('email');

        $data = array(
            'companyName' => $companyName,
            'username' => $username,
            'contactNumber' => $contactNumber,
            'address' => $address,
            'email' => $email,
            'updatedAt' => date('Y-m-d H:i:s'),
        );

        $updateRow = $this->ModelCustomer->updateCustomer($data, $idCustomer);
        if ($updateRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Update Data Berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Error. Update Data Gagal!</strong>
            </div>');
            echo json_encode(false);
        }
    }

    function deleteCustomer()
    {
        $idCustomer = $this->input->post('idCustomer');
        $deleteRow = $this->ModelCustomer->deleteCustomer($idCustomer);
        if ($deleteRow) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Hapus Data Berhasil!</strong>
            </div>');
            echo json_encode(true);
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Error. Hapus Data Gagal!</strong>
            </div>');
            echo json_encode(false);
        }
    }
}

/* End of file Customer.php */
