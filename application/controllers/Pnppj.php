<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Pnppj extends CI_Controller {



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

        $this->tahun_pemilihan='2025';



    }



	public function index(){
		if(!$this->session->userdata('sess_keluarga')){
			redirect(base_url().'login/keluarga');

			die("User Invalid, Access Denied!");

		}

		$data=array();
		$stahun_pemilihan="SELECT * FROM `tahun_pemilihan` ORDER BY `tahun` DESC limit 1";
		$qtahun_pemilihan=$this->m_model->selectcustom($stahun_pemilihan);
		$data['tahun_pemilihan']=$qtahun_pemilihan[0];

		$setting=$this->m_model->selectas('tahun_pemilihan', $this->tahun_pemilihan, 'lock_pemilihan', 'tipe_pemilihan', 'ASC');

		$data['setting']=array();

		foreach ($setting as $key => $value) {

			# code...

			$data['setting'][$value->tipe_pemilihan]=$value;

		}

		#echo "<pre>"; print_r($data['setting']); echo "</pre>"; die();



		//check si pemilih offiline atau online

		$offline=$this->m_model->selectas2('kwg_no', $this->session->userdata('sess_keluarga')->id, 'tahun_pemilihan', $this->tahun_pemilihan, 'pemilih_konvensional');
		foreach ($offline as $key => $value) {
			// code...
			$data['offline'][$value->tipe_pemilihan_id]=$value;
		}




		$this->load->view('frontend/mjppj/index', $data);



	}



	public function pemilihan(){

		$data=array();

		//print_r($this->session->userdata());

		if(!$this->session->userdata('sess_keluarga')){
			redirect(base_url().'login/keluarga');

			die("User Invalid, Access Denied!");

		}

		$data=array();

		$data['keluarga']=$this->session->userdata('sess_keluarga')->kwg_nama;
		$data['tahun_pemilihan']=$this->tahun_pemilihan;

		$sql="select A.*, B.status_kawin

				from anggota_jemaat A 

				left join ags_sts_kawin B on B.id = A.sts_kawin
				join anggota_jemaat_peserta_pemilihan C on C.anggota_jemaat_id = A.id
				where  A.kwg_no='".$this->session->userdata('sess_keluarga')->id."' && C.id >0 && C.id is not null && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.status_peserta_pn1=1 && A.sts_anggota=1 && A.status=1 && A.status_sidi=1
				order by A.hub_kwg ASC, A.no_urut ASC ";

				#where  A.kwg_no='".$this->session->userdata('sess_keluarga')->id."' && A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1";

		$data['anggota_sidi']=$this->m_model->selectcustom($sql);

		$ls_id_pemilih=array();
		$ls_id_pemilih[]=0;
		foreach ($data['anggota_sidi'] as $key => $value) {
			// code...
			$ls_id_pemilih[]=$value->id;
		}

		$spemilih_voting="select * from votes_tahap1 where id_pemilih in (".implode(', ', $ls_id_pemilih).") && tahun_pemilihan = '".$this->tahun_pemilihan."'";
		$qpemilih_voting=$this->m_model->selectcustom($spemilih_voting);

		$data['pemilih_voting']=array();
		foreach ($qpemilih_voting as $key => $value) {
			// code...
			$data['pemilih_voting'][$value->id_pemilih][]=$value;
		}


		$sulasan="select * from ulasan_user where user_id in (".implode(', ', $ls_id_pemilih).") && module='Pemilihan PNT Tahap 1 ".$this->tahun_pemilihan."' ";
		$qulasan=$this->m_model->selectcustom($sulasan); #die($sulasan);
		$data['ulasan']=array();
		foreach ($qulasan as $key => $value) {
			// code...
			$data['ulasan'][$value->user_id]=$value;
		}





		$slockpemilihan=$this->m_model->selectas2('tahun_pemilihan', $this->tahun_pemilihan, 'tipe_pemilihan', 1, 'lock_pemilihan');
		$data['lockpemilihan']=$slockpemilihan;




		$this->load->view('frontend/mjppj/pemilihan', $data);

		

	}



	public function pemilihan_ppj(){

		$data=array();

		//print_r($this->session->userdata());

		if(!$this->session->userdata('sess_keluarga')){
			redirect(base_url().'login/keluarga');

			die("User Invalid, Access Denied!");

		}

		$data=array();

		$data['keluarga']=$this->session->userdata('sess_keluarga')->kwg_nama;
		$data['tahun_pemilihan']=$this->tahun_pemilihan;

		$sql="select A.*, B.status_kawin

				from anggota_jemaat A 

				left join ags_sts_kawin B on B.id = A.sts_kawin
				join anggota_jemaat_peserta_pemilihan C on C.anggota_jemaat_id = A.id

				where  A.kwg_no='".$this->session->userdata('sess_keluarga')->id."' && C.id >0 && C.id is not null && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.status_peserta_ppj=1 && A.sts_anggota=1 && A.status=1 && A.status_sidi=1
				order by A.hub_kwg ASC, A.no_urut ASC ";

				#ini kondisi pemilihan tahun 2021, belum dinamis
				#where  A.kwg_no='".$this->session->userdata('sess_keluarga')->id."' && A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1";

		$data['anggota_sidi']=$this->m_model->selectcustom($sql);

		$ls_id_pemilih=array();
		$ls_id_pemilih[]=0;
		foreach ($data['anggota_sidi'] as $key => $value) {
			// code...
			$ls_id_pemilih[]=$value->id;
		}

		$spemilih_voting="select * from votes_tahap_ppj where id_pemilih in (".implode(', ', $ls_id_pemilih).") && tahun_pemilihan = '".$this->tahun_pemilihan."'";
		$qpemilih_voting=$this->m_model->selectcustom($spemilih_voting);

		$data['pemilih_voting']=array();
		foreach ($qpemilih_voting as $key => $value) {
			// code...
			$data['pemilih_voting'][$value->id_pemilih][]=$value;
		}

		$sulasan="select * from ulasan_user where user_id in (".implode(', ', $ls_id_pemilih).") && module='Pemilihan PPJ ".$this->tahun_pemilihan."' ";
		$qulasan=$this->m_model->selectcustom($sulasan); #die($sulasan);
		$data['ulasan']=array();
		foreach ($qulasan as $key => $value) {
			// code...
			$data['ulasan'][$value->user_id]=$value;
		}





		$slockpemilihan=$this->m_model->selectas2('tahun_pemilihan', $this->tahun_pemilihan, 'tipe_pemilihan', 3, 'lock_pemilihan');
		$data['lockpemilihan']=$slockpemilihan;
			
		$this->load->view('frontend/mjppj/pemilihan_ppj', $data);

		

	}



	public function pemilihan2(){

		$data=array();

		//print_r($this->session->userdata());

		if(!$this->session->userdata('sess_keluarga')){
			redirect(base_url().'login/keluarga');
			die("User Invalid, Access Denied!");

		}

		$data=array();

		$data['keluarga']=$this->session->userdata('sess_keluarga')->kwg_nama;

		$sql="select A.*, B.status_kawin

				from anggota_jemaat A 

				left join ags_sts_kawin B on B.id = A.sts_kawin
				join anggota_jemaat_peserta_pemilihan C on C.anggota_jemaat_id = A.id

				where  A.kwg_no='".$this->session->userdata('sess_keluarga')->id."' && C.id >0 && C.id is not null && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.status_peserta_pn2=1 && A.sts_anggota=1 && A.status=1 && A.status_sidi=1";

		$data['anggota_sidi']=$this->m_model->selectcustom($sql);







		$this->load->view('frontend/mjppj/pemilihan2', $data);

		

	}



	public function vote_tahap1(){

		$id_pemilih=clearText($this->input->post('id_pemilih'));

		$wil_pemilih=clearText($this->input->post('wil_pemilih'));

		$val_calon=explode('#', $this->input->post('val_calon')) ;

		$id_calon=clearText($val_calon[0]);

		$wil_calon=clearText($val_calon[1]);

		$tahun_pemilihan=date('Y');

		$vote=$this->input->post('vote'); //1=voting; 2=unvoted/delete

		$json=array();

		if($vote==1){

			//voting

			$param=array();

			$param['id_pemilih']=$id_pemilih;

			$param['wil_pemilih']=$wil_pemilih;

			$param['id_calon1']=$id_calon;

			$param['wil_calon1']=$wil_calon;

			$param['tahun_pemilihan']=$tahun_pemilihan;

			$param['created_date']=date('Y-m-d H:i:s');



			$q=$this->m_model->insertgetid($param, 'votes_tahap1');

			if($q){

				$json=array('status'=>1,'msg'=>'data saved');

			}

			else{

				$json=array('status'=>0,'msg'=>'failed saved');

			}

		}

		else if($vote==2){

			$q=$this->m_model->deleteas3('id_pemilih',$id_pemilih, 'id_calon1',$id_calon, 'tahun_pemilihan',$tahun_pemilihan, 'votes_tahap1');

			if($q){

					$json=array('status'=>2,'msg'=>'data deleted');

			}

			else{

				$json=array('status'=>3,'msg'=>'failed delete');

			}

		}



		echo json_encode($json);

	}



	public function vote_tahap_ppj(){

		$id_pemilih=clearText($this->input->post('id_pemilih'));

		$wil_pemilih=clearText($this->input->post('wil_pemilih'));

		$val_calon=explode('#', $this->input->post('val_calon')) ;

		$id_calon=clearText($val_calon[0]);

		$wil_calon=clearText($val_calon[1]);

		$tahun_pemilihan=date('Y');

		$vote=$this->input->post('vote'); //1=voting; 2=unvoted/delete

		$json=array();

		if($vote==1){
			//check dulu id_pemilih sudah memilih apa belum untuk PPJ, supaya tidak double
			$scek=$this->m_model->selectas2('id_pemilih', $id_pemilih, 'tahun_pemilihan', $tahun_pemilihan, 'votes_tahap_ppj');
			if(count($scek)>0){
				$json=array('status'=>4,'msg'=>'sudah memilih calon lain!');
			}else{
				//voting

				$param=array();

				$param['id_pemilih']=$id_pemilih;

				$param['wil_pemilih']=$wil_pemilih;

				$param['id_calon1']=$id_calon;

				$param['wil_calon1']=$wil_calon;

				$param['tahun_pemilihan']=$tahun_pemilihan;

				$param['created_date']=date('Y-m-d H:i:s');



				$q=$this->m_model->insertgetid($param, 'votes_tahap_ppj');

				if($q){

					$json=array('status'=>1,'msg'=>'data saved');

				}

				else{

					$json=array('status'=>0,'msg'=>'failed saved');

				}

			}
		}

		else if($vote==2){

			$q=$this->m_model->deleteas3('id_pemilih',$id_pemilih, 'id_calon1',$id_calon, 'tahun_pemilihan',$tahun_pemilihan, 'votes_tahap_ppj');

			if($q){

					$json=array('status'=>2,'msg'=>'data deleted');

			}

			else{

				$json=array('status'=>3,'msg'=>'failed delete');

			}

		}



		echo json_encode($json);

	}



	public function vote_tahap2(){

		$token=clearText($this->input->post('token'));
		$id_pemilih=clearText($this->input->post('id_pemilih'));

		$wil_pemilih=clearText($this->input->post('wil_pemilih'));

		$val_calon=explode('#', $this->input->post('val_calon')) ;

		$id_calon=clearText($val_calon[0]);

		$wil_calon=clearText($val_calon[1]);

		$tahun_pemilihan=date('Y');

		$vote=$this->input->post('vote'); //1=voting; 2=unvoted/delete

		$json=array();

		if($vote==1){

			//voting

			$param=array();

			$param['id_pemilih']=$id_pemilih;

			$param['wil_pemilih']=$wil_pemilih;

			$param['id_calon2']=$id_calon;

			$param['wil_calon2']=$wil_calon;
			$param['sn_surat_suara']=$token;
			$param['admin']=$this->session->userdata('userdata')->username;

			$param['tahun_pemilihan']=$tahun_pemilihan;

			$param['created_date']=date('Y-m-d H:i:s');



			$q=$this->m_model->insertgetid($param, 'votes_tahap2');

			if($q){

				$json=array('status'=>1,'msg'=>'data saved');

			}

			else{

				$json=array('status'=>0,'msg'=>'failed saved');

			}

		}

		else if($vote==2){

			$q=$this->m_model->deleteas3('id_pemilih',$id_pemilih, 'id_calon2',$id_calon, 'tahun_pemilihan',$tahun_pemilihan, 'votes_tahap2');

			if($q){

					$json=array('status'=>2,'msg'=>'data deleted');

			}

			else{

				$json=array('status'=>3,'msg'=>'failed delete');

			}

		}



		echo json_encode($json);

	}



	public function pemilu1($output=null){

		$data=array();

		$data['ls_wil']=lsWil();

		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1

				group by A.kwg_wil";
		#diatas  yg lama pemilihan tahun 2021, belum dinamis


		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A

				join anggota_jemaat_peserta_pemilihan C on C.anggota_jemaat_id = A.id 

				where C.id >0 && C.tahun_pemilihan ='".$this->tahun_pemilihan."' && C.status_peserta_pn1=1

				group by A.kwg_wil";

		$r=$this->m_model->selectcustom($q);

		foreach ($r as $key => $value) {

			# code...

			$data['num_angjem'][$value->kwg_wil]=$value;



		}



		foreach ($data['ls_wil'] as $key => $value) {

			# code...

			$data['voted_wil'][$value->id]=$this->get_pemilu1_perwil($value->id, $this->tahun_pemilihan);
			//$data['voted_wil_konvensional'][$value->id]=$this->get_pemilu1_perwil_konvensional($value->id, $this->tahun_pemilihan);

		}


		if($output==null){
			$this->load->view('pemilu/perolehansuaraTahap1', $data);
		}
		else{
			$this->load->view('pemilu/perolehansuaraTahap1_table', $data);
		}

	}



	public function perolehansuarapemilu1(){

		$data=array();

		//$data['ls_wil']=lsWil();
		if($this->input->get('wil') && $this->input->get('wil') !=0){
			$data['kwg_wil']=$this->input->get('wil');

		}else{
			//default dari login user
			$data['kwg_wil']=$this->session->userdata('sess_keluarga')->kwg_wil;
		}
		#$this->tahun_pemilihan='2021';
		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1 && A.kwg_wil='".$data['kwg_wil']."'

				group by A.kwg_wil";
		#diatas  yg lama pemilihan tahun 2021, belum dinamis


		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A

				join anggota_jemaat_peserta_pemilihan C on C.anggota_jemaat_id = A.id 

				where C.id >0 && C.tahun_pemilihan ='".$this->tahun_pemilihan."' && C.status_peserta_pn1=1 && A.kwg_wil='".$data['kwg_wil']."'

				group by A.kwg_wil";

		$r=$this->m_model->selectcustom($q);

		foreach ($r as $key => $value) {

			# code...

			$data['num_angjem'][$value->kwg_wil]=$value;



		}

		$slot_vote=8;

		$data['max_suara_masuk']=$data['num_angjem'][$value->kwg_wil]->num_angjem*$slot_vote;



		$data['slot_vote']=$slot_vote;



		$data['voted_wil'][$data['kwg_wil']]=$this->get_pemilu1_perwil($data['kwg_wil'], $this->tahun_pemilihan);



		$this->load->view('frontend/mjppj/perolehansuarapemilu1', $data);

	}


	public function hasilpemilu1(){

		$data=array();

		//$data['ls_wil']=lsWil();
		if($this->input->get('wil') && $this->input->get('wil') !=0){
			$data['kwg_wil']=$this->input->get('wil');

		}else{
			//default dari login user
			$data['kwg_wil']=1;
		}
		#$this->tahun_pemilihan='2021';
		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1 && A.kwg_wil='".$data['kwg_wil']."'

				group by A.kwg_wil";
		#diatas  yg lama pemilihan tahun 2021, belum dinamis


		$q="select B.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A
				join keluarga_jemaat B on B.id = A.kwg_no

				join anggota_jemaat_peserta_pemilihan C on C.anggota_jemaat_id = A.id 

				where C.id >0 && C.tahun_pemilihan ='".$this->tahun_pemilihan."' && C.status_peserta_pn1=1 && B.kwg_wil='".$data['kwg_wil']."'

				group by B.kwg_wil";

		$r=$this->m_model->selectcustom($q); #die(nl2br($q));

		foreach ($r as $key => $value) {

			# code...

			$data['num_angjem'][$value->kwg_wil]=$value;



		}

		$slot_vote=8;

		$data['max_suara_masuk']=$data['num_angjem'][$value->kwg_wil]->num_angjem*$slot_vote;



		$data['slot_vote']=$slot_vote;



		$data['voted_wil'][$data['kwg_wil']]=$this->get_pemilu1_perwil($data['kwg_wil'], $this->tahun_pemilihan);

		$qpeserta="select B.kwg_wil, COUNT(A.id) as peserta_pemilihan

				from anggota_jemaat A
				join keluarga_jemaat B on B.id = A.kwg_no

				join (select * from votes_tahap1 where tahun_pemilihan ='".$this->tahun_pemilihan."' group by id_pemilih) C on C.id_pemilih = A.id 

				where C.id >0 && C.tahun_pemilihan ='".$this->tahun_pemilihan."' && B.kwg_wil='".$data['kwg_wil']."' 

				group by B.kwg_wil"; #

		$rpeserta=$this->m_model->selectcustom($qpeserta); #die(nl2br($qpeserta));
		$data['peserta']=$rpeserta[0];

		$this->load->view('frontend/mjppj/hasilperolehanpemilu1', $data);

	}



	public function pemilu2(){

		$data=array();

		$data['ls_wil']=lsWil();

		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1

				"; //group by A.kwg_wil
				
		$q="select B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as num_angjem
                from keluarga_jemaat B
                join anggota_jemaat A on B.id = A.kwg_no
                join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                where A.id >0 && A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null ) && A.created_at < '2022-01-28 00:00:00') || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && B.status=1  && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005
                order by B.kwg_wil ASC";

		$r=$this->m_model->selectcustom($q);

		foreach ($r as $key => $value) {

			# code...

		$data['num_angjem']=$value->num_angjem;



		}



		//foreach ($data['ls_wil'] as $key => $value) {

			# code...

		$data['voted']=$this->get_pemilu2($this->tahun_pemilihan); //ini all
		$voted_domisili=$this->get_pemilu2_domisili($this->tahun_pemilihan); //ini all
		$data['voted_domisili']=array();
		foreach ($voted_domisili as $key => $value) {
			$data['voted_domisili'][$value->id]=$value->voted;
		}
		$voted_nondomisili=$this->get_pemilu2_nondomisili($this->tahun_pemilihan); //ini all
		$data['voted_nondomisili']=array();
		foreach ($voted_nondomisili as $key => $value) {
			$data['voted_nondomisili'][$value->id]=$value->voted;
		}
			// code...
		//}



		$this->load->view('pemilu/perolehansuaraTahap2', $data);

	}



	public function perolehansuarapemilu2(){

		$data=array();

		$data['ls_wil']=lsWil();

		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 
				join keluarga_jemaat B on B.id = A.kwg_no

				where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && A.status_sidi=1 && B.status=1  

				"; //group by A.kwg_wil

		$r=$this->m_model->selectcustom($q);

		foreach ($r as $key => $value) {

			# code...

		$data['num_angjem']=$value->num_angjem;



		}



		//foreach ($data['ls_wil'] as $key => $value) {

			# code...

		$data['voted']=$this->get_pemilu2($this->tahun_pemilihan); //ini all

		//}



		$this->load->view('frontend/mjppj/perolehansuarapemilu2', $data);

	}



	public function pemilu_ppj(){

		$data=array();

		$data['ls_wil']=lsWil();

		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 
				join anggota_jemaat_peserta_pemilihan B on B.anggota_jemaat_id = A.id 

				where B.id >0 && B.tahun_pemilihan='".$this->tahun_pemilihan."'

				"; //group by A.kwg_wil
				#ini filter kondisiuntuk pemilihan tahun 2021, belum dinamis
				#where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1

		$r=$this->m_model->selectcustom($q);
		#die($q);

		foreach ($r as $key => $value) {

			# code...

		$data['num_angjem']=$value->num_angjem;



		}



		//foreach ($data['ls_wil'] as $key => $value) {

			# code...

		$data['voted']=$this->get_pemilu_ppj($this->tahun_pemilihan); //ini all

		//}



		$this->load->view('pemilu/perolehansuaraTahap_ppj', $data);

	}



	public function perolehansuarappj(){

		$data=array();

		$data['ls_wil']=lsWil();
		#$this->tahun_pemilihan='2021';

		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				join anggota_jemaat_peserta_pemilihan B on B.anggota_jemaat_id = A.id

				where B.tahun_pemilihan='".$this->tahun_pemilihan."'

				"; //group by A.kwg_wil

				#where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1
		$r=$this->m_model->selectcustom($q);
		#die(nl2br($q));

		foreach ($r as $key => $value) {

			# code...

		$data['num_angjem']=$value->num_angjem;



		}



		//foreach ($data['ls_wil'] as $key => $value) {

			# code...

		$data['voted']=$this->get_pemilu_ppj($this->tahun_pemilihan); //ini all

		//}



		$this->load->view('frontend/mjppj/perolehansuarappj_jemaat', $data);

	}



	public function pemilu2_per_wil(){

		$data=array();

		$data['ls_wil']=lsWil();

		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1";

		$r=$this->m_model->selectcustom($q);

		foreach ($r as $key => $value) {

			# code...

			$data['num_angjem']=$value;



		}



		foreach ($data['ls_wil'] as $key => $value) {

			# code...

			$data['voted_wil'][$value->id]=$this->get_pemilu2_perwil($value->id, $this->tahun_pemilihan);

		}



		$this->load->view('pemilu/perolehansuaraTahap2_wil', $data);

	}



	public  function load_get_pemilu1_perwil(){

		$data=array();

		$wilayah=$this->input->post('wilayah');

		$tahun_pemilihan=$this->input->post('tahun');

		$data['voted_wil']=$this->get_pemilu1_perwil($wilayah, $tahun_pemilihan);



		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.kwg_wil='".$wilayah."' && A.status_sidi=1

				group by A.kwg_wil";

		$r=$this->m_model->selectcustom($q);

		$data['NumAngjem']=$r[0]->num_angjem;



		$this->load->view('pemilu/perolehansuaraWilayah', $data);



	}

	private function get_pemilu1_perwil($wil, $tahun){

		$data=array();



		$q="select A.*, B.status_kawin, count(C.id) as voted, C.tahun_pemilihan, D.id as jemaat_terpilih1_id, D.status as status_terpilih, D.note, MAX(C.created_date) as last_vote, F.voted_konvensional, last_vote_konvensional, D.id as id_terpilih

				from anggota_jemaat A 

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap1 C on C.id_calon1 = A.id && C.tahun_pemilihan='".$tahun."' && C.wil_calon1='".$wil."' && C.locked = 1
				
				left join (select id_calon1, count(F.id) as voted_konvensional, MAX(F.created_date) as last_vote_konvensional from votes_tahap1 F where F.tahun_pemilihan='".$tahun."' && F.wil_calon1='".$wil."' && F.locked = 1 && F.sn_surat_suara is not NULL && F.sn_surat_suara !='' group by F.id_calon1) F  on F.id_calon1 = A.id

				left join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun."'

				where  A.kwg_wil='".$wil."'  && A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1

				&& A.id in ( select id_calon1 from votes_tahap1 where tahun_pemilihan='".$tahun."' && wil_calon1='".$wil."' && locked = 1 order by created_date asc)

				group by A.id

                order by voted DESC, last_vote ASC";  //die($q);
        #yg diatas tahun 2021, belum dinamis

        $q="select A.*, B.status_kawin, count(C.id) as voted, C.tahun_pemilihan, D.id as jemaat_terpilih1_id, D.status as status_terpilih, D.note, MAX(C.created_date) as last_vote, F.voted_konvensional, last_vote_konvensional, D.id as id_terpilih

				from anggota_jemaat A 

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap1 C on C.id_calon1 = A.id && C.tahun_pemilihan='".$tahun."' && C.wil_calon1='".$wil."' && C.locked = 1
				
				left join (select id_calon1, count(F.id) as voted_konvensional, MAX(F.created_date) as last_vote_konvensional from votes_tahap1 F where F.tahun_pemilihan='".$tahun."' && F.wil_calon1='".$wil."' && F.locked = 1 && F.sn_surat_suara is not NULL && F.sn_surat_suara !='' group by F.id_calon1) F  on F.id_calon1 = A.id

				left join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun."'


				where  A.kwg_wil='".$wil."' && A.id in ( select id_calon1 from votes_tahap1 where tahun_pemilihan='".$tahun."' && wil_calon1='".$wil."' && locked = 1 order by created_date asc)

				group by A.id

                order by voted DESC, last_vote ASC";  //die($q);

                #join anggota_jemaat_bakal_calon E on E.anggota_jemaat_id = A.id coba gak pakai ini dulu, karena udah where in id calon yg di pilih di vote_tahap1

        $r=$this->m_model->selectcustom($q);

        return $r;

	}

	private function get_pemilu1_perwil_konvensional($wil, $tahun){

		$data=array();



		$q="select A.*, B.status_kawin, count(C.id) as voted, C.tahun_pemilihan, D.id as jemaat_terpilih1_id, D.status as status_terpilih, D.note, MAX(C.created_date) as last_vote, F.voted_konvensional, last_vote_konvensional

				from anggota_jemaat A 

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap1 C on C.id_calon1 = A.id && C.tahun_pemilihan='".$tahun."' && C.wil_calon1='".$wil."' && C.locked = 1

				left join (select id_calon1, count(F.id) as voted_konvensional, MAX(F.created_date) as last_vote_konvensional from votes_tahap1 F where F.tahun_pemilihan='".$tahun."' && F.wil_calon1='".$wil."' && F.locked = 1 && F.sn_surat_suara is not NULL && F.sn_surat_suara !='' group by F.id_calon1) F  on F.id_calon1 = A.id

				left join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun."'

				where  A.kwg_wil='".$wil."'  && A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1

				&& A.id in ( select id_calon1 from votes_tahap1 where tahun_pemilihan='".$tahun."' && wil_calon1='".$wil."' && locked = 1 order by created_date asc) && C.sn_surat_suara is not NULL && C.sn_surat_suara !=''

				group by A.id

                order by voted DESC, last_vote ASC"; // die($q);

        $r=$this->m_model->selectcustom($q);

        return $r;

	}



	public  function load_get_pemilu2_perwil(){

		$data=array();

		$wilayah=$this->input->post('wilayah');

		$tahun_pemilihan=$this->input->post('tahun');

		$data['voted_wil']=$this->get_pemilu2_perwil($wilayah, $tahun_pemilihan);



		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1";

		$r=$this->m_model->selectcustom($q);

		$data['NumAngjem']=$r[0]->num_angjem;



		$this->load->view('pemilu/perolehansuaraWilayah', $data);



	}



	public  function load_get_pemilu2(){

		$data=array();

		$wilayah=$this->input->post('wilayah');

		$tahun_pemilihan=$this->input->post('tahun');

		$data['voted']=$this->get_pemilu2($tahun_pemilihan);



		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1";

		$r=$this->m_model->selectcustom($q);

		$data['NumAngjem']=$r[0]->num_angjem;



		$this->load->view('pemilu/perolehansuara', $data);



	}



	public  function load_get_pemilu_ppj(){

		$data=array();

		$wilayah=$this->input->post('wilayah');

		$tahun_pemilihan=$this->input->post('tahun');

		$data['voted']=$this->get_pemilu_ppj($tahun_pemilihan);



		$q="select A.kwg_wil, COUNT(A.id) as num_angjem

				from anggota_jemaat A 

				where (A.tgl_meninggal is null || A.tgl_meninggal ='0000-00-00') && A.sts_anggota=1 && A.status=1 && A.status_sidi=1

				group by A.kwg_wil";

		$r=$this->m_model->selectcustom($q);

		$data['NumAngjem']=$r[0]->num_angjem;



		$this->load->view('pemilu/perolehansuara_ppj', $data);



	}

	

	private function get_pemilu2($tahun){

		$data=array();



		$q="select A.*, B.status_kawin, count(C.id) as voted, C.tahun_pemilihan, D.id as jemaat_terpilih1_id, D.status as status_terpilih, D.note, E.wilayah, MAX(C.created_date) as last_vote

				from anggota_jemaat A 

				join wilayah E on E.id = A.kwg_wil

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap2 C on C.id_calon2 = A.id && C.tahun_pemilihan='".$tahun."' && C.locked = 1

				left join jemaat_terpilih2 D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun."'

				where A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1

				&& A.id in ( select id_calon2 from votes_tahap2 where tahun_pemilihan='".$tahun."' &&  locked = 1)

				group by A.id

                order by voted DESC, last_vote ASC"; //die($q);

        $r=$this->m_model->selectcustom($q);

        return $r;

	}

	private function get_pemilu2_domisili($tahun){

		$data=array();



		$q="select A.*, B.status_kawin, count(C.id) as voted, C.tahun_pemilihan, D.id as jemaat_terpilih1_id, D.status as status_terpilih, D.note, E.wilayah, MAX(C.created_date) as last_vote

				from anggota_jemaat A 

				join wilayah E on E.id = A.kwg_wil

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap2 C on C.id_calon2 = A.id && C.tahun_pemilihan='".$tahun."' && C.locked = 1 && C.wil_pemilih = A.kwg_wil

				left join jemaat_terpilih2 D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun."'

				where A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1

				&& A.id in ( select id_calon2 from votes_tahap2 where tahun_pemilihan='".$tahun."' &&  locked = 1)

				group by A.id

                order by voted DESC, last_vote ASC"; //die($q);

        $r=$this->m_model->selectcustom($q);

        return $r;

	}

	private function get_pemilu2_nondomisili($tahun){

		$data=array();



		$q="select A.*, B.status_kawin, count(C.id) as voted, C.tahun_pemilihan, D.id as jemaat_terpilih1_id, D.status as status_terpilih, D.note, E.wilayah, MAX(C.created_date) as last_vote

				from anggota_jemaat A 

				join wilayah E on E.id = A.kwg_wil

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap2 C on C.id_calon2 = A.id && C.tahun_pemilihan='".$tahun."' && C.locked = 1 && C.wil_pemilih != A.kwg_wil

				left join jemaat_terpilih2 D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun."'

				where A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1

				&& A.id in ( select id_calon2 from votes_tahap2 where tahun_pemilihan='".$tahun."' &&  locked = 1)

				group by A.id

                order by voted DESC, last_vote ASC"; //die($q);

        $r=$this->m_model->selectcustom($q);

        return $r;

	}



	private function get_pemilu_ppj($tahun){

		$data=array();



		/*$q="select A.*, B.status_kawin, count(C.id) as voted, C.tahun_pemilihan, D.id as jemaat_terpilih1_id, D.status as status_terpilih, D.note, E.wilayah, MAX(C.created_date) as last_vote

				from anggota_jemaat A 

				join wilayah E on E.id = A.kwg_wil

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap_ppj C on C.id_calon1 = A.id && C.tahun_pemilihan='".$tahun."' && C.locked = 1

				left join jemaat_terpilih_ppj D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun."'

				where A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1

				&& A.id in ( select id_calon1 from votes_tahap_ppj where tahun_pemilihan='".$tahun."' &&  locked = 1)

				group by A.id

                order by voted DESC, last_vote ASC"; */
                #die(nl2br($q));
        #diatas sql lama

        $q="select A.*, B.status_kawin, count(C.id) as voted, C.tahun_pemilihan, D.id as jemaat_terpilih1_id, D.status as status_terpilih, D.note, E.wilayah, MAX(C.created_date) as last_vote

				from anggota_jemaat A 

				join wilayah E on E.id = A.kwg_wil

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap_ppj C on C.id_calon1 = A.id && C.tahun_pemilihan='".$tahun."' && C.locked = 1

				left join jemaat_terpilih_ppj D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun."'

				join anggota_jemaat_bakal_calon  F on F.anggota_jemaat_id = A.id 

				where F.tahun_pemilihan ='2025' && F.status_ppj = 1

				group by A.id

                order by voted DESC, last_vote ASC"; 
                #die(nl2br($q));

        $r=$this->m_model->selectcustom($q);

        return $r;

	}



	private function get_pemilu2_perwil($wil, $tahun){

		$data=array();



		$q="select A.*, B.status_kawin, count(C.id) as voted, C.tahun_pemilihan, D.id as jemaat_terpilih1_id, D.status as status_terpilih, D.note, MAX(C.created_date) as last_vote

				from anggota_jemaat A 

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap2 C on C.id_calon2 = A.id && C.tahun_pemilihan='".$tahun."' && C.wil_calon2='".$wil."' && C.locked = 1

				left join jemaat_terpilih2 D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun."'

				where  A.kwg_wil='".$wil."'  && A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1

				&& A.id in ( select id_calon2 from votes_tahap2 where tahun_pemilihan='".$tahun."' && wil_calon2='".$wil."' && locked = 1)

				group by A.id

                order by voted DESC, last_vote ASC"; //die($q);

        $r=$this->m_model->selectcustom($q);

        return $r;

	}



	public function cancelJemaatTerpilih1(){

		$data=array();

		$id_calon=$this->input->post('id_calon');

		$tahun_pemilihan=$this->input->post('tahun_pemilihan');

		$wilayah=$this->input->post('wilayah');

		$note=$this->input->post('note');

		$param=array();

		$param['anggota_jemaat_id']=clearText($id_calon);

		$param['tahun_pemilihan']=clearText($tahun_pemilihan);

		$param['status']=2;

		$param['note']=clearText($note);

		$param['kwg_wil']=clearText($wilayah);

		$param['created_at']=date('Y-m-d H:i:s');

		$param['created_by']=$this->session->userdata('userdata')->username;

		$check=$this->m_model->selectas('anggota_jemaat_id', $param['anggota_jemaat_id'], 'jemaat_terpilih1');

		if(count($check)>0){

			$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Calon Terpilih sudah diproses! (Silahkan Segarkan Halaman Sistem Anda!)");

		}

		else{

			$q=$this->m_model->insertgetid($param,'jemaat_terpilih1');

			if($q){

				$json=array('status'=>1, 'msg'=>"Data Berhasil disimpan");

			}

			else{

				$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Data gagal disimpan");

			}

		}

		echo json_encode($json);

	}

	public function acceptJemaatTerpilih1(){

		//print_r($this->session->userdata('userdata')); die();

		$data=array();

		$id_calon=$this->input->post('id_calon');

		$tahun_pemilihan=$this->input->post('tahun_pemilihan');

		$wilayah=$this->input->post('wilayah');

		$note=$this->input->post('note');

		$param=array();

		$param['anggota_jemaat_id']=clearText($id_calon);

		$param['tahun_pemilihan']=clearText($tahun_pemilihan);

		$param['status']=1;

		$param['note']=clearText($note);

		$param['kwg_wil']=clearText($wilayah);

		$param['created_at']=date('Y-m-d H:i:s');

		$param['created_by']=$this->session->userdata('userdata')->username;



		$check=$this->m_model->selectas('anggota_jemaat_id', $param['anggota_jemaat_id'], 'jemaat_terpilih1');

		if(count($check)>0){

			$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Calon Terpilih sudah diproses! (Silahkan Segarkan Halaman Sistem Anda!)");

		}

		else{

			$q=$this->m_model->insertgetid($param,'jemaat_terpilih1');

			if($q){

				$json=array('status'=>1, 'msg'=>"Data Berhasil disimpan");

			}

			else{

				$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Data gagal disimpan");

			}

		}

		echo json_encode($json);

	}



	public function cancelJemaatTerpilih2(){

		$data=array();

		$id_calon=$this->input->post('id_calon');

		$tahun_pemilihan=$this->input->post('tahun_pemilihan');

		$wilayah=$this->input->post('wilayah');

		$note=$this->input->post('note');

		$param=array();

		$param['anggota_jemaat_id']=clearText($id_calon);

		$param['tahun_pemilihan']=clearText($tahun_pemilihan);

		$param['status']=2;

		$param['note']=clearText($note);

		$param['kwg_wil']=clearText($wilayah);

		$param['created_at']=date('Y-m-d H:i:s');

		$param['created_by']=$this->session->userdata('userdata')->username;



		$check=$this->m_model->selectas('anggota_jemaat_id', $param['anggota_jemaat_id'], 'jemaat_terpilih2');

		if(count($check)>0){

			$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Calon Terpilih sudah diproses! (Silahkan Segarkan Halaman Sistem Anda!)");

		}

		else{

			$q=$this->m_model->insertgetid($param,'jemaat_terpilih2');

			if($q){

				$json=array('status'=>1, 'msg'=>"Data Berhasil disimpan");

			}

			else{

				$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Data gagal disimpan");

			}

		}

		echo json_encode($json);

	}

	public function acceptJemaatTerpilih2(){

		//print_r($this->session->userdata('userdata')); die();

		$data=array();

		$id_calon=$this->input->post('id_calon');

		$tahun_pemilihan=$this->input->post('tahun_pemilihan');

		$wilayah=$this->input->post('wilayah');

		$note=$this->input->post('note');

		$param=array();

		$param['anggota_jemaat_id']=clearText($id_calon);

		$param['tahun_pemilihan']=clearText($tahun_pemilihan);

		$param['status']=1;

		$param['note']=clearText($note);

		$param['kwg_wil']=clearText($wilayah);

		$param['created_at']=date('Y-m-d H:i:s');

		$param['created_by']=$this->session->userdata('userdata')->username;

		$check=$this->m_model->selectas('anggota_jemaat_id', $param['anggota_jemaat_id'], 'jemaat_terpilih2');

		if(count($check)>0){

			$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Calon Terpilih sudah diproses! (Silahkan Segarkan Halaman Sistem Anda!)");

		}

		else{

			$q=$this->m_model->insertgetid($param,'jemaat_terpilih2');

			if($q){

				$json=array('status'=>1, 'msg'=>"Data Berhasil disimpan");

			}

			else{

				$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Data gagal disimpan");

			}

		}

		echo json_encode($json);

	}



	public function cancelJemaatTerpilih_ppj(){

		$data=array();

		$id_calon=$this->input->post('id_calon');

		$tahun_pemilihan=$this->input->post('tahun_pemilihan');

		$wilayah=$this->input->post('wilayah');

		$note=$this->input->post('note');

		$param=array();

		$param['anggota_jemaat_id']=clearText($id_calon);

		$param['tahun_pemilihan']=clearText($tahun_pemilihan);

		$param['status']=2;

		$param['note']=clearText($note);

		$param['kwg_wil']=clearText($wilayah);

		$param['created_at']=date('Y-m-d H:i:s');

		$param['created_by']=$this->session->userdata('userdata')->username;

		$check=$this->m_model->selectas('anggota_jemaat_id', $param['anggota_jemaat_id'], 'jemaat_terpilih_ppj');

		if(count($check)>0){

			$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Calon Terpilih sudah diproses! (Silahkan Segarkan Halaman Sistem Anda!)");

		}

		else{

			$q=$this->m_model->insertgetid($param,'jemaat_terpilih_ppj');

			if($q){

				$json=array('status'=>1, 'msg'=>"Data Berhasil disimpan");

			}

			else{

				$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Data gagal disimpan");

			}

		}

		echo json_encode($json);

	}

	public function acceptJemaatTerpilih_ppj(){

		//print_r($this->session->userdata('userdata')); die();

		$data=array();

		$id_calon=$this->input->post('id_calon');

		$tahun_pemilihan=$this->input->post('tahun_pemilihan');

		$wilayah=$this->input->post('wilayah');

		$note=$this->input->post('note');

		$param=array();

		$param['anggota_jemaat_id']=clearText($id_calon);

		$param['tahun_pemilihan']=clearText($tahun_pemilihan);

		$param['status']=1;

		$param['note']=clearText($note);

		$param['kwg_wil']=clearText($wilayah);

		$param['created_at']=date('Y-m-d H:i:s');

		$param['created_by']=$this->session->userdata('userdata')->username;

		$check=$this->m_model->selectas('anggota_jemaat_id', $param['anggota_jemaat_id'], 'jemaat_terpilih_ppj');

		if(count($check)>0){

			$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Calon Terpilih sudah diproses! (Silahkan Segarkan Halaman Sistem Anda!)");

		}

		else{

			$q=$this->m_model->insertgetid($param,'jemaat_terpilih_ppj');

			if($q){

				$json=array('status'=>1, 'msg'=>"Data Berhasil disimpan");

			}

			else{

				$json=array('status'=>0, 'msg'=>"Ooppsss... Terjadi kesalahan, Data gagal disimpan");

			}

		}

		echo json_encode($json);

	}



	public function kunciPilihan(){

		$data=array();

		$id_pemilih=$this->input->post('id_pemilih');

		$wil_pemilih=$this->input->post('wil_pemilih');



		$param=array();

		$param['locked']=1;

		$q=$this->m_model->updateas2('id_pemilih', $id_pemilih, 'wil_pemilih', $wil_pemilih, $param, 'votes_tahap1');

		if($q){

			$json=array('status'=>1, 'msg'=>'Berhasil, Data Calon Pilihan Anda telah di Kunci!');

		}

		else {

			$json=array('status'=>0, 'msg'=>'Ooppsss... Terjadi Kesalahan, Data Calon Pilihan Anda gagal di Kunci!');

		}

		echo json_encode($json);

	}


	public function kunciPilihan_konvensional(){

		$data=array();
		$token=$this->input->post('token');

		$admin=$this->session->userdata('userdata')->username;

		$id_pemilih=$this->input->post('id_pemilih');

		$wil_pemilih=$this->input->post('wil_pemilih');



		$param=array();

		$param['locked']=1;

		$param['admin']=$admin;

		$param['sn_surat_suara']=$token;

		$q=$this->m_model->updateas2('id_pemilih', $id_pemilih, 'wil_pemilih', $wil_pemilih, $param, 'votes_tahap1');

		if($q){

			$json=array('status'=>1, 'msg'=>'Berhasil, Data Calon Pilihan Anda telah di Kunci!');

		}

		else {

			$json=array('status'=>0, 'msg'=>'Ooppsss... Terjadi Kesalahan, Data Calon Pilihan Anda gagal di Kunci!');

		}

		echo json_encode($json);

	}

	public function kunciPilihan_konvensional_pnt2(){

		$data=array();
		$token=$this->input->post('token');

		$admin=$this->session->userdata('userdata')->username;

		$id_pemilih=$this->input->post('id_pemilih');

		$wil_pemilih=$this->input->post('wil_pemilih');



		$param=array();

		$param['locked']=1;

		$param['admin']=$admin;

		$param['sn_surat_suara']=$token;

		$q=$this->m_model->updateas2('id_pemilih', $id_pemilih, 'wil_pemilih', $wil_pemilih, $param, 'votes_tahap2');

		if($q){

			$json=array('status'=>1, 'msg'=>'Berhasil, Data Calon Pilihan Anda telah di Kunci!');

		}

		else {

			$json=array('status'=>0, 'msg'=>'Ooppsss... Terjadi Kesalahan, Data Calon Pilihan Anda gagal di Kunci!');

		}

		echo json_encode($json);

	}



	public function kunciPilihan_ppj(){

		$data=array();

		$id_pemilih=$this->input->post('id_pemilih');

		$wil_pemilih=$this->input->post('wil_pemilih');



		$param=array();

		$param['locked']=1;

		$q=$this->m_model->updateas2('id_pemilih', $id_pemilih, 'wil_pemilih', $wil_pemilih, $param, 'votes_tahap_ppj');

		if($q){

			$json=array('status'=>1, 'msg'=>'Berhasil, Data Calon Pilihan Anda telah di Kunci!');

		}

		else {

			$json=array('status'=>0, 'msg'=>'Ooppsss... Terjadi Kesalahan, Data Calon Pilihan Anda gagal di Kunci!');

		}

		echo json_encode($json);

	}



	public function kunciPilihan_ppj_konvensional(){

		$data=array();

		$token=$this->input->post('token');

		$admin=$this->session->userdata('userdata')->username;

		$id_pemilih=$this->input->post('id_pemilih');

		$wil_pemilih=$this->input->post('wil_pemilih');



		$param=array();

		$param['locked']=1;

		$param['admin']=$admin;

		$param['sn_surat_suara']=$token;

		$q=$this->m_model->updateas2('id_pemilih', $id_pemilih, 'wil_pemilih', $wil_pemilih, $param, 'votes_tahap_ppj');

		if($q){

			$json=array('status'=>1, 'msg'=>'Berhasil, Data Calon Pilihan Anda telah di Kunci!');

		}

		else {

			$json=array('status'=>0, 'msg'=>'Ooppsss... Terjadi Kesalahan, Data Calon Pilihan Anda gagal di Kunci!');

		}

		echo json_encode($json);

	}



	public function kunciPilihan2(){

		$data=array();

		$id_pemilih=$this->input->post('id_pemilih');

		$wil_pemilih=$this->input->post('wil_pemilih');



		$param=array();

		$param['locked']=1;

		$q=$this->m_model->updateas2('id_pemilih', $id_pemilih, 'wil_pemilih', $wil_pemilih, $param, 'votes_tahap2');

		if($q){

			$json=array('status'=>1, 'msg'=>'Berhasil, Data Calon Pilihan Anda telah di Kunci!');

		}

		else {

			$json=array('status'=>0, 'msg'=>'Ooppsss... Terjadi Kesalahan, Data Calon Pilihan Anda gagal di Kunci!');

		}

		echo json_encode($json);

	}



	public function list_calon_penatua2(){

		$nama_anggota=$this->input->get('nama_anggota');
		$jns_kelamin=$this->input->get('jns_kelamin');
		$id_pemilih=$this->input->get('id');

		$wil_pemilih=$this->input->get('kwg_wil');

		$tahun_pemilihan=date('Y');

		$where="";

		$param_active="?";

		$data=array();

		$data['id_pemilih']=$id_pemilih;

		$data['wil_pemilih']=$wil_pemilih;

		$data['hak_suara']=10;

		$numLimit=10;

        $numStart=0;

        if($this->input->get('keyword')){

        	$keyword=clearText($this->input->get('keyword'));

        	$where=" && LOWER(A.nama_lengkap) like '%".strtolower($keyword)."%'";

			$param_active="keyword=".$this->input->get('keyword');	

        }
        if($this->input->get('kwg_wil')){


        	$where.=" && A.kwg_wil = '".$wil_pemilih."'";

			$param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";	

        }
        if($this->input->get('nama_anggota')){


        	$where.=" && LOWER(A.nama_lengkap) like '%".strtolower($nama_anggota)."%'";

			$param_active.="nama_anggota=".$this->input->get('nama_anggota')."&";	

        }

        if($this->input->get('jns_kelamin')){


        	$where.=" && LOWER(A.jns_kelamin) like '%".strtolower($jns_kelamin)."%'";

			$param_active.="jns_kelamin=".$this->input->get('jns_kelamin')."&";	

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

	        $limit="";

        }



        $data['page']=$page;

        $data['numStart']=$numStart;

		//get all calon penatua perwilayah

        /*start get data */

		$get_data=$this->get_data_calon_penatua2($tahun_pemilihan, $id_pemilih, $where, $limit);





    	$data['totalofData']=count($get_data);

    	//echo $data['totalofData'];

        $page_active=$page;

        $param_active=base_url().'pnppj/list_calon_penatua2'.$param_active;

    	$data['pagingnation']=pagingnation($data['totalofData'], $numLimit, $page_active, $param_active, $links=2);

    	if($page>1){

            array_splice($get_data, 0, $numStart);

            array_splice($get_data,$numLimit );

        }

        else{

            array_splice($get_data, $numStart+$numLimit);

        }





		$data['calon']=$get_data;

		//print_r($data['calon']);die();



		



    	if(!$this->input->get('view') && !$this->input->post('view')){

			$this->load->view('pemilu/list_calon_penatua2', $data);

		}

    	else{

			$this->load->view('pemilu/list_calon2', $data);

    	}

	}

	public function list_calonppj(){

		$nama_anggota=$this->input->get('nama_anggota');
		$jns_kelamin=$this->input->get('jns_kelamin');
		$id_pemilih=$this->input->get('id');

		$wil_pemilih=$this->input->get('kwg_wil');

		$tahun_pemilihan=date('Y');

		$where="";

		$param_active="?";

		$data=array();

		$data['id_pemilih']=$id_pemilih;

		$data['wil_pemilih']=$wil_pemilih;

		$data['hak_suara']=10;

		$numLimit=10;

        $numStart=0;

        if($this->input->get('keyword')){

        	$keyword=clearText($this->input->get('keyword'));

        	$where=" && LOWER(A.nama_lengkap) like '%".strtolower($keyword)."%'";

			$param_active="keyword=".$this->input->get('keyword');	

        }
        if($this->input->get('kwg_wil')){


        	$where.=" && A.kwg_wil = '".$wil_pemilih."'";

			$param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";	

        }
        if($this->input->get('nama_anggota')){


        	$where.=" && LOWER(A.nama_lengkap) like '%".strtolower($nama_anggota)."%'";

			$param_active.="nama_anggota=".$this->input->get('nama_anggota')."&";	

        }

        if($this->input->get('jns_kelamin')){


        	$where.=" && LOWER(A.jns_kelamin) like '%".strtolower($jns_kelamin)."%'";

			$param_active.="jns_kelamin=".$this->input->get('jns_kelamin')."&";	

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

	        $limit="";

        }



        $data['page']=$page;

        $data['numStart']=$numStart;

		//get all calon penatua perwilayah

        /*start get data */

		$get_data=$this->get_data_calon_ppj($tahun_pemilihan, $id_pemilih, $where, $limit);





    	$data['totalofData']=count($get_data);

    	//echo $data['totalofData'];

        $page_active=$page;

        $param_active=base_url().'pnppj/list_calonppj'.$param_active;

    	$data['pagingnation']=pagingnation($data['totalofData'], $numLimit, $page_active, $param_active, $links=2);

    	if($page>1){

            array_splice($get_data, 0, $numStart);

            array_splice($get_data,$numLimit );

        }

        else{

            array_splice($get_data, $numStart+$numLimit);

        }





		$data['calon']=$get_data;

		//print_r($data['calon']);die();



		



    	if(!$this->input->get('view') && !$this->input->post('view')){

			$this->load->view('pemilu/list_calonppj', $data);

		}

    	else{

			$this->load->view('pemilu/listcalonppj', $data);

    	}

	}

	private function get_data_calon_penatua2_srt($tahun_pemilihan, $id_pemilih, $where, $limit, $wil_pemilih=null){
		$sql="select A.*, B.status_kawin, count(D.id) as terpilih1, D.status as status_acc, Count(C.id) as voted2, A.kwg_wil, COUNT(C.id) as voted, C.locked
				from anggota_jemaat A 
				join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap2 C on C.id_calon2 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				where  A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 >=25 && D.status = 1
				";

		$group_by=" group by A.id ";
        //$field_order=" order by voted DESC, A.nama_lengkap  ";
        //$field_order=" order by voted DESC, D.persen_vote DESC, D.last_vote ASC";
        $field_order=" order by A.kwg_wil ASC, voted DESC, D.persen_vote DESC, D.last_vote ASC";

		$sql="select  W.num_row, W.nama_lengkap, W.jns_kelamin, W.tgl_lahir, W.kwg_no, W.foto, W.foto_thumb, W.status_kawin, W.terpilih1, W.status_acc, W.voted2, W.kwg_wil, W.voted, W.locked, W.sts_kawin, W.id from
			(select @rownum := @rownum + 1 AS num_row,  Y.nama_lengkap, Y.jns_kelamin, Y.tgl_lahir, Y.kwg_no, Y.foto, Y.foto_thumb, Y.status_kawin, Y.terpilih1, Y.status_acc, Y.voted2, Y.kwg_wil, Y.voted, Y.locked, Y.sts_kawin, Y.id from (
				select Z.nama_lengkap, Z.jns_kelamin, Z.tgl_lahir, Z.kwg_no, Z.foto, Z.foto_thumb, Z.status_kawin, Z.terpilih1, Z.status_acc, Z.voted2, Z.kwg_wil, Z.voted, Z.locked, Z.sts_kawin, Z.id
				from ( select A.nama_lengkap, A.jns_kelamin, A.tgl_lahir, A.kwg_no, A.foto, A.foto_thumb, B.status_kawin, count(D.id) as terpilih1, D.status as status_acc, Count(C.id) as voted2, A.kwg_wil, COUNT(C.id) as voted, C.locked, A.sts_kawin, A.id
				from anggota_jemaat A 
				join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap2 C on C.id_calon2 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				where  A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 >=25 && D.status = 1 && A.kwg_wil = '".$wil_pemilih."' ".$where." ".$group_by." ".$field_order."
				) Z

				UNION ALL
				select Z.nama_lengkap, Z.jns_kelamin, Z.tgl_lahir, Z.kwg_no, Z.foto, Z.foto_thumb, Z.status_kawin, Z.terpilih1, Z.status_acc, Z.voted2, Z.kwg_wil, Z.voted, Z.locked, Z.sts_kawin, Z.id
				from (

				select A.nama_lengkap, A.jns_kelamin, A.tgl_lahir, A.kwg_no, A.foto, A.foto_thumb, B.status_kawin, count(D.id) as terpilih1, D.status as status_acc, Count(C.id) as voted2, A.kwg_wil, COUNT(C.id) as voted, C.locked, A.sts_kawin, A.id
				from anggota_jemaat A 
				join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id
				left join ags_sts_kawin B on B.id = A.sts_kawin
				left join votes_tahap2 C on C.id_calon2 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
				where  A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 >=25 && D.status = 1 && A.kwg_wil != '".$wil_pemilih."' ".$where." ".$group_by." ".$field_order.") Z
				) Y, (SELECT @rownum := 0) r) W
				order by W.voted DESC, W.num_row ASC
				
				"; 
				//&& DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 <=65
		//die($sql);
        $order_by="  ";
        //die($sql." ".$group_by." ".$field_order." ".$order_by." ".$limit);
        //$get_data=$this->m_model->selectcustom($sql." ".$group_by." ".$field_order." ".$order_by." ".$limit);
        $get_data=$this->m_model->selectcustom($sql." ".$limit);
        return $get_data;
	}


	public function get_data_calon_ppj($tahun_pemilihan, $id_pemilihan=null, $where=null, $limit){

		$data=array();



		$sql="select A.*, B.status_kawin, D.id as terpilih1, D.status_ppj as status_acc, E.kwg_nama, E.kwg_alamat, C.hub_keluarga

				from anggota_jemaat A 

				join anggota_jemaat_bakal_calon D on D.anggota_jemaat_id = A.id  && D.tahun_pemilihan='".$tahun_pemilihan."'

				left join ags_sts_kawin B on B.id = A.sts_kawin

				join keluarga_jemaat E on E.id = A.kwg_no

				join ags_hub_kwg C on C.id = A.hub_kwg

				where  A.sts_anggota=1 && A.status=1 && D.status_ppj = 1

				"; 

		if($where!=null){
			$sql="select A.*, B.status_kawin, D.id as terpilih1, D.status_ppj as status_acc, E.kwg_nama, E.kwg_alamat, C.hub_keluarga

				from anggota_jemaat A 

				left join anggota_jemaat_bakal_calon D on D.anggota_jemaat_id = A.id  && D.tahun_pemilihan='".$tahun_pemilihan."'

				left join ags_sts_kawin B on B.id = A.sts_kawin

				join keluarga_jemaat E on E.id = A.kwg_no

				join ags_hub_kwg C on C.id = A.hub_kwg

				where  A.sts_anggota=1 && A.status=1

				"; 
		}

		$group_by=" group by A.id ";

        //$field_order=" order by A.nama_lengkap  ";
        $field_order="  order by D.no_urut_ppj ASC ";

        $order_by=" ";

       // die($sql." ".$where." ".$group_by." ".$field_order." ".$order_by." ".$limit);
        $get_data=$this->m_model->selectcustom($sql." ".$where." ".$group_by." ".$field_order." ".$order_by." ".$limit);
        #die(nl2br($sql." ".$where." ".$group_by." ".$field_order." ".$order_by." ".$limit));

        //die($sql." ".$where." ".$group_by." ".$field_order." ".$order_by." ".$limit);

        return $get_data;

	}

	public function upload_foto_ppj(){

		$data=array();

		$action="view";

		if($this->input->post('action')){

			$action=$this->input->post('action');

		}



		if($action == 'view'){

			$data['recid']=$this->input->post('recid');

			$this->load->view('pemilu/upload_foto_calonppj.php', $data);

		}

		else if($action == 'upload'){

			//print_r($this->input->post()); die();

			$recid=$this->input->post('recid');

		 	$config['upload_path']          = FCPATH.'/images/anggota_jemaat';

		 	$config['file_name']          	= $recid."-".uniqid();

		 	$config['allowed_types']        = 'jpg|png|jpeg|gif';



            $this->load->library('upload', $config);



            if ( ! $this->upload->do_upload('file'))

            {

                    //$error = array('error' => $this->upload->display_errors());



                    echo $this->upload->display_errors();

            }

            else

            {

            	$nameFileNew=$this->upload->data('file_name');

            	$config['image_library'] = 'gd2';

				$config['source_image'] = FCPATH.'/images/anggota_jemaat/'.$nameFileNew;

				$config['create_thumb'] = TRUE;

				$config['maintain_ratio'] = TRUE;

				$config['width']         = 120;

				//$config['height']         = 120;

				$this->load->library('image_lib', $config);



				$this->image_lib->resize();



				//after resize update field foto 

				$param=array();

				$param['foto']="images/anggota_jemaat/".$nameFileNew;

				$param['foto_thumb']="images/anggota_jemaat/".$this->upload->data('raw_name')."_thumb".$this->upload->data('file_ext');



				$this->m_model->updateas('id', $recid, $param, 'anggota_jemaat');

            }

		}



	}


	public function get_data_calon_penatua2($tahun_pemilihan, $id_pemilihan=null, $where=null, $limit){

		$data=array();



		$sql="select A.*, B.status_kawin, count(D.id) as terpilih1, D.status as status_acc, E.kwg_nama, E.kwg_alamat, C.hub_keluarga

				from anggota_jemaat A 

				join jemaat_terpilih1 D on D.anggota_jemaat_id = A.id  && D.tahun_pemilihan='".$tahun_pemilihan."'

				left join ags_sts_kawin B on B.id = A.sts_kawin

				join keluarga_jemaat E on E.id = A.kwg_no

				join ags_hub_kwg C on C.id = A.hub_kwg

				where  A.sts_anggota=1 && A.status=1 && YEAR(A.tgl_lahir) < 2005 && A.status_sidi=1 && DATEDIFF(CURRENT_DATE(), A.tgl_lahir)/365 >=25 && D.status = 1

				"; 

		$group_by=" group by A.id ";

        //$field_order=" order by A.nama_lengkap  ";
        $field_order="  order by D.persen_vote DESC, D.last_vote ASC ";

        $order_by=" ";

       // die($sql." ".$where." ".$group_by." ".$field_order." ".$order_by." ".$limit);
        $get_data=$this->m_model->selectcustom($sql." ".$where." ".$group_by." ".$field_order." ".$order_by." ".$limit);

        //die($sql." ".$where." ".$group_by." ".$field_order." ".$order_by." ".$limit);

        return $get_data;

	}



	public function upload_foto_calon2(){

		$data=array();

		$action="view";

		if($this->input->post('action')){

			$action=$this->input->post('action');

		}



		if($action == 'view'){

			$data['recid']=$this->input->post('recid');

			$this->load->view('pemilu/upload_foto_calon2.php', $data);

		}

		else if($action == 'upload'){

			//print_r($this->input->post()); die();

			$recid=$this->input->post('recid');

		 	$config['upload_path']          = FCPATH.'/images/anggota_jemaat';

		 	$config['file_name']          	= $recid."-".uniqid();

		 	$config['allowed_types']        = 'jpg|png|jpeg|gif';



            $this->load->library('upload', $config);



            if ( ! $this->upload->do_upload('file'))

            {

                    //$error = array('error' => $this->upload->display_errors());



                    echo $this->upload->display_errors();

            }

            else

            {

            	$nameFileNew=$this->upload->data('file_name');

            	$config['image_library'] = 'gd2';

				$config['source_image'] = FCPATH.'/images/anggota_jemaat/'.$nameFileNew;

				$config['create_thumb'] = TRUE;

				$config['maintain_ratio'] = TRUE;

				$config['width']         = 120;

				//$config['height']         = 120;

				$this->load->library('image_lib', $config);



				$this->image_lib->resize();



				//after resize update field foto 

				$param=array();

				$param['foto']="images/anggota_jemaat/".$nameFileNew;

				$param['foto_thumb']="images/anggota_jemaat/".$this->upload->data('raw_name')."_thumb".$this->upload->data('file_ext');



				$this->m_model->updateas('id', $recid, $param, 'anggota_jemaat');

            }

		}



	}



	function list_calon_penatua($type_report='reguler'){

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
		}

		$where="";
		$where_bakal_calon=" && tahun_pemilihan ='".$data['tahunpemilihan']."' ";

		$param_active="?";

		if($this->input->get('nama_anggota')){

			$param_active.="nama_anggota=".rawurldecode($this->input->get('nama_anggota'))."&";

			$where.=" && lower(A.nama_lengkap) like '%".rawurldecode($this->input->get('nama_anggota'))."%'";

		}



		if($this->input->get('jns_kelamin')){

			$param_active.="jns_kelamin=".$this->input->get('jns_kelamin')."&";

			$where.=" && lower(A.jns_kelamin) like '".$this->input->get('jns_kelamin')."'";

		}

		if($this->input->get('kwg_wil')){

			$param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";

			$where.=" && A.kwg_wil ='".$this->input->get('kwg_wil')."'";

		}

		if($this->input->get('seleksi_status')){

			$param_active.="seleksi_status=".$this->input->get('seleksi_status')."&";

		}

		if($this->input->get('status_pn1')){

			$param_active.="status_pn1=".$this->input->get('status_pn1')."&";
			if($this->input->get('status_pn1')==1){
				$where.=" && D.status_pn1 ='".$this->input->get('status_pn1')."'";
			}
			else if($this->input->get('status_pn1')==-1){
				#$where.=" && D.status_pn1 ='".$this->input->get('status_pn1')."'";
				$where.=" && D.status_pn1 IN (0,".$this->input->get('status_pn1').")";
			}


		}



		$sql="select A.*, B.kwg_nama, B.kwg_alamat, C.hub_keluarga, D.id as bakal_calon_id, D.tahun_pemilihan, D.status_pn1, D.status_ppj

				from anggota_jemaat A

				join keluarga_jemaat B on B.id = A.kwg_no

				join ags_hub_kwg C on C.idhubkel = A.hub_kwg

				#left 
				join  anggota_jemaat_bakal_calon D on D.anggota_jemaat_id = A.id ".$where_bakal_calon."

				where A.id >0 && A.status=1 && A.sts_anggota=1 && B.status=1".$where.""; //A.status=1 bearti tidak pernah di delete
				//left join  anggota_jemaat_bakal_calon baru di tambahin 27 Juni 2025 



		$group_by="  ";
		switch ($type_report) {
			case 'print':
        		$field_order=" order by B.kwg_nama, A.no_urut";
				break;

			default: 
        		$field_order=" order by A.nama_lengkap ";
		}


        $order_by=" ASC ";

        $numLimit=50;

        $numStart=0;

        if(!$this->input->get('page')){

            $page=1;

            $numStart=($numLimit*$page)-$numLimit;

        }

        else{

            $page=$this->input->get('page');

            $numStart=($numLimit*$page)-$numLimit;

        }

        $data['page']=$page;

        $data['numStart']=$numStart;

        $limit='LIMIT '.$numStart.', '.$numLimit;

        

        $data_jemaat=$this->m_model->selectcustom($sql." ".$group_by." ".$field_order." ".$order_by);

       #	die(nl2br($sql." ".$group_by." ".$field_order." ".$order_by));

        $data_jemaat_new=array();
        $data_jemaat_new_print=array();

        $jemaatDapatDipilih=0;

        $jemaatNonDipilih=0;

        foreach ($data_jemaat as $key => $value) {

        	$status_seleksi=0;

        	#$tglCutoff="2022-04-03";
        	$tglCutoff=$data['tahun_pemilihan']->tgl_peneguhan; 
        	#die($tglCutoff);

        	if( $value->tgl_lahir == '0000-00-00'){

				$umurLahir=0;

			}else{

				$umurLahir=getUmur($tglCutoff, $value->tgl_lahir);

			}

			if( $value->tgl_sidi == '0000-00-00'){

				$umurSidi=0;

			}

			else{

				$umurSidi=getUmur($tglCutoff, $value->tgl_sidi);

			}

			if( $value->tgl_attestasi_masuk == '0000-00-00'){

				$umurAttesasi=0;

			}

			else{

				$umurAttesasi=getUmur($tglCutoff, $value->tgl_attestasi_masuk);

			}



			$value->attestasi_cocok='<i class="fa fa-times text-danger"></i>';

			$value->sidi_cocok='<i class="fa fa-times text-danger"></i>';

			$value->umur_cocok='<i class="fa fa-times text-danger"></i>';

			if($umurLahir<=65 && $umurLahir>=25){

				#$value->umur_cocok=$umurLahir.'Th <i class="fa fa-check-square text-success"></i>'.$tglCutoff.' '.$value->tgl_lahir;
				$value->umur_cocok=$umurLahir.'Th <i class="fa fa-check-square text-success"></i>';

				$status_seleksi=$status_seleksi+1;

			}else{

				$value->umur_cocok=$umurLahir.'Th <i class="fa fa-times text-danger"></i>';

			}



			if($umurSidi<2 || ($umurAttesasi <1 && $value->tgl_attestasi_masuk != '0000-00-00') ){

				//continue;

				$value->attestasi_cocok='<i class="fa fa-times text-danger"></i>';

				$status_seleksi=0;

			}

			else{

				$value->attestasi_cocok='<i class="fa fa-check-square text-success"></i>';

				$value->sidi_cocok=$umurSidi.'Th <i class="fa fa-check-square text-success"></i>';

				$status_seleksi=$status_seleksi+1;

			}

			$param_sts_bacal=array();
			if($value->bakal_calon_id==NULL){
				if($data['tahunpemilihan']==2021){
					//ini tahun 2021 masih perlu ambil dari data status yg lama di table anggota_jemaat
					$param_sts_bacal['tahun_pemilihan']=$data['tahunpemilihan'];
					$param_sts_bacal['status_pn1']=$value->status_pn1_old;
					$param_sts_bacal['anggota_jemaat_id']=$value->id;
					$param_sts_bacal['created_at']=date('Y-m-d H:i:s');
				}
				else{
					//ini tahun berjalan sudah bisa otomatis
					$param_sts_bacal['tahun_pemilihan']=$data['tahunpemilihan'];
					if($status_seleksi==2){
						// ini bearti lulus pengecekan umur lahir dan umur sidi/umur attestasi
						$param_sts_bacal['status_pn1']=1;
					}
					else{
						$param_sts_bacal['status_pn1']=0;
					}
					$param_sts_bacal['anggota_jemaat_id']=$value->id;
					$param_sts_bacal['created_at']=date('Y-m-d H:i:s');

				}
				//ini bearti bearti perlu di input dulu, karena datanya belum ada di table daftar bakal calon
				$i_bacal=$this->m_model->insertgetid($param_sts_bacal, 'anggota_jemaat_bakal_calon');

				//ini reinisiasi value
				$value->status_pn1=$param_sts_bacal['status_pn1'];
			}



			if($this->input->get('seleksi_status')==-1){

				//ini untuk memunculkan tidak sesuai kriteria

				if($status_seleksi>1){

					continue;

				}

				else{

					$value->status_seleksi=$status_seleksi;

					$data_jemaat_new[]=$value;

				}

			}else if($this->input->get('seleksi_status')==1){

				if($status_seleksi<2){

					continue;

				}

				else{

					$value->status_seleksi=$status_seleksi;

					$data_jemaat_new[]=$value;

				}

			}else{
				$value->status_seleksi=$status_seleksi;

				$data_jemaat_new[]=$value;

			}



			if( $value->status_pn1 == 1){

				$jemaatDapatDipilih++;

			}

			else{

				$jemaatNonDipilih++;

			}



        }

        $data['jemaatDapatDipilih']=$jemaatDapatDipilih;

        $data['jemaatNonDipilih']=$jemaatNonDipilih;

        

        $data['TotalOfData']=count($data_jemaat_new);

        //TotalOfProduct($query_product." ".$where." ".$group_by." ".$field_order." ".$order_by);

        //$data['TotalOfPage']=TotalOfPage($data['TotalOfProduct'], 30);//30 is limit item per page

        if(!$this->input->get('page')){

            $page_active=1;

        }else{

            $page_active=$this->input->get('page');

        }

        

        if($type_report !='print'){

        	$data['pagingnation']=pagingnation($data['TotalOfData'], $numLimit, $page_active, $param_active, $links=2);

	        if($page>1){

	            array_splice($data_jemaat_new, 0, $numStart);

	            array_splice($data_jemaat_new,$numLimit );

	        }

	        else{

	            array_splice($data_jemaat_new, $numStart+$numLimit);

	        }

        }



		$data['data_jemaat']=$data_jemaat_new;

		switch ($type_report) {

			case 'reguler':

				// code...

				$this->load->view('pemilu/list_calon_penatua',$data);

				break;

			case 'print':

				// code...

				$this->load->view('pemilu/list_calon_penatua_print',$data);

				break;

			default:

				// code...

				$this->load->view('pemilu/list_calon_penatua_print',$data);

				break;

		}

	}



	function list_calon_ppj($type_report='reguler'){

		$data=array();

		$where="";

		$param_active="?";

		if($this->input->get('nama_anggota')){

			$param_active.="nama_anggota=".rawurldecode($this->input->get('nama_anggota'))."&";

			$where.=" && lower(A.nama_lengkap) like '%".rawurldecode($this->input->get('nama_anggota'))."%'";

		}



		if($this->input->get('jns_kelamin')){

			$param_active.="jns_kelamin=".$this->input->get('jns_kelamin')."&";

			$where.=" && lower(A.jns_kelamin) like '".$this->input->get('jns_kelamin')."'";

		}

		if($this->input->get('kwg_wil')){

			$param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";

			$where.=" && A.kwg_wil ='".$this->input->get('kwg_wil')."'";

		}

		if($this->input->get('status_pn1')){

			$param_active.="status_pn1=".$this->input->get('status_pn1')."&";

			$where.=" && A.status_pn1 ='".$this->input->get('status_pn1')."'";

		}



		$sql="select A.*, B.kwg_nama, B.kwg_alamat, C.hub_keluarga

				from anggota_jemaat A

				join keluarga_jemaat B on B.id = A.kwg_no

				join ags_hub_kwg C on C.id = A.hub_kwg

				where A.id >0 && A.status=1 && A.sts_anggota=1 && B.status=1 && A.status_sidi=1 ".$where.""; //A.status=1 bearti tidak pernah di delete



		$group_by="  ";

        $field_order=" order by A.nama_lengkap ";

        $order_by=" ASC ";

        $numLimit=50;

        $numStart=0;

        if(!$this->input->get('page')){

            $page=1;

            $numStart=($numLimit*$page)-$numLimit;

        }

        else{

            $page=$this->input->get('page');

            $numStart=($numLimit*$page)-$numLimit;

        }

        $data['page']=$page;

        $data['numStart']=$numStart;

        $limit='LIMIT '.$numStart.', '.$numLimit;

        

        $data_jemaat=$this->m_model->selectcustom($sql." ".$group_by." ".$field_order." ".$order_by);

        $data_jemaat_new=array();

        /*foreach ($data_jemaat as $key => $value) {

        	$status_seleksi=0;

        	$tglCutoff="2022-04-03";

        	if( $value->tgl_lahir == '0000-00-00'){

				$umurLahir=0;

			}else{

				$umurLahir=getUmur($tglCutoff, $value->tgl_lahir);

			}

			if( $value->tgl_sidi == '0000-00-00'){

				$umurSidi=0;

			}

			else{

				$umurSidi=getUmur($tglCutoff, $value->tgl_sidi);

			}

			if( $value->tgl_attestasi_masuk == '0000-00-00'){

				$umurAttesasi=0;

			}

			else{

				$umurAttesasi=getUmur($tglCutoff, $value->tgl_attestasi_masuk);

			}



			$value->asjkdha1="umur tidak cocok";

			if($umurLahir<=65 && $umurLahir>=25){

				$value->asjkdha1="umur cocok";

				$status_seleksi=$status_seleksi+1;

			}



			if($umurSidi<2 || ($umurAttesasi <1 && $value->tgl_attestasi_masuk != '0000-00-00') ){

				//continue;

				$value->asjkdha2="sidi tidak cocok";

				$status_seleksi=0;

			}

			else{

				$value->asjkdha2="sidi cocok";

				$status_seleksi=$status_seleksi+1;

			}



			if($this->input->get('seleksi_status')==-1){

				//ini untuk memunculkan tidak sesuai kriteria

				if($status_seleksi>1){

					continue;

				}

				else{

					$value->asjkdha=$status_seleksi;

					$data_jemaat_new[]=$value;

				}

			}else if($this->input->get('seleksi_status')==1){

				if($status_seleksi<2){

					continue;

				}

				else{

					$value->asjkdha=$status_seleksi;

					$data_jemaat_new[]=$value;

				}

			}else{

				$value->asjkdha=$status_seleksi;

				$data_jemaat_new[]=$value;

			}

        }*/



        //$data['TotalOfData']=count($data_jemaat_new);

        $data['TotalOfData']=count($data_jemaat);

        //TotalOfProduct($query_product." ".$where." ".$group_by." ".$field_order." ".$order_by);

        //$data['TotalOfPage']=TotalOfPage($data['TotalOfProduct'], 30);//30 is limit item per page

        if(!$this->input->get('page')){

            $page_active=1;

        }else{

            $page_active=$this->input->get('page');

        }

        $data['pagingnation']=pagingnation($data['TotalOfData'], $numLimit, $page_active, $param_active, $links=2);



        if($page>1){

            array_splice($data_jemaat, 0, $numStart);

            array_splice($data_jemaat,$numLimit );

        }

        else{

            array_splice($data_jemaat, $numStart+$numLimit);

        }



		$data['data_jemaat']=$data_jemaat;

		switch ($type_report) {

			case 'reguler':

				// code...

				$this->load->view('pemilu/list_calon_penatua',$data);

				break;

			default:

				// code...

				$this->load->view('pemilu/anggota_jemaat',$data);

				break;

		}

	}



	function statuspn(){

		$data=array();

		if(!$this->input->is_ajax_request() ){

			die("Access Denied!");

		}



		$param=array();

		$param['status_pn1']=clearText($this->input->post('locked'));

		#$update=$this->m_model->updateas('id', clearText($this->input->post('recid')), $param , 'anggota_jemaat');
		//per 27 juni 2025 dari table anggota_jemaat_bakal_calon
		$update=$this->m_model->updateas('id', clearText($this->input->post('recid')), $param , 'anggota_jemaat_bakal_calon');

		$json=array();

		if($update){

			$json['status']=1;

			$json['msg']="Wow... Status Bakal Calon Berhasil di Update!";

		}

		else{

			$json['status']=0;

			$json['msg']="Oooppsss... Status Bakal Calon Gagal di Update!";	

		}



		echo json_encode($json);



	}


	function statusppj(){

		$data=array();

		if(!$this->input->is_ajax_request() ){

			die("Access Denied!");

		}



		$param=array();

		$param['status_ppj']=clearText($this->input->post('locked'));

		#$update=$this->m_model->updateas('id', clearText($this->input->post('recid')), $param , 'anggota_jemaat');
		//per 27 juni 2025 dari table anggota_jemaat_bakal_calon
		$update=$this->m_model->updateas('id', clearText($this->input->post('recid')), $param , 'anggota_jemaat_bakal_calon');

		$json=array();

		if($update){

			$json['status']=1;

			$json['msg']="Wow... Status Bakal Calon PPJ Berhasil di Update!";

		}

		else{

			$json['status']=0;

			$json['msg']="Oooppsss... Status Bakal Calon PPJ Gagal di Update!";	

		}



		echo json_encode($json);



	}



	function list_peserta_pemilhan($type_report='reguler'){

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
		}

		$where="";
		$where2="";

		$param_active="?";

		if($this->input->get('nama_anggota')){

			$param_active.="nama_anggota=".rawurldecode($this->input->get('nama_anggota'))."&";

			$where.=" && (lower(A.nama_lengkap) like '%".rawurldecode($this->input->get('nama_anggota'))."%' || lower(B.kwg_nama) like '%".rawurldecode($this->input->get('nama_anggota'))."%' )";
			$where2.=" && (lower(A.nama_lengkap) like '%".rawurldecode($this->input->get('nama_anggota'))."%' || lower(B.kwg_nama) like '%".rawurldecode($this->input->get('nama_anggota'))."%' )";

		}



		if($this->input->get('kwg_wil')){

			$param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";

			$where.=" && A.kwg_wil ='".$this->input->get('kwg_wil')."'";
			$where2.=" && A.kwg_wil ='".$this->input->get('kwg_wil')."'";

		}

		

