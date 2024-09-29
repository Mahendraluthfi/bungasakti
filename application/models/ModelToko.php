<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelToko extends CI_Model
{
    function getAllToko()
    {
        return $this->db->get_where('master_toko', ['isActive' => '1'])->result();
    }

    function insertToko($object)
    {
        $this->db->insert('master_toko', $object);
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if data was inserted successfully
        } else {
            return false; // Return false if data was not inserted
        }
    }

    function getTokoById($idToko)
    {
        return $this->db->get_where('master_toko', ['idToko' => $idToko])->row();
    }

    function updateToko($data, $idToko)
    {
        $this->db->update('master_toko', $data, ['idToko' => $idToko]);
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if data was updated successfully
        } else {
            return false; // Return false if data was not updated
        }
    }

    function deleteToko($id)
    {
        $this->db->where('idToko', $id);
        $this->db->update('master_toko', ['isActive' => '0']);

        if ($this->db->affected_rows() > 0) {
            return true; // Return true if data was deleted successfully
        } else {
            return false; // Return false if data was not deleted
        }
    }

    function getStockByToko($idToko)
    {
        $this->db->select('toko_stock.*, master_barang.description, master_barang.uom, master_barang.type');
        $this->db->from('toko_stock');
        $this->db->join('master_barang', 'toko_stock.idBarang = master_barang.idBarang');
        $this->db->where('idToko', $idToko);
        $db = $this->db->get();
        return $db->result();
    }

    function stockExist($idToko, $idBarang)
    {
        $data = $this->db->get_where('toko_stock', ['idToko' => $idToko, 'idBarang' => $idBarang]);
        return ($data->num_rows() > 0) ? true : false; // Return true if stock exists, otherwise return false
    }

    function updateStock($idToko, $idBarang, $qtyStock)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->where('idToko', $idToko);
        $this->db->where('idBarang', $idBarang);
        $this->db->set('qtyStock', 'qtyStock +' . $qtyStock, FALSE);
        $this->db->set('updatedAt', date('Y-m-d H:i:s'));
        $this->db->update('toko_stock');
        return $this->db->affected_rows() > 0; // Return true if stock was updated successfully, otherwise return false
    }

    function addStock($object)
    {
        $this->db->insert('toko_stock', $object);
        return $this->db->affected_rows() > 0; // Return true if stock was inserted successfully, otherwise return false
    }

    function getStockByIdBarang($idBarang)
    {
        $this->db->select('toko_stock.*, master_toko.namaToko');
        $this->db->from('toko_stock');
        $this->db->join('master_toko', 'master_toko.idToko = toko_stock.idToko');
        $this->db->where('toko_stock.idBarang', $idBarang);
        return $this->db->get()->result();
    }

    function getIdStock($idStock)
    {
        $this->db->select('toko_stock.*, master_barang.description');
        $this->db->from('toko_stock');
        $this->db->join('master_barang', 'master_barang.idBarang = toko_stock.idBarang');
        $this->db->where('toko_stock.idStock', $idStock);
        return $this->db->get()->row();
    }

    function reduceQty($idStock, $qty)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->where('idStock', $idStock);
        $this->db->set('qtyStock', 'qtyStock -' . $qty, FALSE);
        $this->db->set('updatedAt', date('Y-m-d H:i:s'));
        $this->db->update('toko_stock');
        return $this->db->affected_rows() > 0; // Return true if stock was updated successfully, otherwise return false        
    }

    function getHistoryPembelian($idToko)
    {
        $this->db->select('master_pembelian.*, master_toko.namaToko, user.name');
        $this->db->from('master_pembelian');
        $this->db->join('master_toko', 'master_toko.idToko = master_pembelian.idToko');
        $this->db->join('user', 'user.idUser = master_pembelian.idUser');
        $this->db->where('master_pembelian.status', 'SUBMIT');
        $this->db->where('master_pembelian.idToko', $idToko);
        return $this->db->get()->result();
    }
}

/* End of file ModelToko.php */
