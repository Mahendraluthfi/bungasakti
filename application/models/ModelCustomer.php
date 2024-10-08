<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelCustomer extends CI_Model
{
    function getAllCustomer()
    {
        return $this->db->get_where('customer', ['isActive' => '1'])->result();
    }

    function getCustomerById($idCustomer)
    {
        return $this->db->get_where('customer', ['idCustomer' => $idCustomer])->row();
    }

    function insertCustomer($object)
    {
        $this->db->insert('customer', $object);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateCustomer($object, $idCustomer)
    {
        $this->db->update('customer', $object, ['idCustomer' => $idCustomer]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function deleteCustomer($idCustomer)
    {
        $this->db->update('customer', ['isActive' => '0'], ['idCustomer' => $idCustomer]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getUserByEmail($email)
    {
        $query = $this->db->get_where('customer', array('email' => $email));
        return $query->row();
    }

    function getPRbyId($idCustomer)
    {
        return $this->db->get_where('purchase_request', ['idCustomer' => $idCustomer])->num_rows();
    }

    function getPRbyStatus($idCustomer, $status)
    {
        return $this->db->get_where('purchase_request', ['idCustomer' => $idCustomer, 'status' => $status])->num_rows();
    }
}

/* End of file ModelCustomer.php */
