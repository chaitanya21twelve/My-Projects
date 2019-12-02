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
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
          $stripeUrl = 'https://api.stripe.com';
          $stripeKey = 'pk_test_yt3JpiGWmUvIWuAjlDL4c1Tb00lQvTOM5c';
          $stripeSecret = 'sk_test_AjwJEVoEy3GdPMktt9cORFlR00c36Jt9Xc';
          
          \Stripe\Stripe::setApiKey($stripeSecret);
          
          print_r($_POST);
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
        if (!$this->session->user_logged_in) {
          redirect(site_url('index.php/user/login'));
        }

        $user_id = $this->session->userid;

        $data['title'] = _l('Projects');
        $data['projects'] = $this->project->dashboard($user_id);

        $this->data    = $data;
        $this->view    = 'projects/dashboard';
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
  }
