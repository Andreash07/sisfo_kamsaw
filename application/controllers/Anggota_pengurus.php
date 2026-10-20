<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Anggota_pengurus extends CI_Controller {
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

	public function  __construct()
    {
        parent::__construct();

        #if(!isset($this->session->userdata('userdata')->id) ){
        #	redirect(base_url());
        #}


    }

    public function index(){
    	$data=array();
    	$where="";

    	if($this->input->get('kwg_nama')){
    		$where.=" && lower(C.nama_lengkap) like '%".clearText($this->input->get('kwg_nama'))."%'";
    	}

    	if($this->input->get('periode')){
    		$where.=" && A.periode_pelayanan ='".clearText($this->input->get('periode'))."'";
    	}

    	if($this->input->get('pelayanan')){
    		$where.=" && A.pelayanan ='".clearText($this->input->get('pelayanan'))."'";
    	}

    	if($this->input->get('status') || $this->input->get('status')=='0'){
    		$where.=" && A.status ='".clearText($this->input->get('status'))."'";
    	}

    	$s="select A.*, C.nama_lengkap,  B.name as periode
    			from anggota_pengurus_pelayanan A 
    			join periode_pelayanan B on B.id = A.periode_pelayanan
    			join anggota_jemaat C on C.id = A.anggota_jemaat_id
    		where A.id>0 ".$where."
    		order by B.id, A.id ";
    	$q=$this->m_model->selectcustom($s);
    	$data['data']=$q;

    	$data['periode_pelayanan']=$this->m_model->selectas('status', '1', 'periode_pelayanan', 'id', 'DESC');

    	$data['pelayanan']=array('KPA',
								'KOREM',
								'KOPEM',
								'KKM',
								'KOMPRI',
								'KPP',
								'KOMLAN',
								'KLMG',
								'KHRG',
								'KOMBINA',
								'KOMDIKSOS',
								'KOMSAK',
								'KOMPELKES',
								'KPKP',
								'LITBANG',
								'MIK',
								'KPPJ',
								'KRT',
								'Pengurus Teritorial 1',
								'Pengurus Teritorial 2',
								'Pengurus Teritorial 3',
								'Pengurus Teritorial 4',
								'Pengurus Teritorial 5',
								'Pengurus Teritorial 6',
								'Pengurus Teritorial 7');

    	$this->load->view('anggota_pengurus/index', $data);
    }

    public function form_add(){
    	$data=array();
    	$data['periode_pelayanan']=$this->m_model->selectas('status', '1', 'periode_pelayanan', 'id', 'DESC');
    	$this->load->view('anggota_pengurus/form_add', $data);
    }

    public function save(){
    	$data=array();
    	$param=array();
    	$param['pelayanan']=$this->input->post('pelayanan');
    	$param['periode_pelayanan']=$this->input->post('periode');
    	$param['jabatan']='';
    	$param['status']='-1';
    	$param['status_final']='0';
    	$param['notes']='';
    	$param['created_at']=date('Y-m-d H:i:s');
    	$param['created_id']='10';
    	$param['diusulkan_tgl']=$this->input->post('tgl_usulkan');


    	foreach ($this->input->post('anggota_jemaat') as $key => $value) {
    		// code...
    		//check dulu nama sudah pernah ada yg input kah? untuk menentukan prioritas nya sebagai nama usul
    		$cek=$this->m_model->selectas3('anggota_jemaat_id', $value, 'periode_pelayanan', $param['periode_pelayanan'], 'status', $param['status'], 'anggota_pengurus_pelayanan');
    		$param['prioritas']=count($cek)+1;

    		$param['anggota_jemaat_id']=$value;

    		//insert
    		$i=$this->m_model->insertgetid($param, 'anggota_pengurus_pelayanan');
    	}

    	redirect('Anggota_pengurus/index');
    }

    public function search_anggota_jemaat(){
    	$data=array();
    	$nama=$this->input->get('search');

    	$s="select A.id, A.nama_lengkap, B.wilayah
    		from anggota_jemaat A 
    		join wilayah B on B.id = A.kwg_wil
    		where A.sts_anggota=1 && A.status=1 && lower(nama_lengkap) like '%".strtolower($nama)."%'
    		order by A.nama_lengkap
    		limit 10 ";
    	$q=$this->m_model->selectcustom($s);
		$data['results']=array();
    	foreach ($q as $key => $value) {
    		// code...
    		$data['results'][]=array('id' => $value->id, 'text' => $value->nama_lengkap.' (Ter.'.$value->wilayah.')');
    	}

    	echo json_encode($data);
    	return;
    }

    public function perpelayanan(){
    	$data=array();
    	$data['pelayanan']=array('KPA',
								'KOREM',
								'KOPEM',
								'KKM',
								'KOMPRI',
								'KPP',
								'KOMLAN',
								'KLMG',
								'KHRG',
								'KOMBINA',
								'KOMDIKSOS',
								'KOMSAK',
								'KOMPELKES',
								'KPKP',
								'LITBANG',
								'MIK',
								'KPPJ',
								'KRT',
								'Pengurus Teritorial 1',
								'Pengurus Teritorial 2',
								'Pengurus Teritorial 3',
								'Pengurus Teritorial 4',
								'Pengurus Teritorial 5',
								'Pengurus Teritorial 6',
								'Pengurus Teritorial 7');
    	$data['periode_pelayanan']=$this->m_model->selectas('status', '1', 'periode_pelayanan', 'id', 'DESC');
    	$cur_periode=0;
    	foreach ($data['periode_pelayanan'] as $key => $value) {
    		// code...
    		if($cur_periode==0){
    			$cur_periode=$value->id;
    		}
    		continue;
    	}
    	$data['cur_periode']=$cur_periode;

    	$where="";
    	if($cur_periode!=0){
    		$where.=" && A.periode_pelayanan='".$cur_periode."'";
    	}

    	if($this->input->get('filter')=='1' ){
    		$where.=" && A.anggota_jemaat_id in (select anggota_jemaat_id from anggota_pengurus_pelayanan where periode_pelayanan='".$cur_periode."' group by anggota_jemaat_id having COUNT(anggota_jemaat_id)=1)";
    	}
    	else if($this->input->get('filter')=='2' ){
    		$where.=" && A.anggota_jemaat_id in (select anggota_jemaat_id from anggota_pengurus_pelayanan where periode_pelayanan='".$cur_periode."' group by anggota_jemaat_id having COUNT(anggota_jemaat_id)>1)";
    	}else if($this->input->get('filter')=='3' ){
    		$where.=" && A.status=1";
    	}else if($this->input->get('filter')=='4' ){
    		$where.=" ";
    	}else if($this->input->get('filter')=='5' ){
    		$where.=" && A.pelayanan in (select pelayanan from anggota_pengurus_pelayanan where periode_pelayanan='".$cur_periode."' && A.status= in (0,2) && pelayanan not in (select pelayanan from anggota_pengurus_pelayanan where periode_pelayanan='".$cur_periode."' && A.status=1)  group by pelayanan having COUNT(anggota_jemaat_id)=0)";
    	}
		else if($this->input->get('filter')=='6' ){
    		$where.=" && A.pelayanan in (select pelayanan from anggota_pengurus_pelayanan where periode_pelayanan='".$cur_periode."' && status in (-1,0,2) && pelayanan not in (select pelayanan from anggota_pengurus_pelayanan where periode_pelayanan='".$cur_periode."' && status=1)) ";
    		//$where.=" && A.anggota_jemaat_id in (select anggota_jemaat_id from anggota_pengurus_pelayanan where periode_pelayanan='".$cur_periode."' group by anggota_jemaat_id having COUNT(anggota_jemaat_id)>1)";
    	}else if($this->input->get('filter')=='7' ){
    		$where.=" && A.anggota_jemaat_id in (select anggota_jemaat_id from anggota_pengurus_pelayanan where periode_pelayanan='".$cur_periode."' group by anggota_jemaat_id having COUNT(anggota_jemaat_id)>1)";
    	}

    	$s="select A.*, C.nama_lengkap,  B.name as periode
    			from anggota_pengurus_pelayanan A 
    			join periode_pelayanan B on B.id = A.periode_pelayanan
    			join anggota_jemaat C on C.id = A.anggota_jemaat_id
    		where A.id>0 ".$where."
    		order by A.id, A.prioritas, B.id, A.pelayanan, A.jabatan, A.id ";
    	#die(nl2br($s));
    	$q=$this->m_model->selectcustom($s);

    	$data['data']=array();
    	$data['offer_perorang']=array();
    	foreach ($q as $key => $value) {
    		// code...
    		if(!isset($data['data'][$value->pelayanan])){
    			$data['data'][$value->pelayanan]=array();
    		}

    		if(!isset($data['offer_perorang'][$value->anggota_jemaat_id])){
    			$data['offer_perorang'][$value->anggota_jemaat_id]=array();
    		}
    			$data['data'][$value->pelayanan][]=$value;
    			$data['offer_perorang'][$value->anggota_jemaat_id][]=$value;
    	}
    	$this->load->view('anggota_pengurus/perpelayanan', $data);
    }

}

