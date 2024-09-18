<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ErrorPage extends CI_Controller
{

    public function index()
    {
        $this->load->view('404_error');
    }
}

/* End of file Error.php */
