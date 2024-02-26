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

    public function cek(){
        $data=array();
        //verfikasi NIK
        if($this->input->post('nik') && $this->input->post('nik') != ''){
            $s="select * from anggota_jemaat where no_anggota='".clearText($this->input->post('nik'))."' && sts_kpkp=1";
            $q=$this->m_model->selectcustom($s);
            $alt="Nama Lengkap dan Tanggal Lahir";
        }
        else if($this->input->post('namalengkap') && $this->input->post('namalengkap') != '' && $this->input->post('tgl_lahir') && $this->input->post('tgl_lahir') != ''){
            $s="select * from anggota_jemaat where lower(nama_lengkap)='".clearText(strtolower($this->input->post('namalengkap')))."' && tgl_lahir='".clearText(strtolower($this->input->post('tgl_lahir')))."' && sts_kpkp=1";
            $q=$this->m_model->selectcustom($s);
            $alt="NIK Anggota Jemaat";
        }
        else{
            $data['msg']='Anda belum memasukan NIK atau Nama Lengkap & Tanggal Lahir untuk pencarian data.';
            echo $data['msg'];
            return;
        }

        if(count($q)<=0){
            $data['sts']=0;
            $data['msg']='Data tidak ditemukan, silahkan menggunakan pencarian dengan '.$alt.' atau mungkin belum terdaftar sebagai Anggota KPKP (Dapat Hubungi Pengurus KPKP untuk Status Anggota KPKP)';
            echo $data['msg'];
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
        $mutasiiuran_kpkp=$this->m_model->selectas('keluarga_jemaat_id', $kwg_id, 'kpkp_bayar_bulanan');
        $data['total_biayaKPKP']=$total_biayaKPKP;
        if(count($dompet_kpkp)>0){
            $data['dompet_kpkp']=$dompet_kpkp[0];
            $data['data']=$dompet_kpkp[0];
        }
        $data['mutasiiuran_kpkp']=$mutasiiuran_kpkp;

        $this->load->view('kpkp/rincian_kpkp', $data);


    }

}

