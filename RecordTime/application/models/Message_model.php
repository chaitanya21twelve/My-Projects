<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('upload');
    }
	
	
	public function addmessage($data = array()) {
        //add created and modified data if not included
        if(!array_key_exists("sent", $data)){
            $data['sent'] = date("Y-m-d H:i:s");
        }
		
		if(!array_key_exists("attachments", $data)){
            $data['attachments'] = '';
        }
        
        
        //insert user data to users table
        $insert = $this->db->insert('tblmessages', $data);
        
        //return the status
        if($insert){
            $insertId = $this->db->insert_id();
			$this->db->select('*');
			$this->db->from('tblmessages');
			$this->db->where('id', $insertId );
			$query = $this->db->get();

			if ( $query->num_rows() > 0 )
			{
				$row = $query->result_array();
				return $row;
			}
			
        }else{
            return false;
        }
    }
	
	function getRows($params = array()){
		//echo "test"; exit;
			$a = $params['from_id'].$params['to_id'];
			$b = $params['to_id'].$params['from_id'];
			$this->db->select('*');
			$this->db->from('tblmessages');
			//$this->db->where('thread_id',$params['from_id'].$params['to_id']);
			//$this->db->where('thread_id',$params['to_id'].$params['from_id']);
			$where = '(thread_id='.$a.' or thread_id = '.$b.')';
			$this->db->where($where);
			$query = $this->db->get();
			$result = $query->result_array();




		//return fetched data
		return $result;
	}
	
	function getRecipientdetails($params = array()){
		//echo "test"; exit;
		$user_id = $params['id'];
		$rec_id = $params['rec_id'];
		
		$this->db->select('to_id,from_id');
		$this->db->distinct();
		$this->db->from('tblmessages');

		//$where = "from_id='$user_id' AND to_id='$rec_id' OR from_id='$rec_id' AND to_id='$user_id'";
		//$this->db->where($where);

		$this->db->where('from_id', $user_id );
		$this->db->or_where('to_id', $user_id );
		$query = $this->db->get();
		//print_r($this->db->last_query());    exit;
		if ( $query->num_rows() > 0 )
		{
			$row = $query->result_array();
			//echo "<pre>"; print_r($row);
			$row1 = array();
			$row2 = array();
			foreach($row as $rows) {


				$userto_id = $rows['to_id'];
				$userfrom_id = $rows['to_id'];

				if($user_id == $userto_id){
					$userto_id = $rows['from_id'];
				}else{
					$userto_id = $rows['to_id'];
				}
				//
				$this->db->select('id,firstname,lastname');
				$this->db->from('tbl_user');
				$this->db->where('id', $userto_id );
				$query1 = $this->db->get();
				$row1[] = $query1->result_array();
				
				
				$this->db->select('message');
				$this->db->from('tblmessages');
				$this->db->limit(1);
				$this->db->order_by('id',"DESC");
				$where = '(to_id='.$userto_id.' OR from_id = '.$userto_id.')';
				$this->db->where($where);
				$query2 = $this->db->get();
				//print_r($this->db->last_query());    exit;
				$row2[] = $query2->result_array();
				 
				
			}
			return $row1;
		
		}
	}

	function getAllRecipients($id){
		
		$this->db->select('id,firstname,lastname');
		$this->db->from('tbl_user');
		$this->db->where('id !=', $id );
		$query1 = $this->db->get();
		//print_r($this->db->last_query());    exit;
		return $query1->result_array();
	}

	function getRecipient($id){
		
		$this->db->select('id,firstname,email');
		$this->db->from('tbl_user');
		$this->db->where('id', $id );
		$query1 = $this->db->get();
		//print_r($this->db->last_query());    exit;
		return $query1->result_array();
	}

	function getAllProjects($id){
		
		$this->db->select('project_id,name,producer_id,user_id');
		$this->db->from('tbl_projects');
		$this->db->where('user_id', $id );
		$query1 = $this->db->get();
		//print_r($this->db->last_query());    exit;
		return $query1->result_array();
	}

	function selectType($id){
		
		$this->db->select('type');
		$this->db->from('tbl_user');
		$this->db->where('id', $id );
		$query1 = $this->db->get();
		return $query1->result_array();
	}
	
	function getRecipientmsg($params = array()){
		//echo "test"; exit;
		$user_id = $params['id'];
		$rec_id = $params['rec_id'];
		
		$this->db->select('to_id,from_id');
		$this->db->distinct();
		$this->db->from('tblmessages');
		$this->db->where('from_id', $user_id );
		
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
		{
			$row = $query->result_array();
			//echo "<pre>"; print_r($row);
			
			$row2 = array();
			foreach($row as $rows) {
				$userto_id = $rows['to_id'];
				//$userfrom_id = $rows['from_id'];
			
				$this->db->select('message');
				$this->db->from('tblmessages');
				$this->db->limit(1);
				$this->db->order_by('id',"DESC");
				$where = '(to_id='.$userto_id.' OR from_id = '.$userto_id.')';
				$this->db->where($where);
				$query2 = $this->db->get();
				$row2[] = $query2->result_array();

			}
			return $row2;
		}
	}
	
}
