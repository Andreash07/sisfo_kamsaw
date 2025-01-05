<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$status_login=$this->session->userdata('status_login');
		if(($status_login && $status_login=='success') || $this->session->userdata('userdata')){
			$data['wilayah']=$this->m_model->selectas('id>0',NULL, 'wilayah');
			$query1="select COUNT(A.id) as NUM_keluarga, sum(A.num_anggota) as NUM_jiwa, A.kwg_wil from keluarga_jemaat A where  A.status =1 group by A.kwg_wil"; //A.status_migration=1 &&
			//status migration di hilangkan karena sudah banyak yang di input tidak dari migrasi, yang penting status anggota aktif

			$perwilayah=$this->m_model->selectcustom($query1);

			$query2="select COUNT(A.id) as NUM_keluarga, sum(A.num_anggota) as NUM_jiwa, A.kwg_wil from ags_kwg_table A where A.status =1 group by A.kwg_wil";

			$perwilayah_old=$this->m_model->selectcustom($query2);
			$data['sumKK']=0;
			$data['sumjiwa']=0;
			$data['sumKKOld']=0;
			$data['sumKKOld_label']=0;
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

			$data['sumKKOld_label']=$data['sumKKOld'];
			if($data['sumKKOld']<$data['sumKK']){
				$data['sumKKOld']=$data['sumKK'];
			}

			$query3="select A.*, B.name from keluarga_jemaat A join ags_users B on  (A.created_user = B.username) order by A.id DESC limit 10 ";
			$data['lastinput']=$this->m_model->selectcustom($query3);

			// dapetin tanggal dalam seminggu
			$get_dateInWeek=get_dateInWeek(date('N'));
			$where4=" && DATE_FORMAT(A.tgl_lahir, '%m-%d') >='".$get_dateInWeek['date_from']."'  && DATE_FORMAT(A.tgl_lahir, '%m-%d') <='".$get_dateInWeek['date_to']."' ";

			if($get_dateInWeek['year_from'] != $get_dateInWeek['year_to'] ){
				//$get_dateInWeek['date_to']='12-31';

				$where4=" && ( (DATE_FORMAT(A.tgl_lahir, '%m-%d') >='".$get_dateInWeek['date_from']."'  && DATE_FORMAT(A.tgl_lahir, '%m-%d') <='12-31') || (DATE_FORMAT(A.tgl_lahir, '%m-%d') >='01-01'  && DATE_FORMAT(A.tgl_lahir, '%m-%d') <='".$get_dateInWeek['date_to']."') ) ";
			}

			$query4="select A.id, A.kwg_wil, A.nama_lengkap, A.sts_kawin, A.jns_kelamin, A.tgl_lahir,  DATE_FORMAT(A.tgl_lahir, '%d %b') as tgl_ulang_tahun,  DATE_FORMAT(A.tgl_lahir, '%m-%d') as date_lahir
					from anggota_jemaat A 
					where A.status =1 && A.sts_anggota =1 ".$where4."
					order by DATE_FORMAT(A.tgl_lahir, '%m-%d') ASC, A.nama_lengkap ASC";
					//die($query4 ."asjdaksd");

			$dataUlangTahun=$this->m_model->selectcustom($query4);
			$data['date_name_from']=$get_dateInWeek['date_name_from'];
			$data['date_name_to']=$get_dateInWeek['date_name_to'];
			$data['year_from']=$get_dateInWeek['year_from'];
			$data['year_to']=$get_dateInWeek['year_to'];

			$data['ls_date']=array();
			$data['ls_hbd']=array();
			foreach ($dataUlangTahun as $key => $value) {
				# code...
				if(strtotime($value->tgl_ulang_tahun)  < strtotime($get_dateInWeek['date_from'])){
					$year=date('y')+1;
				}
				else{
					$year=date('y');
				}
				$value->year=$year;
				$data['ls_date'][$value->tgl_ulang_tahun." '".$year]=$value;
				$data['ls_hbd'][$value->tgl_ulang_tahun." '".$year][]=$value;

			}

			// dapetin tanggal dalam seminggu
			$get_dateInWeek=get_dateInWeek(date('N'),2);
			//if($get_dateInWeek['date_to'] == '01-05'){
			$where41=" && DATE_FORMAT(A.tgl_lahir, '%m-%d') >='".$get_dateInWeek['date_from']."'  && DATE_FORMAT(A.tgl_lahir, '%m-%d') <='".$get_dateInWeek['date_to']."' ";

			if($get_dateInWeek['year_from'] != $get_dateInWeek['year_to'] ){
				$where41=" && ( (DATE_FORMAT(A.tgl_lahir, '%m-%d') >='".$get_dateInWeek['date_from']."'  && DATE_FORMAT(A.tgl_lahir, '%m-%d') <='12-31') || (DATE_FORMAT(A.tgl_lahir, '%m-%d') >='01-01'  && DATE_FORMAT(A.tgl_lahir, '%m-%d') <='".$get_dateInWeek['date_to']."') ) ";
			}

			$query41="select A.id, A.kwg_wil, A.nama_lengkap, A.sts_kawin, A.jns_kelamin, A.tgl_lahir,  DATE_FORMAT(A.tgl_lahir, '%d %b') as tgl_ulang_tahun,  DATE_FORMAT(A.tgl_lahir, '%m-%d') as date_lahir
					from anggota_jemaat A 
					where A.sts_anggota =1 && A.status =1 ".$where41."
					order by DATE_FORMAT(A.tgl_lahir, '%m-%d') ASC, A.nama_lengkap ASC";
					//die($query41);

			$dataUlangTahun1=$this->m_model->selectcustom($query41);
			$data['date_name_from1']=$get_dateInWeek['date_name_from'];
			$data['date_name_to1']=$get_dateInWeek['date_name_to'];

			$data['year_from1']=$get_dateInWeek['year_from'];
			$data['year_to1']=$get_dateInWeek['year_to'];

			$data['ls_date1']=array();
			$data['ls_hbd1']=array();
			foreach ($dataUlangTahun1 as $key => $value) {
				# code...
				if(strtotime($value->tgl_ulang_tahun)  < strtotime($get_dateInWeek['date_from'])){
					$year=date('y')+1;
				}
				else{
					$year=date('y');
				}
				$value->year=$year;
				$data['ls_date1'][$value->tgl_ulang_tahun." '".$year]=$value;
				$data['ls_hbd1'][$value->tgl_ulang_tahun." '".$year][]=$value;

			}


			$s="select  A.*, B.kwg_nama, B.kwg_wil, C.num_kpkp
				from kpkp_keluarga_jemaat A 
				join keluarga_jemaat B on B.id = A.keluarga_jemaat_id
				join (select kwg_no, count(id) as num_kpkp from anggota_jemaat where sts_anggota=1 && sts_anggota=1 && status=1 group by kwg_no) C on C.kwg_no = B.id
				where B.status=1 && A.saldo_akhir <0
				";
			$s="select  A.*, B.kwg_nama, B.kwg_wil, C.num_kpkp as num_kpkp_inti, IF(D.num_kpkp is null, 0, D.num_kpkp)  as num_kpkp_tambahan, (C.num_kpkp + IF(D.num_kpkp is null, 0, D.num_kpkp)) as num_kpkp
				from kpkp_keluarga_jemaat A 
				join keluarga_jemaat B on B.id = A.keluarga_jemaat_id
				join (select kwg_no, count(id) as num_kpkp from anggota_jemaat where sts_anggota=1 && sts_anggota=1 && status=1 group by kwg_no) C on C.kwg_no = B.id
				left join (select kwg_no_kpkp, count(id) as num_kpkp from anggota_jemaat where sts_anggota=1 && sts_anggota=1 && status=1 group by kwg_no_kpkp) D on D.kwg_no_kpkp = B.id
				where B.status=1 && A.saldo_akhir <0
				";
			$q=$this->m_model->selectcustom($s);// die($s);
			$bulan3=0;
			$bulan6=0;
			$bulan12=0;
			$bulan36=0;

			$bulan3_ls=array();
			$bulan6_ls=array();
			$bulan12_ls=array();
			$bulan36_ls=array();

			$bulan3_ls[]=0;
			$bulan6_ls[]=0;
			$bulan12_ls[]=0;
			$bulan36_ls[]=0;

			$total_biayaKPKP=0;

			foreach ($q as $key => $value) {
				// code...
				$total_biayaKPKP=$value->num_kpkp * 5000;
				$bulan_tertampung=countBulanTercover($total_biayaKPKP, $value->saldo_akhir, date('Y-m'));
				//echo $value->kwg_nama." ".$bulan_tertampung['num_month'];
				if($bulan_tertampung['num_month'] >= -3){
					$bulan3++;
					$bulan3_ls[]= $value->keluarga_jemaat_id;
			
				}
				else if($bulan_tertampung['num_month'] > -12){
					$bulan6++;
					$bulan6_ls[]=$value->keluarga_jemaat_id;
			
				}
				else if($bulan_tertampung['num_month'] <= -12 && $bulan_tertampung['num_month'] > -36){
					$bulan12++;
					$bulan12_ls[]=$value->keluarga_jemaat_id;
				}
				else if($bulan_tertampung['num_month'] <= -36){
					$bulan36++;
					$bulan36_ls[]=$value->keluarga_jemaat_id;
				}

			}

			$data['kpkpbulan3']=$bulan3;
			$data['kpkpbulan6']=$bulan6;
			$data['kpkpbulan12']=$bulan12;
			$data['kpkpbulan36']=$bulan36;


			$data['kpkpbulan3_ls']=$bulan3_ls;
			$data['kpkpbulan6_ls']=$bulan6_ls;
			$data['kpkpbulan12_ls']=$bulan12_ls;
			$data['kpkpbulan36_ls']=$bulan36_ls;


			$this->load->view('admin/home/dashboard', $data);
		}
		else{
			header('Location:'.base_url().'login/');
		}
	}
}
