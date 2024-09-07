<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelDashboard extends CI_Model
{
    function getPRofMonth($month, $year)
    {
        return $this->db->query("SELECT * FROM purchase_request WHERE MONTH(createdAt) = '$month' AND YEAR(createdAt) = '$year'")->num_rows();
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

    function poComplete()
    {
        return $this->db->get_where('master_order', ['status' => 'COMPLETE'])->num_rows();
    }

    function poPending()
    {
        return $this->db->query("SELECT * FROM master_order WHERE NOT status = 'COMPLETE'")->num_rows();
    }

    function kreditCum()
    {
        return $this->db->query("SELECT master_invoice.createdAt, SUM(det_invoice.qtyInvoice * det_master_order.fixedPrice) as  kredit_invoice FROM `det_invoice`
        JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
        JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
        WHERE master_invoice.status='PENDING'")->row();
    }

    function jatuhTempo($date)
    {
        $this->db->from('master_invoice');
        $this->db->where('DATE(dueDate) <=', $date);
        $this->db->where('status', 'PENDING');
        $db = $this->db->get();
        return $db->num_rows();
    }

    function getOrderChart($year)
    {
        return $this->db->query("SELECT 
            SUM(CASE WHEN MONTH(master_order.createdAt) = 1 THEN total ELSE 0 END) AS January,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 2 THEN total ELSE 0 END) AS February,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 3 THEN total ELSE 0 END) AS March,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 4 THEN total ELSE 0 END) AS April,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 5 THEN total ELSE 0 END) AS May,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 6 THEN total ELSE 0 END) AS June,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 7 THEN total ELSE 0 END) AS July,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 8 THEN total ELSE 0 END) AS August,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 9 THEN total ELSE 0 END) AS September,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 10 THEN total ELSE 0 END) AS October,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 11 THEN total ELSE 0 END) AS November,
            SUM(CASE WHEN MONTH(master_order.createdAt) = 12 THEN total ELSE 0 END) AS December
        FROM det_master_order
        JOIN master_order ON master_order.idMasterOrder = det_master_order.idMasterOrder
        WHERE YEAR(master_order.createdAt) = '$year'")->row();
    }

    function getInvoiceChart($year)
    {
        return $this->db->query("SELECT 
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 1 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS January,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 2 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS February,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 3 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS March,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 4 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS April,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 5 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS May,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 6 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS June,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 7 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS July,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 8 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS August,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 9 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS September,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 10 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS October,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 11 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS November,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 12 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS December
        FROM det_invoice
        JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
        JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
        WHERE YEAR(master_invoice.createdAt) = '$year';")->row();
    }

    function getPiutangChart($year)
    {
        return $this->db->query("SELECT 
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 1 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS January,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 2 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS February,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 3 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS March,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 4 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS April,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 5 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS May,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 6 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS June,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 7 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS July,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 8 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS August,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 9 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS September,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 10 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS October,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 11 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS November,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 12 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS December
        FROM det_invoice
        JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
        JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
        WHERE YEAR(master_invoice.createdAt) = '$year' 
            AND master_invoice.status = 'PENDING';")->row();
    }

    function getDebitChart($year)
    {
        return $this->db->query("SELECT 
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 1 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS January,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 2 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS February,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 3 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS March,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 4 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS April,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 5 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS May,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 6 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS June,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 7 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS July,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 8 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS August,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 9 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS September,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 10 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS October,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 11 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS November,
            SUM(CASE WHEN MONTH(master_invoice.createdAt) = 12 THEN det_invoice.qtyInvoice * det_master_order.fixedPrice ELSE 0 END) AS December
        FROM det_invoice
        JOIN det_master_order ON det_master_order.idDetOrder = det_invoice.idDetOrder
        JOIN master_invoice ON master_invoice.idInvoice = det_invoice.idInvoice
        WHERE YEAR(master_invoice.createdAt) = '$year' 
            AND master_invoice.status = 'LUNAS';")->row();
    }

    function lowStock()
    {
        return $this->db->query("SELECT master_barang.description, SUM(qtyStock) as total 
        FROM toko_stock
        JOIN master_barang ON master_barang.idBarang = toko_stock.idBarang
        GROUP BY toko_stock.idBarang
        HAVING SUM(qtyStock) <= 5;")->result();
    }
}

/* End of file ModelDashboard.php */
