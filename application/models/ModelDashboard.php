<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelDashboard extends CI_Model
{
    function getPRofMonth($month, $year)
    {
        return $this->db->query("SELECT * FROM purchase_request WHERE MONTH(datePR) = '$month' AND YEAR(datePR) = '$year'")->num_rows();
    }

    function getPOofMonth($month, $year)
    {
        return $this->db->query("SELECT * FROM master_order WHERE MONTH(createdAt) = '$month' AND YEAR(createdAt) = '$year'")->num_rows();
    }

    function omzetofMonth($month, $year)
    {
        return $this->db->query("SELECT SUM(total) as omzet FROM det_master_order 
            JOIN master_order ON master_order.idMasterOrder = det_master_order.idMasterOrder
            WHERE MONTH(master_order.createdAt) = '$month' AND YEAR(master_order.createdAt) = '$year'")->row();
    }

    function invoiceofMonth($month, $year)
    {
        return $this->db->query("SELECT master_invoice.createdAt, SUM(det_invoice.qtyInvoice * det_master_order.fixedPrice) as  omzet_invoice FROM `det_invoice`
            JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
            JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
            WHERE MONTH(master_invoice.createdAt) = '$month' AND YEAR(master_invoice.createdAt) = '$year'")->row();
    }
    function kreditofMonth($month, $year)
    {
        return $this->db->query("SELECT master_invoice.createdAt, SUM(det_invoice.qtyInvoice * det_master_order.fixedPrice) as  kredit_invoice FROM `det_invoice`
            JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
            JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
            WHERE MONTH(master_invoice.createdAt) = '$month' AND YEAR(master_invoice.createdAt) = '$year' AND master_invoice.status='PENDING'")->row();
    }
    function debitofMonth($month, $year)
    {
        return $this->db->query("SELECT master_invoice.createdAt, SUM(det_invoice.qtyInvoice * det_master_order.fixedPrice) as  debit_invoice FROM `det_invoice`
            JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
            JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
            WHERE MONTH(master_invoice.paymentDate) = '$month' AND YEAR(master_invoice.paymentDate) = '$year' AND master_invoice.status='LUNAS'")->row();
    }
}

/* End of file ModelDashboard.php */
