<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends Public_controller
{
  public function __construct()
  {
      parent::__construct();
      // $this->form_validation->set_error_delimiters('<p class="text-danger alert-validation">', '</p>');;;
      do_action('after_website_init');

      $this->load->helper('form');

      $this->load->library('session');
      $this->load->library('form_validation');

      $this->load->model('search_model');

      $this->load->model('user_model','user');

  }

  public function index()
  {
      if (!$this->session->user_logged_in) {
        redirect(site_url('/index.php/user/login'));
      }

      $this->load->helper('form');

      $data['is_home'] = false;
      $data['title'] = get_option('companyname');

      $search = NULL;

      $user_id = $this->session->userdata['userid'];

			$this->db->select('tbl_user.firstname,tbl_user.lastname,tbl_user.state,tbl_user.city');
			$this->db->from('tbl_user');

      $this->db->where('tbl_user.id', $user_id);
      $query=$this->db->get();

      $data['user'] = $query->result_array();

      $data['producerdatas'] = $this->search_model->searchProducer($user_id);
    
      //echo "<pre>"; print_r($producerdatas); exit;



      $this->data    = $data;
      $this->view    = 'search';
      $this->layout();
  }

  public function producers()
  {

      parse_str($_SERVER['QUERY_STRING'], $_GET);

      $results = $this->search_model->search($_GET['search']);

      header('Content-Type: application/json');
      // echo json_encode( "HELLO THAR" );
      echo json_encode($results);

  }

  public function search_profile(){
    
    $output = "";
    $searchData = array(
      'current_user_id' => $this->input->post('current_user_id'),
      'search' => $this->input->post('search')       
    );
  
    $showsearch = $this->search_model->searchProfile($searchData);
    if($showsearch > 0){

        foreach($showsearch as $row){

          $output .= '
            <div class="producer-contact-details-container box-shadow">
              <div class="container">
                <div class="row desktop-section">
                  <div class="col-sm-1"></div>
                  <div class="col-sm-4 producer-profile-img-container">
                    <div class="producer-profile-img">';
                      if(!empty($row->profile_pic)){
                      
                        $output .= '<img src="'.site_url().template_assets_path().'/images/'.$row->profile_pic.'">';
                     }else{
                        $output .= '<img src="'.site_url().template_assets_path().'/images/profucer-profile-image.png">';
                     }
            $output .= '  </div>
                  </div>
                  <div class="col-sm-7 producer-profile-contact-details-container">
                    <div class="producer-name">
                      <a href="'.site_url().'userprofile?userid='.$row->id.'">
                        <h1>'.$row->firstname.' '.$row->lastname.'</h1>
                      </a>
                    </div>
                    <div class="producer-type">
                      <p>'.$row->genre.'</p>
                    </div>
                    <div class="producer-city">
                      <p>'.$row->city.', '.$row->state.'</p>
                    </div>

                    <div class="producer-email-container">
                      <a href="'.site_url().'message?recipient_id='.$row->id.'" class="email-icon">
                        <img src="'.site_url().template_assets_path().'/images/big-mail-icon.png">
                      </a>
                    </div>

                  </div>
                  </div>  
                </div>
              </div>
            </div>
          ';
      }
                
    }else{
      $output .= 'No Data Found';
    } 
    echo $output;

  }


}
