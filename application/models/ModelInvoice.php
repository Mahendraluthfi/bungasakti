<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelInvoice extends CI_Model
{

    function insertNewInvoice($object)
    {
        $this->db->insert('master_invoice', $object);
        return $this->db->affected_rows();
    }
}

/* End of file ModelInvoice.php */
