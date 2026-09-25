<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'pdf7/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class Pdf extends CI_Controller {

public function index()
{
    // code...
}

    public function SuratPemberitahuanIuranWajibKPKP($auth=null)
    {   
        if($auth==NULL){
            die("Access Denied!");
        }
        $auth;// data anggota jemaat yg di encrypt
        $data=array();
        $iuranKpkpp='5000';
        $total_biayaKPKP='0';
        $data['iuranKpkpp']=$iuranKpkpp;
        $data['total_biayaKPKP']=$total_biayaKPKP;

        
        $s10="select Z.* from ( select *, '1' as keluarga_inti 
                        from anggota_jemaat A 
                        where MD5(CONCAT('*(2791bjaksdk',A.kwg_no))='".$auth."'
                        UNION ALL 
                        select *, '0' as keluarga_inti 
                        from anggota_jemaat A
                        where MD5(CONCAT('*(2791bjaksdk',A.kwg_no_kpkp))='".$auth."'
                        ) Z
                        where Z.delete_user IS NULL && Z.status
                        order by Z.keluarga_inti DESC, Z.no_urut ASC";
        //die($s10); 
        $anggota_KK=$this->m_model->selectcustom($s10); 



        $num_anggotaKPKP=0;
        $kwg_no=0;
        $kwg_nama='-';
        $kwg_wil='-';
        foreach ($anggota_KK as $key => $value) {
            // code...
            if($value->sts_kpkp==1 && ($value->kwg_no_kpkp==0 || $auth == MD5('*(2791bjaksdk'.$value->kwg_no_kpkp) ) ){
                $total_biayaKPKP=$total_biayaKPKP+$iuranKpkpp;

                $num_anggotaKPKP++;
            }

            if($value->kwg_no_kpkp==0){
                $kwg_no=$value->kwg_no;
                if($value->hub_kwg ==1){
                    //ini bearti kepala keluarga
                    $kwg_nama=$value->nama_lengkap;
                    $kwg_wil=$value->kwg_wil;
                }
            }
        }
        $total_biayaKPKP=$iuranKpkpp*$num_anggotaKPKP;
        $data['total_biayaKPKP']=$total_biayaKPKP;


        $data['anggota_KK']=$anggota_KK;
        $data['kwg_no']=$kwg_no;
        $data['kwg_nama']=$kwg_nama;
        $data['kwg_wil']=$kwg_wil;
        $data['num_anggotaKPKP']=$num_anggotaKPKP;

        //get_dompet kpkp
        $dompet_kpkp=$this->m_model->selectas('keluarga_jemaat_id', $kwg_no, 'kpkp_keluarga_jemaat');
        $saldo_akhir=0;
        foreach ($dompet_kpkp as $key => $value) {
            // code...
            $saldo_akhir=$value->saldo_akhir;
        }
        $data['dompet_kpkp']=$dompet_kpkp;
        $data['saldo_akhir']=$saldo_akhir;

        #$sq="select * from kpkp_bayar_bulanan where keluarga_jemaat_id='".$dataKK[0]->id."' order by tgl_bayar DESC, type ASC,  created_at ASC";
        #$mutasiiuran_kpkp=$this->m_model->selectcustom($sq);

        $est_bulanTercover=countBulanTercover($total_biayaKPKP, $saldo_akhir, date('Y-m'));

        $data['est_bulanTercover']=$est_bulanTercover;

        // code...
        try {
            //ob_start();
            #include 'cred.php';
            #include dirname(__FILE__).'/content/surat_kpkp.php';
            $content = $this->load->view('pdf/suratpemberitahuaniuranwajibkpkp', $data, TRUE);
            //$content = ob_get_clean();

            $html2pdf = new Html2Pdf('P',array(210, 330),'en',true,'UTF-8',array(7, 10, 15, 10));
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content);
            $html2pdf->output('Surat-Pemberitahuan-Iuran-Bulanan-KPKP-'.date('dMY').'.pdf');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

}

