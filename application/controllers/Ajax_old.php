<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Ajax extends CI_Controller {



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



	public function get_keluarga(){

		$data=array();

		$keyword=clearText(strtolower($this->input->post('keyword_keluarga')));

		//ini viewnya ditentukan dari kiriman form

		$view=clearText(strtolower($this->input->post('view')));

		//get kk by keyword

		if($keyword==null){

			die("Tolong ketikan nama keluarga/anggota jemaat...");

		}



		$q="select A.id, A.kwg_nama, B.nama_lengkap, B.hub_kwg, C.hub_keluarga, COUNT(B.id) as num_anggota, A.kwg_wil, D.wilayah, B.id as jemaat_id, B.tgl_lahir

				from keluarga_jemaat A 

				join anggota_jemaat B on B.kwg_no = A.id 

				join ags_hub_kwg C on C.idhubkel = B.hub_kwg

				left join wilayah D on D.id = A.kwg_wil

				where lower(A.kwg_nama) like '%".$keyword."%' || lower(B.nama_lengkap) like '%".$keyword."%' && A.status=1

				group by A.id"; //die($q);

		$data['keluarga']=$this->m_model->selectcustom($q);

		$data['keyword']=$this->input->post('keyword_keluarga');



		$this->load->view($view, $data);

	}





	public function get_angjem(){

		$data=array();

		$jemaat_id=clearText(strtolower($this->input->post('kwg_id')));

		//ini viewnya ditentukan dari kiriman form

		$view=clearText(strtolower($this->input->post('view')));

		//get kk by keyword

		if($jemaat_id==null){

			die("Parameter Invalid");

		}

		$post=array();

		foreach ($this->input->post() as $key => $value) {

			# code...

			if($key!='view'){

				$post[$key]=$value;

			}

		}

		if(count($post)>0){

			$data['angjem'][0]=(object) $post;

		}

		$data['ls_kawin']=lsKawin();

		$data['ls_hubkwg']=lshubkwg();



		$this->load->view($view, $data);

	}

	public function save_no_urut(){
		$no_urut=$this->input->post('no_urut');
		$anggota_id=$this->input->post('recid');
		$this->m_model->updateas('id', $anggota_id, array('no_urut'=>$no_urut),'anggota_jemaat' );
	}

	public function list_calon_penatua(){
		$id_pemilih=$this->input->get('id');
		$wil_pemilih=$this->input->get('kwg_wil');
		$nama_pemilih=rawurldecode($this->input->get('nama'));
		$tahun_pemilihan=date('Y');
		$data=array();
		$data['nama_pemilih']=$nama_pemilih;
		$data['id_pemilih']=$id_pemilih;
		$data['wil_pemilih']=$wil_pemilih;
		$data['hak_suara']=10;
		//get all calon penatua perwilayah
		$sql="select A.*, B.status_kawin, count(C.id) as voted, C.locked
				from anggota_jemaat A 
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap1 C on C.id_calon1 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				where  A.kwg_wil='".$wil_pemilih."'  && A.sts_anggota=1 && A.status=1 && A.status_pn1=1 && A.status_sidi=1 
				group by A.id
				order by voted DESC, A.nama_lengkap"; //die($sql);
		//&& YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF('2022-04-03', A.tgl_lahir)/365 >=25 && DATEDIFF('2022-04-03', A.tgl_lahir)/365 <=65
		$data['calon']=$this->m_model->selectcustom($sql);

		//get calon terpilih
		/*$q1="select A.id, A.id_calon1, COUNT(A.id) as num_pilih
				from votes_tahap1 A 
				where id_pemilih='".$id_pemilih."'
				group by id_calon1";
		$calon_voted=$this->m_model->selectcustom($q1);
		$data['calon_voted']=array();
		foreach ($calon_voted as $key => $value) {
			# code...
			$data['calon_voted'][$value->id_calon1]=$value;
		}*/

		$this->load->view('frontend/mjppj/list_calon_penatua', $data);
	}

	public function list_calon_penatua2(){
		$id_pemilih=$this->input->get('id');
		$wil_pemilih=$this->input->get('kwg_wil');
		$nama_pemilih=rawurldecode($this->input->get('nama'));
		$tahun_pemilihan=date('Y');
		$where="";
		$param_active="?";
		$data=array();
		$data['nama_pemilih']=$nama_pemilih;
		$data['id_pemilih']=$id_pemilih;
		$data['wil_pemilih']=$wil_pemilih;
		$data['hak_suara_wil']=2;
		$data['hak_suara_mix']=3;
		$data['hak_suara']=$data['hak_suara_wil']+$data['hak_suara_mix'];
		$numLimit=20;
        $numStart=0;
        if($this->input->get('keyword')){
        	$keyword=clearText($this->input->get('keyword'));
        	$where=" && LOWER(A.nama_lengkap) like '%".strtolower($keyword)."%'";
			$param_active="keyword=".$this->input->get('keyword');	
        }


        if(!$this->input->get('page')){
        	//kkalau masuk ini bearti  bukan dari klik page
            $page=1;
            $numStart=($numLimit*$page)-$numLimit;
	        $limit="";
        }
        else{
        	//dari click page
            $page=$this->input->get('page');
            $numStart=($numLimit*$page)-$numLimit;

	        $limit='LIMIT '.$numStart.', '.$numLimit;
        }

        $data['page']=$page;
		//get all calon penatua perwilayah
        /*start get data */
		$get_data=$this->get_data_calon_penatua2($tahun_pemilihan, $id_pemilih, $where, $limit);
        
        


    	$num_voted=0;
    	$num_voted_wil_pemilih=0;
    	$num_voted_wil_mix=0;
    	foreach ($get_data as $key => $value) {
    		# code...
    		if($value->voted2>0){
    			$num_voted++;

    			if($value->kwg_wil == $this->session->userdata('sess_keluarga')->kwg_wil ){
	    			$num_voted_wil_pemilih++;
	    		}
	    		else if($value->kwg_wil != $this->session->userdata('sess_keluarga')->kwg_wil){
	    			$num_voted_wil_mix++;
	    		}

    		}

    	}

        if(!$this->input->get('page')){

        	$data['totalofData']=count($get_data);
        	//echo $data['totalofData'];
            $page_active=1;
            $param_active=base_url().'ajax/list_calon_penatua2'.$param_active;
        	$data['pagingnation']=pagingnation_materialTheme($data['totalofData'], $numLimit, $page_active, $param_active, $links=2);
        	if($page>1){
	            array_splice($get_data, 0, $numStart);
	            array_splice($get_data,$numLimit );
	        }
	        else{
	            array_splice($get_data, $numStart+$numLimit);
	        }

        }else{
            $page_active=$this->input->get('page');
        }


		$data['num_voted']=$num_voted;
		$data['num_voted_wil_pemilih']=$num_voted_wil_pemilih;
		$data['num_voted_wil_mix']=$num_voted_wil_mix;
		$data['calon']=$get_data;


		

    	if(!$this->input->get('view') && !$this->input->post('view')){
			$this->load->view('frontend/mjppj/list_calon_penatua2', $data);
		}
    	else{
			$this->load->view('ajax/list_calon2', $data);
    	}
	}

	private function get_data_calon_penatua2($tahun_pemilihan, $id_pemilih, $where, $limit){
		$sql="select A.*, B.status_kawin, count(D.id) as terpilih1, D.status as status_acc, Count(C.id) as voted2, A.kwg_wil, COUNT(C.id) as voted, C.locked
				from anggota_jemaat A 
				join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap2 C on C.id_calon2 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				where  A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 >=25 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 <=65 && D.status = 1
				"; 
		//die($sql);
		$group_by=" group by A.id ";
        $field_order=" order by voted DESC, A.nama_lengkap  ";
        $order_by=" ASC ";
        $get_data=$this->m_model->selectcustom($sql." ".$where." ".$group_by." ".$field_order." ".$order_by." ".$limit);
        //die($sql." ".$where." ".$group_by." ".$field_order." ".$order_by." ".$limit);
        return $get_data;
	}

	public function list_calon_ppj(){
		$id_pemilih=$this->input->get('id');
		$wil_pemilih=$this->input->get('kwg_wil');
		$nama_pemilih=rawurldecode($this->input->get('nama'));
		$tahun_pemilihan=date('Y');
		$data=array();
		$data['nama_pemilih']=$nama_pemilih;
		$data['id_pemilih']=$id_pemilih;
		$data['wil_pemilih']=$wil_pemilih;
		$data['hak_suara']=10;
		//get all calon penatua perwilayah
		$sql="select A.*, B.status_kawin, count(C.id) as voted, C.locked
				from anggota_jemaat A 
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap_ppj C on C.id_calon1 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				where A.sts_anggota=1 && A.status_sidi=1 && A.status=1 && A.status_ppj=1
				group by A.id
				order by voted DESC, A.nama_lengkap ASC, A.kwg_wil ASC"; //die($sql);
				//&& YEAR(A.tgl_lahir) < 2005 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 >=25 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 <=65
				//  A.kwg_wil='".$wil_pemilih."'  && 
		$data['calon']=$this->m_model->selectcustom($sql);

		$this->load->view('frontend/mjppj/list_calon_ppj', $data);
	}

	public function get_pertumbuhanJemaat(){
		//sleep ( 5 );
		$data=array();
		$type=$this->input->post('type');
		$group=$this->input->post('group');
		$tahun=date('Y');
		if($this->input->post('tahun')){
			$tahun=$this->input->post('tahun');
		}
		//$tahun='2019';

		$sql="select COUNT(A.id) as num, 'meninggal' as label, B.initials as bulan, B.id as id_bulan
				from bulan B
				left join anggota_jemaat A  on B.initials = DATE_FORMAT(A.tgl_meninggal, '%b') && A.tgl_meninggal != '0000-00-00' && YEAR(A.tgl_meninggal) = '".$tahun."' && A.status=1 
				group by bulan

				UNION ALL 
				select COUNT(A.id) as num, 'lahir' as label, B.initials as bulan , B.id as id_bulan
				from bulan B
				left join anggota_jemaat A  on B.initials = DATE_FORMAT(A.tgl_lahir, '%b') && A.tgl_lahir != '0000-00-00' && YEAR(A.tgl_lahir) = '".$tahun."' && A.status=1 
				group by bulan
				order by label ASC, id_bulan ASC
				";
		$q=$this->m_model->selectcustom($sql);
		$data['labels']=array();
		foreach ($q as $key => $value) {
			# code...
			$data[$value->label][]=$value->num;
			if(!in_array($value->bulan, $data['labels'])){
				$data['labels'][]=$value->bulan;
			}
		}

		if($type=='json'){
			echo json_encode($data);
		}
	}

	public function get_pertumbuhanJemaat_perTahun(){
		//sleep ( 5 );
		$data=array();
		$type=$this->input->post('type');
		$group=$this->input->post('group');
		$tahun=date('Y');
		if($this->input->post('tahun')){
			$tahun=$this->input->post('tahun');
		}
		//$tahun='2019';

		$sql="select COUNT(A.id) as num, 'meninggal' as label, B.name as tahun
				from tahun B 
				left join anggota_jemaat A on B.name=DATE_FORMAT(A.tgl_meninggal, '%Y') && A.tgl_meninggal != '0000-00-00'  && A.status=1
				where  B.name >= ".$tahun."-5 && B.name <= '".$tahun."'
				group by tahun

				UNION ALL 
				select COUNT(A.id) as num, 'lahir' as label, B.name as tahun
				from tahun B 
				left join anggota_jemaat A on B.name=DATE_FORMAT(A.tgl_lahir, '%Y') && A.tgl_lahir != '0000-00-00'  && A.status=1
				where B.name >= ".$tahun."-5 && B.name <= '".$tahun."'
				group by tahun
				order by label ASC, tahun ASC
				";
		//die($sql);
		$q=$this->m_model->selectcustom($sql);
		$data['labels']=array();
		foreach ($q as $key => $value) {
			# code...
			$data[$value->label][]=$value->num;
			if(!in_array($value->tahun, $data['labels'])){
				$data['labels'][]=$value->tahun;
			}
		}

		if($type=='json'){
			echo json_encode($data);
		}
	}


}

