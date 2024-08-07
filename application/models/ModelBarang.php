<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelBarang extends CI_Model
{
    function getAllBarang()
    {
        return $this->db->get_where('master_barang', ['isActive' => '1'])->result();
    }

    function getAllBarangReady()
    {
        return $this->db->get_where('master_barang', ['isActive' => '1', 'type' => 'READY'])->result();
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

    function getKartuStock($idBarang)
    {
        $this->db->select('toko_stock.*, master_barang.description, master_toko.namaToko');
        $this->db->from('toko_stock');
        $this->db->join('master_barang', 'toko_stock.idBarang = master_barang.idBarang');
        $this->db->join('master_toko', 'toko_stock.idToko = master_toko.idToko');
        $this->db->where('toko_stock.idBarang', $idBarang);
        $db = $this->db->get();
        return $db->result();
    }
}

/* End of file ModelBarang.php */
