<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Api extends CI_Controller {



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



	public function index(){

		die('Access Denied!');

	}

	public function yt_live_streaming(){
		header('Content-Type: application/json');
		$token=$this->input->get('api_key');
		if(!$token || $token==null || $token != md5("asjkAsh#172596#Thaklasjd")){
			$data['status']=0;
			$data['url']=null;
			$data['date']=null;
			$data['msg']="Token Invalid, Access Denied!";
			echo json_encode($data, JSON_PRETTY_PRINT);
			return;
		}

		$q="select * from live_streaming where status = 1";
		$streaming=$this->m_model->selectcustom($q);
		$data=array();
		if(count($streaming)>0){
			foreach ($streaming as $key => $value) {
				// code...
				$data['status']=$value->status;
				$data['url']=$value->url;
				$data['date']=$value->date;
			}
		}
		else{
			$data['status']=0;
			$data['url']=null;
			$data['date']=null;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);

	}

	public function submitReview(){
		$data=array();
		$param=array();
		if($this->input->post('auth_review') != md5($this->session->userdata('sess_keluarga')->id.'(71hkas37%')){
			$data['sts']=0;
			$data['msg']='Gagal simpan Ulasan, Peringatan: Akses tidak sah!';
			echo json_encode($data, JSON_PRETTY_PRINT);
			return;
		}


		#$param['user_id']=$this->session->userdata('sess_keluarga')->id;
		$param['user_id']=$this->input->post('user_idUlasan');
		$param['nama']=$this->input->post('nama_pengguna');
		$param['rating']=$this->input->post('rating');
		$param['pesan']=$this->input->post('feedbackText');
		$param['module']=$this->input->post('moduleUlasan');

		$i=$this->m_model->insertgetid($param, 'ulasan_user');
		if($i>0){
			$data['sts']=1;
			$data['msg']='Berhasil simpan Ulasan.<br>Hatur nuhun <b>'.$param['nama'].'</b>, Tuhan Yesus Memberkati.🙏';
		}else{
			$data['sts']=0;
			$data['msg']='Gagal simpan Ulasan, Peringatan: General Error!';
		}
			echo json_encode($data, JSON_PRETTY_PRINT);
	}

}

