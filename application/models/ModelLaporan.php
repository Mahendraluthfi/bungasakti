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

    function getTotalPenjualan($df, $dt, $idToko)
    {
        $this->db->select('SUM(det_master_penjualan.total) as totalPenjualan');
        $this->db->from('det_master_penjualan');
        $this->db->join('master_penjualan', 'master_penjualan.idPenjualan = det_master_penjualan.idPenjualan');
        $this->db->where('DATE(createdAt) >=', $df);
        $this->db->where('DATE(createdAt) <=', $dt);
        $this->db->where('idToko', $idToko);
        $this->db->where('master_penjualan.status', 1);
        return $this->db->get()->row();
    }

    function getTotalItems($df, $dt, $idToko)
    {
        $this->db->select('SUM(det_master_penjualan.qty) as totalItems');
        $this->db->from('det_master_penjualan');
        $this->db->join('master_penjualan', 'master_penjualan.idPenjualan = det_master_penjualan.idPenjualan');
        $this->db->where('DATE(createdAt) >=', $df);
        $this->db->where('DATE(createdAt) <=', $dt);
        $this->db->where('idToko', $idToko);
        $this->db->where('master_penjualan.status', 1);
        return $this->db->get()->row();
    }

    function getTotalTransaksi($df, $dt, $idToko)
    {
        $this->db->from('master_penjualan');
        $this->db->where('DATE(createdAt) >=', $df);
        $this->db->where('DATE(createdAt) <=', $dt);
        $this->db->where('idToko', $idToko);
        $this->db->where('status', 1);
        return $this->db->get()->num_rows();
    }

    function topFive($df, $dt, $idToko)
    {
        return $this->db->query("SELECT master_barang.description, SUM(det_master_penjualan.qty) as qtyJual FROM `det_master_penjualan`
                JOIN master_penjualan ON master_penjualan.idPenjualan = det_master_penjualan.idPenjualan
                JOIN toko_stock ON toko_stock.idStock = det_master_penjualan.idStock
                JOIN master_barang ON master_barang.idBarang = toko_stock.idBarang
                WHERE DATE(master_penjualan.createdAt) >= '$df' 
                AND DATE(master_penjualan.createdAt) <= '$dt'
                AND master_penjualan.idToko = '$idToko'
                GROUP BY det_master_penjualan.idStock
                ORDER BY qtyJual DESC
                LIMIT 5")->result();
    }
}

/* End of file ModelLaporan.php */