$having_count="";

		if($this->input->get('methode_pemilihan') == '1'){

			$having_count=" HAVING COUNT(D.id)>0 ";

		}

		else if($this->input->get('methode_pemilihan') == '0'){

			$having_count=" HAVING COUNT(D.id) = 0 ";

		}
		else{
			#$param_active.="status_pn1=".$this->input->get('status_pn1')."&";
		}



		if($this->input->get('status_pn1')){

			$param_active.="status_pn1=".$this->input->get('status_pn1')."&";

			$where.=" && A.status_pn1 ='".$this->input->get('status_pn1')."'";

		}


		if($this->input->get('tahunpemilihan')){
			$param_active.="tahunpemilihan=".$this->input->get('tahunpemilihan')."&";

			$data['tahunpemilihan']=$this->input->get('tahunpemilihan');

		}



		$sql="select A.*, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(D.id) as num_pemilih_konvensional

				from keluarga_jemaat B

				join  anggota_jemaat A on B.id = A.kwg_no

				join ags_hub_kwg C on C.idhubkel = A.hub_kwg

				left join pemilih_konvensional D on D.anggota_jemaat_id = A.id && A.kwg_no = D.kwg_no && D.tahun_pemilihan ='".$data['tahun_pemilihan']->tahun."' 

				where A.id >0 && A.status=1 && A.sts_anggota=1 && B.status=1 && A.status_sidi=1 ".$where.""; //A.status=1 bearti tidak pernah di delete
				#mengecek sudah sidi apa belum saja tidak perlu tahun kelahiran.
				#&& YEAR(A.tgl_lahir) < 2005  

		$sql="select A.*, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(D.id) as num_pemilih_konvensional

				from anggota_jemaat_peserta_pemilihan E

				join anggota_jemaat A on E.anggota_jemaat_id = A.id

				join keluarga_jemaat B on B.id = A.kwg_no

				join ags_hub_kwg C on C.idhubkel = A.hub_kwg

				left join pemilih_konvensional D on D.anggota_jemaat_id = A.id && A.kwg_no = D.kwg_no && D.tahun_pemilihan ='".$data['tahun_pemilihan']->tahun."' 

				where A.id >0 && A.status=1 && A.status_sidi=1 && E.tahun_pemilihan ='".$data['tahun_pemilihan']->tahun."' ".$where.""; 
				# yg baru langsung cek ke jemaat peserta pemilihan



		$group_by=" group by B.id ".$having_count;

        $field_order=" order by B.kwg_nama ASC, A.no_urut ASC ";

        $order_by=" ";

        $numLimit=50;

        $numStart=0;

        if(!$this->input->get('page')){

            $page=1;

            $numStart=($numLimit*$page)-$numLimit;

        }

        else{

            $page=$this->input->get('page');

            $numStart=($numLimit*$page)-$numLimit;

        }

        $data['page']=$page;

        $data['numStart']=$numStart;

        $limit='LIMIT '.$numStart.', '.$numLimit;

        

        $data_kwg_jemaat=$this->m_model->selectcustom($sql." ".$group_by." ".$field_order." ".$order_by);

       	#die(nl2br($sql." ".$group_by." ".$field_order." ".$order_by));

        $data_keluarga_jemaat=array();

        $data_keluarga_jemaat_konvensional=array();

        $data_keluarga_jemaat_online=array();

        $ls_kwg_no=array();

        foreach ($data_kwg_jemaat as $key => $value) {

        	$data_keluarga_jemaat[]=$value;

        	if($value->num_pemilih_konvensional>0){

		        $data_keluarga_jemaat_konvensional[]=$value;

        	}

        	else{

		        $data_keluarga_jemaat_online[]=$value;

        	}

        	$ls_kwg_no[]=$value->kwg_no;

        }



        if(count($ls_kwg_no)>0){

        	$where.=" && A.kwg_no in (".implode(',', $ls_kwg_no).")";

        }

        else{

        	$where.=" && A.kwg_no = ''";

        }



        $sql_angjem="select A.*, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(D.id) as num_pemilih_konvensional, E.id as peserta_pemilihan_id, E.status_peserta_pn1, E.status_peserta_pn2, E.status_peserta_ppj, E.tahun_pemilihan

				from anggota_jemaat A

				join keluarga_jemaat B on B.id = A.kwg_no

				join ags_hub_kwg C on C.idhubkel = A.hub_kwg

				left join pemilih_konvensional D on D.anggota_jemaat_id = A.id && A.kwg_no = D.kwg_no && D.tahun_pemilihan ='".$data['tahun_pemilihan']->tahun."'  

				left join anggota_jemaat_peserta_pemilihan E on E.anggota_jemaat_id = A.id && E.tahun_pemilihan ='".$data['tahun_pemilihan']->tahun."'

				where A.id >0 && A.status=1 && A.sts_anggota=1 && B.status=1 && A.status_sidi=1 ".$where."

				group by A.id

				order by A.no_urut ASC, A.nama_lengkap ASC"; //die($sql_angjem);
				#mengecek sudah sidi apa belum saja tidak perlu tahun kelahiran.
				#&& YEAR(A.tgl_lahir) < 2005

		$sql_angjem="select A.*, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(D.id) as num_pemilih_konvensional, E.id as peserta_pemilihan_id, E.status_peserta_pn1, E.status_peserta_pn2, E.status_peserta_ppj, E.tahun_pemilihan

			from anggota_jemaat_peserta_pemilihan E

			join anggota_jemaat A on E.anggota_jemaat_id = A.id

			join keluarga_jemaat B on B.id = A.kwg_no

			join ags_hub_kwg C on C.idhubkel = A.hub_kwg 

			left join pemilih_konvensional D on D.anggota_jemaat_id = A.id && A.kwg_no = D.kwg_no && D.tahun_pemilihan ='".$data['tahun_pemilihan']->tahun."'  

			where A.id >0 && A.status_sidi=1 && E.tahun_pemilihan ='".$data['tahun_pemilihan']->tahun."' ".$where2."

			group by A.id

			order by A.no_urut ASC, A.nama_lengkap ASC"; //die($sql_angjem);
			 #yg terbaru tanpa cek keluarga, karena langsung ke anggota jemaat peserta pemilihan
			
			#&& A.status=1 && A.sts_anggota=1 && B.status=1 && 


		$data_jemaat=$this->m_model->selectcustom($sql_angjem);
		//echo count($data_jemaat);
		//die(nl2br($sql_angjem));





        $data_jemaat_new=array();

        $jemaatPesertaPemilihanOnline=0;

        $jemaatPesertaPemilihanKonvensional=0;



        foreach ($data_jemaat as $key => $value) {

        	$status_seleksi=0;

        	#$tglCutoff="2022-04-03";
        	#ini sudah dinamis
        	$tglCutoff=$data['tahun_pemilihan']->tgl_peneguhan;




        	if( $value->tgl_lahir == '0000-00-00'){

				$umurLahir=0;

			}else{

				$umurLahir=getUmur($tglCutoff, $value->tgl_lahir);

			}

			if( $value->tgl_sidi == '0000-00-00'){

				$umurSidi=0;

			}

			else{

				$umurSidi=getUmur($tglCutoff, $value->tgl_sidi);

			}

			if( $value->tgl_attestasi_masuk == '0000-00-00'){

				$umurAttesasi=0;

			}

			else{

				$umurAttesasi=getUmur($tglCutoff, $value->tgl_attestasi_masuk);

			}



			$value->attestasi_cocok='<i class="fa fa-times text-danger"></i>';

			$value->sidi_cocok='Belum (<i class="fa fa-times text-danger"></i>)';

			$value->umur_cocok='<i class="fa fa-times text-danger"></i>';

			/*if($umurLahir<=65 && $umurLahir>=25){

				$value->umur_cocok=$umurLahir.'Th <i class="fa fa-check-square text-success"></i>';

				$status_seleksi=$status_seleksi+1;

			}else{

				$value->umur_cocok=$umurLahir.'Th <i class="fa fa-times text-danger"></i>';

			}*/



			if($value->status_sidi ==0 ){

				//continue;

				$value->attestasi_cocok='<i class="fa fa-times text-danger"></i>';

				$status_seleksi=0;

			}

			else{

				$value->sidi_cocok="Sudah (".$umurSidi.'Th <i class="fa fa-check-square text-success"></i>)';

				$status_seleksi=$status_seleksi+1;

			}



			$value->status_seleksi=$status_seleksi;

			$data_jemaat_new[$value->kwg_no][]=$value;

			//echo($value->num_pemilih_konvensional);

			if( $value->num_pemilih_konvensional == 0){

				#print_r($value); die("asdasd");

				if($value->peserta_pemilihan_id !=null && $value->peserta_pemilihan_id > 0){
					$jemaatPesertaPemilihanOnline++;
				}
			}

			else{
				if($value->peserta_pemilihan_id !=null && $value->peserta_pemilihan_id > 0){
					$jemaatPesertaPemilihanKonvensional++;
				}

			}
			#echo $jemaatPesertaPemilihanKonvensional; die();



        }

        $data['jemaatPesertaPemilihanOnline']=$jemaatPesertaPemilihanOnline;

        $data['data_keluarga_jemaat_online']=$data_keluarga_jemaat_online;

        $data['jemaatPesertaPemilihanKonvensional']=$jemaatPesertaPemilihanKonvensional;

        $data['data_keluarga_jemaat_konvensional']=$data_keluarga_jemaat_konvensional;

        //print_r($data_jemaat_new[249]);die();

        $data['TotalOfData']=count($data_keluarga_jemaat);

        //TotalOfProduct($query_product." ".$where." ".$group_by." ".$field_order." ".$order_by);

        //$data['TotalOfPage']=TotalOfPage($data['TotalOfProduct'], 30);//30 is limit item per page

        if(!$this->input->get('page')){

            $page_active=1;

        }else{

            $page_active=$this->input->get('page');

        }

        $data['pagingnation']=pagingnation($data['TotalOfData'], $numLimit, $page_active, $param_active, $links=2);



        if($page>1){

            array_splice($data_keluarga_jemaat, 0, $numStart);

            array_splice($data_keluarga_jemaat,$numLimit );

        }

        else{

            array_splice($data_keluarga_jemaat, $numStart+$numLimit);

        }



		$data['data_keluarga_jemaat']=$data_keluarga_jemaat;



		$data['data_jemaat']=$data_jemaat_new;

		switch ($type_report) {

			case 'reguler':

				// code...

				$this->load->view('pemilu/list_peserta_pemilihan',$data);

				break;

			default:

				// code...

				//$this->load->view('pemilu/anggota_jemaat',$data);

				break;

		}

	}



	public function statusprosespemilihan(){

		$param=array();

		$data=array();

		$kwg_no=$this->input->post('recid');

		$angjemid_pemilih=$this->input->post('angjemid_pemilih');

		$tahun_pemilihan=$this->input->post('tahun_pemilihan');

		if($angjemid_pemilih!=0){

			$arr_angjemid_pemilih=explode(',', $angjemid_pemilih);

		}

		$locked=$this->input->post('locked');

		if($locked==0){

			//ini bearti memlih online

			//delete semua data pemilihan konvensional yang ada

			$q=$this->m_model->deleteas2('kwg_no', $kwg_no, 'tahun_pemilihan', $tahun_pemilihan,  'pemilih_konvensional');
			if($q){
				echo json_encode(array('sts'=>'OK!', 'msg'=>'Berhasil mendaftarkan sebagai pemilih Online!'));
			}
		}

		else{

			$tipe_pemilihan=$this->m_model->select('tipe_pemilihan');

			//ini bearti memlih secara konvensional

			//semua anggota keluarga yang memiliki hak suara akan mendapatkan serial angka surat suara

			foreach ($arr_angjemid_pemilih as $key => $value) {

				$param['kwg_no']=$kwg_no;

				$param['anggota_jemaat_id']=$value;
				if(isset($this->session->userdata('userdata')->username)){
					$param['created_by']=$this->session->userdata('userdata')->username;

				}

				foreach ($tipe_pemilihan as $keytipe_pemilihan => $valuetipe_pemilihan) {

				// code...

					$uniqid=uniqid();

					$sn_surat_suara=$uniqid;

					$generate_qrcode=$this->generate_qrcode($sn_surat_suara, $uniqid."-".$valuetipe_pemilihan->id);

					//$sn_surat_suara=crypt($uniqid, 'astha');

					//die($uniqid);

					$param['tipe_pemilihan_id']=$valuetipe_pemilihan->id;

					$param['tahun_pemilihan']=$tahun_pemilihan;

					$param['created_at']=date('Y-m-d H:i:s');

					$param['sn_surat_suara']=$sn_surat_suara;

					$param['path_qrcode']=$generate_qrcode;

					$q=$this->m_model->insertgetid($param, 'pemilih_konvensional');
				}
			}
			echo json_encode(array('sts'=>'OK!', 'msg'=>'Berhasil mendaftarkan sebagai pemilih Konvensional!'));
		}
	}



	private function generate_qrcode($sn_surat_suara=null, $file_name){

        $this->load->library('Ciqrcode');

        $data=array();

        $folder ='/images/qrcode_sn_surat_suara/';

        



        $config['cacheable']    = true; //boolean, the default is true

        //$config['cachedir']     = './assets/'; //string, the default is application/cache/

        //$config['errorlog']     = './assets/'; //string, the default is application/logs/

        $config['imagedir']     = $folder; //direktori penyimpanan qr code

        $config['quality']      = true; //boolean, the default is true

        $config['size']         = '1024'; //interger, the default is 1024

        $config['black']        = array(224,255,255); // array, default is array(255,255,255)

        $config['white']        = array(70,130,180); // array, default is array(0,0,0)

        $this->ciqrcode->initialize($config);



        $text1=$sn_surat_suara;

        $valueQRCODE=$sn_surat_suara;

        $file_name1 = $file_name.".png";



        $image_name=$file_name1; //buat name dari qr code sesuai dengan nip



        $params=array();

        $params['data'] = $valueQRCODE; //data yang akan di jadikan QR CODE

        $params['level'] = 'H'; //H=High

        $params['size'] = 10;

        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/

        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE



        return  $folder.$image_name;

    }



    public function polling_surat_suara_ppj(){

    	$data=array();

    	$where="";



    	$where="";

		$param_active="?";

		if($this->input->get('nama_anggota')){

			$param_active.="nama_anggota=".rawurldecode($this->input->get('nama_anggota'))."&";

			$where.=" && (lower(A.nama_lengkap) like '%".rawurldecode($this->input->get('nama_anggota'))."%' || lower(B.kwg_nama) like '%".rawurldecode($this->input->get('nama_anggota'))."%' )";

		}



		if($this->input->get('kwg_wil')){

			$param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";

			$where.=" && A.kwg_wil ='".$this->input->get('kwg_wil')."'";

		}

		



		if($this->input->get('seleksi_status')){

			$param_active.="seleksi_status=".$this->input->get('seleksi_status')."&";

		}

		if($this->input->get('status_pn1')){

			$param_active.="status_pn1=".$this->input->get('status_pn1')."&";

			$where.=" && A.status_pn1 ='".$this->input->get('status_pn1')."'";

		}



		$q="select A.nama_lengkap, A.id as angjem_id, A.kwg_wil, count(C.id) as voted, C.tahun_pemilihan, E.wilayah, C.sn_surat_suara, C.admin, D.nama_lengkap as calon, D.id as calon_id, D.kwg_wil as calon_wil, C.admin

				from  votes_tahap_ppj C

				join anggota_jemaat A on C.id_pemilih = A.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join anggota_jemaat D on C.id_calon1 = D.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join wilayah E on E.id = A.kwg_wil

				where C.locked=1 && C.sn_surat_suara is not null ".$where."";



		$group_by=" group by C.sn_surat_suara  ";

        $field_order=" order by C.id ASC ";

        $order_by=" ";

        $numLimit=50;

        $numStart=0;

        if(!$this->input->get('page')){

            $page=1;

            $numStart=($numLimit*$page)-$numLimit;

        }

        else{

            $page=$this->input->get('page');

            $numStart=($numLimit*$page)-$numLimit;

        }

        $data['page']=$page;

        $data['numStart']=$numStart;

        $limit='LIMIT '.$numStart.', '.$numLimit;



        $r=$this->m_model->selectcustom($q." ".$group_by." ".$field_order." ".$order_by);

        $data['TotalOfData']=count($r);



        //get _konvensional

        //$data['konvensional']=$this->m_model->selectas('tipe_pemilihan_id', 3, 'pemilih_konvensional');

        $q1="select A.*

        		from pemilih_konvensional A

        		join anggota_jemaat B on B.id = A.anggota_jemaat_id

        		where B.status=1 && B.sts_anggota=1 && A.tipe_pemilihan_id=3";



        $data['konvensional']=$this->m_model->selectcustom($q1);



        if(!$this->input->get('page')){

            $page_active=1;

        }else{

            $page_active=$this->input->get('page');

        }

        $data['pagingnation']=pagingnation($data['TotalOfData'], $numLimit, $page_active, $param_active, $links=2);



        if($page>1){

            array_splice($r, 0, $numStart);

            array_splice($r,$numLimit );

        }

        else{

            array_splice($r, $numStart+$numLimit);

        }







        $data['voting']=$r;



        $this->load->view('pemilu/polling_surat_suara_ppj', $data);



    }

    public function polling_surat_suara_pnt1(){

    	$data=array();

    	$where="";



    	$where="";

		$param_active="?";

		if($this->input->get('nama_anggota')){

			$param_active.="nama_anggota=".rawurldecode($this->input->get('nama_anggota'))."&";

			$where.=" && (lower(A.nama_lengkap) like '%".rawurldecode($this->input->get('nama_anggota'))."%' || lower(B.kwg_nama) like '%".rawurldecode($this->input->get('nama_anggota'))."%' )";

		}



		if($this->input->get('kwg_wil')){

			$param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";

			$where.=" && A.kwg_wil ='".$this->input->get('kwg_wil')."'";

		}

		



		if($this->input->get('seleksi_status')){

			$param_active.="seleksi_status=".$this->input->get('seleksi_status')."&";

		}

		if($this->input->get('status_pn1')){

			$param_active.="status_pn1=".$this->input->get('status_pn1')."&";

			$where.=" && A.status_pn1 ='".$this->input->get('status_pn1')."'";

		}



		$q="select A.nama_lengkap, A.id as angjem_id, A.kwg_wil, count(C.id) as voted, C.tahun_pemilihan, E.wilayah, C.sn_surat_suara, C.admin, D.nama_lengkap as calon, D.id as calon_id, D.kwg_wil as calon_wil, C.admin

				from  votes_tahap1 C

				join anggota_jemaat A on C.id_pemilih = A.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join anggota_jemaat D on C.id_calon1 = D.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join wilayah E on E.id = A.kwg_wil

				where C.locked=1 && C.sn_surat_suara is not null ".$where."";



		$group_by=" group by C.sn_surat_suara  ";

        $field_order=" order by C.id ASC ";

        $order_by=" ";

        $numLimit=50;

        $numStart=0;

        if(!$this->input->get('page')){

            $page=1;

            $numStart=($numLimit*$page)-$numLimit;

        }

        else{

            $page=$this->input->get('page');

            $numStart=($numLimit*$page)-$numLimit;

        }

        $data['page']=$page;

        $data['numStart']=$numStart;

        $limit='LIMIT '.$numStart.', '.$numLimit;



        $r=$this->m_model->selectcustom($q." ".$group_by." ".$field_order." ".$order_by);

        $data['TotalOfData']=count($r);



        //get _konvensional

        //$data['konvensional']=$this->m_model->selectas('tipe_pemilihan_id', 3, 'pemilih_konvensional');

        $q1="select A.*

        		from pemilih_konvensional A

        		join anggota_jemaat B on B.id = A.anggota_jemaat_id

        		where B.status=1 && B.sts_anggota=1 && A.tipe_pemilihan_id=1";



        $data['konvensional']=$this->m_model->selectcustom($q1);



        if(!$this->input->get('page')){

            $page_active=1;

        }else{

            $page_active=$this->input->get('page');

        }

        $data['pagingnation']=pagingnation($data['TotalOfData'], $numLimit, $page_active, $param_active, $links=2);



        if($page>1){

            array_splice($r, 0, $numStart);

            array_splice($r,$numLimit );

        }

        else{

            array_splice($r, $numStart+$numLimit);

        }







        $data['voting']=$r;


        //get calon dipilih
        $q1="select A.nama_lengkap, A.id as angjem_id, A.kwg_wil, count(C.id) as voted, C.tahun_pemilihan, E.wilayah, C.sn_surat_suara, C.admin, D.nama_lengkap as calon, D.id as calon_id, D.kwg_wil as calon_wil, C.admin

				from  votes_tahap1 C

				join anggota_jemaat A on C.id_pemilih = A.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join anggota_jemaat D on C.id_calon1 = D.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join wilayah E on E.id = A.kwg_wil

				where C.locked=1 && C.sn_surat_suara is not null ".$where."
				group by C.id ";
		$r1=$this->m_model->selectcustom($q1);
		$data['calon_vote']=array();
		foreach ($r1 as $key => $value) {
			// code...
			if(!isset($data['calon_vote'][$value->sn_surat_suara])){
				$data['calon_vote'][$value->sn_surat_suara]=array();
			}

			$data['calon_vote'][$value->sn_surat_suara][]=$value;
		}



        $this->load->view('pemilu/polling_surat_suara_pnt1', $data);



    }


    public function polling_surat_suara_pnt2(){

    	$data=array();

    	$where="";



    	$where="";

		$param_active="?";
		$tahun_pemilihan="2022";

		if($this->input->get('nama_anggota')){

			$param_active.="nama_anggota=".rawurldecode($this->input->get('nama_anggota'))."&";

			$where.=" && (lower(A.nama_lengkap) like '%".rawurldecode($this->input->get('nama_anggota'))."%' || lower(B.kwg_nama) like '%".rawurldecode($this->input->get('nama_anggota'))."%' )";

		}



		if($this->input->get('kwg_wil')){

			$param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";

			$where.=" && A.kwg_wil ='".$this->input->get('kwg_wil')."'";

		}

		



		if($this->input->get('seleksi_status')){

			$param_active.="seleksi_status=".$this->input->get('seleksi_status')."&";

		}

		if($this->input->get('status_pn2')){

			$param_active.="status_pn2=".$this->input->get('status_pn1')."&";

			$where.=" && A.status_pn2 ='".$this->input->get('status_pn1')."'";

		}



		$q="select A.nama_lengkap, A.id as angjem_id, A.kwg_wil, count(C.id) as voted, C.tahun_pemilihan, E.wilayah, C.sn_surat_suara, C.admin, D.nama_lengkap as calon, D.id as calon_id, D.kwg_wil as calon_wil, C.admin

				from  votes_tahap2 C

				join anggota_jemaat A on C.id_pemilih = A.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join anggota_jemaat D on C.id_calon2 = D.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join wilayah E on E.id = A.kwg_wil

				where C.locked=1 && C.sn_surat_suara is not null ".$where."";



		$group_by=" group by C.sn_surat_suara  ";

        $field_order=" order by C.id ASC ";

        $order_by=" ";

        $numLimit=50;

        $numStart=0;

        if(!$this->input->get('page')){

            $page=1;

            $numStart=($numLimit*$page)-$numLimit;

        }

        else{

            $page=$this->input->get('page');

            $numStart=($numLimit*$page)-$numLimit;

        }

        $data['page']=$page;

        $data['numStart']=$numStart;

        $limit='LIMIT '.$numStart.', '.$numLimit;



        $r=$this->m_model->selectcustom($q." ".$group_by." ".$field_order." ".$order_by);

        $data['TotalOfData']=count($r);



        //get _konvensional

        //$data['konvensional']=$this->m_model->selectas('tipe_pemilihan_id', 3, 'pemilih_konvensional');

        $q1="select A.*

        		from pemilih_konvensional A

        		join anggota_jemaat B on B.id = A.anggota_jemaat_id

        		where B.status=1 && B.sts_anggota=1 && A.tipe_pemilihan_id=2";



        $data['konvensional']=$this->m_model->selectcustom($q1);



        if(!$this->input->get('page')){

            $page_active=1;

        }else{

            $page_active=$this->input->get('page');

        }

        $data['pagingnation']=pagingnation($data['TotalOfData'], $numLimit, $page_active, $param_active, $links=2);



        if($page>1){

            array_splice($r, 0, $numStart);

            array_splice($r,$numLimit );

        }

        else{

            array_splice($r, $numStart+$numLimit);

        }







        $data['voting']=$r;


        //get calon dipilih
        $q1="select A.nama_lengkap, A.id as angjem_id, A.kwg_wil, count(C.id) as voted, C.tahun_pemilihan, E.wilayah, C.sn_surat_suara, C.admin, D.nama_lengkap as calon, D.id as calon_id, D.kwg_wil as calon_wil, C.admin

				from  votes_tahap2 C

				join anggota_jemaat A on C.id_pemilih = A.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join anggota_jemaat D on C.id_calon2 = D.id && C.tahun_pemilihan='".$this->tahun_pemilihan."' && C.locked = 1

				join wilayah E on E.id = A.kwg_wil

				where C.locked=1 && C.sn_surat_suara is not null ".$where."
				group by C.id ";
		$r1=$this->m_model->selectcustom($q1);
		$data['calon_vote']=array();
		foreach ($r1 as $key => $value) {
			// code...
			if(!isset($data['calon_vote'][$value->sn_surat_suara])){
				$data['calon_vote'][$value->sn_surat_suara]=array();
			}

			$data['calon_vote'][$value->sn_surat_suara][]=$value;
		}



        $this->load->view('pemilu/polling_surat_suara_pnt2', $data);



    }



    function check_token_ppj(){

    	$data=array();

    	$token=$this->input->post('sn_surat_suara');

    	//$check=$this->m_model->selectas('sn_surat_suara', $token, 'pemilih_konvensional');

    	$q="select A.*, B.kwg_wil

    			from pemilih_konvensional A 

    			join anggota_jemaat B on B.id = A.anggota_jemaat_id

    			where A.sn_surat_suara = '".$token."'

    			group by A.anggota_jemaat_id";

    	$check=$this->m_model->selectcustom($q);

		$data['token']=$token;

    	if(count($check)>0){

    		foreach ($check as $key => $value) {

    			// code...

    			$wil_pemilih=$value->kwg_wil;

    			$id_pemilih=$value->anggota_jemaat_id;

    			$tipe_pemilihan=$value->tipe_pemilihan_id;
    			if($this->input->post('tipe_pemilihan')){
    				$tipe_pemilihan=$this->input->post('tipe_pemilihan');
    			}

    			$anggota_jemaat_id=$value->anggota_jemaat_id;

    			//$tahun_pemilihan=$value->tahun_pemilihan;
    			$tahun_pemilihan=2022;

    			$data['tipe_pemilihan']=$tipe_pemilihan;

    			$data['anggota_jemaat_id']=$anggota_jemaat_id;

    			$data['tahun_pemilihan']=$tahun_pemilihan;

    			$data['id_pemilih']=$id_pemilih;

    			$data['wil_pemilih']=$wil_pemilih;

    		}

    		$view="";

    		switch ($tipe_pemilihan) {

    			case 1:

    				// code...
					$data['hak_suara_wanita']=4;
					$data['hak_suara_pria']=4;
					$data['hak_suara']=$data['hak_suara_wanita']+$data['hak_suara_pria'];
					//$data['hak_suara']=4;
					//get all calon penatua perwilayah
					$sql="select A.*, B.status_kawin, count(C.id) as voted, C.locked
							from anggota_jemaat A 
							left join ags_sts_kawin B on B.id = A.sts_kawin
							left join votes_tahap1 C on C.id_calon1 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'
							where  A.kwg_wil='".$wil_pemilih."'  && A.sts_anggota=1 && A.status=1 && A.status_pn1=1 && A.status_sidi=1 && A.kwg_no !=0
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





					$view="pemilu/form_surat_suara_pnt1";

    				break;

				case 2:

    				// code...
				$where="";
				$param_active="?";
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
				$get_data=$this->get_data_calon_penatua2_srt($tahun_pemilihan, $id_pemilih, $where, $limit, $wil_pemilih);
		        
		        


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
				//die($num_voted_wil_mix_l."asdasd");

				

		    	if(!$this->input->get('view') && !$this->input->post('view')){
					$view="pemilu/form_surat_suara_pnt2";
					//$this->load->view('frontend/mjppj/list_calon_penatua2', $data);
				}
		    	else{
					$view="ajax/list_calon2_srt";
					//$this->load->view('ajax/list_calon2', $data);
		    	}

    				break;

				case 3:

    				// code...

				//ppj

				$sql="select A.*, B.status_kawin, count(C.id) as voted, C.locked

				from anggota_jemaat A 

				left join ags_sts_kawin B on B.id = A.sts_kawin

				left join votes_tahap_ppj C on C.id_calon1 = A.id && C.id_pemilih='".$id_pemilih."' && C.tahun_pemilihan='".$tahun_pemilihan."'

				where A.sts_anggota=1 && A.status_sidi=1 && A.status=1 && A.status_ppj=1

				group by A.id

				order by voted DESC, A.nama_lengkap ASC, A.kwg_wil ASC"; //die($sql);

				$data['calon']=$this->m_model->selectcustom($sql);



				$data['hak_suara']=1;





				$view="pemilu/form_surat_suara_ppj";

    				break;

    			

    			default:

    				// code...

    				break;

    		}



    		$this->load->view($view, $data);

    	}

    	else{

    		die('<div class="col-xs-12" style="padding:20px;">Peringatan: <span class="text-danger">Autentikasi Gagal! SN Surat Suara <b><i>'.$token.'</i></b> tidak terdaftar!</span></div>');

    	}

    }



    function statistik_ppj(){

    	$data=array();

    	$wil=lsWil();

    	$data['wil']=$wil;

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
		}

    	$this->load->view('pemilu/statistik/ppj/index', $data);





    }



    function statistik_pnt1(){

    	$data=array();

    	$wil=lsWil();

    	$data['wil']=$wil;

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
		}



    	$this->load->view('pemilu/statistik/pnt1/index', $data);





    }

    function statistik_pnt2(){

    	$data=array();

    	$wil=lsWil();

    	$data['wil']=$wil;



    	$this->load->view('pemilu/statistik/pnt2/index', $data);





    }

    function statistik_pnt1new(){

    	$data=array();

    	$wil=lsWil();

    	$data['wil']=$wil;



    	$this->load->view('pemilu/statistik/pnt1/index_new', $data);





    }


    public function penetapan_peserta_pemilihan($value='')
	{
		// code...
		$tahun_pemilihan=$this->input->get('tahun_pemilihan');
		$data=array();
		if($tahun_pemilihan=='2021'){
            #ini  kondisi dulu awal 2021
            $q="select B.id as kwg_no, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, A.nama_lengkap, C.hub_keluarga, A.id as anggota_jemaat_id, D.id as peserta, A.tgl_sidi, A.created_at, A.tgl_meninggal, A.tmpt_meninggal, A.remarks, A.tgl_keluar, A.sts_anggota 
				from keluarga_jemaat B
				join anggota_jemaat A on B.id = A.kwg_no
				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
				left join anggota_jemaat_peserta_pemilihan D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun_pemilihan."'
				where A.id >0 && A.status=1 && ((A.sts_anggota = 1 && (A.created_at < '2021-09-09 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-09-09 00:00:00' && A.created_at < '2021-09-09 00:00:00') ) && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005 && (A.tgl_sidi < '".$tahun_pemilihan."-09-01' || (A.tgl_sidi='0000-00-00' && A.status_sidi=1))
				order by B.kwg_wil , B.kwg_nama ASC;
				";
		}else{
			//delet dulu datanya lalu create ulang
			$d="delete from anggota_jemaat_peserta_pemilihan where tahun_pemilihan ='".$tahun_pemilihan."'";
			$qd=$this->m_model->querycustom($d);
			//warning

			$q="select B.id as kwg_no, B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, A.nama_lengkap, C.hub_keluarga, A.id as anggota_jemaat_id, D.id as peserta, A.tgl_sidi, A.created_at, A.tgl_meninggal, A.tmpt_meninggal, A.remarks, A.tgl_keluar, A.sts_anggota
					from keluarga_jemaat B
					join anggota_jemaat A on B.id = A.kwg_no
					join ags_hub_kwg C on C.idhubkel = A.hub_kwg
					left join anggota_jemaat_peserta_pemilihan D on D.anggota_jemaat_id = A.id && D.tahun_pemilihan='".$tahun_pemilihan."'
					where A.id >0 && A.sts_anggota = 1 && A.status=1 && B.status=1 && A.status_sidi=1 && (A.tgl_sidi < '".$tahun_pemilihan."-09-01' || (A.tgl_sidi='0000-00-00' && A.status_sidi=1)) && A.created_at < '".$tahun_pemilihan."-09-01 00:00:00'
	                order by B.kwg_wil ASC";
		}

		$s=$this->m_model->selectcustom($q);
		foreach ($s as $key => $value) {
			// code...
			if($value->peserta!=null && $value->peserta>0){
				continue;
				#dilewatin aja
			}
			$param=array();
			$param['tahun_pemilihan']=$tahun_pemilihan;
			$param['status_peserta_pn1']=1;
			$param['status_peserta_pn2']=1;
			$param['status_peserta_ppj']=1;
			$param['anggota_jemaat_id']=$value->anggota_jemaat_id;
			$param['created_at']=date('Y-m-d H:i:s');

			$i=$this->m_model->insertgetid($param, 'anggota_jemaat_peserta_pemilihan');
		}

		echo json_encode(array('sts'=>1, 'msg'=>'Selesai diperbarui data Peserta Pemilihan!'));
	}

}

?>