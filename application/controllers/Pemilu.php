<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemilu extends CI_Controller {

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

    	date_default_timezone_set('Asia/Jakarta');

        parent::__construct();



            // Your own constructor code
        $this->tahun_pemilihan=date('Y');

    }

	public function index(){
		die("Page Unavailable!");
	}

	public function setting(){
		$data=array();
		$q="select A.*, B.name as pemilihan
				from lock_pemilihan A 
				join tipe_pemilihan B on B.id = A.tipe_pemilihan
				order by id ASC";
		$data['lock_pemilihan']=$this->m_model->selectcustom($q);


		$this->load->view('pemilu/setting', $data);
	}

	public function lockunlock(){
		$data=array();
		$param=array();
		$recid=$this->input->post('recid');
		$param['locked']=$this->input->post('locked');
		if($param['locked']==1){
			//locked
			$param['locked_by']=$this->session->userdata('userdata')->username;
			$param['locked_at']=date('Y-m-d H:i:s');
		}
		else if($param['locked']==0){
			//locked
			$param['opened_by']=$this->session->userdata('userdata')->username;
			$param['opened_at']=date('Y-m-d H:i:s');
		}
		$update=$this->m_model->updateas('id', $recid, $param, 'lock_pemilihan');

		$json=array();
		if($update){
			$json['status']=1;
			$json['msg']="Wow... Pengaturan Pemilihan Berhasil di Update!";
		}
		else{
			$json['status']=0;
			$json['msg']="Oooppsss... Pengaturan Pemilihan Gagal di Update!";	
		}

		echo json_encode($json);
	}
}
?>