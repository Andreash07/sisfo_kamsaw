<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Tools extends CI_Controller {



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

    }



    public function index(){}



    public function hitungAnggotaJemaatOld(){

    	$data=array();

    	$query="SELECT B.kwg_no, B.kwg_nama, COUNT(A.id) as Sum_anggota

FROM ags_kwg_detail_table A 

join ags_kwg_table B on (B.kwg_no = A.kwg_no)

WHERE A.status=1 && B.status=1 && LOWER(A.sts_anggota) like 'aktif'

group by B.kwg_no

ORDER by B.kwg_no ASC";

    	$anggota=$this->m_model->selectcustom($query);



		$param=array();

		$i=0;

    	foreach ($anggota as $key => $value) {

    		# code...

    		unset($param);

    		$param['num_anggota']=$value->Sum_anggota;

			$update=$this->m_model->updateas('kwg_no', $value->kwg_no, $param, 'ags_kwg_table');

    		if($update){

    			$i++;

    		}

    	}

    	echo "Done ".$i;

    }



    public function hitungAnggotaJemaat(){

    	$data=array();

    	$query="SELECT B.id, B.kwg_nama, COUNT(A.id) as Sum_anggota

FROM keluarga_jemaat B

left join  anggota_jemaat A on B.id = A.kwg_no && A.status=1 && A.sts_anggota = 1

WHERE B.status=1 && B.id=2

group by B.kwg_no

ORDER by B.kwg_no ASC";

    	$anggota=$this->m_model->selectcustom($query);



		$param=array();

		$i=0;

    	foreach ($anggota as $key => $value) {

    		# code...

    		unset($param);

    		$param['num_anggota']=$value->Sum_anggota;
            $param['kwg_nama']=$value->kwg_nama;

            if($param['num_anggota']>0){
                if($value->Sum_anggota == 25){
                 $update=$this->m_model->updateas('id', $value->id, $param, 'keluarga_jemaat');

                }
                else{
			     //$update=$this->m_model->updateas('id', $value->id, $param, 'keluarga_jemaat');
                }
            }
            else{
                //die($value->id);
                $param['status']=0;
                $update=$this->m_model->updateas('id', $value->id, $param, 'keluarga_jemaat');
            }

    		//if($update){

    			//$i++;

//    		}

    	}

    	echo "Done ".$i;

    }

    public function generate_keluarga_tersensus($wilayah){

    	$data=array();

    	$query="SELECT A.id, A.kwg_nama, A.kwg_no, A.status, A.status_migration
					FROM ags_kwg_table A 
					WHERE A.status=1 && A.kwg_wil=".$wilayah."
					group by A.kwg_no
					ORDER by A.kwg_no ASC";

    	$old_anggota=$this->m_model->selectcustom($query);
    	$data['wilayah']=$wilayah;
    	$data['old_anggota']=$old_anggota;

    	$query1="SELECT A.id, A.kwg_nama, A.kwg_no, A.kwg_no_old, A.status
					FROM keluarga_jemaat A 
					WHERE A.status=1 && A.kwg_wil=".$wilayah."
					group by A.kwg_no
					ORDER by A.kwg_no ASC";

    	$new_anggota=$this->m_model->selectcustom($query1);
    	$data['new_anggota']=array();
    	foreach ($new_anggota as $key => $value) {
	    	$data['new_anggota'][$value->kwg_no_old]=$value;
    	}
//print_r($data['new_anggota']);
    	$this->load->view('tools/generate_keluarga_tersensus', $data);

    }

    public function generate_qrcode($keluarga=null){
        $this->load->library('Ciqrcode');
        $where="";
        if($keluarga!=null){
            $where=" && id='".$keluarga."'";
        }
        $q="select * from keluarga_jemaat where status=1 && (qrcode is null || qrcode ='') ".$where;
        $data=array();
        $data['qrcode']=$this->m_model->selectcustom($q);
        //print_r($data['qrcode']);
        //die();

        //$folder = FCPATH.'/images/qrcode/';
        $folder ='/images/qrcode/';
        

        $config['cacheable']    = true; //boolean, the default is true
        //$config['cachedir']     = './assets/'; //string, the default is application/cache/
        //$config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = $folder; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        foreach ($data['qrcode'] as $key => $value) {
            # code...
            /*$folder = FCPATH.'/images/qrcode/';
            $text1="qIR-";
            $valueQRCODE=base_url()."invitation/assign_quest/".$value->id;
            $file_name1 = $text1.uniqid().".png";
            $file_name = $folder.$file_name1;
            QRcode::png($text,$file_name);*/
            $text1="qJKpSawah-";
            //$valueQRCODE=base_url()."invitation/assign_quest/".$value->id;
            $valueQRCODE="https://sisfo-gkpkampungsawah.com/qrcode/scan/".md5($value->id."#17ashdkj25ahsdkja96#Asthaaksjdha");
            $file_name1 = $text1.uniqid().".png";

            $image_name=$file_name1; //buat name dari qr code sesuai dengan nip

            $params=array();
            $params['data'] = $valueQRCODE; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

            $param_add=array();
            $param_add['qrcode']=$config['imagedir'].$image_name;
            $this->m_model->updateas('id', $value->id, $param_add, 'keluarga_jemaat');

            $json=array();
            if($this->input->post('generate')){
                $json['img']=base_url().$config['imagedir'].$image_name;
                echo json_encode($json);
            }
        }
    }

    public function update_pelayanan_kategory($type="all"){
        //$type= all, partial;

        $data=array();
        //get all anggota aktif
        $where="";
        if($type=='partial'){
            $where.=" && (kd_group is NULL || kd_group='')"; //ini untuk update partial
        }
        $s="select *
                from anggota_jemaat
                where status=1 && sts_anggota=1";
        $angjem=$this->m_model->selectcustom($s);

        $s1="select *
                from ags_group_data";
        $rkd_group=$this->m_model->selectcustom($s1);
        foreach ($rkd_group as $key => $value) {
            $kd_group[$value->kd_group]=$value;
        }

        foreach ($angjem as $key => $value) {
            # code...
            $umur=getUmur(date('Y-m-d'), $value->tgl_lahir);
            $umurnikah=0;
            if($value->tgl_nikah!='0000-00-00'){
                $umurnikah=getUmur(date('Y-m-d'), $value->tgl_nikah);
            }

            $baptis=$value->status_baptis;
            $sidi=$value->status_sidi;
            $nikah=$value->sts_kawin;
            $jenis_kelamin=strtoupper($value->jns_kelamin);
            $kategori_palayanan=array();
            $kategori_palayanan['kd_group']='Unknown';
            $kategori_palayanan['kd_group_id']=0;   
            if($umur>=0 && $umur<=11){
                //kpa
                $kategori_palayanan['kd_group']=$kd_group['KPA']->kd_group;
                $kategori_palayanan['kd_group_id']=$kd_group['KPA']->id;
            }
            else if($umur>=12 && $umur<=14){
                //ktr
                $kategori_palayanan['kd_group']=$kd_group['KTR']->kd_group;
                $kategori_palayanan['kd_group_id']=$kd_group['KTR']->id;
            }
            else if(($umur>=15 || $sidi==0) && $umur<=17  && $nikah==1) {
                //korem
                $kategori_palayanan['kd_group']=$kd_group['KOREM']->kd_group;
                $kategori_palayanan['kd_group_id']=$kd_group['KOREM']->id;
            }
            else if(($umur>=18 || $sidi==1) && $umur<=55 && $nikah==1){
                //kopem
                $kategori_palayanan['kd_group']=$kd_group['KOPEM']->kd_group;
                $kategori_palayanan['kd_group_id']=$kd_group['KOPEM']->id;
            }
            else if($umur>=18 && $umur<=55 && $nikah!=1 &&  $umurnikah <=10 ){
                //kkm
                $kategori_palayanan['kd_group']=$kd_group['KKM']->kd_group;
                $kategori_palayanan['kd_group_id']=$kd_group['KKM']->id;
            }
            else if($umur>=18 && $umur<=55 && $nikah!=1 &&  $umurnikah >10 ){
                //kompri KPP
                if($jenis_kelamin=='L'){
                    //kompri
                    $kategori_palayanan['kd_group']=$kd_group['KOMPRI']->kd_group;
                    $kategori_palayanan['kd_group_id']=$kd_group['KOMPRI']->id;
                }
                else if($jenis_kelamin=='P'){
                    //KPP
                    $kategori_palayanan['kd_group']=$kd_group['KPP']->kd_group;
                    $kategori_palayanan['kd_group_id']=$kd_group['KPP']->id;
                }
            }
            else if($umur>55){
                //KOMLAN
                $kategori_palayanan['kd_group']=$kd_group['KOMLAN']->kd_group;
                $kategori_palayanan['kd_group_id']=$kd_group['KOMLAN']->id;
            }

            //update kd_group
            $this->m_model->updateas('id', $value->id, $kategori_palayanan, 'anggota_jemaat');
            echo $value->nama_lengkap." ".$value->tgl_lahir." umur:".$umur." nikah".$nikah." umurnikah:".$value->tgl_nikah."(".$umurnikah.") sidi=".$sidi;
            print_r($kategori_palayanan);
            echo "<br>";
        }
    }

    function gen_report($wilayah=null){
        $where="";
        if($wilayah!=null){
            $where.=" && B.kwg_wil='".$wilayah."'";
        }
        $data=array();
        $s="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, C.hub_keluarga, B.kwg_telepon, B.kwg_alamat, A.tgl_baptis, A.jns_kelamin, A.golongandarah, A.pndk_akhir, A.tmpt_sidi, A.tmpt_baptis, A.no_anggota
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
left join ags_hub_kwg C on C.idhubkel = A.hub_kwg
where A.status=1 && A.sts_anggota=1 && B.status=1 ".$where."
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $data['angjem']=$this->m_model->selectcustom($s);

        $this->load->view('tools/report_gen',$data);

    }

    function gen_report_memilih($wilayah=null){
        $where="";
        if($wilayah!=null){
            $where.=" && B.kwg_wil='".$wilayah."'";
        }
        $data=array();
        $s="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
where A.status=1 && A.sts_anggota=1 && A.status_sidi=1 ".$where."
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $data['angjem']=$this->m_model->selectcustom($s);

        $this->load->view('tools/report_gen_memilih',$data);

    }

    function report_gen_batita($wilayah=null){
        $where="";
        if($wilayah!=null){
            $where.=" && B.kwg_wil='".$wilayah."'";
        }
        $data=array();
        $s="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
where A.status=1 && A.sts_anggota=1 ".$where."
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $data['angjem']=$this->m_model->selectcustom($s);

        $this->load->view('tools/report_gen_batita',$data);

    }

    function report_belum_memilih_ppj($wilayah=null){
        $where="";
        if(!$this->input->post('token') && $wilayah==null){
            $this->load->view('tools/login_report');
            return;
        }

        switch ($this->input->post('token')) {
            case 'df43e':
                // code...
                $wilayah=1;
                break;
            case 'kj152':
                // code...
                $wilayah=2;
                break;
            case 'hg98p':
                // code...
                $wilayah=3;
                break;
            case 'yk64f':
                // code...
                $wilayah=4;
                break;
            case 'bm632':
                // code...
                $wilayah=5;
                break;
            case 'efq24':
                // code...
                $wilayah=6;
                break;
            case 'am207':
                // code...
                $wilayah=7;
                break;
            default:
                // code...
                die("Token Invalid!");
                break;
        }

        if($wilayah!=null){
            $where.=" && B.kwg_wil='".$wilayah."'";
        }


        $data=array();
        $s="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-09-09 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-09-09 00:00:00' && A.last_modified_dorkas < '2021-09-09 00:00:00') ) && A.status_sidi=1 ".$where."
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $data['angjem']=$this->m_model->selectcustom($s);

        $s1="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks, C.locked, C.sn_surat_suara
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join votes_tahap_ppj C on (C.id_pemilih = A.id)
where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-09-09 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-09-09 00:00:00' && A.last_modified_dorkas < '2021-09-09 00:00:00') ) && A.status_sidi=1 && C.locked in (1,0) ".$where."
group by C.id_pemilih
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $sudah_vote=$this->m_model->selectcustom($s1);
        $data['sudah_vote']=array();
        $data['sudah_vote_online']=array();
        $data['sudah_vote_offline']=array();
        foreach($sudah_vote as $key =>$value){
            $data['sudah_vote'][$value->id]=$value;
            if($value->sn_surat_suara!=null){
                $data['sudah_vote_offline'][$value->id]=$value;
            }else{
                $data['sudah_vote_online'][$value->id]=$value;
            }
        }

        $s2="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join pemilih_konvensional C on (C.anggota_jemaat_id = A.id)
where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-09-09 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-09-09 00:00:00' && A.last_modified_dorkas < '2021-09-09 00:00:00') ) && A.status_sidi=1 && C.tipe_pemilihan_id in (3) ".$where."
group by C.anggota_jemaat_id
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC"; //die($s2);

        $konvensional=$this->m_model->selectcustom($s2);
        $data['konvensional']=array();
        foreach($konvensional as $key =>$value){
            $data['konvensional'][$value->id]=$value;
        }

        $this->load->view('tools/report_gen_belum_memilih',$data);

    }

    function report_belum_memilih_pnt1($wilayah=null){
        $where="";
        if(!$this->input->post('token') && !$this->uri->segment(3) && $wilayah==null){
            $this->load->view('tools/login_report');
            return;
        }
        $token=$this->input->post('token');
        $token=$this->uri->segment(3);
        switch ($token) {
            case 'df43e':
                // code...
                $wilayah=1;
                break;
            case 'kj152':
                // code...
                $wilayah=2;
                break;
            case 'hg98p':
                // code...
                $wilayah=3;
                break;
            case 'yk64f':
                // code...
                $wilayah=4;
                break;
            case 'bm632':
                // code...
                $wilayah=5;
                break;
            case 'efq24':
                // code...
                $wilayah=6;
                break;
            case 'am207':
                // code...
                $wilayah=7;
                break;
            default:
                // code...
                die("Token Invalid!");
                break;
        }

        if($wilayah!=null){
            $where.=" && B.kwg_wil='".$wilayah."'";
        }


        $data=array();
        $s="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && A.status_sidi=1 ".$where."
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $data['angjem']=$this->m_model->selectcustom($s);

        $s1="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks, C.sn_surat_suara, COUNT(C.id) as num_dipilih, min(C.locked) as locked
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join votes_tahap1 C on (C.id_pemilih = A.id)
where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && A.status_sidi=1 && C.locked in (1,0) ".$where."
group by C.id_pemilih
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $sudah_vote=$this->m_model->selectcustom($s1);
        $data['sudah_vote']=array();
        $data['sudah_vote_online']=array();
        $data['sudah_vote_offline']=array();
        foreach($sudah_vote as $key =>$value){
            $data['sudah_vote'][$value->id]=$value;
            if($value->sn_surat_suara!=null){
                $data['sudah_vote_offline'][$value->id]=$value;
            }else{
                $data['sudah_vote_online'][$value->id]=$value;
            }
        }

        $s2="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join pemilih_konvensional C on (C.anggota_jemaat_id = A.id)
where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2021-10-21 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2021-10-21 00:00:00' && A.last_modified_dorkas < '2021-10-21 00:00:00') ) && A.status_sidi=1 && C.tipe_pemilihan_id in (1) ".$where."
group by C.anggota_jemaat_id
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC"; //die($s2);

        $konvensional=$this->m_model->selectcustom($s2);
        $data['konvensional']=array();
        foreach($konvensional as $key =>$value){
            $data['konvensional'][$value->id]=$value;
        }

        $data['hak_suara']=8;

        $this->load->view('tools/report_gen_belum_memilih_pnt1',$data);

    }

    function report_belum_memilih_pnt2($wilayah=null){
        $where="";
        if(!$this->input->post('token') && !$this->uri->segment(3) && $wilayah==null){
            $this->load->view('tools/login_report');
            return;
        }
        $token=$this->input->post('token');
        $token=$this->uri->segment(3);
        switch ($token) {
            case 'df43e':
                // code...
                $wilayah=1;
                break;
            case 'kj152':
                // code...
                $wilayah=2;
                break;
            case 'hg98p':
                // code...
                $wilayah=3;
                break;
            case 'yk64f':
                // code...
                $wilayah=4;
                break;
            case 'bm632':
                // code...
                $wilayah=5;
                break;
            case 'efq24':
                // code...
                $wilayah=6;
                break;
            case 'am207':
                // code...
                $wilayah=7;
                break;
            default:
                // code...
                die("Token Invalid!");
                break;
        }

        if($wilayah!=null){
            $where.=" && B.kwg_wil='".$wilayah."'";
        }


        $data=array();
        $s="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && A.status_sidi=1 ".$where."
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $data['angjem']=$this->m_model->selectcustom($s);

        $s1="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks, C.sn_surat_suara, COUNT(C.id) as num_dipilih, min(C.locked) as locked
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join votes_tahap2 C on (C.id_pemilih = A.id)
where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && A.status_sidi=1 && C.locked in (1,0) ".$where."
group by C.id_pemilih
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $sudah_vote=$this->m_model->selectcustom($s1);
        $data['sudah_vote']=array();
        $data['sudah_vote_online']=array();
        $data['sudah_vote_offline']=array();
        foreach($sudah_vote as $key =>$value){
            $data['sudah_vote'][$value->id]=$value;
            if($value->sn_surat_suara!=null){
                $data['sudah_vote_offline'][$value->id]=$value;
            }else{
                $data['sudah_vote_online'][$value->id]=$value;
            }
        }

        $s2="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join pemilih_konvensional C on (C.anggota_jemaat_id = A.id)
where A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null )) || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && A.status_sidi=1 && C.tipe_pemilihan_id in (2) ".$where."
group by C.anggota_jemaat_id
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC"; //die($s2);

        $konvensional=$this->m_model->selectcustom($s2);
        $data['konvensional']=array();
        foreach($konvensional as $key =>$value){
            $data['konvensional'][$value->id]=$value;
        }

        $data['hak_suara']=8;

        $this->load->view('tools/report_gen_belum_memilih_pnt1',$data);

    }


    function gen_report_pemilihan_tahap1(){
        $data=array();
        $s="SELECT A.*
                from votes_tahap1 A";
        $q=$this->m_model->selectcustom($s);
        $num_user_id=array();
        $num_vote_sah=array();
        $num_vote_nonsah=array();
        $num_user_perwil=array();
        $list_user_id_wil=array();
        foreach ($q as $key => $value) {
            // code...
            if(!isset($num_user_perwil[$value->wil_pemilih])){
                $num_user_perwil[$value->wil_pemilih]=0;
            }

            if(!in_array($value->id_pemilih, $list_user_id_wil)){ 
                $list_user_id_wil[]=$value->id_pemilih;
                $num_user_perwil[$value->wil_pemilih]++;
            }

            if(!isset($num_vote_sah[$value->wil_pemilih])){
                $num_vote_sah[$value->wil_pemilih]=0;
            }

            if(!isset($num_vote_nonsah[$value->wil_pemilih])){
                $num_vote_nonsah[$value->wil_pemilih]=0;
            }

            if($value->locked==1){
                $num_vote_sah[$value->wil_pemilih]++;
            }
            if($value->locked==0){
                $num_vote_nonsah[$value->wil_pemilih]++;
            }
        }

        //print_r($list_user_id_wil);
        /*foreach ($list_user_id_wil as $key => $value) {
            // code...
            echo $key.". ".$value."<br>";
        }*/
        $data['num_vote_sah']=$num_vote_sah;
        $data['num_vote_nonsah']=$num_vote_nonsah;
        $data['num_user_perwil']=$num_user_perwil;
        $data['list_user_id_wil']=$list_user_id_wil;

        $wilayah=$this->m_model->selectas('id > 0', null, 'wilayah');
        $data['wilayah']=$wilayah;
        $data['vote1']=$q;

        $this->load->view('tools/gen_report_pemilihan_tahap1', $data);

    }


    function total_angjem_per_kelompok_usia(){
        $data=array();
        $where="";
        $sql="select A.*, B.kwg_nama, B.kwg_alamat, C.hub_keluarga

                from anggota_jemaat A

                join keluarga_jemaat B on B.id = A.kwg_no

                join ags_hub_kwg C on C.idhubkel = A.hub_kwg

                where A.id >0 && A.status=1 && A.sts_anggota ='1'".$where."";
        $data['angjem']=$this->m_model->selectcustom($sql);


        $kel_usia=array('0-15', '16-25', '26-55', '>55');
        $usia=array();
        $usia['0-15']['total']=0;
        $usia['0-15']['l']=0;
        $usia['0-15']['p']=0;

        $usia['16-25']['total']=0;
        $usia['16-25']['l']=0;
        $usia['16-25']['p']=0;

        $usia['26-55']['total']=0;
        $usia['26-55']['l']=0;
        $usia['26-55']['p']=0;

        $usia['>55']['total']=0;
        $usia['>55']['l']=0;
        $usia['>55']['p']=0;

        $usia2=array();
        $usia2['0-15']['total']=0;
        $usia2['0-15']['l']=0;
        $usia2['0-15']['p']=0;
        
        $usia2['16-25']['total']=0;
        $usia2['16-25']['l']=0;
        $usia2['16-25']['p']=0;

        $usia2['26-55']['total']=0;
        $usia2['26-55']['l']=0;
        $usia2['26-55']['p']=0;

        $usia2['>55']['total']=0;
        $usia2['>55']['l']=0;
        $usia2['>55']['p']=0;
        

        $tglCutoff1=date('Y-m-d');
        $tglCutoff2='2021-12-31';
        foreach ($data['angjem'] as $key => $value) {
            // code...
            $umurLahir1=getUmur($tglCutoff1, $value->tgl_lahir);
            $umurLahir2=getUmur($tglCutoff2, $value->tgl_lahir);

            if($umurLahir1<=15){
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia['0-15']['p']++;
                }
                else{
                    $usia['0-15']['l']++;
                }
                $usia['0-15']['total']++;
            }
            else if($umurLahir1<=25 && $umurLahir1>=16){
                $usia['16-25']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia['16-25']['p']++;
                }
                else{
                    $usia['16-25']['l']++;
                }
            }
            else if($umurLahir1<=55 && $umurLahir1>=26){
                $usia['26-55']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia['26-55']['p']++;
                }
                else{
                    $usia['26-55']['l']++;
                }
            }
            else{
                $usia['>55']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia['>55']['p']++;
                }
                else{
                    $usia['>55']['l']++;
                }
            }


            if($umurLahir2<=15){
                $usia2['0-15']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia2['0-15']['p']++;
                }
                else{
                    $usia2['0-15']['l']++;
                }
            }
            else if($umurLahir2<=25 && $umurLahir2>=16){
                $usia2['16-25']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia2['16-25']['p']++;
                }
                else{
                    $usia2['16-25']['l']++;
                }
            }
            else if($umurLahir2<=55 && $umurLahir2>=26){
                $usia2['26-55']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia2['26-55']['p']++;
                }
                else{
                    $usia2['26-55']['l']++;
                }
            }
            else{
                $usia2['>55']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia2['>55']['p']++;
                }
                else{
                    $usia2['>55']['l']++;
                }
            }
        }
        echo '<table>';
        echo '<tr>';
        echo '<th rowspan="2">Kelompok Usia</th>';
        echo '<th colspan="3">Umur (per '.$tglCutoff1.')</th>';
        echo '<th colspan="3">Umur (per '.$tglCutoff2.')</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th >Perempuan</th>';
        echo '<th >Laki - Laki</th>';
        echo '<th >Total</th>';
        echo '<th >Perempuan</th>';
        echo '<th >Laki - Laki</th>';
        echo '<th >Total</th>';
        echo '</tr>';
        foreach ($kel_usia as $key => $value) {
            // code...
            echo '<tr>';
            echo '<td>'.$value.'</td>';
            echo '<td>'.$usia[$value]['p'].'</td>';
            echo '<td>'.$usia[$value]['l'].'</td>';
            echo '<td>'.$usia[$value]['total'].'</td>';
            echo '<td>'.$usia2[$value]['p'].'</td>';
            echo '<td>'.$usia2[$value]['l'].'</td>';
            echo '<td>'.$usia2[$value]['total'].'</td>';
            echo '</tr>';

        }
        echo '/<table>';

    }


    function total_angjem_per_kelompok_usia_pendidikan(){
        $data=array();
        $where="";
        $sql1="SELECT pndk_akhir, priority FROM `pndk_terakhir`";
        $data['pndk']=$this->m_model->selectcustom($sql1);


        $sql="select A.*, B.kwg_nama, B.kwg_alamat, C.hub_keluarga

                from anggota_jemaat A

                join keluarga_jemaat B on B.id = A.kwg_no

                join ags_hub_kwg C on C.idhubkel = A.hub_kwg

                where A.id >0 && A.status=1 && A.sts_anggota ='1'".$where."";
        $data['angjem']=$this->m_model->selectcustom($sql);


        $kel_usia=array('0-5','6-12', '13-15', '16-18', '19-24', '25-34', '35-44', '45-55', '>55');
        $usia=array();
        foreach ($data['pndk'] as $key => $value) {
            foreach ($kel_usia as $key1 => $value1) {
                // code...
                $usia[strtoupper($value->pndk_akhir)][$value1]=0;
            }
        }

        //print_r($usia); die();
        /*$usia['0-5']['total']=0;
        $usia['0-5']['l']=0;
        $usia['0-5']['p']=0;

        $usia['6-12']['total']=0;
        $usia['6-12']['l']=0;
        $usia['6-12']['p']=0;

        $usia['13-15']['total']=0;
        $usia['13-15']['l']=0;
        $usia['13-15']['p']=0;

        $usia['16-18']['total']=0;
        $usia['16-18']['l']=0;
        $usia['16-18']['p']=0;

        $usia['19-24']['total']=0;
        $usia['19-24']['l']=0;
        $usia['19-24']['p']=0;

        $usia['25-34']['total']=0;
        $usia['25-34']['l']=0;
        $usia['25-34']['p']=0;

        $usia['45-55']['total']=0;
        $usia['45-55']['l']=0;
        $usia['45-55']['p']=0;

        $usia['>55']['total']=0;
        $usia['>55']['l']=0;
        $usia['>55']['p']=0;

        $usia2=array();
        $usia2['0-15']['total']=0;
        $usia2['0-15']['l']=0;
        $usia2['0-15']['p']=0;
        
        $usia2['16-25']['total']=0;
        $usia2['16-25']['l']=0;
        $usia2['16-25']['p']=0;

        $usia2['26-55']['total']=0;
        $usia2['26-55']['l']=0;
        $usia2['26-55']['p']=0;

        $usia2['>55']['total']=0;
        $usia2['>55']['l']=0;
        $usia2['>55']['p']=0;*/
        

        $tglCutoff1=date('Y-m-d');
        $tglCutoff2='2021-12-31';
        foreach ($data['angjem'] as $key => $value) {
            // code...
            $umurLahir1=getUmur($tglCutoff1, $value->tgl_lahir);
            $umurLahir2=getUmur($tglCutoff2, $value->tgl_lahir);

            if($umurLahir1<=5){
                $usia[strtoupper($value->pndk_akhir)]['0-5']++;
            }
            else if($umurLahir1<=12){
                $usia[strtoupper($value->pndk_akhir)]['6-12']++;
            }
            else if($umurLahir1<=15){
                $usia[strtoupper($value->pndk_akhir)]['13-15']++;
            }
            else if($umurLahir1<=18){
                $usia[strtoupper($value->pndk_akhir)]['16-18']++;
            }
            else if($umurLahir1<=24){
                $usia[strtoupper($value->pndk_akhir)]['19-24']++;
            }
            else if($umurLahir1<=34){
                $usia[strtoupper($value->pndk_akhir)]['25-34']++;
            }
            else if($umurLahir1<=44){
                $usia[strtoupper($value->pndk_akhir)]['35-44']++;
            }
            else if($umurLahir1<=55){
                $usia[strtoupper($value->pndk_akhir)]['45-55']++;
            }
            else{
                $usia[strtoupper($value->pndk_akhir)]['>55']++;
            }


            /*if($umurLahir2<=15){
                $usia2['0-15']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia2['0-15']['p']++;
                }
                else{
                    $usia2['0-15']['l']++;
                }
            }
            else if($umurLahir2<=25 && $umurLahir2>=16){
                $usia2['16-25']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia2['16-25']['p']++;
                }
                else{
                    $usia2['16-25']['l']++;
                }
            }
            else if($umurLahir2<=55 && $umurLahir2>=26){
                $usia2['26-55']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia2['26-55']['p']++;
                }
                else{
                    $usia2['26-55']['l']++;
                }
            }
            else{
                $usia2['>55']['total']++;
                if(strtolower($value->jns_kelamin) == 'p'){
                    $usia2['>55']['p']++;
                }
                else{
                    $usia2['>55']['l']++;
                }
            }*/
        }
        echo '<table>';
        echo '<tr>';
        echo '<th rowspan="2">Pendidikan</th>';
        echo '<th colspan="'.count($kel_usia).'">Umur (per '.$tglCutoff1.')</th>';
        //echo '<th colspan="3">Umur (per '.$tglCutoff2.')</th>';
        echo '</tr>';
        echo '<tr>';
        foreach ($kel_usia as $key => $value) {
            echo '<th>'.$value.'</th>';
        }
        echo '</tr>';
        //echo '<tr>';
        //echo '<th >Perempuan</th>';
//        echo '<th >Laki - Laki</th>';
        //echo '<th >Total</th>';
        //echo '<th >Perempuan</th>';
        //echo '<th >Laki - Laki</th>';
        //echo '<th >Total</th>';
        //echo '</tr>';
        foreach ($data['pndk'] as $key1 => $value1) {
            echo '<tr>';
            echo '<td>'.strtoupper($value1->pndk_akhir).'</td>';
            foreach ($kel_usia as $key => $value) {
            // code...
                echo '<td>'.$usia[strtoupper($value1->pndk_akhir)][$value].'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';

    }

    function gen_report_pemilihan_tahap2(){
        $data=array();
        $s="SELECT A.*
                from votes_tahap2 A";
        $q=$this->m_model->selectcustom($s);
        $num_user_id=array();
        $num_vote_sah=array();
        $num_vote_nonsah=array();
        $num_user_perwil=array();
        $list_user_id_wil=array();
        foreach ($q as $key => $value) {
            // code...
            if(!isset($num_user_perwil[$value->wil_pemilih])){
                $num_user_perwil[$value->wil_pemilih]=0;
            }

            if(!in_array($value->id_pemilih, $list_user_id_wil)){ 
                $list_user_id_wil[]=$value->id_pemilih;
                $num_user_perwil[$value->wil_pemilih]++;
            }

            if(!isset($num_vote_sah[$value->wil_pemilih])){
                $num_vote_sah[$value->wil_pemilih]=0;
            }

            if(!isset($num_vote_nonsah[$value->wil_pemilih])){
                $num_vote_nonsah[$value->wil_pemilih]=0;
            }

            if($value->locked==1){
                $num_vote_sah[$value->wil_pemilih]++;
            }
            if($value->locked==0){
                $num_vote_nonsah[$value->wil_pemilih]++;
            }
        }

        //print_r($list_user_id_wil);
        /*foreach ($list_user_id_wil as $key => $value) {
            // code...
            echo $key.". ".$value."<br>";
        }*/
        $data['num_vote_sah']=$num_vote_sah;
        $data['num_vote_nonsah']=$num_vote_nonsah;
        $data['num_user_perwil']=$num_user_perwil;
        $data['list_user_id_wil']=$list_user_id_wil;

        $wilayah=$this->m_model->selectas('id > 0', null, 'wilayah');
        $data['wilayah']=$wilayah;
        $data['vote1']=$q;

        $this->load->view('tools/gen_report_pemilihan_tahap1', $data);

    }

    function report_gen_pnt2($kwg_wil=0){
        $data=array();
        $s="SELECT B.nama_lengkap, B.kwg_wil, A.konvensional, C.onlen, A.konvensional+C.onlen as total
            FROM anggota_jemaat B
            left join (select id_calon2,  wil_calon2, COUNT(id) as konvensional from votes_tahap2 where sn_surat_suara is not null && wil_calon2='".$kwg_wil."' group by id_calon2)  A on B.id = A.id_calon2 && A.wil_calon2='".$kwg_wil."'
            left join (select id_calon2, wil_calon2, COUNT(id) as onlen from votes_tahap2 where sn_surat_suara is null && wil_calon2='".$kwg_wil."' group by id_calon2)  C on B.id = C.id_calon2 && C.wil_calon2='".$kwg_wil."'
            WHERE B.id >0 && B.kwg_wil='".$kwg_wil."'

            order by total DESC";// die($s);
        $q=$this->m_model->selectcustom($s);
        $data['data']=$q;

        $q="select B.kwg_nama, B.kwg_alamat, B.kwg_wil, B.kwg_no as no_kk, C.hub_keluarga, COUNT(A.id) as peserta
                from keluarga_jemaat B
                join anggota_jemaat A on B.id = A.kwg_no
                join ags_hub_kwg C on C.idhubkel = A.hub_kwg
                where A.id >0 && A.status=1 && ((A.sts_anggota = 1  && (A.last_modified_dorkas < '2022-01-27 00:00:00' || A.last_modified_dorkas is null ) && A.created_at < '2022-01-28 00:00:00') || (A.sts_anggota = 0 && A.last_modified_dorkas > '2022-01-10 00:00:00' && A.last_modified_dorkas < '2022-01-27 00:00:00') ) && B.status=1  && A.status_sidi=1 && YEAR(A.tgl_lahir) < 2005
                order by B.kwg_wil ASC";
        $pesertaPemilihan=$this->m_model->selectcustom($q);
        $data['angjem']=$pesertaPemilihan[0];


        $this->load->view('tools/report_gen_pnt2', $data);
    }

    public function test_angjem(){
        $r=$this->m_model->selectas('id > 0', null, 'anggota_jemaat');
        print_r($r);
    }

    public function info(){
        phpinfo();
    }

    public function sync_angjem_lampiran(){
        $data=array();
        $date="2023-02-04 00:00:00";
        $s="select * from lampiran_angjem where status=1 && (new_path is NULL || new_path = '') && created_at < '".$date."'  && new_path_sts=0
            limit 1000"; //die($s);
        $q=$this->m_model->selectcustom($s);
        $param=array();
        $table="drive_lampiran_angjem";
        $success=0;
        $failed=0;
        foreach ($q as $key => $value) {
            // code...
            //check to drivetable
            $filename=basename($value->path);
            $check=$this->check_drive($table, $filename);
            if(count($check)>0){
                $param['new_path_sts']=1;
                $param['new_path']=$check[0]->fileid;
            }
            else{
                $param['new_path_sts']=-1;
            }

            $u=$this->m_model->updateas('id', $value->id, $param, 'lampiran_angjem');
            if($u){
                $success++;
            }
            else{
                $failed++;
            }
        }

        echo "success :" .$success." | failed: ".$failed;
    }

    public function sync_angjem_lampiran_compress(){
        $data=array();
        $date="2023-02-04 00:00:00";
        $s="select * from lampiran_angjem where status=1 && (new_path_compress is NULL || new_path_compress = '') && created_at < '".$date."' && path_compress_sts=0 
            limit 1000";
        $q=$this->m_model->selectcustom($s);
        $table="drive_lampiran_angjem";
        $success=0;
        $failed=0;
        foreach ($q as $key => $value) {
            // code...
            //check to drivetable
            $param=array();
            $filename=basename($value->path_compress);
            $check=$this->check_drive($table, $filename);
            if(count($check)>0){
                $param['path_compress_sts']=1;
                $param['new_path_compress']=$check[0]->fileid;
            }
            else{
                $param['path_compress_sts']=-1;
            }

            $u=$this->m_model->updateas('id', $value->id, $param, 'lampiran_angjem');
            if($u){
                $success++;
            }
            else{
                $failed++;
            }
        }
        echo "success :" .$success." | failed: ".$failed;
    }

    private function check_drive($table, $name_file){
        $data=array();
        $q="select * from ".$table." where filename like '".$name_file."'";
        $r=$this->m_model->selectcustom($q);
        return $r;

    }

    public function insert_kpkp_keluarga(){
        $data=array();
        $s="select A.*, B.kwg_nama, B.kwg_alamat, C.hub_keluarga, B.id as kwg_id, B.kwg_telepon, D.id as kpkp_keluarga_jemaat_id 
            from anggota_jemaat A 
            join keluarga_jemaat B on B.id = A.kwg_no
            join ags_hub_kwg C on C.idhubkel = A.hub_kwg 
            left join kpkp_keluarga_jemaat D on D.keluarga_jemaat_id = B.id 
            where A.id >0 && A.status=1 && A.sts_anggota=1 and A.sts_kpkp = 1 
            order by A.nama_lengkap ASC ";
        $q=$this->m_model->selectcustom($s);
        $ls_keluarga_id=array();
        foreach ($q as $key => $value) {
            // code...
            if($value->kpkp_keluarga_jemaat_id != null){
                $ls_keluarga_id[]=$value->kwg_id;
                continue; //ini bearti sudah punya dompet KPKP
            }

            if(in_array($value->kwg_id, $ls_keluarga_id)){
                continue; //ini dilewati karena pada iterasi sebelumnya sudah di proses atau di cek jadi tidak perlu di insert lagi data keluarganya ke dompet KPKP
            }

            $param=array();
            //ini bearti belum ada tapi status KPKP nya aktif, maka harus diinsert ke data kpkp_keluarga

            $param['keluarga_jemaat_id']=$value->kwg_id;
            $param['saldo_akhir']=0;
            $param['saldo_akhir_sukarela']=0;
            $param['last_pembayaran']='0000-00-00';
            $param['created_at']=date('Y-m-d H:i:s');
            $param['created_by']=6;
            $this->m_model->insertgetid($param, 'kpkp_keluarga_jemaat');

            $ls_keluarga_id[]=$value->kwg_id;

        }

    }

    public function import_bulanan_kpkp(){
        $data=array();
        //get keluarga jemaat dulu
        $s="select B.kwg_nama, B.kwg_alamat, B.kwg_telepon, D.*, B.kwg_wil, C.num_jiwa, B.status
            from keluarga_jemaat B
            join kpkp_keluarga_jemaat D on D.keluarga_jemaat_id = B.id
            join (select z.kwg_no, COUNT(z.id) as num_jiwa 
                    from anggota_jemaat z where z.status=1 && z.sts_kpkp=1 && z.sts_anggota=1 && tgl_meninggal='0000-00-00' && (z.tmpt_meninggal='' || z.tmpt_meninggal is NULL) 
                    group by z.kwg_no
                ) C on C.kwg_no = B.id 
            where B.status=1
            order by B.kwg_wil ASC, B.kwg_nama ASC
            ";
        $q=$this->m_model->selectcustom($s);
        $ls_keluarga=array();
        foreach ($q as $key => $value) {
            // code...
            $ls_keluarga[$value->kwg_nama.'-'.$value->kwg_wil]=$value;

        }
      
        $path_file="import/kpkp/data-kpkp per Januari 2024.xlsx";
        //die(FCPATH.$path_file);

        $this->load->helper('XLSXReader');
        $this->load->helper('XLSXWorksheet');
        $xlsx = new XLSXReader(FCPATH.$path_file);
        $sheetNames = $xlsx->getSheetNames();

        foreach ($sheetNames as $key => $sheetName) {
            if($key>1){
              continue;
            }
            //ini berjalan hanya di sheet 1
            $sheet = $xlsx->getSheet($sheetName);
            $xlsx_data = $sheet->getData();
            $header_row_xlsx = array_shift($xlsx_data);

            //echo json_encode(array('total'=>$old_total));
            //echo print_r($header_row_xlsx); die();
            $nameField=array();
            foreach ($header_row_xlsx as $key => $value) {
              // code...
              /*if($value==null){
                continue;
              }*/
              
              $nameField[]=$value;
            }
            //echo count($nameField); print_r($nameField); die();

            $success=0;
            $success_temp=0;
            $read_process=0;
            $ls_data_kwg_exl=array();
            foreach ($xlsx_data as $key => $row_xlsx) {
              //if($key+1 <= $read_data){
                //ini bearti sudah dibaca sebelumnya
                //continue;
              //}

                if($read_process>=4000 ){
                //ini bearti sudah dibaca sebelumnya
                break;
                }

                unset($arrData);
                //unset($arrData_new);
                for ($i = 0; $i < count($row_xlsx); $i++) {
                    if($i>count($nameField)){
                        continue;
                    }
                    // non-date value
                    $xlsx_field_value = $row_xlsx[$i];

                    $arrData[$nameField[$i]]=htmlentities(clearText($xlsx_field_value));
                    if($nameField[$i]=='Tgl Terakhir Bayar'){
                        $UNIX_DATE = ($xlsx_field_value - 25569) * 86400;
                        //$arrData[$nameField[$i]]=gmdate("m-d-Y", $UNIX_DATE);
                        $arrData[$nameField[$i]]=gmdate("Y-m-d", $UNIX_DATE);
                    }
                }
                $ls_data_kwg_exl[$arrData['Nama KK'].'|'.$arrData['Wilayah']][]=$arrData;
            }
        }

        //get pokok iuran
        $s1="select * from kpkp_pokok_iuran ";
        $q1=$this->m_model->selectcustom($s1);

        echo '<table>';
        echo '<tr><th>#</th><th>Nama</th><th>Wilayah Sisfo</th><th>Data System</th><th>Data Excel</th></tr>';
        $i=1;





        $num_month=array();
        foreach ($ls_keluarga as $key => $value) {
            // code...

            if(isset($ls_data_kwg_exl[$value->kwg_nama.'|'.$value->kwg_wil])){
                if(count($ls_data_kwg_exl[$value->kwg_nama.'|'.$value->kwg_wil] ) == 1){
                    //continue;
                    if($value->num_jiwa!=$ls_data_kwg_exl[$value->kwg_nama.'|'.$value->kwg_wil][0]['Jumlah Jiwa KPKP']){
                        //continue;
                    }
                    else{
                        continue;

                    }
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo '<td>'.$value->kwg_nama.'</td>';
                    echo '<td>'.$value->kwg_wil.'</td>';
                    echo '<td><ul>';
                    foreach ($ls_data_kwg_exl[$value->kwg_nama.'|'.$value->kwg_wil] as $key1 => $value1) {
                        // code...
                        //hitung bulan berdasarkan pokok_iuran
                        $summary="";
                        $total=0;
                        $last_periode=null;
                        $last_num_month=0;
                        $total_saldo_new=0;

                        //check jiwa terdaftar kpkp
                        $num_jiwa=$value->num_jiwa;
                        $sts_num_jiwa='';
                        if($value->num_jiwa!=$value1['Jumlah Jiwa KPKP']){
                            $sts_num_jiwa=' | Beda';
                        }

                        foreach ($q1 as $key2 => $value2) {
                            // code...
                            $num_month[$value->kwg_nama][$value2->periode]=$this->count_month($value2->periode, $value2->nominal, $value1['Tgl Terakhir Bayar'], $value2->status, $last_periode, $last_num_month);

                            $summary.=$value2->periode.": ".$num_month[$value->kwg_nama][$value2->periode]['num']." | ";
                            $total=$total+$num_month[$value->kwg_nama][$value2->periode]['num'];
                            $last_periode=$num_month[$value->kwg_nama][$value2->periode]['last_periode'];
                            $last_num_month=$num_month[$value->kwg_nama][$value2->periode]['num'];

                            $num_bulan_periode=$num_month[$value->kwg_nama][$value2->periode]['num'];
                            $saldo_new=$this->hitung_saldo($num_jiwa, $num_bulan_periode, $value2->nominal);
                            $total_saldo_new=$total_saldo_new+$saldo_new;
                        }
                        //if($value->num_jiwa!=$value1['Jumlah Jiwa KPKP']){
                          //  echo '<li>(Jiwa: '.$num_jiwa.''.$sts_num_jiwa.')</li>';
                        //}else{
                            echo '<li>Wil: <b>'.$value1['Wilayah'].'</b> (saldo: '.$total_saldo_new.'; Jiwa: '.$num_jiwa.''.$sts_num_jiwa.'; Tgl Terakhir Bayar: '.$value1['Tgl Terakhir Bayar'].'; Total Bulan: '.$total.' ['.$summary.'])</li>';
                        //}

                        //insert dulu data saldo awal setiap keluarga
                        $param1=array();
                        $param1['keluarga_jemaat_id']=$value->keluarga_jemaat_id;
                        $param1['type']='0'; //sebagai initiati saldo awal
                        $param1['nominal']=$total_saldo_new;
                        $param1['tgl_bayar']=date('Y-m-d');
                        $param1['created_at']=date('Y-m-d H:i:s');
                        $param1['created_by']='1'; //system administrator
                        //$i_databayaranKPKP=$this->m_model->insertgetid($param1, 'kpkp_bayar_bulanan');
                        $i_databayaranKPKP=true;
                        if($i_databayaranKPKP){
                            //update ke keluarga KPKP
                            $recid_kpkp=$value->id; //id kpkp_keluarga
                            $param=array();
                            $param['saldo_akhir']=$total_saldo_new;
                            $param['last_pembayaran']=NULL;
                            $param['last_update']=NULL;
                            //$u=$this->m_model->updateas('id', $recid_kpkp, $param, 'kpkp_keluarga_jemaat');
                        }
                    }
                    echo '</ul></td>';
                    echo '<td><ul>';
                    $status_check='';
                    foreach ($ls_data_kwg_exl[$value->kwg_nama.'|'.$value->kwg_wil] as $key1 => $value1) {
                        // code...
                        $status_check='';
                        if($total!=$value1['Bulan yang harus dibayar/sudah bayar']){
                            $status_check='<i style="color:red;">Tidak Sesuai</i>';
                        }
                        echo '<li>Wil: <b>'.$value1['Wilayah'].'</b> (saldo: '.$value1['Total Keseluruhan'].'; Jiwa: '.$value1['Jumlah Jiwa KPKP'].'; Total Bulan: '.$value1['Bulan yang harus dibayar/sudah bayar'].' '.$status_check.')</li>';
                    }
                    echo '</ul></td>';
                    echo '</tr>';
                    $i++;
                }
            }
            else{
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$value->kwg_nama.' | jiwa:'.$value->num_jiwa.' | status:'.$value->status.' (tidak ada)</td>';
                echo '<td>'.$value->kwg_wil.' | '.$value->keluarga_jemaat_id.'</td>';
                echo '<td></td>';
                echo '</tr>';
                $i++;
            }
        }
        echo '</table>';

        //$data['data']=$arrData_new;
        //$data['po_barang_masuk_supplier']=$po_barang_masuk_supplier;
        //$this->load->view('tools/import_bulanan_kpkp', $data);
    }

    private function count_month($periode, $nominal, $tgl_user, $status=1, $last_periode=null, $last_num_month=0){
        $data=array();
        $data['num']=0;
        $data['nominal']=0;
        $data['last_periode']=null;
        $tgl_user=date('Y-m', strtotime($tgl_user) ).'-01';
        $tgl_periode=date('Y-m', strtotime($periode) ).'-01';
        $today=date('Y-m').'-01';
        
        if($status==1){
            //ini bearti masih aktif
            if(strtotime($tgl_user) > strtotime($tgl_periode) && $last_periode!=null ){
                $data['num']=0;
                $data['nominal']=0;
            }else{
                $diff = abs(strtotime($today)-strtotime($tgl_user));
                //echo ($today.'-'.$tgl_user); die();
                //echo ($diff); die();
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $data['num']=(($years*12)+$months)+$last_num_month;
                if(strtotime($tgl_user)<strtotime($today)){
                    //ini bearti minus
                    $data['num']=$data['num']*-1;
                }
                $data['last_periode']=$tgl_periode;
            }

        }
        else if($status==0){
            //ini bearti sudah tidak berlaku, tapi masih digunakan untuk melihat tagihan sebelum di periode ini
            if(strtotime($tgl_user) > strtotime($tgl_periode)){
                $data['num']=0;
                $data['nominal']=0;
            }else{
                $diff = abs(strtotime($tgl_user)-strtotime($tgl_periode));
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $data['num']=(($years*12)+$months)+$last_num_month;
                $data['last_periode']=$tgl_periode;
                if(strtotime($tgl_user)<strtotime($today)){
                    //ini bearti minus
                    $data['num']=$data['num']*-1;
                }
            }
            
        }

        //die($tgl_user);
        return $data;
    }

    private function hitung_saldo($jiwa, $num_bulan, $nominal_pokok){
        $data=array();
        $saldo=($jiwa*$nominal_pokok)*$num_bulan;

        return $saldo;

    }

}

