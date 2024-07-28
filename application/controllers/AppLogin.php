<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AppLogin extends CI_Controller
{

    public function index()
    {
        if ($this->auth->is_logged_in() == false) {
            $this->load->view('app/login');
        } else {
            redirect('appHome', 'refresh');
        }
    }

    function submit()
    {
        $this->load->model('ModelUser');

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->ModelUser->getUserByUsername($username);

        if ($user && password_verify($password, $user->password)) {
            $array = array(
                'sessionIdUser' => $user->idUser,
                'sessionApp' => 'TRUE',
                'sessionName' => $user->name,
                'sessionUsername' => $user->username,
                'sessionLevel' => $user->level,
                'sessionToko' => $user->idToko,
            );

            $this->ModelUser->updateLastLogin($username);
            $this->session->set_userdata($array);
            redirect('appHome');
        } else {
            $this->session->set_flashdata('msg', '
            <div class="alert alert-danger" role="alert">
                <strong>Error. Username atau Password Salah! </strong>
            </div>');
            redirect('appLogin');
        }
    }


    function logout()
    {
        session_destroy();
        redirect('appLogin', 'refresh');
    }
}


/* End of file AppLogin.php */
