<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

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
	public function index()
	{
		$data=array();
		/*$status_login=$this->session->userdata('status_login');
		if(($status_login && $status_login=='success') || $this->session->userdata('userdata')){
			$data['wilayah']=$this->m_model->selectas('id>0',NULL, 'wilayah');
			$query1="select COUNT(A.id) as NUM_keluarga, sum(A.num_anggota) as NUM_jiwa, A.kwg_wil from keluarga_jemaat A where A.status_migration=1 && A.status =1 group by A.kwg_wil";

			$perwilayah=$this->m_model->selectcustom($query1);

			$query2="select COUNT(A.id) as NUM_keluarga, sum(A.num_anggota) as NUM_jiwa, A.kwg_wil from ags_kwg_table A where A.status =1 group by A.kwg_wil";

			$perwilayah_old=$this->m_model->selectcustom($query2);
			$data['sumKK']=0;
			$data['sumjiwa']=0;
			$data['sumKKOld']=0;
			$data['sumjiwaOld']=0;
			foreach ($perwilayah as $key => $value) {
				# code...
				$data['perwilayah'][$value->kwg_wil]=$value;
				$data['sumKK']=$data['sumKK']+$value->NUM_keluarga;
				$data['sumjiwa']=$data['sumjiwa']+$value->NUM_jiwa;
			}

			foreach ($perwilayah_old as $keyperwilayah_old => $valueperwilayah_old) {
				# code...
				$data['perwilayahOld'][$valueperwilayah_old->kwg_wil]=$valueperwilayah_old;
				$data['sumKKOld']=$data['sumKKOld']+$valueperwilayah_old->NUM_keluarga;
				$data['sumjiwaOld']=$data['sumjiwaOld']+$valueperwilayah_old->NUM_jiwa;
			}

			$query3="select A.*, B.name from keluarga_jemaat A join ags_users B on  (A.created_user = B.username) order by A.id DESC limit 10 ";
			$data['lastinput']=$this->m_model->selectcustom($query3);
			$this->load->view('admin/home/dashboard', $data);
		}
		else{
			header('Location:'.base_url().'login/');
		}*/
		//print_r($this->session->userdata());

		if(!$this->session->userdata('sess_token_valid') || $this->session->userdata('sess_token_valid') == -1){
			redirect(base_url().'login/keluarga');
		}
		else{
			//get lock pemilihan
			$slockpemilihan=$this->m_model->selectas2('tahun_pemilihan', date('Y'), 'tipe_pemilihan', 2, 'lock_pemilihan');
			$data['lockpemilihan']=$slockpemilihan;
			$this->load->view('frontend/home/index', $data);
		}
	}
}
?>