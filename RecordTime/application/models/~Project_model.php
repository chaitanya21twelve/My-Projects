<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->database();
    }

 public function dashboard($user_id) {
    //$query = "SELECT * FROM tbl_projects LEFT JOIN tbl_user ON tbl_projects.producer_id = tbl_user.id WHERE user_id = " . $user_id . " ORDER BY start_date DESC;";
     $query = "SELECT tu.*,tp.*,tud.profile_pic FROM tbl_projects tp LEFT JOIN tbl_user tu ON tp.producer_id = tu.id LEFT JOIN tbl_userdetails tud ON tu.id = tud.user_id WHERE tp.user_id = " . $user_id . " ORDER BY tp.start_date DESC";

    $projects = $this->db->query($query);

    if ($projects->num_rows() < 1) {
      return false;
    }
    else {
      return $projects->result_array();
    }
 }

 // TODO: Add error handling
 public function start($project_id) {

   $query = "UPDATE tbl_projects SET start_date = CURDATE() WHERE project_id = " . $project_id . ";";

   $started_project = $this->db->query($query);
 }

 public function create($data)
 {
   $criteria = implode(',', $data['criteria']);
   $proj_data  = array(
       'name' => $data['name'],
       'budget' => $data['budget'],
       'songs' => $data['songs'],
       'complete_time' => $data['complete_time'],
       'criteria' => $criteria,
       'user_id' => $this->session->userdata['userid']
    );

   $this->db->insert('tbl_projects', $proj_data);
 }

 public function projects_add($data){
        $proj_name = $data['name'];
        $this->db->where("name", $proj_name);
        $query = $this->db->get("tbl_projects");
         if ($query->num_rows() > 0) {
            return false;
        }
        else {
            unset($data['submit']);
            $criteria = implode(',', $data['criteria']);
            $proj_data  = array(
                'name' => $data['name'],
                'budget' => $data['budget'],
                'songs' => $data['songs'],
                'complete_time' => $data['complete_time'],
                'criteria' => $criteria,
                'user_id' => $this->session->userdata['userid']
             );
            $this->db->insert('tbl_projects', $proj_data);
            $lastId = $this->db->insert_id();
            if(isset($data['doc_name']) && $data['doc_name'] != ''){
                $proj_doc_data = array(
                    'doc_name' => $data['doc_name'],
                    'project_id' => $lastId
                 );
            }
            $this->db->insert('tbl_project_docs', $proj_doc_data);
            return $lastId;

        }
 }
}
