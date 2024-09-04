<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelLaporan extends CI_Model
{

    function omzetOrder($df, $dt)
    {
        return $this->db->query("SELECT SUM(total) as omzet FROM det_master_order 
        JOIN master_order ON master_order.idMasterOrder = det_master_order.idMasterOrder
        WHERE DATE(master_order.createdAt) BETWEEN '$df' AND '$dt'")->row();
    }
    function invoiceRelease($df, $dt)
    {
        return $this->db->query("SELECT master_invoice.createdAt, SUM(det_invoice.qtyInvoice * det_master_order.fixedPrice) as  omzet_invoice FROM `det_invoice`
            JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
            JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
            WHERE DATE(master_invoice.createdAt) BETWEEN '$df' AND '$dt'")->row();
    }

    function piutangPeriode($df, $dt)
    {
        return $this->db->query("SELECT master_invoice.createdAt, SUM(det_invoice.qtyInvoice * det_master_order.fixedPrice) as  kredit_invoice FROM `det_invoice`
            JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
            JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
            WHERE DATE(master_invoice.createdAt) BETWEEN '$df' AND '$dt' AND master_invoice.status='PENDING'")->row();
    }

    function debitPeriode($df, $dt)
    {
        return $this->db->query("SELECT master_invoice.createdAt, SUM(det_invoice.qtyInvoice * det_master_order.fixedPrice) as  debit_invoice FROM `det_invoice`
            JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
            JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
            WHERE DATE(master_invoice.paymentDate) BETWEEN '$df' AND '$dt' AND master_invoice.status='LUNAS'")->row();
    }

    function getAllOrder($df, $dt)
    {
        $this->db->select('master_order.*, customer.companyName, customer.username');
        $this->db->from('master_order');
        $this->db->join('customer', 'customer.idCustomer = master_order.idCustomer');
        $this->db->where('master_order.isActive', '1');
        $this->db->where('DATE(master_order.createdAt) >=', $df);
        $this->db->where('DATE(master_order.createdAt) <=', $dt);
        $db = $this->db->get();
        return $db->result();
    }

    function getAllInvoice($df, $dt)
    {
        $this->db->select('master_invoice.*,customer.companyName, master_order.poRefrence, customer.username');
        $this->db->from('master_invoice');
        $this->db->join('master_order', 'master_order.idMasterOrder = master_invoice.idMasterOrder');
        $this->db->join('customer', 'customer.idCustomer = master_order.idCustomer');
        $this->db->where('DATE(master_invoice.createdAt) >=', $df);
        $this->db->where('DATE(master_invoice.createdAt) <=', $dt);
        $db = $this->db->get();
        return $db->result();
    }
}

/* End of file ModelLaporan.php */
