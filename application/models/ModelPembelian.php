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

    function getPending()
    {
        $this->db->select('master_pembelian.*, master_toko.namaToko, user.name');
        $this->db->from('master_pembelian');
        $this->db->join('master_toko', 'master_toko.idToko = master_pembelian.idToko', 'left');
        $this->db->join('user', 'user.idUser = master_pembelian.idUser', 'left');
        $this->db->where('master_pembelian.status', 'PENDING');
        return $this->db->get()->row();
    }

    function getPembelianById($idPembelian)
    {
        $this->db->select('master_pembelian.*, master_toko.namaToko, user.name');
        $this->db->from('master_pembelian');
        $this->db->join('master_toko', 'master_toko.idToko = master_pembelian.idToko');
        $this->db->join('user', 'user.idUser = master_pembelian.idUser');
        $this->db->where('master_pembelian.idPembelian', $idPembelian);
        return $this->db->get()->row();
    }

    function getItemPembelian($idPembelian)
    {
        $this->db->select('det_master_pembelian.*, master_barang.description');
        $this->db->from('det_master_pembelian');
        $this->db->join('toko_stock', 'toko_stock.idStock = det_master_pembelian.idStock');
        $this->db->join('master_barang', 'toko_stock.idBarang = master_barang.idBarang');
        $this->db->where('det_master_pembelian.idPembelian', $idPembelian);
        return $this->db->get()->result();
    }
}

/* End of file ModelPembelian.php */
