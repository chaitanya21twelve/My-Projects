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
     $query = "SELECT DISTINCT tu.*,tp.*,tud.profile_pic FROM tbl_projects tp LEFT JOIN tbl_user tu ON tp.producer_id = tu.id LEFT JOIN tbl_userdetails tud ON tu.id = tud.user_id WHERE tp.user_id = " . $user_id . " ORDER BY tp.start_date DESC";
 
    $projects = $this->db->query($query);

    if ($projects->num_rows() < 1) {
      return false;
    }
    else {
      return $projects->result_array();
    }
  }

  public function produceroroject($user_id) {

      $this->db->select('tbl_projects.*,tbl_user.*');
      $this->db->from('tbl_projects');
      $this->db->join('tbl_user','tbl_user.id=tbl_projects.producer_id');
      $this->db->where('tbl_projects.producer_id', $user_id);
      $query=$this->db->get();

     
      if ( $query->num_rows() > 0 ) {
        
        $row = $query->result_array();
        return $row;
      }


  }

  public function userdata($user_id) {
    $query = "SELECT type FROM tbl_user WHERE id = " . $user_id;
     
    $userdatas = $this->db->query($query);

    if ($userdatas->num_rows() < 1) {
      return false;
    }
    else {
      return $userdatas->result_array()[0];
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
    $proj_name = $data['project_name'];
    $this->db->where("name", $proj_name);
    $query = $this->db->get("tbl_projects");
     if ($query->num_rows() > 0) {
        return false;
    }
    else {
        unset($data['submit']);
        $criteria = implode(',', $data['criteria']);
        $origDate = $data['complete_time'];
        $date = date("Y-m-d", strtotime($origDate));
        $proj_data  = array(
            'name' => $data['project_name'],
            'budget' => $data['budget'],
            'songs' => $data['songs'],
            //'complete_time' => $data['complete_time'],
            'complete_time' => $date,
            'criteria' => $criteria,
            'user_id' => $this->session->userdata['userid']
         );
       // echo "<pre>"; print_r($proj_data); exit;
        $this->db->insert('tbl_projects', $proj_data);
        $lastId = $this->db->insert_id();
        if(isset($_FILES['doc_name']) && $_FILES['doc_name'] != ''){
            $proj_doc_data = array(
                'doc_name' => $_FILES['doc_name']['name'],
                'project_id' => $lastId
             );

            $config['upload_path']="./assets/themes/recordtime/project_files/";
            $config['allowed_types']='gif|jpg|jpeg|png|iso|dmg|avi|mpeg|mp3|mp4|3gp';
            $this->upload->initialize($config);
            $this->load->library('upload',$config);

            if($this->upload->do_upload("doc_name")){              
              $data = array('upload_data' => $this->upload->data());
            }


        }
        $this->db->insert('tbl_project_docs', $proj_doc_data);
        return $lastId;

    }
  }

  public function producer_projects_add($data){
    $proj_name = $data['name'];
    $this->db->where("name", $proj_name);
    $query = $this->db->get("tbl_projects");
     if ($query->num_rows() > 0) {
        return false;
    }
    else {
        unset($data['submit']);
        $songcost1 = implode(',', $data['songcost']);
        $songcost = rtrim($songcost1,",");  
        $players = implode(',', $data['players']);
        $songcost = rtrim($songcost1,","); 
      
        $origDate = $data['complete_time'];
        $date = date("Y-m-d", strtotime($origDate));
        $proj_data  = array(
            'name' => $data['name'],
            'complete_time' => $date,
            'songs_cost' => $songcost,
            'players' => $players,
            'user_id' => $this->session->userdata['userid']
         );
        
        $this->db->insert('tbl_projects', $proj_data);
        $lastId = $this->db->insert_id();
        return $lastId;

    }
  }

  public function prodetails($project_id) {

      $this->db->select('tbl_projects.*,tbl_project_docs.doc_name');
      $this->db->from('tbl_projects');
      $this->db->join('tbl_project_docs','tbl_project_docs.project_id=tbl_projects.project_id');
      $this->db->where('tbl_projects.project_id', $project_id);
      $query=$this->db->get();

      if ( $query->num_rows() > 0 )
      {
        $row = $query->result_array()[0];
        return $row;
      }else{
        $this->db->select('*');
        $this->db->from('tbl_projects');
        $this->db->where('project_id', $project_id);
        $query=$this->db->get();
        $row = $query->result_array()[0];
        return $row;
      }

  }

  //  start by Cp

    public function updateFeedback($data){
//echo "<pre>"; print_r($data); exit;
      $project_id = $data['project_id'];

      $this->db->select('project_id');
      $this->db->from('tbl_projects');
      $this->db->where('project_id', $project_id);
      $query=$this->db->get();


      if ( $query->num_rows() > 0 )
      {
          $this->db->where('project_id',$project_id);
          $row = $this->db->update('tbl_projects',$data);
          //echo $this->db->last_query(); exit;
          return $row;
      }   
    }

    public function updateProducerFeedback($data){

      $project_id = $data['project_id'];

      $this->db->select('project_id');
      $this->db->from('tbl_projects');
      $this->db->where('project_id', $project_id);
      $query=$this->db->get();


      if ( $query->num_rows() > 0 )
      {
          $this->db->where('project_id',$project_id);
          $row = $this->db->update('tbl_projects',$data);
          //echo $this->db->last_query(); exit;
          return $row;
      }   
    }


    public function updateProducer($data){
      $project_id = $data['project_id'];

          $this->db->set('producer_id','producer_id', true);
          $this->db->where('project_id',$project_id);
          $row = $this->db->update('tbl_projects',$data);
         // echo $this->db->last_query(); exit;
          return $row;
        
    }


  //  end


  // update artist project
    public function update_artist_projects($data){
    
      $project_id = $data['project_id'];
      $this->db->where("project_id", $project_id);
      $query = $this->db->get("tbl_projects");

      if ($query->num_rows() > 0) {
        
        unset($data['submit']);
        
        $criteria = implode(',', $data['criteria']);
        $origDate = $data['complete_time'];
        $date = date("Y-m-d", strtotime($origDate));
        $proj_data  = array(
            'name' => $data['project_name'],
            'budget' => $data['budget'],
            'songs' => $data['songs'],
            'complete_time' => $date,
            'criteria' => $criteria,
            'user_id' => $this->session->userdata['userid'],
            'updated_at' => date('Y-m-d H:i:s')
         );
     
        $this->db->where('project_id',$project_id);
        
        $this->db->update('tbl_projects',$proj_data);

        //$this->db->insert('tbl_projects', $proj_data);
       // $lastId = $this->db->insert_id();
        if(isset($_FILES['doc_name']) && $_FILES['doc_name'] != ''){
            $proj_doc_data = array(
                'doc_name' => $_FILES['doc_name']['name'],
                'project_id' => $project_id
             );

            $config['upload_path']="./assets/themes/recordtime/project_files/";
            $config['allowed_types']='gif|jpg|jpeg|png|iso|dmg|avi|mpeg|mp3|mp4|3gp';
            $this->upload->initialize($config);
            $this->load->library('upload',$config);

            if($this->upload->do_upload("doc_name")){              
              $data = array('upload_data' => $this->upload->data());
            }


        }
        $this->db->where('project_id',$project_id);
        $this->db->update('tbl_project_docs', $proj_doc_data);
        return $project_id;

      }else {
        return false;

      }
    } 


    public function update_producer_projects($data){

      $project_id = $data['project_id'];
      $this->db->where("project_id", $project_id);
      $query = $this->db->get("tbl_projects");

      if ($query->num_rows() > 0) {

          unset($data['submit']);
          $songcost1 = implode(',', $data['songcost']);
          $songcost = rtrim($songcost1,",");  
          $players = implode(',', $data['players']);
          $origDate = $data['complete_time'];
          $date = date("Y-m-d", strtotime($origDate));
          $proj_data  = array(
              'name' => $data['name'],
              'complete_time' => $date,
              'songs_cost' => $songcost,
              'players' => $players,
              'user_id' => $this->session->userdata['userid'],
              'updated_at' => date('Y-m-d H:i:s')
           );
          
          $this->db->where('project_id',$project_id); 
          $this->db->update('tbl_projects',$proj_data);

          return true;

      }else {    
         return false;
      }
    }


    public function myprojects($user_id,$project_id) {

        $query = "SELECT tu.*,tp.*,tud.profile_pic FROM tbl_projects tp LEFT JOIN tbl_user tu ON tp.producer_id = tu.id LEFT JOIN tbl_userdetails tud ON tu.id = tud.user_id WHERE tp.user_id = " . $user_id . " AND tp.project_id = " . $project_id . " ORDER BY tp.start_date DESC"; 

      $projects = $this->db->query($query);

      if ($projects->num_rows() < 1) {
        return false;
      }
      else {
        return $projects->result_array();
      }
   }



}
