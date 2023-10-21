<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
		//die("asdasd");
    	date_default_timezone_set('Asia/Jakarta');
        parent::__construct();
    }

    public function index(){
    	$data=array();
    	$param=array();
        $this->session->unset_userdata('userdata');
        header('Location:'.base_url().'login/');
    }

    public function keluarga(){
    	$data=array();
    	$param=array();
    	/*
    	$data['sess_token']=$token;
		$data['sess_token_valid']=0;
		$data['sess_keluarga']=false;	
		$data['sess_nama_user']=false;
		$data['sess_id_user']=false;
		$data['sess_num_login']=false;
		*/
        $this->session->unset_userdata('sess_token');
        $this->session->unset_userdata('sess_token_valid');
        $this->session->unset_userdata('sess_keluarga');
        $this->session->unset_userdata('sess_nama_user');
        $this->session->unset_userdata('sess_id_user');
        $this->session->unset_userdata('sess_num_login');
        header('Location:'.base_url().'login/keluarga');
    }
}
