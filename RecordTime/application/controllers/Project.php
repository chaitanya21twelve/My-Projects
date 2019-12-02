<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends Public_controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->form_validation->set_error_delimiters('<p class="text-danger alert-validation">', '</p>');;;
        do_action('after_website_init');

        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('project_model','project');
    }

    public function index()
    {
        $data['is_home'] = true;
        $data['title'] = get_option('companyname');
        $this->data    = $data;
        $this->view    = 'home';
        $this->layout();
    }

    public function dashboard()
    {   

        if($this->input->post('accept')){
           

            $data = array(
                'project_id' => $this->input->post('project_id') ,
                'artist_status ' => $this->input->post('status') ,
                'creative ' => $this->input->post('creative') ,
                'candor' => $this->input->post('candor') ,
                'workload ' => $this->input->post('workload') ,
                'flexibility ' => $this->input->post('flexibility') ,
                'feedback ' => $this->input->post('feedback') ,
                'updated_at' => date('Y-m-d H:i:s')                 
            );

            $getfeedback = $this->project->updateFeedback($data);

            if($getfeedback){
                redirect('project/dashboard');

            }else{
                $data['error_msg'] = 'Some problems occured, please try again.';
            }
        }


        if ($this->input->server('REQUEST_METHOD') == 'POST'){
          if(!empty($_POST['token'])){
            $stripeUrl = 'https://api.stripe.com';
            $stripeKey = 'pk_test_yt3JpiGWmUvIWuAjlDL4c1Tb00lQvTOM5c';
            $stripeSecret = 'sk_test_AjwJEVoEy3GdPMktt9cORFlR00c36Jt9Xc';
            
            \Stripe\Stripe::setApiKey($stripeSecret);
            
            $token = $_POST['token'];
            $amount = $_POST['amount'];
            try{
              
              $charge = \Stripe\Charge::create([
              "amount" => $amount,
              "currency" => "usd",
              "source" => $token, // obtained with Stripe.js
              "description" => "Charge for RecordTime"
            ]);
              
            } catch(\Stripe\Error\Card $e) {
              // Since it's a decline, \Stripe\Error\Card will be caught
              http_response_code(401);
              die();
            } catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
              http_response_code(401);
              die();
          }
          
          $data = [];
          
          $data['user_id'] = $this->session->userid;
          $data['payment_id'] = $charge['id'];
          $data['type'] = 'credit';
          $data['amount'] = $amount;
          $this->db->insert('tbl_payments', $data);
          
          http_response_code(200);
          die();
          }
        }
        
        if (!$this->session->user_logged_in) {
          redirect(site_url('index.php/user/login'));
        }

        $user_id = $this->session->userid;

        $data['title'] = _l('Projects');
        $data['projects'] = $this->project->dashboard($user_id);

        $data['producerprojects'] = $this->project->produceroroject($user_id);

        $data['userdatas'] = $this->project->userdata($user_id);

        $this->data    = $data;
        $this->view    = 'projects/dashboard';
        $this->layout();
    }


    public function producer_dashboard()
    {   

        if($this->input->post('accept')){
           

            $data = array(
                'project_id' => $this->input->post('project_id') ,
                'status ' => $this->input->post('status') ,
                'creative ' => $this->input->post('creative') ,
                'candor' => $this->input->post('candor') ,
                'workload ' => $this->input->post('workload') ,
                'flexibility ' => $this->input->post('flexibility') ,
                'feedback ' => $this->input->post('feedback') ,
                'updated_at' => date('Y-m-d H:i:s')                 
            );

            $getfeedback = $this->project->updateProducerFeedback($data);

            if($getfeedback){
                redirect('project/dashboard');

            }else{
                $data['error_msg'] = 'Some problems occured, please try again.';
            }
        }


        if ($this->input->server('REQUEST_METHOD') == 'POST'){
          if(!empty($_POST['token'])){
            $stripeUrl = 'https://api.stripe.com';
            $stripeKey = 'pk_test_yt3JpiGWmUvIWuAjlDL4c1Tb00lQvTOM5c';
            $stripeSecret = 'sk_test_AjwJEVoEy3GdPMktt9cORFlR00c36Jt9Xc';
            
            \Stripe\Stripe::setApiKey($stripeSecret);
            
            $token = $_POST['token'];
            $amount = $_POST['amount'];
            try{
              
              $charge = \Stripe\Charge::create([
              "amount" => $amount,
              "currency" => "usd",
              "source" => $token, // obtained with Stripe.js
              "description" => "Charge for RecordTime"
            ]);
              
            } catch(\Stripe\Error\Card $e) {
              // Since it's a decline, \Stripe\Error\Card will be caught
              http_response_code(401);
              die();
            } catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
              http_response_code(401);
              die();
          }
          
          $data = [];
          
          $data['user_id'] = $this->session->userid;
          $data['payment_id'] = $charge['id'];
          $data['type'] = 'credit';
          $data['amount'] = $amount;
          $this->db->insert('tbl_payments', $data);
          
          http_response_code(200);
          die();
          }
        }
        
        if (!$this->session->user_logged_in) {
          redirect(site_url('index.php/user/login'));
        }

        $user_id = $this->session->userid;

        $data['title'] = _l('Projects');
        $data['projects'] = $this->project->dashboard($user_id);

        $data['producerprojects'] = $this->project->produceroroject($user_id);

        $data['userdatas'] = $this->project->userdata($user_id);

        $this->data    = $data;
        $this->view    = 'projects/producer_dashboard';
        $this->layout();
    }

    public function start($project_id){
      if (!$this->session->user_logged_in) {
        redirect(site_url('index.php/user/login'));
      }

      $data['started_project'] = $this->project->start($project_id);
      redirect(site_url('index.php/project/dashboard'));

    }

    public function create()
    {
      if (!$this->session->user_logged_in) {
        redirect(site_url('/index.php/user/login'));
      }

      $this->form_validation->set_rules('name', 'Project Name', 'required');
      $this->form_validation->set_rules('budget', 'Budget', 'required');
      // $this->form_validation->set_rules('songs', 'Project Song', 'required');

      if ($this->form_validation->run() == FALSE)
      {
        $data['title'] = _l('add project');
        $this->data    = $data;
        $this->view    = 'projects/create';
        $this->layout();
      }
      else
      {
        $formData = $this->input->post();
        $insert = $this->project->create($formData);
        redirect('index.php/project/dashboard');
      }
    }


      public function artist_create() {

        if (!$this->session->user_logged_in) {
          redirect(site_url('/index.php/user/login'));
        }

        $this->form_validation->set_rules('project_name', 'Project Name', 'required');
        $this->form_validation->set_rules('budget', 'Budget', 'required');

        if ($this->form_validation->run() == FALSE)
        {
          $data['title'] = _l('add project');
          $this->data    = $data;
          $this->view    = 'projects/artist_create';
          $this->layout();
        }
        else
        {
          //echo "<pre>"; print_r($_POST); exit;
          $formData = $this->input->post();
          $insert = $this->project->projects_add($formData);
          redirect('/search');
        }
      }

      public function producer_create() {

        if (!$this->session->user_logged_in) {
          redirect(site_url('/index.php/user/login'));
        }

        $this->form_validation->set_rules('name', 'Project Name', 'required');
        //$this->form_validation->set_rules('budget', 'Budget', 'required');

        if ($this->form_validation->run() == FALSE)
        {
          $data['title'] = _l('add project');
          $this->data    = $data;
          $this->view    = 'projects/producer_create';
          $this->layout();
        }
        else
        {
          $formData = $this->input->post();
          $insert = $this->project->producer_projects_add($formData);
          redirect('project/dashboard');
        }
      }


      public function artist_project_view() {

        if (!$this->session->user_logged_in) {
          redirect(site_url('/index.php/user/login'));
        }

        $user_id = $this->session->userdata['userid']; 
        $project_id = $_GET['project_id'];
        $data['projectdetails'] = $this->project->prodetails($project_id);


          $data['title'] = _l('View project details');
          $this->data    = $data;
          $this->view    = 'projects/artist_project_view';
          $this->layout();
       
      }

      public function my_projects() {

        if (!$this->session->user_logged_in) {
          redirect(site_url('/index.php/user/login'));
        }

        //$user_id = $this->session->userdata['userid']; 
        $project_id = $_GET['project_id'];
        $user_id = $_GET['user_id'];
       // $data['projectdetails'] = $this->project->prodetails($project_id);

        $data['projects'] = $this->project->myprojects($user_id,$project_id);

        $data['userdatas'] = $this->project->userdata($user_id);


        if($this->input->post('acceptproject')){
           

            $data = array(
                'project_id' => $this->input->post('project_id') ,
                'producer_id' => $this->input->post('user_id') ,
                'updated_at' => date('Y-m-d H:i:s')                 
            );

            $getProducer = $this->project->updateProducer($data);

            if($getProducer){
                redirect('project/dashboard');

            }else{
                $data['error_msg'] = 'Some problems occured, please try again.';
            }
        }




          $data['title'] = _l('View projects');
          $this->data    = $data;
          $this->view    = 'projects/my_projects';
          $this->layout();
       
      }



      public function producer_project_view() {

        if (!$this->session->user_logged_in) {
          redirect(site_url('/index.php/user/login'));
        }

        $user_id = $this->session->userdata['userid']; 
        $project_id = $_GET['project_id'];
        $data['projectdetails'] = $this->project->prodetails($project_id);


          $data['title'] = _l('View project details');
          $this->data    = $data;
          $this->view    = 'projects/producer_project_view';
          $this->layout();
       
      }

      public function artist_project_edit() {

        if (!$this->session->user_logged_in) {
          redirect(site_url('/index.php/user/login'));
        }

        $this->form_validation->set_rules('project_name', 'Project Name', 'required');
        $this->form_validation->set_rules('budget', 'Budget', 'required');

        if ($this->form_validation->run() != FALSE)
        {
          
          //echo "<pre>"; print_r($_POST); exit;
          $formData = $this->input->post();
          $update = $this->project->update_artist_projects($formData);
          redirect('project/dashboard');
        }



        $user_id = $this->session->userdata['userid']; 
        $project_id = $_GET['project_id'];
        $data['projectdetails'] = $this->project->prodetails($project_id);


          $data['title'] = _l('Edit project details');
          $this->data    = $data;
          $this->view    = 'projects/artist_project_edit';
          $this->layout();
       
      }

      public function producer_project_edit() {

        if (!$this->session->user_logged_in) {
          redirect(site_url('/index.php/user/login'));
        }

        $this->form_validation->set_rules('name', 'Project Name', 'required');
        //$this->form_validation->set_rules('budget', 'Budget', 'required');

        if ($this->form_validation->run() == true)
        {
          
          $formData = $this->input->post();
          $insert = $this->project->update_producer_projects($formData);
          redirect('project/dashboard');
        }



        $user_id = $this->session->userdata['userid']; 
        $project_id = $_GET['project_id'];
        $data['projectdetails'] = $this->project->prodetails($project_id);


          $data['title'] = _l('Edit project details');
          $this->data    = $data;
          $this->view    = 'projects/producer_project_edit';
          $this->layout();
       
      }

  }
