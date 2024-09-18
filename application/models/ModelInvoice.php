<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelInvoice extends CI_Model
{

    function insertNewInvoice($object)
    {
        $this->db->insert('master_invoice', $object);
        return $this->db->affected_rows();
    }

    function getAllInvoice()
    {
        $this->db->select('master_invoice.*,customer.companyName, customer.username, master_order.poRefrence');
        $this->db->from('master_invoice');
        $this->db->join('master_order', 'master_order.idMasterOrder = master_invoice.idMasterOrder');
        $this->db->join('customer', 'customer.idCustomer = master_order.idCustomer');
        $this->db->order_by('master_invoice.createdAt', 'desc');

        $db = $this->db->get();
        return $db->result();
    }

    function getInvoiceById($idInvoice)
    {
        $this->db->select('master_invoice.*, master_order.poRefrence, customer.companyName, customer.email, customer.contactNumber, customer.address, customer.username');
        $this->db->from('master_invoice');
        $this->db->join('master_order', 'master_order.idMasterOrder = master_invoice.idMasterOrder');
        $this->db->join('customer', 'customer.idCustomer = master_order.idCustomer');
        $this->db->where('master_invoice.idInvoice', $idInvoice);
        $db = $this->db->get();
        return $db->row();
    }

    function getInvoiceItemById($idInvoice)
    {
        $this->db->select('master_barang.description, master_barang.uom, master_barang.type, master_barang.mcRefrence, det_invoice.*, det_master_order.qtyOrder, det_master_order.fixedPrice');
        $this->db->from('det_invoice');
        $this->db->join('det_master_order', 'det_master_order.idDetOrder = det_invoice.idDetOrder');
        $this->db->join('master_barang', 'master_barang.idBarang = det_master_order.idBarang');
        $this->db->where('det_invoice.idInvoice', $idInvoice);
        $db = $this->db->get();
        return $db->result();
    }

    function getSumTotal($idInvoice)
    {
        $this->db->select('SUM(det_invoice.qtyInvoice * det_master_order.fixedPrice) totalBayar');
        $this->db->from('det_invoice');
        $this->db->join('det_master_order', 'det_master_order.idDetOrder = det_invoice.idDetOrder');
        $this->db->where('det_invoice.idInvoice', $idInvoice);
        $db = $this->db->get();
        return $db->row();
    }

    function clientInvoices($idCustomer)
    {
        return $this->db->query("SELECT master_invoice.*, master_order.idPR FROM `master_invoice`
        JOIN master_order ON master_order.idMasterOrder = master_invoice.idMasterOrder
        JOIN customer ON master_order.idCustomer = customer.idCustomer
        WHERE master_order.idCustomer = '$idCustomer'")->result();
    }
}

/* End of file ModelInvoice.php */
