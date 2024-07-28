<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->auth->is_logged_in() == false) {
            redirect('appLogin', 'refresh');
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Uuid');
        $this->load->model('ModelUser');
    }

    public function index()
    {
        $id = substr($this->uuid->v4(), 0, 18);

        $data = array(
            'content' => 'app/user',
            'getAllUsers' => $this->ModelUser->getAllUser(),
        );
        $this->load->view('app/index', $data);
    }

    function saveUser()
    {
        $idUser = substr($this->uuid->v4(), 0, 8);
        $username = str_replace(' ', '', $this->input->post('username'));
        $name = $this->input->post('name');
        $level = $this->input->post('level');
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

        $checkUsernameExists = $this->ModelUser->checkExistUsername($username);
        if ($checkUsernameExists) {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Error. Username sudah tersedia! </strong>
            </div>');
            echo json_encode(true);
        } else {
            $data = array(
                'idUser' => $idUser,
                'name' => $name,
                'level' => $level,
                'password' => $password,
                'username' => $username,
                'createdAt' => date('Y-m-d H:i:s'),
            );

            $insertRow = $this->ModelUser->insertUser($data);
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Simpan Berhasil !</strong>
            </div>');
            echo ($insertRow) ? json_encode(true) : json_encode(false);
        }
    }

    function getUserById()
    {
        $idUser = $this->input->post('idUser');
        $data = $this->ModelUser->getUserById($idUser);
        echo json_encode($data);
    }

    function editUser()
    {
        $idUser = $this->input->post('idUser');
        $username = str_replace(' ', '', $this->input->post('username'));
        $name = $this->input->post('name');
        $level = $this->input->post('level');

        $data = array(
            'name' => $name,
            'level' => $level,
            'username' => $username,
            'updatedAt' => date('Y-m-d H:i:s'),
        );

        $checkSameUsername = $this->ModelUser->getUserById($idUser);
        if ($checkSameUsername->username == $username) {
            $insertRow = $this->ModelUser->updateUser($data, $idUser);
            $this->session->set_flashdata('msg', '
            <div class="alert alert-success" role="alert">
                <strong>Update Berhasil !</strong>
            </div>');
            echo ($insertRow) ? json_encode(true) : json_encode(false);
        } else {
            $checkUsernameExists = $this->ModelUser->checkExistUsername($username);
            if ($checkUsernameExists) {
                $this->session->set_flashdata('msg', '
                <div class="alert alert-danger" role="alert">
                    <strong>Error. Username sudah tersedia! </strong>
                </div>');
                echo json_encode(true);
            } else {
                $insertRow = $this->ModelUser->updateUser($data, $idUser);
                $this->session->set_flashdata('msg', '
                <div class="alert alert-success" role="alert">
                    <strong>Update Berhasil !</strong>
                </div>');
                echo ($insertRow) ? json_encode(true) : json_encode(false);
            }
        }
    }

    function deleteUser()
    {
        $idUser = $this->input->post('idUser');
        $deleteRow = $this->ModelUser->deleteUser($idUser);
        $this->session->set_flashdata('msg', '
        <div class="alert alert-success" role="alert">
            <strong>Hapus Berhasil!</strong>
        </div>');
        echo ($deleteRow) ? json_encode(true) : json_encode(false);
    }
}

/* End of file User.php */
