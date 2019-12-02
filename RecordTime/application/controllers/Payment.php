<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Payment extends Public_controller
{
    public function __construct()
    {
        parent::__construct();
//        $this->form_validation->set_error_delimiters('<p class="text-danger alert-validation">', '</p>');
        do_action('after_website_init');
        $this->load->library('form_validation');
        $this->load->model('user_model','user');
    }

    public function index()
    {
        $data['is_home'] = true;

        $data['title'] = get_option('companyname');
        $this->data    = $data;
        $this->view    = 'home';
        $this->layout();

        if (!is_client_logged_in()) {
            redirect(site_url('clients/login'));
        }
    }

    public function add()
    {
        //Add funds your wallet

        if($this->input->post()){

        }

        $this->view    = 'payment/add';
        $this->layout();
    }
}
