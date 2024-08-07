<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelOrder extends CI_Model
{

    function getAllOrder()
    {
        $this->db->select('master_order.*, customer.companyName');
        $this->db->from('master_order');
        $this->db->join('customer', 'customer.idCustomer = master_order.idCustomer');
        $this->db->where('master_order.isActive', '1');
        $db = $this->db->get();
        return $db->result();
    }
    function insertOrderbyPR($object)
    {
        $this->db->insert('master_order', $object);
        return $this->db->affected_rows() > 0;
    }
}

/* End of file ModelOrder.php */
