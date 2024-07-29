<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelToko extends CI_Model
{
    function getAllToko()
    {
        return $this->db->get_where('master_toko', ['isActive' => '1'])->result();
    }

    function insertToko($object)
    {
        $this->db->insert('master_toko', $object);
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if data was inserted successfully
        } else {
            return false; // Return false if data was not inserted
        }
    }

    function getTokoById($idToko)
    {
        return $this->db->get_where('master_toko', ['idToko' => $idToko])->row();
    }

    function updateToko($data, $idToko)
    {
        $this->db->update('master_toko', $data, ['idToko' => $idToko]);
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if data was updated successfully
        } else {
            return false; // Return false if data was not updated
        }
    }

    function deleteToko($id)
    {
        $this->db->where('idToko', $id);
        $this->db->update('master_toko', ['isActive' => '0']);

        if ($this->db->affected_rows() > 0) {
            return true; // Return true if data was deleted successfully
        } else {
            return false; // Return false if data was not deleted
        }
    }
}

/* End of file ModelToko.php */
