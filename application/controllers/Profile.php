<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in_customer() == false) {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $idCustomer = $this->session->userdata('sessionIdCustomer');
        $data = array(
            'get' => $this->db->get_where('customer', ['idCustomer' => $idCustomer])->row(),
            'content' => 'client/profile',
        );
        $this->load->view('client/index', $data);
        // echo json_encode($data);
    }

    function update()
    {
        $idCustomer = $this->input->post('idCustomer');
        $companyName = $this->input->post('companyName');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $contactNumber = $this->input->post('contactNumber');
        $address = $this->input->post('address');
        $this->db->update('customer', [
            'companyName' => $companyName,
            'username' => $username,
            'email' => $email,
            'contactNumber' => $contactNumber,
            'address' => $address,
            'updatedAt' => date('Y-m-d H:i:s')
        ], ['idCustomer' => $idCustomer]);
        $this->session->set_flashdata('msg', '
        <div class="alert alert-success" role="alert">
            <strong>Update Berhasil !</strong>
        </div>');
        redirect('profile');
    }

    function changePassword()
    {
        $this->load->model('ModelCustomer');

        $idCustomer = $this->input->post('idCustomer');
        $currentPassword = $this->input->post('currentPassword');
        $newPassword = $this->input->post('newPassword');
        $confirmPassword = $this->input->post('confirmPassword');
        $getCustomer = $this->ModelCustomer->getCustomerById($idCustomer);
        if ($getCustomer && password_verify($currentPassword, $getCustomer->password)) {
            if ($newPassword == $confirmPassword) {
                $password = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->db->update('customer', ['password' => $password], ['idCustomer' => $idCustomer]);
                $this->session->set_flashdata('msg', '
                <div class="alert alert-success" role="alert">
                    <strong>Change password successfull !</strong>
                </div>');
            } else {
                $this->session->set_flashdata('msg', '
                <div class="alert alert-danger" role="alert">
                    <strong>New password and confirm password must be the same!</strong>
                </div>');
            }
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Current password is wrong !</strong>
            </div>');
        }

        redirect('profile');
    }
}

/* End of file Profile.php */
