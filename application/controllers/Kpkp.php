<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Kpkp extends CI_Controller {



  /**

   * Index Page for this controller.

   *

   * Maps to the following URL

   *    http://example.com/index.php/welcome

   *  - or -

   *    http://example.com/index.php/welcome/index

   *  - or -

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



    public function index(){
        $data=array();

        $this->load->view('kpkp/index', $data);

    }

    public function agree_opening(){
        $data=array();
        $opening=$this->input->post('opening');
        $expire=300;
        $this->session->set_tempdata('opening', $opening, $expire);
    }

    public function cek(){
        $data=array();
        //verfikasi NIK
        if($this->input->post('nik') && $this->input->post('nik') != ''){
            $s="select * from anggota_jemaat where no_anggota='".clearText($this->input->post('nik'))."' && sts_kpkp=1";
            $q=$this->m_model->selectcustom($s);
            $alt="Nama Lengkap dan Tanggal Lahir";
            $name_log=clearText($this->input->post('nik'));
            $tgl_lahir_log=NULL;
        }
        else if($this->input->post('namalengkap') && $this->input->post('namalengkap') != '' && $this->input->post('tgl_lahir') && $this->input->post('tgl_lahir') != ''){
            $tgl_lahir="";

            $num=1;;
            //foreach ($this->input->post('tgl_lahir') as $key => $value) {
            for ($i=0; $i < 3; $i++) { 
                // code...
                $value='00';
                if(isset($this->input->post('tgl_lahir')[$i])){
                   $value =$this->input->post('tgl_lahir')[$i];
                }
                if($value<10){
                    $value='0'.$value;
                }
                $tgl_lahir.=$value;
                $num++;
                if($num<=3){
                    $tgl_lahir.='-';
                }
                
            }
            $s="select * from anggota_jemaat where lower(nama_lengkap)='".clearText(strtolower($this->input->post('namalengkap')))."' && tgl_lahir='".clearText(strtolower($tgl_lahir))."' && sts_kpkp=1";
            $q=$this->m_model->selectcustom($s); //die($s);
            $alt="NIK Anggota Jemaat";

            $name_log=clearText($this->input->post('namalengkap'));
            $tgl_lahir_log=$tgl_lahir;
        }
        else{
            $name_log='Percobaan tanpa NIK atau Nama Jemaat';
            $tgl_lahir_log=NULL;
            $ilog="insert into kpkp_log_cek (nama, tanggal_lahir, succes_open, ip_address, created_at) values('".$name_log."','".$tgl_lahir_log."','0','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d H:i:s')."')";
            $qilog=$this->m_model->querycustom($ilog);

            $data['msg']='Anda belum memasukan NIK atau Nama Lengkap & Tanggal Lahir untuk pencarian data.';
            echo $data['msg'];
            return;
        }

        if(count($q)<=0){
            $ilog="insert into kpkp_log_cek (nama, tanggal_lahir, succes_open, ip_address, created_at) values('".$name_log."','".$tgl_lahir_log."','0','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d H:i:s')."')";
            $qilog=$this->m_model->querycustom($ilog);

            $data['sts']=0;
            //$data['msg']='Data tidak ditemukan, silahkan menggunakan pencarian dengan '.$alt.' atau mungkin belum terdaftar sebagai Anggota KPKP (Dapat Hubungi Pengurus KPKP untuk Status Anggota KPKP)';
            $txtwa="Halo, saya ingin bertanya mengenai data *".strtolower($this->input->post('namalengkap'))."* dengan Tanggal Lahir *".date('d M Y', strtotime($tgl_lahir))."* tersebut tidak ditemukan dalam sistem KPKP?";

            $data['msg']='Data tidak ditemukan (<b>'.strtolower($this->input->post('namalengkap')).'</b> dengan tanggal lahir <b>'.date('d M Y', strtotime($tgl_lahir)).'</b>). <br> Untuk pertanyaan data Anda di Sisfo GKP Kampung Sawah, Anda dapat menghubungi nomor dibawah ini:';
            $data['msg']=$data['msg'].'<ol>'; 
            $data['msg']=$data['msg'].'<li>Melsi Vania (<a href="tel:085173240545">0851 7324 0545</a>) <br><a aria-label="Chat on WhatsApp" href="https://wa.me/6281287565026?text=.'.urlencode($txtwa).'" title="Chat on Whatsapp"><img style="width:30px;" src="'.base_url().'assets/images/wa-ico.png"></a> <a href="tel:085173240545"><img style="width:30px;" src="'.base_url().'assets/images/phone-ico.png"></a> <br></li> <li>Grace Millenia (<a href="tel:085156794987">0851 5679 4987</a>) <br><a aria-label="Chat on WhatsApp" href="https://wa.me/085156794987?text='.urlencode($txtwa).'" title="Chat on Whatsapp"><img style="width:30px;" src="'.base_url().'assets/images/wa-ico.png"></a> <a href="tel:085156794987"><img style="width:30px;" src="'.base_url().'assets/images/phone-ico.png"></a> </li></ol>';
            //echo $data['msg'];
            echo '<div class="col-12" style="padding: unset; marin-left: unset; text-align:justify">'.$data['msg'].'</div>';
            return;
        }

        $kwg_id=0;
        $total_biayaKPKP=0;
        $num_anggota=0;
        $nama_kk='[tidak diketahui]';
        foreach ($q as $key => $value) {
            // code...
            $kwg_id=$value->kwg_no;

            //cek jumlah jiwa
            $s3="select * from keluarga_jemaat where id='".$kwg_id."'  ";
            $q3=$this->m_model->selectcustom($s3);
            foreach ($q3 as $key3 => $value3) {
                // code...
                $nama_kk=$value3->kwg_nama;
            }

            $s2="select * from anggota_jemaat where kwg_no='".$kwg_id."'  && sts_anggota=1 && status=1 && sts_kpkp=1";
            $q2=$this->m_model->selectcustom($s2);
            foreach ($q2 as $key1 => $value1) {
                // code...
                $total_biayaKPKP=$total_biayaKPKP+5000;
                $num_anggota++;

            }
        }

        $data['nama_kk']=$nama_kk;
        $data['num_anggota']=$num_anggota;

        //cek data KPKP
        //get_dompet kpkp
        $dompet_kpkp=$this->m_model->selectas('keluarga_jemaat_id', $kwg_id, 'kpkp_keluarga_jemaat');
        //$mutasiiuran_kpkp=$this->m_model->selectas('keluarga_jemaat_id', $kwg_id, 'kpkp_bayar_bulanan');
        $sq="select * from kpkp_bayar_bulanan where keluarga_jemaat_id='".$kwg_id."' order by tgl_bayar ASC, type ASC,  created_at ASC";
        $mutasiiuran_kpkp=$this->m_model->selectcustom($sq);
        $data['total_biayaKPKP']=$total_biayaKPKP;
        if(count($dompet_kpkp)>0){
            $data['dompet_kpkp']=$dompet_kpkp[0];
            $data['data']=$dompet_kpkp[0];
        }
        $data['mutasiiuran_kpkp']=$mutasiiuran_kpkp;

        $ilog="insert into kpkp_log_cek (nama, tanggal_lahir, succes_open, ip_address, created_at) values('".$name_log."','".$tgl_lahir_log."','1','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d H:i:s')."')";
        $qilog=$this->m_model->querycustom($ilog);

        $this->load->view('kpkp/rincian_kpkp', $data);


    }

}

