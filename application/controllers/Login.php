<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelCustomer');
        $this->load->library('Uuid');
    }

    public function index()
    {
        if ($this->auth->is_logged_in() == false) {
            $this->load->view('client/login');
        } else {
            redirect('ClientHome', 'refresh');
        }
    }

    function submit()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $customer = $this->ModelCustomer->getUserByEmail($email);

        if ($customer && password_verify($password, $customer->password)) {
            $array = array(
                'sessionIdCustomer' => $customer->idCustomer,
                'sessionLoged' => 'TRUE',
                'sessionUsernameCustomer' => $customer->username,
            );

            $this->session->set_userdata($array);
            redirect('clientHome');
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert text-center alert-danger" role="alert">
                <strong>Error. Email atau Password Salah! </strong>
            </div>');
            redirect('login');
        }
    }

    function register()
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

        $isEmailExist = $this->ModelCustomer->getUserByEmail($email);
        if ($isEmailExist) {
            $this->session->set_flashdata('msg', '
            <div class="alert text-center alert-danger" role="alert">
                <strong>Error. Email sudah terdaftar !</strong>
            </div>');
        } else {
            $insertRow = $this->ModelCustomer->insertCustomer($data);
            if ($insertRow) {
                $this->session->set_flashdata('msg', '
                <div class="alert text-center alert-success" role="alert">
                    <strong>Register Berhasil!</strong>
                </div>');
            } else {
                $this->session->set_flashdata('msg', '
                <div class="alert text-center alert-danger" role="alert">
                    <strong>Error. Register Gagal!</strong>
                </div>');
            }
        }
        redirect('login');
        // echo json_encode($data);

    }

    function logout()
    {
        session_destroy();
        redirect('login');
    }

    function forgotPassword()
    {
        $this->session->set_flashdata('msg', '
                <div class="alert text-center alert-danger" role="alert">
                    <strong>Hubungi pihak Bunga Sakti untuk reset password !</strong>
                </div>');
        redirect('login');
    }
}

/* End of file Login.php */
