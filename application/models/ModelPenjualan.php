<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelPenjualan extends CI_Model
{
    function getDetailTransaksi($idPenjualan)
    {
        $this->db->select('det_master_penjualan.*, master_barang.description');
        $this->db->from('det_master_penjualan');
        $this->db->join('master_penjualan', 'master_penjualan.idPenjualan = det_master_penjualan.idPenjualan');
        $this->db->join('toko_stock', 'det_master_penjualan.idStock = toko_stock.idStock');
        $this->db->join('master_barang', 'master_barang.idBarang = toko_stock.idBarang');
        $this->db->where('det_master_penjualan.idPenjualan', $idPenjualan);
        return $this->db->get()->result();
    }

    function findBarcode($idToko, $barcode)
    {
        $this->db->from('toko_stock');
        $this->db->join('master_barang', 'master_barang.idBarang = toko_stock.idBarang');
        $this->db->where('toko_stock.idToko', $idToko);
        $this->db->where('master_barang.barcode', $barcode);
        return $this->db->get();
    }

    function getTotalBayar($idPenjualan)
    {
        return $this->db->query("SELECT SUM(total) as totalBayar FROM det_master_penjualan WHERE idPenjualan='$idPenjualan'")->row();
    }

    function getTotalItems($idPenjualan)
    {
        return $this->db->query("SELECT SUM(qty) as totalQty FROM det_master_penjualan WHERE idPenjualan='$idPenjualan'")->row();
    }

    function getBarangReady($idToko)
    {
        $this->db->select('toko_stock.*, master_barang.description, master_barang.basePrice');
        $this->db->from('toko_stock');
        $this->db->join('master_barang', 'toko_stock.idBarang = master_barang.idBarang');
        $this->db->where('toko_stock.idToko', $idToko);
        $this->db->where('toko_stock.qtyStock > 0');
        return $this->db->get()->result();
    }
}

/* End of file ModelPenjualan.php */
