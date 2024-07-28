<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelUser extends CI_Model
{
    function getAllUser()
    {
        $this->db->from('user');
        $this->db->join('master_toko', 'master_toko.idToko = user.idToko', 'left');
        $db = $this->db->get();
        return $db->result();
    }

    function checkExistUsername($username)
    {
        $data = $this->db->get_where('user', ['username' => $username])->row();
        return ($data) ? true : false; // Return true if username already exists, otherwise return false
    }

    function insertUser($object)
    {
        $this->db->insert('user', $object);
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if data was inserted successfully
        } else {
            return false; // Return false if data was not inserted
        }
    }

    function getUserById($id)
    {
        $data = $this->db->get_where('user', ['idUser' => $id])->row();
        return $data; // Return user data if exists, otherwise return null
    }

    function updateUser($object, $idUser)
    {
        $this->db->where('idUser', $idUser);
        $this->db->update('user', $object);
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if data was updated successfully
        } else {
            return false; // Return false if data was not updated
        }
    }

    function deleteUser($idUser)
    {
        $this->db->where('idUser', $idUser);
        $this->db->delete('user');
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if data was deleted successfully
        } else {
            return false; // Return false if data was not deleted
        }
    }

    function getUserbyUsername($username)
    {
        $query = $this->db->get_where('user', array('username' => $username));
        return $query->row();
    }

    function updateLastLogin($username)
    {
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
        $this->db->update('user', ['lastLogin' => $timestamp], array('username' => $username));
        return $this->db->affected_rows() > 0; // Return true if data was updated successfully, otherwise return false
    }
}

/* End of file ModelUser.php */
