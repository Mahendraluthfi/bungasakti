<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelBarang extends CI_Model
{
    function getAllBarang()
    {
        return $this->db->get_where('master_barang', ['isActive' => '1'])->result();
    }

    function insertBarang($object)
    {
        $this->db->insert('master_barang', $object);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getBarangById($id)
    {
        return $this->db->get_where('master_barang', ['idBarang' => $id])->row();
    }

    function updateBarang($object, $idBarang)
    {
        $this->db->where('idBarang', $idBarang);
        $this->db->update('master_barang', $object);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function deleteBarang($idBarang)
    {
        $this->db->where('idBarang', $idBarang);
        $this->db->update('master_barang', ['isActive' => '0']);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file ModelBarang.php */
