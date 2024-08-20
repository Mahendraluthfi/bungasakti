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
        $this->db->select('master_invoice.*,customer.companyName');
        $this->db->from('master_invoice');
        $this->db->join('master_order', 'master_order.idMasterOrder = master_invoice.idMasterOrder');
        $this->db->join('customer', 'customer.idCustomer = master_order.idCustomer');
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
}

/* End of file ModelInvoice.php */
