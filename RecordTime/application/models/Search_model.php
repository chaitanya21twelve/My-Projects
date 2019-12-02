<?php
defined('BASEPATH') or exit('No direct script access allowed');
Class Search_model Extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function search($search)
    {
        exit;
        $this->db->like('philosophy', $search);
        $this->db->or_like('skills', $search);
        $this->db->or_like('genres', $search);
        // $query = $this->db->get('producers');
        // $this->db->join('tbl_user', 'tbl_user.id = producers.user_id');
        // return $query->result();
        // return array($search);


        $this->db->from('producers');
        $this->db->join('tbl_user', 'tbl_user.id = producers.user_id');
        $query = $this->db->get();
        return $query->result();
    }


    public function searchProfile($data = array()) {
       
       $search = $data['search'];
       $userid = $data['current_user_id'];

        $this->db->distinct();
         $this->db->select('tbl_user.*,tbl_userdetails.profile_pic');
        $this->db->from("tbl_user");
        $this->db->join('tbl_userdetails','tbl_user.id=tbl_userdetails.user_id');
        $this->db->where('tbl_user.type','2');
        $this->db->where_not_in('tbl_user.id', $userid);
        if($data != '')
        {
            $this->db->like('firstname', $search);
            $this->db->or_like('lastname', $search);
            $this->db->or_like('genre', $search);
        }
        $query = $this->db->get();
        return $query->result();

    }


    public function searchProducer($id) {
       
        $this->db->distinct();
        $this->db->select('tbl_user.*,tbl_userdetails.profile_pic');
        $this->db->from('tbl_user');
        $this->db->join('tbl_userdetails','tbl_user.id=tbl_userdetails.user_id');
        $this->db->where('tbl_user.type','2');
        $this->db->where_not_in('tbl_user.id', $id);
        $query=$this->db->get();


      //  echo $this->db->last_query(); exit;
        return $query->result_array();

    }

}
