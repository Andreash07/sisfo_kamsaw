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



		$q="select A.id, A.kwg_nama, B.nama_lengkap, B.hub_kwg, C.hub_keluarga, COUNT(B.id) as num_anggota, A.kwg_wil, D.wilayah, B.id as jemaat_id, B.tgl_lahir, B.sts_kpkp

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

		$data['tahun_pemilihan']=array();
		$tahun_pemilihan=$this->m_model->selectcustom('SELECT * FROM `tahun_pemilihan` order by tahun ASC');
		$data['tahun_pemilihan_semua']=$tahun_pemilihan;
		foreach ($tahun_pemilihan as $key => $value) {
			// code...
			#echo $key;
			$data['tahun_pemilihan']=$value;
			$data['tahunpemilihan']=$value->tahun;
			if($value->tahun == $this->input->get('tahunpemilihan')){
				break;
			}
			//ini bearti tahun pemiilhannya ambil yg dilooping terakhir
			$tahun_pemilihan=$data['tahunpemilihan'];
		}


		$data['nama_pemilih']=$nama_pemilih;
		$data['id_pemilih']=$id_pemilih;
		$data['wil_pemilih']=$wil_pemilih;
		$data['hak_suara_wanita']=4;
		$data['hak_suara_pria']=4;
		$data['hak_suara']=$data['hak_suara_wanita']+$data['hak_suara_pria'];
		//$data['hak_suara']=4;
		//get all calon penatua perwilayah
		$sql="select A.*, B.status_kawin, count(C.id) as voted, C.locked
				from anggota_jemaat A 
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap1 C on C.id_calon1 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				join anggota_jemaat_bakal_calon D on D.anggota_jemaat_id = A.id
				where  A.kwg_wil='".$wil_pemilih."'  && A.sts_anggota=1 && A.status=1 && D.status_pn1=1 && A.status_sidi=1 && A.kwg_no !=0
				group by A.id
				order by voted DESC, A.nama_lengkap"; #die(nl2br($sql));
		//&& YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF('2022-04-03', A.tgl_lahir)/365 >=25 && DATEDIFF('2022-04-03', A.tgl_lahir)/365 <=65
		$data['calon']=$this->m_model->selectcustom($sql);

		$num_voted=0;
    	$num_voted_pria=0;
    	$num_voted_wanita=0;
    	foreach ($data['calon'] as $key => $value) {
    		# code...
    		if($value->voted>0){
    			$num_voted++;

    			if($value->jns_kelamin == 'L'){
	    			$num_voted_pria++;
	    		}
	    		else if($value->jns_kelamin == 'P'){
	    			$num_voted_wanita++;
	    		}

    		}

    	}

    	$data['num_voted']=$num_voted;
		$data['num_voted_pria']=$num_voted_pria;
		$data['num_voted_wanita']=$num_voted_wanita;

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

	public function list_calon_penatua_review(){
		if(!$this->input->get('token')){
			die("Token Invalid, Access Denied!");
		}

		$token=$this->input->get('token');
		$wil_pemilih=$this->input->get('kwg_wil');
		$tahun_pemilihan=date('Y');
		$data=array();

		$data['tahun_pemilihan']=array();
		$tahun_pemilihan=$this->m_model->selectcustom('SELECT * FROM `tahun_pemilihan` order by tahun ASC');
		$data['tahun_pemilihan_semua']=$tahun_pemilihan;
		foreach ($tahun_pemilihan as $key => $value) {
			// code...
			#echo $key;
			$data['tahun_pemilihan']=$value;
			$data['tahunpemilihan']=$value->tahun;
			if($value->tahun == $this->input->get('tahunpemilihan')){
				break;
			}
			//ini bearti tahun pemiilhannya ambil yg dilooping terakhir
			$tahun_pemilihan=$data['tahunpemilihan'];
		}

		$data['wil_pemilih']=$wil_pemilih;
		$data['hak_suara_wanita']=4;
		$data['hak_suara_pria']=4;
		$data['hak_suara']=$data['hak_suara_wanita']+$data['hak_suara_pria'];
		//$data['hak_suara']=4;
		//get all calon penatua perwilayah
		$sql="select A.*, B.status_kawin, '0' as voted, '1' as locked
				from anggota_jemaat A 
				left join ags_sts_kawin B on B.id = A.sts_kawin
				join anggota_jemaat_bakal_calon D on D.anggota_jemaat_id = A.id
				where  md5(CONCAT('hasg2&^!#',A.kwg_wil))='".$token."'  && A.sts_anggota=1 && A.status=1 && D.status_pn1=1 && A.status_sidi=1 && A.kwg_no !=0
				group by A.id
				order by voted DESC, A.nama_lengkap"; //die($sql);
		//&& YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF('2022-04-03', A.tgl_lahir)/365 >=25 && DATEDIFF('2022-04-03', A.tgl_lahir)/365 <=65
		$data['calon']=$this->m_model->selectcustom($sql);

		$num_voted=0;
    	$num_voted_pria=0;
    	$num_voted_wanita=0;
    	foreach ($data['calon'] as $key => $value) {
    		# code...
    		if($value->voted>0){
    			$num_voted++;

    			if($value->jns_kelamin == 'L'){
	    			$num_voted_pria++;
	    		}
	    		else if($value->jns_kelamin == 'P'){
	    			$num_voted_wanita++;
	    		}

    		}

    	}

    	$data['num_voted']=$num_voted;
		$data['num_voted_pria']=$num_voted_pria;
		$data['num_voted_wanita']=$num_voted_wanita;

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

		$this->load->view('frontend/mjppj/list_calon_penatua_review', $data);
	}

	public function list_calon_penatua2(){
		$id_pemilih=$this->input->get('id');
		$wil_pemilih=$this->input->get('kwg_wil');
		$filter_wilayah=$this->input->get('filter_wilayah');
		$nama_pemilih=rawurldecode($this->input->get('nama'));
		$tahun_pemilihan=date('Y');
		$where="";
		$param_active="?";
		$data=array();
		
		$data['tahun_pemilihan']=array();
		$tahun_pemilihan=$this->m_model->selectcustom('SELECT * FROM `tahun_pemilihan` order by tahun DESC limit 1');
		$data['tahun_pemilihan_semua']=$tahun_pemilihan;
		foreach ($tahun_pemilihan as $key => $value) {
			// code...
			#echo $key;
			$data['tahun_pemilihan']=$value;
			$data['tahunpemilihan']=$value->tahun;
			if($value->tahun == $this->input->get('tahunpemilihan')){
				break;
			}
			//ini bearti tahun pemiilhannya ambil yg dilooping terakhir
			$tahun_pemilihan=$data['tahunpemilihan'];
		}


		$data['filter_wilayah']=$filter_wilayah;
		$data['nama_pemilih']=$nama_pemilih;
		$data['id_pemilih']=$id_pemilih;
		$data['wil_pemilih']=$wil_pemilih;
		$data['hak_suara_wil']=4;
		$data['hak_suara_wil_l']=2;
		$data['hak_suara_wil_p']=2;

		$data['hak_suara_mix']=4;
		$data['hak_suara_mix_l']=2;
		$data['hak_suara_mix_p']=2;
		$data['hak_suara']=$data['hak_suara_wil']+$data['hak_suara_mix'];
		$numLimit=20;
        $numStart=0;
        if($this->input->get('keyword')){
        	$keyword=clearText($this->input->get('keyword'));
        	$where=" && LOWER(A.nama_lengkap) like '%".strtolower($keyword)."%'";
			$param_active.="keyword=".$this->input->get('keyword')."&";	
        }
        if($this->input->get('filter_wilayah') && $this->input->get('filter_wilayah') !=0){
        	$filter_wilayah=clearText($this->input->get('filter_wilayah'));
        	$where.=" && A.kwg_wil = '".$this->input->get('filter_wilayah')."'";
			$param_active.="filter_wilayah=".$this->input->get('filter_wilayah')."&";	
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
		$get_data=$this->get_data_calon_penatua2($tahun_pemilihan, $id_pemilih, $where, $limit, $wil_pemilih);
        
        


    	$num_voted=0;
    	$num_voted_wil_pemilih=0;
    	$num_voted_wil_l=0;
    	$num_voted_wil_p=0;

    	$num_voted_wil_mix=0;
    	$num_voted_wil_mix_l=0;
    	$num_voted_wil_mix_p=0;
    	foreach ($get_data as $key => $value) {
    		# code...
    		if($value->voted2>0){
    			$num_voted++;

    			if($value->kwg_wil == $wil_pemilih ){
	    			$num_voted_wil_pemilih++;
	    			if (strtolower($value->jns_kelamin)=='l') {
	    				// code...
	    				$num_voted_wil_l++;
	    			}
	    			else if (strtolower($value->jns_kelamin)=='p') {
	    				// code...
	    				$num_voted_wil_p++;
	    			}
	    		}
	    		else if($value->kwg_wil != $wil_pemilih){
	    			$num_voted_wil_mix++;
	    			if (strtolower($value->jns_kelamin)=='l') {
	    				// code...
	    				$num_voted_wil_mix_l++;
	    			}
	    			else if (strtolower($value->jns_kelamin)=='p') {
	    				// code...
	    				$num_voted_wil_mix_p++;
	    			}
	    		}

    		}

    	}

        if(!$this->input->get('page')){

        	$data['totalofData']=count($get_data);
        	//echo $data['totalofData'];
            $page_active=1;
            $param_active=base_url().'ajax/list_calon_penatua2'.$param_active;
        	$data['pagingnation']=pagingnation_materialTheme_noNav($data['totalofData'], $numLimit, $page_active, $param_active, $links=2);
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

		$data['num_voted_wil_l']=$num_voted_wil_l;
    	$data['num_voted_wil_p']=$num_voted_wil_p;

    	$data['num_voted_wil_mix_l']=$num_voted_wil_mix_l;
    	$data['num_voted_wil_mix_p']=$num_voted_wil_mix_p;

		$data['calon']=$get_data;


		

    	if(!$this->input->get('view') && !$this->input->post('view')){
			$this->load->view('frontend/mjppj/list_calon_penatua2', $data);
		}
		else if($this->input->get('surat_suara') ==1){
			$this->load->view('ajax/list_calon2_srt', $data);
		}
    	else{
			$this->load->view('ajax/list_calon2', $data);
    	}
	}

	private function get_data_calon_penatua2($tahun_pemilihan, $id_pemilih, $where, $limit, $wil_pemilih=null){
		$sql="select A.*, B.status_kawin, count(D.id) as terpilih1, D.status as status_acc, Count(C.id) as voted2, A.kwg_wil, COUNT(C.id) as voted, C.locked
				from anggota_jemaat A 
				join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap2 C on C.id_calon2 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				where  A.sts_anggota=1 && A.status=1  && A.status_sidi=1 && D.status = 1
				";
				#where  A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 >=25 && D.status = 1

		$group_by=" group by A.id ";
        //$field_order=" order by voted DESC, A.nama_lengkap  ";
        //$field_order=" order by voted DESC, D.persen_vote DESC, D.last_vote ASC";
        $field_order=" order by A.kwg_wil ASC,  D.persen_vote DESC"; #voted DESC, D.last_vote ASC,
        #$field_order=" order by A.kwg_wil ASC, A.nama_lengkap ASC";

		$sql="select  W.num_row, W.nama_lengkap, W.jns_kelamin, W.tgl_lahir, W.kwg_no, W.foto, W.foto_thumb, W.status_kawin, W.terpilih1, W.status_acc, W.voted2, W.kwg_wil, W.voted, W.locked, W.sts_kawin, W.id from
			(select @rownum := @rownum + 1 AS num_row,  Y.nama_lengkap, Y.jns_kelamin, Y.tgl_lahir, Y.kwg_no, Y.foto, Y.foto_thumb, Y.status_kawin, Y.terpilih1, Y.status_acc, Y.voted2, Y.kwg_wil, Y.voted, Y.locked, Y.sts_kawin, Y.id from (
				select Z.nama_lengkap, Z.jns_kelamin, Z.tgl_lahir, Z.kwg_no, Z.foto, Z.foto_thumb, Z.status_kawin, Z.terpilih1, Z.status_acc, Z.voted2, Z.kwg_wil, Z.voted, Z.locked, Z.sts_kawin, Z.id
				from ( select A.nama_lengkap, A.jns_kelamin, A.tgl_lahir, A.kwg_no, A.foto, A.foto_thumb, B.status_kawin, count(D.id) as terpilih1, D.status as status_acc, Count(C.id) as voted2, A.kwg_wil, COUNT(C.id) as voted, C.locked, A.sts_kawin, A.id
				from anggota_jemaat A 
				join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap2 C on C.id_calon2 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				where  A.sts_anggota=1 && A.status=1  && A.status_sidi=1 && D.status = 1 && A.kwg_wil = '".$wil_pemilih."' && D.tahun_pemilihan='".$tahun_pemilihan."' ".$where." ".$group_by." ".$field_order."
				) Z

				UNION ALL
				select Z.nama_lengkap, Z.jns_kelamin, Z.tgl_lahir, Z.kwg_no, Z.foto, Z.foto_thumb, Z.status_kawin, Z.terpilih1, Z.status_acc, Z.voted2, Z.kwg_wil, Z.voted, Z.locked, Z.sts_kawin, Z.id
				from (

				select A.nama_lengkap, A.jns_kelamin, A.tgl_lahir, A.kwg_no, A.foto, A.foto_thumb, B.status_kawin, count(D.id) as terpilih1, D.status as status_acc, Count(C.id) as voted2, A.kwg_wil, COUNT(C.id) as voted, C.locked, A.sts_kawin, A.id
				from anggota_jemaat A 
				join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap2 C on C.id_calon2 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				where  A.sts_anggota=1 && A.status=1 && A.status_sidi=1 && D.status = 1 && A.kwg_wil != '".$wil_pemilih."' && D.tahun_pemilihan='".$tahun_pemilihan."' ".$where." ".$group_by." ".$field_order.") Z
				) Y, (SELECT @rownum := 0) r) W
				order by W.voted DESC, W.num_row ASC
				
				"; 
				//&& DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 <=65
		#die(nl2br($sql));
        $order_by="  ";
        //die($sql." ".$group_by." ".$field_order." ".$order_by." ".$limit);
        //$get_data=$this->m_model->selectcustom($sql." ".$group_by." ".$field_order." ".$order_by." ".$limit);
        $get_data=$this->m_model->selectcustom($sql." ".$limit);
        return $get_data;
	}

	public function list_calon_ppj(){
		$id_pemilih=$this->input->get('id');
		$wil_pemilih=$this->input->get('kwg_wil');
		$nama_pemilih=rawurldecode($this->input->get('nama'));
		#$tahun_pemilihan=date('Y'); //ini sudah tidak terpakai lagi, sudah pakai tahun berjalan saja

		$data=array();
		$data['tahun_pemilihan']=array();
		$tahun_pemilihan=$this->m_model->selectcustom('SELECT * FROM `tahun_pemilihan` order by tahun ASC');
		$data['tahun_pemilihan_semua']=$tahun_pemilihan;
		foreach ($tahun_pemilihan as $key => $value) {
			// code...
			#echo $key;
			$data['tahun_pemilihan']=$value;
			$data['tahunpemilihan']=$value->tahun;
			if($value->tahun == $this->input->get('tahunpemilihan')){
				break;
			}
			//ini bearti tahun pemiilhannya ambil yg dilooping terakhir
			$tahun_pemilihan=$data['tahunpemilihan'];
		}


		$data['nama_pemilih']=$nama_pemilih;
		$data['id_pemilih']=$id_pemilih;
		$data['wil_pemilih']=$wil_pemilih;
		$data['hak_suara']=1;
		//get all calon penatua perwilayah
		$sql="select A.*, B.status_kawin, count(C.id) as voted, C.locked
				from anggota_jemaat A 
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap_ppj C on C.id_calon1 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				join anggota_jemaat_bakal_calon D on D.anggota_jemaat_id = A.id
				where A.sts_anggota=1 && A.status_sidi=1 && A.status=1 && D.status_ppj=1
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

	public function detail_get_pertumbuhanJemaat($tahun=0){
		//sleep ( 5 );
		$data=array();
		if($tahun==0){
			$tahun=date('Y');
		}
		$tahun='2022s';

		$sql="select A.id, A.nama_lengkap, A.tgl_meninggal, A.tmpt_meninggal, 'meninggal' as label, A.kwg_wil, B.kwg_nama, A.jns_kelamin
				from anggota_jemaat A
				join keluarga_jemaat B on B.id = A.kwg_no
				where A.tgl_meninggal != '0000-00-00' && YEAR(A.tgl_meninggal) = '".$tahun."' && A.status=1
				order by A.tgl_meninggal ASC";
		$q=$this->m_model->selectcustom($sql);
		$data['meninggal']=$q;

		$sql="select A.id, A.nama_lengkap, A.tgl_lahir, A.tmpt_lahir,A.jns_kelamin, 'lahir' as label, A.kwg_wil, C.nama_lengkap as ortu1, C.jns_kelamin as jns_kelamin1, D.nama_lengkap as ortu2, D.jns_kelamin as jns_kelamin2, A.kwg_no
				from anggota_jemaat A
				join keluarga_jemaat B on B.id = A.kwg_no
				left join anggota_jemaat C on C.kwg_no = A.kwg_no && C.hub_kwg=1 && C.status=1 
				left join anggota_jemaat D on D.kwg_no = A.kwg_no && D.hub_kwg=2 && D.status=1 
				where A.tgl_lahir != '0000-00-00' && YEAR(A.tgl_lahir) = '".$tahun."' && A.status=1 
				order by A.tgl_lahir ASC
				";
		$q=$this->m_model->selectcustom($sql);
		$data['lahir']=$q;
		$this->load->view('ajax/detail_pertumbuhanJemaat', $data);
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

	public function kirimPesan(){
		$data=array();
		$param=array();
		$param['keluarga']=$this->input->post('txt_keluarga');
		$param['pengguna']=$this->input->post('txt_pengguna');
		$param['pesan']=$this->input->post('pesan');
		$param['created_date']=date('Y-m-d H:i:s');

		$i=$this->m_model->insertgetid($param, 'kotak_pesan');
		if($i){
			$json['sts']=1;
		}
		else{
			$json['sts']=0;
		}

		echo json_encode($json);
	}

	public function statistik_ppj_wil(){
		$tahun_pemilihan=date('Y');
		if($this->input->post('tahun_pemilihan') >0){
			$tahun_pemilihan=$this->input->post('tahun_pemilihan');
		}
		$data=array();
		$data['num_pesertaPemilihan']=array();
		$data['num_suaraDikunci']=array();
		$data['num_BelumDikunci']=array();

		$data['num_pesertaPemilihan_global']=0;
		$data['num_suaraDikunci_global']=0;
		$data['num_BelumDikunci_global']=0;

		$wil=lsWil();
		foreach ($wil as $key => $value) {
			// code...
			$data['num_pesertaPemilihan'][$value->wilayah]=0;
			$data['num_suaraDikunci'][$value->wilayah]=0;
			$data['num_BelumDikunci'][$value->wilayah]=0;
		}

		$q="select B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta_old, COUNT(D.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
				join anggota_jemaat_peserta_pemilihan D on D.anggota_jemaat_id = A.id 
				where A.id >0 && D.tahun_pemilihan='".$tahun_pemilihan."'
                group by B.id
                order by B.kwg_wil ASC";
                #ini  kondisi dulu awal 2021
                #&& ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-09-09 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-09-09 00:00:00' && A.last_modified_dorkas < '2021-09-09 00:00:00') ) && B.status=1 && A.status_sidi=1 
                #&& YEAR(A.tgl_lahir) < 2005
		$pesertaPemilihan=$this->m_model->selectcustom($q);
		#die(nl2br($q));

		$data['pesertaPemilihan']=array();
		foreach ($pesertaPemilihan as $key => $value) {
			// code...
			if(!isset($data['num_pesertaPemilihan'][$value->kwg_wil])){
				$data['num_pesertaPemilihan'][$value->kwg_wil]=0;
			}
			$data['num_pesertaPemilihan'][$value->kwg_wil]=$data['num_pesertaPemilihan'][$value->kwg_wil]+$value->peserta;
			$data['pesertaPemilihan'][$value->kwg_wil]=$value;

			$data['num_pesertaPemilihan_global']=$data['num_pesertaPemilihan_global']+$value->peserta;
		}
		#print_r($data); die();
		$data['max_peserta_pemilihan']=max($data['num_pesertaPemilihan']);
		$data['min_peserta_pemilihan']=min($data['num_pesertaPemilihan']);

		$q1="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join votes_tahap_ppj D on D.id_pemilih = A.id
				where A.id >0 && D.locked=1 && D.tahun_pemilihan ='".$tahun_pemilihan."'
                group by B.id
                order by B.kwg_wil ASC";
                # A.status=1 && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005 && D.locked=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-09-09 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-09-09 00:00:00' && A.last_modified_dorkas < '2021-09-09 00:00:00') )
		$suaraDikunci=$this->m_model->selectcustom($q1);
		$data['suaraDikunci']=array();
		foreach ($suaraDikunci as $key => $value) {
			// code...
			if(!isset($data['num_suaraDikunci'][$value->kwg_wil])){
				$data['num_suaraDikunci'][$value->kwg_wil]=0;
			}
			$data['num_suaraDikunci'][$value->kwg_wil]=$data['num_suaraDikunci'][$value->kwg_wil]+$value->peserta;
			$data['suaraDikunci'][$value->kwg_wil]=$value;

			$data['num_suaraDikunci_global']=$data['num_suaraDikunci_global']+$value->peserta;
		}
		$data['max_suaraDikunci']=max($data['num_suaraDikunci']);
		$data['min_suaraDikunci']=min($data['num_suaraDikunci']);


		$q2="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join votes_tahap_ppj D on D.id_pemilih = A.id
				where A.id >0 && D.locked=0 && D.tahun_pemilihan ='".$tahun_pemilihan."' 
                group by B.id
                order by B.kwg_wil ASC";
                #&& A.status=1 && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005 && D.locked=0 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-09-09 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-09-09 00:00:00' && A.last_modified_dorkas < '2021-09-09 00:00:00') )
		$suaraBelumDikunci=$this->m_model->selectcustom($q2); 
		#die($q2);

		$data['suaraBelumDikunci']=array();
		foreach ($suaraBelumDikunci as $key => $value) {
			// code...
			if(!isset($data['num_BelumDikunci'][$value->kwg_wil])){
				$data['num_BelumDikunci'][$value->kwg_wil]=0;
			}
			$data['num_BelumDikunci'][$value->kwg_wil]=$data['num_BelumDikunci'][$value->kwg_wil]+$value->peserta;
			$data['suaraBelumDikunci'][$value->kwg_wil]=$value;

			$data['num_BelumDikunci_global']=$data['num_BelumDikunci_global']+$value->peserta;
		}
		$data['max_BelumDikunci']=max($data['num_BelumDikunci']);
		$data['min_BelumDikunci']=min($data['num_BelumDikunci']);

		echo json_encode($data);

	}

	public function statistik_pnt1_wil(){
		$data=array();
		$tahun_pemilihan=$this->input->post('tahun_pemilihan');
		if(!$this->input->post('tahun_pemilihan')){
			$tahun_pemilihan=date('Y');;
		}

		$data['num_pesertaPemilihan']=array();
		$data['num_suaraDikunci']=array();
		$data['num_BelumDikunci']=array();

		$data['pesertaPemilihan_dikunci']=array();
		$data['pesertaPemilihan_belumkunci']=array();

		$data['num_pesertaPemilihan_global']=0;
		$data['num_suaraDikunci_global']=0;
		$data['num_BelumDikunci_global']=0;
		$data['pesertaPemilihan_dikunci_global']=0;
		$data['pesertaPemilihan_belumkunci_global']=0;

		$wil=lsWil();
		foreach ($wil as $key => $value) {
			// code...
			$data['num_pesertaPemilihan'][$value->wilayah]=0;
			$data['num_suaraDikunci'][$value->wilayah]=0;
			$data['num_BelumDikunci'][$value->wilayah]=0;
			$data['pesertaPemilihan_dikunci'][$value->wilayah]=0;
			$data['pesertaPemilihan_belumkunci'][$value->wilayah]=0;
		}

		/*$q="select B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
				where A.id >0 && A.status=1 && ((A.sts_anggota = 1  && (A.created_at < '".$tahun_pemilihan."-07-31 00:00:00') ) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && B.status=1  && A.status_sidi=1 
                group by B.id
                order by B.kwg_wil ASC";
                #&& YEAR(A.tgl_lahir) < 2005 */
                
       	#diatas sql lama 2021, saat ini sudah pakai anggota_jemaat_peserta_pemilihan

        $q="select B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
				join anggota_jemaat_peserta_pemilihan D on D.anggota_jemaat_id = A.id
				where A.id >0 && D.tahun_pemilihan ='".$tahun_pemilihan."' && D.status_peserta_pn1=1 
                group by B.id
                order by B.kwg_wil ASC";
		$pesertaPemilihan=$this->m_model->selectcustom($q);
		#die($q);

		$data['pesertaPemilihan']=array();
		foreach ($pesertaPemilihan as $key => $value) {
			// code...
			if(!isset($data['num_pesertaPemilihan'][$value->kwg_wil])){
				$data['num_pesertaPemilihan'][$value->kwg_wil]=0;
			}
			$data['num_pesertaPemilihan'][$value->kwg_wil]=$data['num_pesertaPemilihan'][$value->kwg_wil]+$value->peserta;
			$data['pesertaPemilihan'][$value->kwg_wil]=$value;

			$data['num_pesertaPemilihan_global']=$data['num_pesertaPemilihan_global']+$value->peserta;
		}

		$data['max_peserta_pemilihan']=max($data['num_pesertaPemilihan']);
		$data['min_peserta_pemilihan']=min($data['num_pesertaPemilihan']);

		$q1="select B.id, B.kwg_nama, B.kwg_alamat, A.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join votes_tahap1 D on D.id_pemilih = A.id
				where A.id >0 && D.locked=1 && D.tahun_pemilihan ='".$tahun_pemilihan."'
                group by B.id
                order by B.kwg_wil ASC"; #&& YEAR(A.tgl_lahir) < 2005 
                #where A.id >0 && A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && A.status_sidi=1 && D.locked=1
		$suaraDikunci=$this->m_model->selectcustom($q1);
		$data['suaraDikunci']=array();
		foreach ($suaraDikunci as $key => $value) {
			// code...
			if(!isset($data['num_suaraDikunci'][$value->kwg_wil])){
				$data['num_suaraDikunci'][$value->kwg_wil]=0;
			}
			$data['num_suaraDikunci'][$value->kwg_wil]=$data['num_suaraDikunci'][$value->kwg_wil]+$value->peserta;
			$data['suaraDikunci'][$value->kwg_wil]=$value;

			$data['num_suaraDikunci_global']=$data['num_suaraDikunci_global']+$value->peserta;
		}
		$data['max_suaraDikunci']=max($data['num_suaraDikunci']);
		$data['min_suaraDikunci']=min($data['num_suaraDikunci']);


		$q2="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join votes_tahap1 D on D.id_pemilih = A.id
				where A.id >0 && D.locked=0 && D.tahun_pemilihan ='".$tahun_pemilihan."'
                group by B.id
                order by B.kwg_wil ASC";

                #&& ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') )  && YEAR(A.tgl_lahir) < 2005 

		$suaraBelumDikunci=$this->m_model->selectcustom($q2);

		$data['suaraBelumDikunci']=array();
		foreach ($suaraBelumDikunci as $key => $value) {
			// code...
			if(!isset($data['num_BelumDikunci'][$value->kwg_wil])){
				$data['num_BelumDikunci'][$value->kwg_wil]=0;
			}
			$data['num_BelumDikunci'][$value->kwg_wil]=$data['num_BelumDikunci'][$value->kwg_wil]+$value->peserta;
			$data['suaraBelumDikunci'][$value->kwg_wil]=$value;

			$data['num_BelumDikunci_global']=$data['num_BelumDikunci_global']+$value->peserta;
		}

		$q3="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta, D.id_pemilih
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join (select * from votes_tahap1 where tahun_pemilihan ='".$tahun_pemilihan."' group by id_pemilih) D on D.id_pemilih = A.id
				where A.id >0 && D.locked=0
                group by B.kwg_wil
                order by B.kwg_wil ASC"; #&& A.status=1
                #&& ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005
		$suaraBelumDikunci3=$this->m_model->selectcustom($q3);

		foreach ($suaraBelumDikunci3 as $key => $value) {
			$data['pesertaPemilihan_belumkunci'][$value->kwg_wil]=$value->peserta;
			$data['pesertaPemilihan_belumkunci_global']=$data['pesertaPemilihan_belumkunci_global']+$value->peserta;
		}

		$q4="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta, D.id_pemilih
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join (select * from votes_tahap1 where tahun_pemilihan ='".$tahun_pemilihan."' group by id_pemilih) D on D.id_pemilih = A.id
				where A.id >0 && D.locked=1
                group by B.kwg_wil
                order by B.kwg_wil ASC"; #&& A.status=1 

                #&& ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005 

		$suaraDikunci4=$this->m_model->selectcustom($q4);

		foreach ($suaraDikunci4 as $key => $value) {
			$data['pesertaPemilihan_dikunci'][$value->kwg_wil]=$value->peserta;
			$data['pesertaPemilihan_dikunci_global']=$data['pesertaPemilihan_dikunci_global']+$value->peserta;
		}


		$data['max_BelumDikunci']=max($data['num_BelumDikunci']);
		$data['min_BelumDikunci']=min($data['num_BelumDikunci']);

		echo json_encode($data);

	}

	public function statistik_pnt2_wil(){
		$data=array();

		$tahun_pemilihan=$this->input->post('tahun_pemilihan');
		if(!$this->input->post('tahun_pemilihan')){
			$tahun_pemilihan=date('Y');;
		}


		$data['num_pesertaPemilihan']=array();
		$data['num_suaraDikunci']=array();
		$data['num_BelumDikunci']=array();

		$data['pesertaPemilihan_dikunci']=array();
		$data['pesertaPemilihan_belumkunci']=array();

		$data['num_pesertaPemilihan_global']=0;
		$data['num_suaraDikunci_global']=0;
		$data['num_BelumDikunci_global']=0;
		$data['pesertaPemilihan_dikunci_global']=0;
		$data['pesertaPemilihan_belumkunci_global']=0;

		$wil=lsWil();
		foreach ($wil as $key => $value) {
			// code...
			$data['num_pesertaPemilihan'][$value->wilayah]=0;
			$data['num_suaraDikunci'][$value->wilayah]=0;
			$data['num_BelumDikunci'][$value->wilayah]=0;
			$data['pesertaPemilihan_dikunci'][$value->wilayah]=0;
			$data['pesertaPemilihan_belumkunci'][$value->wilayah]=0;
		}

		/*$q="select B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
				where A.id >0 && A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && B.status=1  && A.status_sidi=1 
                group by B.id
                order by B.kwg_wil ASC";
                #&& YEAR(A.tgl_lahir) < 2005*/ #ini periode 2022-2026
        $tahun_peserta_pemilihan=$tahun_pemilihan;
        if($tahun_pemilihan=='2022'){
        	$tahun_peserta_pemilihan='2021';
        }
         $q="select B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
				join anggota_jemaat_peserta_pemilihan D on D.anggota_jemaat_id = A.id
				where A.id >0 && D.tahun_pemilihan ='".$tahun_peserta_pemilihan."' && D.status_peserta_pn2=1 
                group by B.id
                order by B.kwg_wil ASC";

		$pesertaPemilihan=$this->m_model->selectcustom($q);
		#die(nl2br($q));

		$data['pesertaPemilihan']=array();
		foreach ($pesertaPemilihan as $key => $value) {
			// code...
			if(!isset($data['num_pesertaPemilihan'][$value->kwg_wil])){
				$data['num_pesertaPemilihan'][$value->kwg_wil]=0;
			}
			$data['num_pesertaPemilihan'][$value->kwg_wil]=$data['num_pesertaPemilihan'][$value->kwg_wil]+$value->peserta;
			$data['pesertaPemilihan'][$value->kwg_wil]=$value;

			$data['num_pesertaPemilihan_global']=$data['num_pesertaPemilihan_global']+$value->peserta;
		}

		$data['max_peserta_pemilihan']=max($data['num_pesertaPemilihan']);
		$data['min_peserta_pemilihan']=min($data['num_pesertaPemilihan']);

		$q1="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join votes_tahap2 D on D.id_pemilih = A.id
				where A.id >0 && A.status=1 && D.tahun_pemilihan ='".$tahun_pemilihan."' && D.locked=1
                group by B.id
                order by B.kwg_wil ASC"; #&& YEAR(A.tgl_lahir) < 2005
                #&& ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && A.status_sidi=1 
		$suaraDikunci=$this->m_model->selectcustom($q1);
		$data['suaraDikunci']=array();
		foreach ($suaraDikunci as $key => $value) {
			// code...
			if(!isset($data['num_suaraDikunci'][$value->kwg_wil])){
				$data['num_suaraDikunci'][$value->kwg_wil]=0;
			}
			$data['num_suaraDikunci'][$value->kwg_wil]=$data['num_suaraDikunci'][$value->kwg_wil]+$value->peserta;
			$data['suaraDikunci'][$value->kwg_wil]=$value;

			$data['num_suaraDikunci_global']=$data['num_suaraDikunci_global']+$value->peserta;
		}
		$data['max_suaraDikunci']=max($data['num_suaraDikunci']);
		$data['min_suaraDikunci']=min($data['num_suaraDikunci']);


		$q2="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join votes_tahap2 D on D.id_pemilih = A.id
				where A.id >0 && A.status=1 && D.tahun_pemilihan ='".$tahun_pemilihan."' && D.locked=0
                group by B.id
                order by B.kwg_wil ASC"; #&& YEAR(A.tgl_lahir) < 2005
                #&& ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && A.status_sidi=1 
		$suaraBelumDikunci=$this->m_model->selectcustom($q2);

		$data['suaraBelumDikunci']=array();
		foreach ($suaraBelumDikunci as $key => $value) {
			// code...
			if(!isset($data['num_BelumDikunci'][$value->kwg_wil])){
				$data['num_BelumDikunci'][$value->kwg_wil]=0;
			}
			$data['num_BelumDikunci'][$value->kwg_wil]=$data['num_BelumDikunci'][$value->kwg_wil]+$value->peserta;
			$data['suaraBelumDikunci'][$value->kwg_wil]=$value;

			$data['num_BelumDikunci_global']=$data['num_BelumDikunci_global']+$value->peserta;
		}

		$q3="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta, D.id_pemilih
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join (select * from votes_tahap2 where tahun_pemilihan ='".$tahun_pemilihan."' group by id_pemilih) D on D.id_pemilih = A.id
				where A.id >0 && A.status=1 && D.locked=0
                group by B.kwg_wil
                order by B.kwg_wil ASC"; #&& YEAR(A.tgl_lahir) < 2005 
                #((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && A.status_sidi=1 && 

		$suaraBelumDikunci3=$this->m_model->selectcustom($q3);

		foreach ($suaraBelumDikunci3 as $key => $value) {
			$data['pesertaPemilihan_belumkunci'][$value->kwg_wil]=$value->peserta;
			$data['pesertaPemilihan_belumkunci_global']=$data['pesertaPemilihan_belumkunci_global']+$value->peserta;
		}

		$q4="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta, D.id_pemilih
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join (select * from votes_tahap2 where tahun_pemilihan ='".$tahun_pemilihan."' group by id_pemilih) D on D.id_pemilih = A.id
				where A.id >0 && A.status=1  && D.locked=1
                group by B.kwg_wil
                order by B.kwg_wil ASC";
                #&& YEAR(A.tgl_lahir) < 2005
                #&& ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && A.status_sidi=1 
		$suaraDikunci4=$this->m_model->selectcustom($q4);

		foreach ($suaraDikunci4 as $key => $value) {
			$data['pesertaPemilihan_dikunci'][$value->kwg_wil]=$value->peserta;
			$data['pesertaPemilihan_dikunci_global']=$data['pesertaPemilihan_dikunci_global']+$value->peserta;
		}


		$data['max_BelumDikunci']=max($data['num_BelumDikunci']);
		$data['min_BelumDikunci']=min($data['num_BelumDikunci']);

		echo json_encode($data);

	}

	public function statistik_pnt1_wil_new(){
		$data=array();
		$data['num_pesertaPemilihan']=array();
		$data['pesertaPemilihan_dikunci']=0;
		$data['pesertaPemilihan_belumkunci']=0;
		$data['num_suaraDikunci']=array();
		$data['num_BelumDikunci']=array();

		$data['num_pesertaPemilihan_global']=0;
		$data['num_suaraDikunci_global']=0;
		$data['num_BelumDikunci_global']=0;

		$wil=lsWil();
		foreach ($wil as $key => $value) {
			// code...
			$data['num_pesertaPemilihan'][$value->wilayah]=0;
			$data['num_suaraDikunci'][$value->wilayah]=0;
			$data['num_BelumDikunci'][$value->wilayah]=0;
		}

		$q="select B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
				where A.id >0 && A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && B.status=1  && A.status_sidi=1 
                group by B.id
                order by B.kwg_wil ASC";
                #&& YEAR(A.tgl_lahir) < 2005
		$pesertaPemilihan=$this->m_model->selectcustom($q);

		$data['pesertaPemilihan']=array();
		foreach ($pesertaPemilihan as $key => $value) {
			// code...
			if(!isset($data['num_pesertaPemilihan'][$value->kwg_wil])){
				$data['num_pesertaPemilihan'][$value->kwg_wil]=0;
			}
			$data['num_pesertaPemilihan'][$value->kwg_wil]=$data['num_pesertaPemilihan'][$value->kwg_wil]+$value->peserta;
			$data['pesertaPemilihan'][$value->kwg_wil]=$value;

			$data['num_pesertaPemilihan_global']=$data['num_pesertaPemilihan_global']+$value->peserta;
		}

		$data['max_peserta_pemilihan']=max($data['num_pesertaPemilihan']);
		$data['min_peserta_pemilihan']=min($data['num_pesertaPemilihan']);

		$q1="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join (select * from votes_tahap1 group by id_pemilih) D on D.id_pemilih = A.id
				where A.id >0 && A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && A.status_sidi=1 && D.locked=1
                group by B.id
                order by B.kwg_wil ASC";
                #&& YEAR(A.tgl_lahir) < 2005
		$suaraDikunci=$this->m_model->selectcustom($q1);

		$data['suaraDikunci']=array();
		foreach ($suaraDikunci as $key => $value) {
			// code...
			if(!isset($data['num_suaraDikunci'][$value->kwg_wil])){
				$data['num_suaraDikunci'][$value->kwg_wil]=0;
			}
			$data['num_suaraDikunci'][$value->kwg_wil]=$data['num_suaraDikunci'][$value->kwg_wil]+$value->peserta;
			$data['suaraDikunci'][$value->kwg_wil]=$value;

			$data['num_suaraDikunci_global']=$data['num_suaraDikunci_global']+$value->peserta;
		}
		$data['max_suaraDikunci']=max($data['num_suaraDikunci']);
		$data['min_suaraDikunci']=min($data['num_suaraDikunci']);


		$q2="select B.id, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                join (select * from votes_tahap1 group by id_pemilih) D on D.id_pemilih = A.id
				where A.id >0 && A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && A.status_sidi=1 && D.locked=0
                group by B.id
                order by B.kwg_wil ASC";
                #&& YEAR(A.tgl_lahir) < 2005
		$suaraBelumDikunci=$this->m_model->selectcustom($q2);

		$data['suaraBelumDikunci']=array();
		foreach ($suaraBelumDikunci as $key => $value) {
			// code...
			if(!isset($data['num_BelumDikunci'][$value->kwg_wil])){
				$data['num_BelumDikunci'][$value->kwg_wil]=0;
			}
			$data['num_BelumDikunci'][$value->kwg_wil]=$data['num_BelumDikunci'][$value->kwg_wil]+$value->peserta;
			$data['suaraBelumDikunci'][$value->kwg_wil]=$value;

			$data['num_BelumDikunci_global']=$data['num_BelumDikunci_global']+$value->peserta;
		}

		$data['max_BelumDikunci']=max($data['num_BelumDikunci']);
		$data['min_BelumDikunci']=min($data['num_BelumDikunci']);

		echo json_encode($data);

	}

	public function get_content_yt(){
		//$data=file_get_contents('https://www.youtube.com/watch?v=aN0oDEnl6ic');
		$apikey = 'AIzaSyDhpILoMaLtdP6ceYzWHFQz6DkFB15TBKo';  //My API key
		$videoid = $this->input->get('yt_id');
		$recid = $this->input->get('recid');
		$json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$videoid.'&key='.$apikey.'&part=snippet');
		$ytdata = (array) json_decode($json);

		//print_r($ytdata);
		$param=array();
		$param['title']=$ytdata['items'][0]->snippet->title;
		$param['img']=$ytdata['items'][0]->snippet->thumbnails->high->url;
		$this->m_model->updateas('id', $recid, $param, 'live_streaming');

		//$ytdata = json_decode($data, true);
		//print_r($ytdata);
		//print_r($data);
	}

	public function generatenomorkartu($value='')
	{
		// code...
		$data=array();
		$periode_id=$this->input->post('periode_id');
		$sql1="select A.id, A.no_anggota, C.kwg_no, COUNT(B.id) as num_persembahanbulanan, A.kwg_wil
				from anggota_jemaat A 
				join keluarga_jemaat C on C.id = A.kwg_no
				left join persembahan_bulanan B on B.anggota_jemaat_id = A.id && B.periode_id='".$periode_id."'
				where A.status_sidi=1 && A.sts_anggota=1 && A.status=1
				group by A.id
				HAVING COUNT(B.id)=0
				";
		//die($sql1);
		$qsql1=$this->m_model->selectcustom($sql1);
		foreach ($qsql1 as $key => $value) {
			// code...
			$nij=$value->no_anggota;
			$kwg_no=$value->kwg_no;
			$kwg_wil=$value->kwg_wil;

			if($value->num_persembahanbulanan ==0){
				$genNoKartu=generateNoKartu($nij, $kwg_no, $kwg_wil);

				$param['anggota_jemaat_id']=$value->id;
				$param['no_kartu']=$genNoKartu;
				$param['periode_id']=$periode_id;

				$this->m_model->insertgetid($param, 'persembahan_bulanan');
			}
			else{
				continue;
			}
		}
		echo json_encode(array('sts'=>1));
	}

	public function get_tunggakan_kpkp($value='')
	{
		// code...
		$data=array();
		$s="select  A.*, B.kwg_nama, B.kwg_wil, C.num_kpkp as num_kpkp_inti, IF(D.num_kpkp is null, 0, D.num_kpkp) as num_kpkp_tambahan, (C.num_kpkp + IF(D.num_kpkp is null, 0, D.num_kpkp)) as num_kpkp
				from kpkp_keluarga_jemaat A 
				join keluarga_jemaat B on B.id = A.keluarga_jemaat_id
				join (select kwg_no, count(id) as num_kpkp) from anggota_jemaat where sts_anggota=1 && sts_anggota=1 && status=1 group by kwg_no) C on C.kwg_no = B.id
				left join (select kwg_no_kpkp, count(id) as num_kpkp from anggota_jemaat where sts_anggota=1 && sts_anggota=1 && status=1 group by kwg_no_kpkp) D on D.kwg_no_kpkp = B.id
				where B.status=1 && A.saldo_akhir <0
				";
		$q=$this->m_model->selectcustom($s);// die($s);
		$bulan3=0;
		$bulan6=0;
		$bulan12=0;
		$bulan36=0;
		$total_biayaKPKP=0;

		foreach ($q as $key => $value) {
			// code...
			$total_biayaKPKP=$value->num_kpkp * 5000;
			$bulan_tertampung=countBulanTercover($total_biayaKPKP, $value->saldo_akhir, date('Y-m'));
			if($bulan_tertampung >= -3){
				$bulan3++;
			}
			else if($bulan_tertampung <= -6 && $bulan_tertampung < -12){
				$bulan6++;
			}
			else if($bulan_tertampung <= -12 && $bulan_tertampung < -36){
				$bulan12++;
			}
			else if($bulan_tertampung <= -36){
				$bulan36++;
			}

		}

		$data['bulan3']=$bulan3;
		$data['bulan6']=$bulan6;
		$data['bulan12']=$bulan12;
		$data['bulan36']=$bulan36;
	}


	public function detail_keluarga_kpkp($value='')
	{
		// code...
		$data=array();
		$ls_kk_id=$this->input->post('ls_kk_id');
		$s="select  A.*, B.kwg_nama, B.kwg_wil,  C.num_kpkp as num_kpkp_inti, IF(D.num_kpkp is null, 0, D.num_kpkp) as num_kpkp_tambahan, (C.num_kpkp + IF(D.num_kpkp is null, 0, D.num_kpkp)) as num_kpkp, '0' as bulan_tertampung, '0' as est_tunggakan_kpkp, '' as nama_bulan_tertampung
				from kpkp_keluarga_jemaat A 
				join keluarga_jemaat B on B.id = A.keluarga_jemaat_id
				join (select kwg_no, count(id) as num_kpkp from anggota_jemaat where sts_anggota=1 && sts_anggota=1 && status=1 && kwg_no in (".$ls_kk_id.") group by kwg_no ) C on C.kwg_no = B.id
				left join (select kwg_no_kpkp, count(id) as num_kpkp from anggota_jemaat where sts_anggota=1 && sts_anggota=1 && status=1 group by kwg_no_kpkp) D on D.kwg_no_kpkp = B.id
				where B.status=1 && A.saldo_akhir <0 && A.keluarga_jemaat_id in (".$ls_kk_id.")
				order by B.kwg_wil ASC, B.kwg_nama ASC
				";
		//die($s);
		$q=$this->m_model->selectcustom($s); 
		
		$kk=array();
		foreach ($q as $key => $value) {
			// code...
			$total_biayaKPKP=$value->num_kpkp * 5000;
			$bulan_tertampung=countBulanTercover($total_biayaKPKP, $value->saldo_akhir, date('Y-m'));
			
			$value->nama_bulan_tertampung=$bulan_tertampung['month'];
			$value->bulan_tertampung=$bulan_tertampung['num_month'];
			$value->est_tunggakan_kpkp=$total_biayaKPKP * $bulan_tertampung['num_month'];
			$kk[]=$value;

		}

		$data['kk']=$kk;
		$data['title']=$this->input->post('title');
		$this->load->view('ajax/ls_kk_kpkp', $data);
	}
}

