<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelPembelian extends CI_Model
{

    function isPending()
    {
        $this->db->get_where('master_pembelian', ['status' => 'PENDING']);
        return $this->db->affected_rows() > 0;
    }

    function insertNewPembelian($object)
    {
        $this->db->insert('master_pembelian', $object);
        return $this->db->affected_rows() > 0;
    }
}

/* End of file ModelPembelian.php */
