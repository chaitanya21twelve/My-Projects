<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common extends Public_controller
{
  public function __construct()
  {
      parent::__construct();
      // $this->form_validation->set_error_delimiters('<p class="text-danger alert-validation">', '</p>');;;
      do_action('after_website_init');

      $this->load->helper('form');

      $this->load->library('session');
      $this->load->library('form_validation');

      $this->load->model('user_model','user');

  }

  public function index()
  {
      
      $this->load->helper('form');

      $data['title'] = _l('Terms');

      $this->data    = $data;
      $this->view    = 'terms';
      $this->layout();
  }

  public function terms(){
        
    $data['title'] = _l('Terms');

    $this->data    = $data;
    $this->view    = 'terms';
    $this->layout();

  }

  public function privacy(){
        
    $data['title'] = _l('Privacy');

    $this->data    = $data;
    $this->view    = 'privacy';
    $this->layout();
    
  }

  public function contact(){
        
    $data['title'] = _l('Contact');

    $this->data    = $data;
    $this->view    = 'contact';
    $this->layout();
    
  }

  

  

  

}
