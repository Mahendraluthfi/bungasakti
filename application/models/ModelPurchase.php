<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelPurchase extends CI_Model
{

    function getAllPurchase()
    {
        $this->db->select('purchase_request.*, customer.companyName');
        $this->db->from('purchase_request');
        $this->db->join('customer', 'customer.idCustomer = purchase_request.idCustomer');
        $this->db->where('purchase_request.isActive', '1');

        $db = $this->db->get();
        return $db->result();
    }

    function getPRbyId($idPR)
    {
        $this->db->select('purchase_request.*, customer.companyName, customer.address, customer.contactNumber, customer.email');
        $this->db->from('purchase_request');
        $this->db->join('customer', 'customer.idCustomer = purchase_request.idCustomer');
        $this->db->where('IdPR', $idPR);
        $db = $this->db->get();
        return $db->row();
    }

    function isPending($idCustomer)
    {
        $this->db->get_where('purchase_request', ['idCustomer' => $idCustomer, 'status' => 'PENDING']);
        return $this->db->affected_rows() > 0;
    }

    function getCurrentPurchase($idCustomer)
    {
        $this->db->select('purchase_request.*, customer.companyName, customer.address, customer.contactNumber, customer.email');
        $this->db->from('purchase_request');
        $this->db->join('customer', 'customer.idCustomer = purchase_request.idCustomer');
        $this->db->where('purchase_request.idCustomer', $idCustomer);
        $this->db->where('purchase_request.status', 'PENDING');
        $db = $this->db->get();
        return $db->row();
    }

    function insertNewPurchase($object)
    {
        $this->db->insert('purchase_request', $object);
        return $this->db->affected_rows() > 0;
    }

    function getDetailPurchase($idPR)
    {
        $this->db->select('det_purchase_request.*, master_barang.description, master_barang.mcRefrence, master_barang.basePrice');
        $this->db->from('det_purchase_request');
        $this->db->join('master_barang', 'master_barang.idBarang = det_purchase_request.idBarang', 'left');
        $this->db->where('idPR', $idPR);
        $db = $this->db->get();
        return $db->result();
    }

    function updateForm($idPR, $data)
    {
        $this->db->update('purchase_request', $data, ['idPR' => $idPR]);
        return $this->db->affected_rows() > 0;
    }

    function addDetBarang($object)
    {
        $this->db->insert('det_purchase_request', $object);
        return $this->db->affected_rows() > 0;
    }

    function updateDetBarang($idDetPR, $object)
    {
        $this->db->update('det_purchase_request', $object, ['idDetPR' => $idDetPR]);
        return $this->db->affected_rows() > 0;
    }

    function getDetPRbyID($idDetPR)
    {
        $this->db->select('det_purchase_request.*, master_barang.description');
        $this->db->from('det_purchase_request');
        $this->db->join('master_barang', 'master_barang.idBarang = det_purchase_request.idBarang', 'left');
        $this->db->where('idDetPR', $idDetPR);
        $db = $this->db->get();
        return $db->row();
    }

    function deleteDetPR($idDetPR)
    {
        $this->db->delete('det_purchase_request', ['idDetPR' => $idDetPR]);
        return $this->db->affected_rows() > 0;
    }

    function submitPR($idPR)
    {
        $this->db->update('purchase_request', ['status' => 'SUBMIT', 'updatedAt' => date('Y-m-d H:i:s')], ['idPR' => $idPR]);
        return $this->db->affected_rows() > 0;
    }

    function hapusPR($idPR, $status)
    {
        if ($status == "PENDING") {
            $this->db->delete('purchase_request', ['idPR' => $idPR]);
        } else {
            $this->db->update('purchase_request', ['isActive' => '0'], ['idPR' => $idPR]);
        }
        return $this->db->affected_rows() > 0;
    }

    function getAllPurchaseByCustomer($idCustomer)
    {
        $this->db->select('purchase_request.*, customer.companyName');
        $this->db->from('purchase_request');
        $this->db->join('customer', 'customer.idCustomer = purchase_request.idCustomer');
        $this->db->where('purchase_request.isActive', '1');
        $this->db->where('purchase_request.idCustomer', $idCustomer);
        $db = $this->db->get();
        return $db->result();
    }
}

/* End of file ModelPurchase.php */
