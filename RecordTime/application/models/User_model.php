<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');

    }

	public function artists_signup($data){
	    // $this->db->insert('ef_userinvestorprofile', $data);
	    // return true;

	        $email = $data['email'];
	        $this->db->where("email", $email);
	        $query = $this->db->get("tbl_user");
	        
	        if ($query->num_rows() > 0) {
	            return false;
	        }
	        else {
	            unset($data['submit']);
	            $data['password'] = md5($data['password']);
//echo "<pre>"; print_r($data); exit;
	            $this->db->insert('tbl_user', $data);
	            $lastId = $this->db->insert_id();
	            $this->db->insert('tbl_userdetails', array('user_id' => $lastId));
	            return $lastId;

	        }
	}

	public function email_exists($email)
	{
	    $this->db->select('email'); 
	    $this->db->from('tbl_user');
	    $this->db->where('email', $email);
	    $query = $this->db->get();
	    $result = $query->result_array();
	    return $result;
	}


 public function login_user($data){
        // print_r($data);die;
        $data = array(
            'email' => $data['email'],
            'password' => $data['password']
        );
        $query = $this->db->get_where('tbl_user', $data);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                //add all data to session
                $newdata = array(
                    'userid' => $rows->id,
                    'email'     => $rows->email,
                    'user_logged_in' => TRUE,
                    'type' => $rows->type
                );
            }
            $this->session->set_userdata($newdata);
            return $newdata;
        }
        else{
            return false;
        }

    }
    public function producer_signup($data){
    // $this->db->insert('ef_userinvestorprofile', $data);
    // return true;
        $email = $data['email'];
        $data['type'] = 2;
        $this->db->where("email", $email);
        $query = $this->db->get("tbl_user");
         if ($query->num_rows() > 0) {
            return false;
        }
        else {
            unset($data['submit']);
            $data['password'] = md5($data['password']);
            $this->db->insert('tbl_user', $data);
            $lastId = $this->db->insert_id();
            return $lastId;

        }
 	}
	
	// Artist edit profile module start cpp
	
		public function getArtistdetails($data){

			$user_id = $data['user_id'];

			$this->db->select('user_id');
			$this->db->from('tbl_userdetails');
			$this->db->where('user_id', $user_id);
			$query=$this->db->get();

			if ( $query->num_rows() > 0 )
			{
				$this->db->select('tbl_user.firstname,tbl_user.lastname,tbl_user.state,tbl_user.city,tbl_user.genre,tbl_userdetails.*');
				$this->db->from('tbl_user');
				$this->db->join('tbl_userdetails','tbl_userdetails.user_id=tbl_user.id');
				$this->db->where('tbl_user.id', $user_id);

			}else{

				$this->db->select('id as user_id,firstname,lastname,state,city,genre');
				$this->db->from('tbl_user');
				$this->db->where('id', $user_id);
			}


			// $this->db->select('tbl_user.firstname,tbl_user.lastname,tbl_user.state,tbl_user.city,tbl_user.genre,tbl_userdetails.*');
			// $this->db->from('tbl_user');
			// $this->db->join('tbl_userdetails','tbl_userdetails.user_id=tbl_user.id');
			// $this->db->where('tbl_user.id', $user_id);
			$query=$this->db->get();

			if ( $query->num_rows() > 0 )
			{
				$row = $query->result_array();
				return $row;
			}

		}

		public function updateartistprofile($id) {
			//add created and modified data if not included

			$fname = $this->input->post('fname');
			$lname = $this->input->post('lname');
			$state = $this->input->post('state');
			$city = $this->input->post('city');
			$base_rate = $this->input->post('base_rate');
			$genre = $this->input->post('genre');
			// $philosphy = $this->input->post('philosphy');
			// $credits = $this->input->post('credits');
			// $skills = $this->input->post('skills');
			// $creative = $this->input->post('creative');
			// $candor = $this->input->post('candor');
			// $workload = $this->input->post('workload');
			// $flexibility = $this->input->post('flexibility');

			

		//	echo $profile_pic = $this->upload->data('profile_pic'); exit;


			//insert user data to users table

			$this->db->set('firstname', $fname);
			$this->db->set('lastname', $lname);
			$this->db->set('state', $state);
			$this->db->set('city', $city);
			$this->db->set('genre', $genre);
			$this->db->where('id', $id);  
			$updateuser = $this->db->update('tbl_user'); 

			// if($this->upload->do_upload("profile_pic")){

			// 	$data = array('upload_data' => $this->upload->data());

			// 	echo $profile_pic = $data['upload_data']['file_name']; exit;

			// 	$this->db->set('profile_pic', $profile_pic);
				
			// }

			if(!empty($_FILES['profile_pic']['name'])){
				
                $config['upload_path'] = './assets/themes/recordtime/users/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['profile_pic']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_pic')){
                    $uploadData = $this->upload->data();
                   $profile_pic = $uploadData['file_name']; 
                }else{
                    $profile_pic = ''; 
                }
            }else{
                $profile_pic = '';
            }


			
            $this->db->set('profile_pic', $profile_pic);
			// $this->db->set('philosphy', $philosphy);
			// $this->db->set('credits', $credits);
			// $this->db->set('skills', $skills);
			// $this->db->set('creative', $creative);
			
			// $this->db->set('candor', $candor);
			// $this->db->set('workload', $workload);
			// $this->db->set('flexibility', $flexibility);
			$this->db->where('user_id', $id);  
			$updateuserdetails = $this->db->update('tbl_userdetails'); 


			//print_r($this->db->last_query()); exit;
			//return the status
			if($updateuser && $updateuserdetails){
				return true;
			}else{
				return false;
			}
		}
	
	// Artist edit profile module end


	// Producer edit profile start

		public function getProducerdetails($data){

			$user_id = $data['user_id'];

			$this->db->select('user_id');
			$this->db->from('tbl_userdetails');
			$this->db->where('user_id', $user_id);
			$query=$this->db->get();

			if ( $query->num_rows() > 0 )
			{
				$this->db->select('tbl_user.firstname,tbl_user.lastname,tbl_user.state,tbl_user.city,tbl_user.genre,tbl_userdetails.*');
				$this->db->from('tbl_user');
				$this->db->join('tbl_userdetails','tbl_userdetails.user_id=tbl_user.id');
				$this->db->where('tbl_user.id', $user_id);

			}else{

				$this->db->select('id as user_id,firstname,lastname,state,city,genre');
				$this->db->from('tbl_user');
				$this->db->where('id', $user_id);
			}

			$query=$this->db->get();
   
			if ( $query->num_rows() > 0 )
			{
				$row = $query->result_array();
				return $row;
			}

		}


		public function updateproducerprofile($id) {
			//add created and modified data if not included

			$fname = $this->input->post('fname');
			$lname = $this->input->post('lname');
			$state = $this->input->post('state');
			$city = $this->input->post('city');
			$genre = $this->input->post('genre');
			$philosphy = $this->input->post('philosphy');
			$credits = $this->input->post('credits');
			$skills = $this->input->post('skills');
			$creative = $this->input->post('creative');
			$candor = $this->input->post('candor');
			$workload = $this->input->post('workload');
			$flexibility = $this->input->post('flexibility');
			$flexibility = $this->input->post('flexibility');

			//insert user data to users table

			$this->db->set('firstname', $fname);
			$this->db->set('lastname', $lname);
			$this->db->set('state', $state);
			$this->db->set('city', $city);
			$this->db->set('genre', $genre);
			$this->db->where('id', $id);  
			$updateuser = $this->db->update('tbl_user'); 

			// if($this->upload->do_upload("profile_pic")){

			// 	$data = array('upload_data' => $this->upload->data());

			// 	$profile_pic = $data['upload_data']['file_name'];

			// }

			if(!empty($_FILES['profile_pic']['name'])){
				
				
                $config['upload_path'] = './assets/themes/recordtime/users/';
                $config['allowed_types'] = '*';
                $config['file_name'] = $_FILES['profile_pic']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_pic')){
                	//echo "test"; exit;
                    $uploadData = $this->upload->data();
                   	$profile_pic = $uploadData['file_name']; 
                }else{
                	// $error = array('error' => $this->upload->display_errors());
                	// print_r($error);
                	// echo "test123"; exit;
                    $profile_pic = '';  
                }
            }else{
                $profile_pic = ''; 
            }

            $this->db->set('profile_pic', $profile_pic);
			$this->db->set('philosphy', $philosphy);
			$this->db->set('credits', $credits);
			$this->db->set('skills', $skills);
			$this->db->set('creative', $creative);
			$this->db->set('candor', $candor);
			$this->db->set('workload', $workload);
			$this->db->set('flexibility', $flexibility);
			$this->db->where('user_id', $id);  
			$updateuserdetails = $this->db->update('tbl_userdetails'); 
			//print_r($this->db->last_query()); exit;

			
			//return the status
			if($updateuser && $updateuserdetails){
				return true;
			}else{
				return false;
			}
		}

	// end

	// Production rate module start by Cp

		public function insertprorates($data){

			$user_id = $data['user_id'];

			$this->db->select('user_id');
			$this->db->from('tbl_productionexpenses');
			$this->db->where('user_id', $user_id);
			$query=$this->db->get();

			if ( $query->num_rows() > 0 )
			{
				$this->db->where('user_id',$user_id);
            	return $this->db->update('tbl_productionexpenses',$data);
			}else{
				return $this->db->insert('tbl_productionexpenses', $data);
            	
			}


            
		}


	// Edit Sounds

		public function updatesound($id) {
			
			$song1 = $this->input->post('song1');
			$song2 = $this->input->post('song2');
			$song3 = $this->input->post('song3');
			$song4 = $this->input->post('song4');
			$song5 = $this->input->post('song5');
		
			$this->db->set('song1', $song1);
			$this->db->set('song2', $song2);
			$this->db->set('song3', $song3);
			$this->db->set('song4', $song4);
			$this->db->set('song5', $song5);
			$this->db->where('user_id', $id);  
			$updatesound = $this->db->update('tbl_userdetails'); 

			
			//return the status
			if($updatesound && $updatesound){
				return true;
			}else{
				return false;
			}
		}


	// get production rate summary start

		public function getSummary($data){

			$user_id = $data['user_id'];

			$this->db->select('*');
			$this->db->from('tbl_productionexpenses');
			$this->db->where('user_id', $user_id);
			$query=$this->db->get();

			if ( $query->num_rows() > 0 )
			{
				$row = $query->result_array();
				return $row;
			}

		}

	// end
	
	
}
