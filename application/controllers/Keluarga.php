<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluarga extends CI_Controller {

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
	public function anggota_keluarga()
	{	
		if(!$this->session->userdata('sess_keluarga') || !$this->input->is_ajax_request() ){
			die("Access Denied!");
		}
		$data=array();
		$data['keluarga']=$this->session->userdata('sess_keluarga')->kwg_nama;
		$sql="select A.*, B.status_kawin
				from anggota_jemaat A 
				left join ags_sts_kawin B on B.id = A.sts_kawin
				where  A.kwg_no='".$this->session->userdata('sess_keluarga')->id."' && A.status=1 && A.sts_anggota=1
				order by A.hub_kwg ASC, A.no_urut";
		$data['anggota']=$this->m_model->selectcustom($sql);
		//$data['anggota']=$this->m_model->selectas3('kwg_no', $this->session->userdata('sess_keluarga')->id, 'status_migration', 1, 'status', 1, 'anggota_jemaat');
		$this->load->view('frontend/home/anggota_keluarga', $data);
	}

	public function view()
	{	
		if(!$this->session->userdata('sess_keluarga') || !$this->input->is_ajax_request() ){
			die("Access Denied!");
		}
		$data=array();
		//$data['keluarga']=$this->session->userdata('sess_keluarga');
		$data['wilayah']=lsWil();
		$data['keluarga']=$this->m_model->selectas('id', $this->session->userdata('sess_keluarga')->id,'keluarga_jemaat');
		$this->load->view('frontend/home/modal_keluarga', $data);
	}

	public function view_anggota()
	{	
		if(!$this->session->userdata('sess_keluarga') || !$this->input->is_ajax_request() ){
			die("Access Denied!");
		}
		$AnggotaId=$this->uri->segment(3);
		$data=array();
		//$data['keluarga']=$this->session->userdata('sess_keluarga');
		$data['wilayah']=lsWil();
		$data['AnggotaJemaat']=$this->m_model->selectas("md5(id)='".$AnggotaId."'", null, 'anggota_jemaat');
		$this->load->view('frontend/home/modal_anggota_keluarga', $data);
	}

	public function update()
	{	
		if(!$this->session->userdata('sess_keluarga')){
			die("Access Denied!");
		}
		if(!$this->input->post('keluarga_jemaat_id')){
			$this->session->set_userdata(array('status_action'=>-2, 'module'=>'update', 'msg'=>'Ooppss... Maaf, Terjadi kesalahan, coba ulangi lagi atau Hubungi Administrator!'));
			redirect(base_url().'beranda', 'location');
		}
		$param=array(
					"kwg_nama"=>$this->input->post('kwg_nama'),
					"kwg_alamat"=>$this->input->post('kwg_alamat'),
					"kwg_telepon"=>$this->input->post('kwg_telepon'),
					"user_modified "=>$this->session->userdata('sess_keluarga')->kwg_nama,
				);
		if($this->input->post('kwg_wil')!=$this->session->userdata('sess_keluarga')->kwg_wil){
			$param['kwg_wil_new']=$this->input->post('kwg_wil');
			$param['kwg_wil_approve']=0;
		}
		$update=$this->m_model->updateas('id', $this->input->post('keluarga_jemaat_id'), $param, 'keluarga_jemaat');
		if($update && !isset($param['kwg_wil_approve'])){
			$this->session->set_userdata(array('status_action'=>1, 'module'=>'update', 'msg'=>'<strong>Yeah... Berhasil</strong>, Data Kelurga Anda telah diperbarui!'));
		}
		else if($update && isset($param['kwg_wil_approve'])){
			$this->session->set_userdata(array('status_action'=>1, 'module'=>'update', 'msg'=>'<strong>Yeah... Berhasil</strong>, Data Kelurga Anda telah diperbarui dan menunggu persetujuan pergantian Wilayah!'));
		}
		else{
			$this->session->set_userdata(array('status_action'=>-1, 'module'=>'update', 'msg'=>'<strong>Ooppss... Maaf</strong>, Data Keluarga Anda gagal telah diperbarui, coba ulangi lagi atau Hubungi Administrator!'));
		}

		redirect(base_url().'beranda', 'location');
	}


	/*function akun_kk(){
		if(!$this->session->userdata('sess_keluarga') || !$this->input->is_ajax_request() ){
			die("Access Denied!");
		}
		$AnggotaId=$this->uri->segment(3);
		$data=array();

		$this->load->view()
	}*/
}
?>