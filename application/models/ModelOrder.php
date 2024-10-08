<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelOrder extends CI_Model
{

    function getAllOrder()
    {
        $this->db->select('master_order.*, customer.companyName, customer.username');
        $this->db->from('master_order');
        $this->db->join('customer', 'customer.idCustomer = master_order.idCustomer');
        $this->db->where('master_order.isActive', '1');
        $this->db->order_by('master_order.createdAt', 'desc');
        $db = $this->db->get();
        return $db->result();
    }
    function insertOrderbyPR($object)
    {
        $this->db->insert('master_order', $object);
        return $this->db->affected_rows() > 0;
    }

    function getOrderById($idMasterOrder)
    {
        $this->db->select('master_order.*, customer.companyName, customer.email, customer.contactNumber, customer.address, customer.username, user.name');
        $this->db->from('master_order');
        $this->db->join('customer', 'customer.idCustomer = master_order.idCustomer');
        $this->db->join('user', 'master_order.idUser = user.idUser', 'left');
        $this->db->where('idMasterOrder', $idMasterOrder);
        $db = $this->db->get();
        return $db->row();
    }

    function getOrderListById($idMasterOrder)
    {
        $this->db->select('det_master_order.*, master_barang.description, master_barang.mcRefrence, master_barang.type, master_barang.uom');
        $this->db->from('det_master_order');
        $this->db->join('master_barang', 'master_barang.idBarang = det_master_order.idBarang');
        $this->db->where('det_master_order.idMasterOrder', $idMasterOrder);
        $db = $this->db->get();
        return $db->result();
    }

    function checkBarangNotInMaster($idPR)
    {
        $this->db->select('*');
        $this->db->from('det_purchase_request');
        $this->db->where('idPR', $idPR);
        $this->db->where('idBarang', null);
        $db = $this->db->get();
        return $db->result();
    }

    function insertDetMasterOrder($object)
    {
        $this->db->insert('det_master_order', $object);
        return $this->db->affected_rows() > 0;
    }

    function getDetOrderById($idDetOrder)
    {
        $this->db->select('det_master_order.*, master_barang.description');
        $this->db->from('det_master_order');
        $this->db->join('master_barang', 'master_barang.idBarang = det_master_order.idBarang');
        $this->db->where('det_master_order.idDetOrder', $idDetOrder);
        $db = $this->db->get();
        return $db->row();
    }

    function getStockIssuedByDetOrder($idDetOrder)
    {
        $db = $this->db->query("SELECT stock_issued.*, master_toko.namaToko FROM `stock_issued`
            JOIN toko_stock ON toko_stock.idStock = stock_issued.idStock
            JOIN master_toko ON master_toko.idToko = toko_stock.idToko
            WHERE stock_issued.idDetOrder = '$idDetOrder'");
        return $db->result();
    }

    function getSumStockIssued($idDetOrder)
    {
        $this->db->select('SUM(qtyIssued) AS sumStockIssued');
        $this->db->from('stock_issued');
        $this->db->where('idDetOrder', $idDetOrder);
        $db = $this->db->get();
        return $db->row()->sumStockIssued;
    }

    function insertNewOrder($object)
    {
        $this->db->insert('master_order', $object);
        return $this->db->affected_rows() > 0;
    }

    function isOrderComplete($idMasterOrder)
    {
        return $this->db->query("SELECT SUM(qtyInvoice) as totalInvoice FROM `det_invoice`
            JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
            WHERE det_invoice.idDetOrder IN(SELECT idDetOrder FROM det_master_order WHERE idMasterOrder = '$idMasterOrder')
            AND det_master_order.idMasterOrder = '$idMasterOrder'")->row();
    }

    function countQtyOrder($idMasterOrder)
    {
        return $this->db->query("SELECT SUM(qtyOrder) as totalOrder FROM `det_master_order` WHERE idMasterOrder='$idMasterOrder'")->row();
    }
}

/* End of file ModelOrder.php */
