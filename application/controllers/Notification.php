<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Notification extends CI_Controller

{

    /**
`
     * Send to a single device

     */

    public function sendNotification_old(){

        $priority="high";

        $status="Test Notification - Old";

        $notification= array('title' => 'GKP Kampung Sawah ','body' => $status,'sound' => 'default', 'click_action'=>'');



        $fields = array(

             'to' => 'cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE',

             'notification' => $notification



            );



        $api_web="AIzaSyBTq7wa4sIL3iD7QnzCQQ5OKNJaOnwN9_M";

        $api="AAAA8TY8TIY:APA91bH3wZgTYp_AhcJbYPlybNvAbHQh5bX1o62kv8PKUfHWnCAtv9F9_8XGbO3CrLEyYBZzUVEETiLYWTADizCaKv1RFaMC9qaEVrqu0nkz_pTrv7Ci9dndAwl_gSLzvPDsihwIRbbi";

        $headers = array(

            'Authorization:key='.$api,

            'Content-Type: application/json'

            );

        $url = 'https://fcm.googleapis.com/fcm/send';

       $ch = curl_init();

       curl_setopt($ch, CURLOPT_URL, $url);

       curl_setopt($ch, CURLOPT_POST, true);

       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  

       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // echo json_encode($fields);

       $result = curl_exec($ch);           

       echo curl_error($ch);

       if ($result === FALSE) {

           die('Curl failed: ' . curl_error($ch));

       }

       curl_close($ch);



       print_r($result);

     

       return $result;



    }

    public function sendNotification()

    {

        $token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE'); // push token

        $message = "Test notification message CI";



        $this->load->library('fcm');

        $this->fcm->setTitle('Test FCM Notification');

        $this->fcm->setMessage($message);



        /**

         * set to true if the notificaton is used to invoke a function

         * in the background

         */

        $this->fcm->setIsBackground(true);



        /**

         * payload is userd to send additional data in the notification

         * This is purticularly useful for invoking functions in background

         * -----------------------------------------------------------------

         * set payload as null if no custom data is passing in the notification

         */

        $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

        $payload = array();

        $this->fcm->setPayload($payload);



        /**

         * Send images in the notification

         */

        $this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp_compressed.png');

        $this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



        /**

         * Get the compiled notification data as an array

         */

        $json = $this->fcm->getPush();

        //print_r($json);

        $p = $this->fcm->send($token, $json);



        print_r($p);

    }



    public function sendNotification_ppj_start()
    {

        //get notification
        $device_id=$this->m_model->select('users_jemaat');
        $device_id2=$this->m_model->select('device_users');
        $ls_device_id=array();

        foreach ($device_id as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id) && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }

        foreach ($device_id2 as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }
        $token = $ls_device_id;
        //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE'); // push token

        //, 'cZE8m7MuQW-jNDAXFJRymR:APA91bFb1ZqI8MogkKiIlq6WAlwnhU6-nLYapN3jmkD6_b6cUn64LQ0gRvS31JolcJzbWJ5IuCY79blux5zLGg4RnWOCrTcS3sBo8a7ugACw77JomcDmEvxlQlB4RMMDjZsqZ0SR7xiw' //william

        $title = "🔔Sampurasun AngJem GKP Kp Sawah😇";
        $message = "Pemilu Online-PPJ sudah dibuka.\nNyok Kite Milih & Sukseskan!";



        $this->load->library('fcm');

        $this->fcm->setTitle($title);

        $this->fcm->setMessage($message);



        /**

         * set to true if the notificaton is used to invoke a function

         * in the background

         */

        $this->fcm->setIsBackground(true);



        /**

         * payload is userd to send additional data in the notification

         * This is purticularly useful for invoking functions in background

         * -----------------------------------------------------------------

         * set payload as null if no custom data is passing in the notification

         */

        $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

        $payload = array();

        $this->fcm->setPayload($payload);



        /**

         * Send images in the notification

         */

        $this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/51842-Pemilu-ppj.jpg');
        $this->fcm->setImage('https://dev.sisfo-gkpkampungsawah.com/assets/images/poster-mobile-ppj-01_compressed-xs.jpg');

        $this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



        /**

         * Get the compiled notification data as an array

         */

        $json = $this->fcm->getPush();

        //print_r($json);

        $p = $this->fcm->send($token, $json);



        print_r($p);

    }

    public function sendNotification_pnt1_start()
    {

        //get notification
        $device_id=$this->m_model->select('users_jemaat');
        $device_id2=$this->m_model->select('device_users');
        $ls_device_id=array();

        foreach ($device_id as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id) && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }

        foreach ($device_id2 as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }
        $token = $ls_device_id;
        //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE'); // push token

        //, 'cZE8m7MuQW-jNDAXFJRymR:APA91bFb1ZqI8MogkKiIlq6WAlwnhU6-nLYapN3jmkD6_b6cUn64LQ0gRvS31JolcJzbWJ5IuCY79blux5zLGg4RnWOCrTcS3sBo8a7ugACw77JomcDmEvxlQlB4RMMDjZsqZ0SR7xiw' //william

        $title = "🔔Sampurasun AngJem GKP Kp Sawah😇";
        $message = "Pemilu Online-Penatua Tahap 1 sudah dibuka.\nNyok Kite Milih & Sukseskan!";



        $this->load->library('fcm');

        $this->fcm->setTitle($title);

        $this->fcm->setMessage($message);



        /**

         * set to true if the notificaton is used to invoke a function

         * in the background

         */

        $this->fcm->setIsBackground(true);



        /**

         * payload is userd to send additional data in the notification

         * This is purticularly useful for invoking functions in background

         * -----------------------------------------------------------------

         * set payload as null if no custom data is passing in the notification

         */

        $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

        $payload = array();

        $this->fcm->setPayload($payload);



        /**

         * Send images in the notification

         */

        //$this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/51842-Pemilu-ppj.jpg');
        $this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/poster-mobile-pnt-01_compressed.jpg');

        $this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



        /**

         * Get the compiled notification data as an array

         */

        $json = $this->fcm->getPush();

        //print_r($json);

        $p = $this->fcm->send($token, $json);



        print_r($p);

    }

    public function sendNotification_pnt2_start()
    {

        //get notification
        $device_id=$this->m_model->select('users_jemaat');
        $device_id2=$this->m_model->select('device_users');
        $ls_device_id=array();

        foreach ($device_id as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id) && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }

        foreach ($device_id2 as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }
        $token = $ls_device_id;
        //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE'); // push token

        //, 'cZE8m7MuQW-jNDAXFJRymR:APA91bFb1ZqI8MogkKiIlq6WAlwnhU6-nLYapN3jmkD6_b6cUn64LQ0gRvS31JolcJzbWJ5IuCY79blux5zLGg4RnWOCrTcS3sBo8a7ugACw77JomcDmEvxlQlB4RMMDjZsqZ0SR7xiw' //william

        $title = "🔔Sampurasun AngJem GKP Kp Sawah😇";
        $message = "Pemilu Online-Penatua Tahap 2 sudah dibuka.\nNyok Kite Milih & Sukseskan!";



        $this->load->library('fcm');

        $this->fcm->setTitle($title);

        $this->fcm->setMessage($message);



        /**

         * set to true if the notificaton is used to invoke a function

         * in the background

         */

        $this->fcm->setIsBackground(true);



        /**

         * payload is userd to send additional data in the notification

         * This is purticularly useful for invoking functions in background

         * -----------------------------------------------------------------

         * set payload as null if no custom data is passing in the notification

         */

        $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

        $payload = array();

        $this->fcm->setPayload($payload);



        /**

         * Send images in the notification

         */

        //$this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/51842-Pemilu-ppj.jpg');
        $this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/poster-mobile-pnt2-01_compressed.jpg');

        $this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



        /**

         * Get the compiled notification data as an array

         */

        $json = $this->fcm->getPush();

        //print_r($json);

        $p = $this->fcm->send($token, $json);



        print_r($p);

    }

    public function sendNotification_ppj_tutup()
    {

        //get notification
        $device_id=$this->m_model->select('users_jemaat');
        $device_id2=$this->m_model->select('device_users');
        $ls_device_id=array();

        foreach ($device_id as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id) && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }

        foreach ($device_id2 as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }
        $token = $ls_device_id;
        //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE', 'cZE8m7MuQW-jNDAXFJRymR:APA91bFb1ZqI8MogkKiIlq6WAlwnhU6-nLYapN3jmkD6_b6cUn64LQ0gRvS31JolcJzbWJ5IuCY79blux5zLGg4RnWOCrTcS3sBo8a7ugACw77JomcDmEvxlQlB4RMMDjZsqZ0SR7xiw'); // push token

        //, 'cZE8m7MuQW-jNDAXFJRymR:APA91bFb1ZqI8MogkKiIlq6WAlwnhU6-nLYapN3jmkD6_b6cUn64LQ0gRvS31JolcJzbWJ5IuCY79blux5zLGg4RnWOCrTcS3sBo8a7ugACw77JomcDmEvxlQlB4RMMDjZsqZ0SR7xiw' //william

        $title = "🔔Sampurasun AngJem GKP Kp Sawah😇";
        $message = "Pemilu Online-PPJ sudah ditutup.\nTerimakasih atas partisipasinya dalam proses pemilihan PPJ ini.";



        $this->load->library('fcm');

        $this->fcm->setTitle($title);

        $this->fcm->setMessage($message);



        /**

         * set to true if the notificaton is used to invoke a function

         * in the background

         */

        $this->fcm->setIsBackground(true);



        /**

         * payload is userd to send additional data in the notification

         * This is purticularly useful for invoking functions in background

         * -----------------------------------------------------------------

         * set payload as null if no custom data is passing in the notification

         */

        $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

        $payload = array();

        $this->fcm->setPayload($payload);



        /**

         * Send images in the notification

         */

        $this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/51842-Pemilu-ppj.jpg');
        $this->fcm->setImage('https://dev.sisfo-gkpkampungsawah.com/assets/images/poster-mobile-ppj-01_compressed-xs.jpg');

        $this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



        /**

         * Get the compiled notification data as an array

         */

        $json = $this->fcm->getPush();

        //print_r($json);

        $p = $this->fcm->send($token, $json);



        //print_r($p);

    }


    public function sendNotification_livestreaming(){
        //get notification
        $device_id=$this->m_model->select('users_jemaat');
        $device_id2=$this->m_model->select('device_users');
        $ls_device_id=array();

        foreach ($device_id as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id) && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }

        foreach ($device_id2 as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }
        //print_r($ls_device_id); die();

        //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE'); 
        $token = $ls_device_id; 
        //, 'cZE8m7MuQW-jNDAXFJRymR:APA91bFb1ZqI8MogkKiIlq6WAlwnhU6-nLYapN3jmkD6_b6cUn64LQ0gRvS31JolcJzbWJ5IuCY79blux5zLGg4RnWOCrTcS3sBo8a7ugACw77JomcDmEvxlQlB4RMMDjZsqZ0SR7xiw' //william
        // push token

        //get data link
        $yt=$this->m_model->selectas('id', $this->input->get('recid'), 'live_streaming');
        //print_r($yt);die();
        //$title = "🔔Wilujeng Dinten Ahad - GKP Kp.Sawah😇";
        $title = "🔔Selamat Hari Minggu - GKP Kp.Sawah😇";
        //$title = "🔔Selamat Hari Natal Semuanya - GKP Kp.Sawah😇";
        //$title = "🔔Selamat Tahun Baru 2022 - GKP Kp.Sawah😇";
        //$title = "🔔Selamat Malam - Kita KRT dulu Yuk😇";
        $message = "Live Streaming: ".$yt[0]->title;
        //$title = "🔔Selamat Malam - Kita KRT dulu Yuk😇";
        //$title = "🔔 ".$yt[0]->title;
        //$title = "🔔Sedang Berlangsung Rapat AngJem Sidi - Khusus";
        //$message = "Link tersedia di Live Streaming pada Aplikasi!";
        $img = $yt[0]->img;
        //$img = 'https://sisfo-gkpkampungsawah.com/assets/images/krt%20asdas.jpg';
        $link = $yt[0]->url;
        //$img = 'https://sisfo-gkpkampungsawah.com/assets/images/rapat%20jemaat1.jpg';
        //$link = 'https://us02web.zoom.us/j/81461356165?pwd=cVhVUmFyVHdGaHdyMlBtdlhaOW9qQT09';



        $this->load->library('fcm');

        $this->fcm->setTitle($title);

        $this->fcm->setMessage($message);
        //$this->fcm->setLink($link);



        /**

         * set to true if the notificaton is used to invoke a function

         * in the background

         */

        $this->fcm->setIsBackground(true);



        /**

         * payload is userd to send additional data in the notification

         * This is purticularly useful for invoking functions in background

         * -----------------------------------------------------------------

         * set payload as null if no custom data is passing in the notification

         */

        $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

        $payload = array();

        $this->fcm->setPayload($payload);



        /**

         * Send images in the notification

         */

        $this->fcm->setImage($img);

//        $this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



        /**

         * Get the compiled notification data as an array

         */

        $json = $this->fcm->getPush();

        //print_r($json);

        $p = $this->fcm->send($token, $json);



        print_r($p);

    }

    public function sendNotification_belummilih(){
        $where="";
        $s="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
where A.status=1 && A.sts_anggota=1 && A.status_sidi=1 ".$where."
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $angjem=$this->m_model->selectcustom($s);

        $s1="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks, C.locked
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join votes_tahap_ppj C on (C.id_pemilih = A.id)
where A.status=1 && A.sts_anggota=1 && A.status_sidi=1 && C.locked in (1,0) ".$where."
group by C.id_pemilih
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $qsudah_vote=$this->m_model->selectcustom($s1);
        $sudah_vote=array();
        foreach($qsudah_vote as $key =>$value){
            $sudah_vote[$value->id]=$value;
        }

        $s2="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join pemilih_konvensional C on (C.anggota_jemaat_id = A.id)
where A.status=1 && A.sts_anggota=1 && A.status_sidi=1 && C.tipe_pemilihan_id in (3) ".$where."
group by C.anggota_jemaat_id
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC"; //die($s2);

        $konvensional=$this->m_model->selectcustom($s2);
        $data['konvensional']=array();
        foreach($konvensional as $key =>$value){
            $data['konvensional'][$value->id]=$value;
        }

        $ls_belum_milih=array();
        $lsnama_belum_milih=array();
        $tidaksah=0;
        foreach ($angjem as $key => $value) {
            // code...
            //check if konvensional diskip
            if(isset($data['konvensional'][$value->id])){
                continue;
            }

            if(isset($sudah_vote[$value->id])){
                //check dulu suara sudah dilock atau belum
                //print_r($sudah_vote[$value->id]);die();
                if($sudah_vote[$value->id]->locked==0){
                    $status_vote='<span style="background:gray; color:#fff;">Belum dilock</span>';
                    $tidaksah=$tidaksah+1;
                }
                else{
                    continue;
                    //$status_vote='<span style="background:green; color:#fff;">Sudah </span>';
                }

                $ls_belum_milih[]=$value->kwg_id;
                $lsnama_belum_milih[$value->kwg_id]=$value->kwg_nama;
            }
        }


        //get notification
        $device_id=$this->m_model->select('users_jemaat');
        $device_id2=$this->m_model->select('device_users');
        $ls_device_id=array();

        foreach ($device_id as $key => $value) {
            // code...
            if(in_array($value->keluarga_jemaat_id, $ls_belum_milih)){
                if(!in_array($value->device_id, $ls_device_id) && $value->device_id!=''){
                    $ls_device_id[$value->keluarga_jemaat_id][]=$value->device_id;
                }
            }
        }

        foreach ($device_id2 as $key => $value) {
            // code...
            if(in_array($value->keluarga_jemaat_id, $ls_belum_milih)){
                if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                    $ls_device_id[$value->keluarga_jemaat_id][]=$value->device_id;
                }
            }
        }
        //print_r($ls_device_id); die();

        //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE');
        $date1=date_create("2021-09-09");
        $date2=date_create(date('Y-m-d'));
        $diff=date_diff($date1,$date2);
        $Hday=$diff->format("%a"); 
        foreach ($ls_device_id as $key => $value) {
            // code...
            $token = $value; 
            //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE');
            //print_r($token);
            //die();

            //$title = "🔔Wilujeng Dinten Ahad - GKP Kp.Sawah😇";
            $title = "🔔Sampurasun Kel. ". $lsnama_belum_milih[$key]." - GKP Kp.Sawah😇";
            $message = "Nyok Gunakan Hak Suaranya dalam pemilihan PPJ. ".$Hday." Hari lagi akan Ditutup loh.";
            //echo($title);
            //echo($message);die();



            $this->load->library('fcm');

            $this->fcm->setTitle($title);

            $this->fcm->setMessage($message);
            //$this->fcm->setLink($link);



            /**

             * set to true if the notificaton is used to invoke a function

             * in the background

             */

            $this->fcm->setIsBackground(true);



            /**

             * payload is userd to send additional data in the notification

             * This is purticularly useful for invoking functions in background

             * -----------------------------------------------------------------

             * set payload as null if no custom data is passing in the notification

             */

            $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

            $payload = array();

            $this->fcm->setPayload($payload);



            /**

             * Send images in the notification

             */

            $this->fcm->setImage('https://dev.sisfo-gkpkampungsawah.com/assets/images/poster-mobile-ppj-01_compressed-xs.jpg');

            $this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



            /**

             * Get the compiled notification data as an array

             */

            $json = $this->fcm->getPush();

            //print_r($json);

            $p = $this->fcm->send($token, $json);



            print_r($p);
            //die();
        }

    }


    public function sendNotification_belummilih_pnt1(){
        $where="";
        $s="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
where A.status=1 && A.sts_anggota=1 && A.status_sidi=1 ".$where."
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $angjem=$this->m_model->selectcustom($s);

        $s1="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks, C.locked
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join votes_tahap1 C on (C.id_pemilih = A.id)
where A.status=1 && A.sts_anggota=1 && A.status_sidi=1 && C.locked in (1,0) ".$where."
group by C.id_pemilih
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC";

        $qsudah_vote=$this->m_model->selectcustom($s1);
        $sudah_vote=array();
        foreach($qsudah_vote as $key =>$value){
            $sudah_vote[$value->id]=$value;
        }

        $s2="SELECT A.id, B.kwg_nama, A.nama_lengkap, A.tgl_lahir, A.tgl_sidi, A.kwg_wil, A.tgl_meninggal, A.tgl_attestasi_masuk, B.id as kwg_id, A.status_sidi, A.telepon, B.kwg_telepon, A.sts_kawin, A.remarks
from anggota_jemaat A 
join keluarga_jemaat B on (B.id = A.kwg_no)
join pemilih_konvensional C on (C.anggota_jemaat_id = A.id)
where A.status=1 && A.sts_anggota=1 && A.status_sidi=1 && C.tipe_pemilihan_id in (3) ".$where."
group by C.anggota_jemaat_id
order by B.kwg_wil, B.kwg_nama, A.no_urut, A.hub_kwg ASC"; //die($s2);

        $konvensional=$this->m_model->selectcustom($s2);
        $data['konvensional']=array();
        foreach($konvensional as $key =>$value){
            $data['konvensional'][$value->id]=$value;
        }

        $ls_belum_milih=array();
        $lsnama_belum_milih=array();
        $lsmsg=array();
        $tidaksah=0;

        $date1=date_create("2021-10-20 23:59:59");
        $date2=date_create(date('Y-m-d H:i:s'));
        $diff=date_diff($date1,$date2);
        $Hday=$diff->format("%a"); 
        $Hhour=$diff->format("%h"); 
        $Hminute=$diff->format("%i"); 


        foreach ($angjem as $key => $value) {
            // code...
            //check if konvensional diskip
            if(isset($data['konvensional'][$value->id])){
                continue;
            }

            if(isset($sudah_vote[$value->id])){
                //check dulu suara sudah dilock atau belum
                //print_r($sudah_vote[$value->id]);die();
                if($sudah_vote[$value->id]->locked==0){
                    $status_vote='<span style="background:gray; color:#fff;">Belum dilock</span>';
                    $tidaksah=$tidaksah+1;
                    $lsmsg[$value->kwg_id]="JANGAN LUPA dikunci dulu Pilihan Calon Penatua Tahap 1-nya Ya! ";
                }
                else{
                    //continue;
                    //$status_vote='<span style="background:green; color:#fff;">Sudah </span>';
                    $status_vote='<span style="background:gray; color:#fff;">Sudah dilock</span>';
                    $tidaksah=$tidaksah+1;
                    $lsmsg[$value->kwg_id]="Terimakasih atas partisipasinya dalam Proses Pemilihan Penatua Tahap 1. ";
                }

                $ls_belum_milih[]=$value->kwg_id;
                $lsnama_belum_milih[$value->kwg_id]=$value->kwg_nama;
            }
            else{

                $lsmsg[$value->kwg_id]="Nyok Gunakan Hak Suaranya dalam pemilihan Penatua Tahap 1. ";
                $ls_belum_milih[]=$value->kwg_id;
                $lsnama_belum_milih[$value->kwg_id]=$value->kwg_nama;   
            }
        }


        //get notification
        $device_id=$this->m_model->select('users_jemaat');
        $device_id2=$this->m_model->select('device_users');
        $ls_device_id=array();
        $ls_device_id_all=array();

        foreach ($device_id as $key => $value) {
            // code...
            if($value->device_id=='cmh5k2g6QGirxAby4fFYN2:APA91bHC3XHufIb7Tk63TO40gZDxCdTvjNNY1jkBnFEwnkLbaTimnBS_yD4Dgw3_JwAMr7g8h_B1mYR_Fk1cQG64xkE16ifVJx54khDUy968DI94fsONWlBCU8Q4FyV9VT6lc5sYJhbw'){
                if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                    //die("asdas1");
                }
                //die("asdas");

            } 

            if(in_array($value->keluarga_jemaat_id, $ls_belum_milih)){
                if(!in_array($value->device_id, $ls_device_id_all) && $value->device_id!=''){
                    $ls_device_id[$value->keluarga_jemaat_id][]=$value->device_id;
                    $ls_device_id_all[]=$value->device_id;
                }
            }
        }

        foreach ($device_id2 as $key => $value) {
            // code...

            if($value->device_id=='cmh5k2g6QGirxAby4fFYN2:APA91bHC3XHufIb7Tk63TO40gZDxCdTvjNNY1jkBnFEwnkLbaTimnBS_yD4Dgw3_JwAMr7g8h_B1mYR_Fk1cQG64xkE16ifVJx54khDUy968DI94fsONWlBCU8Q4FyV9VT6lc5sYJhbw'){
                if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                    //die("asdas2");
                }
                //die("asdas3");

            }
            if(in_array($value->keluarga_jemaat_id, $ls_belum_milih)){
                if(!in_array($value->device_id, $ls_device_id_all)  && $value->device_id!=''){
                    $ls_device_id[$value->keluarga_jemaat_id][]=$value->device_id;
                    $ls_device_id_all[]=$value->device_id;
                }
            }
        }
        //print_r($ls_device_id); echo count($ls_device_id); die();

        //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE');
        
        foreach ($ls_device_id as $key => $value) {
            // code...
            $token = $value; 
           // $token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE');
            //print_r($token);
            //die();

            //$title = "🔔Wilujeng Dinten Ahad - GKP Kp.Sawah😇";
            //$title = "🔔Sampurasun Kel. ". $lsnama_belum_milih[$key]." - GKP Kp.Sawah😇";
            $title = "🔔Sampurasun Anggota Jemaat - GKP Kp.Sawah😇";
            //$message = $lsmsg[$key]." Tinggal ".$Hday." Hari lagi akan Ditutup loh.";
            //$message = $lsmsg[$key]." Tinggal ".$Hhour." Jam  ".$Hminute." Menit  lagi akan Ditutup loh.";
            $message = $lsmsg[$key]." Tinggal ".$Hminute." Menit  lagi akan Ditutup loh.";
            //echo($title);
            //echo($message);die();



            $this->load->library('fcm');

            $this->fcm->setTitle($title);

            $this->fcm->setMessage($message);
            //$this->fcm->setLink($link);



            /**

             * set to true if the notificaton is used to invoke a function

             * in the background

             */

            $this->fcm->setIsBackground(true);



            /**

             * payload is userd to send additional data in the notification

             * This is purticularly useful for invoking functions in background

             * -----------------------------------------------------------------

             * set payload as null if no custom data is passing in the notification

             */

            $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

            $payload = array();

            $this->fcm->setPayload($payload);



            /**

             * Send images in the notification

             */

            //$this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/poster-mobile-pnt-01_compressed.jpg');

            $this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



            /**

             * Get the compiled notification data as an array

             */

            $json = $this->fcm->getPush();

            //print_r($json);

            $p = $this->fcm->send($token, $json);



           // print_r($p);
            //die();
        }

    }



    /**

     * Send to multiple devices

     */

    public function sendToMultiple()

    {

        $token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE'); // array of push tokens

        $message = "Test notification message";



        $this->load->library('fcm');

        $this->fcm->setTitle('Test FCM Notification');

        $this->fcm->setMessage($message);

        $this->fcm->setIsBackground(false);

        // set payload as null

        $payload = array('notification' => '');

        $this->fcm->setPayload($payload);

        $this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp_compressed.png');

        $json = $this->fcm->getPush();



        /** 

         * Send to multiple

         * 

         * @param array  $token     array of firebase registration ids (push tokens)

         * @param array  $json      return data from getPush() method

         */

        $result = $this->fcm->sendMultiple($token, $json);

        print_r($json);

        print_r($result);

    }



    function info(){

        echo phpinfo();

    }


    public function sendNotification_pnt1_tutup()
    {

        //get notification
        $device_id=$this->m_model->select('users_jemaat');
        $device_id2=$this->m_model->select('device_users');
        $ls_device_id=array();

        foreach ($device_id as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id) && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }

        foreach ($device_id2 as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }
        $token = $ls_device_id;
        //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE'); // push token

        //, 'cZE8m7MuQW-jNDAXFJRymR:APA91bFb1ZqI8MogkKiIlq6WAlwnhU6-nLYapN3jmkD6_b6cUn64LQ0gRvS31JolcJzbWJ5IuCY79blux5zLGg4RnWOCrTcS3sBo8a7ugACw77JomcDmEvxlQlB4RMMDjZsqZ0SR7xiw' //william

        $title = "🔔Sampurasun AngJem GKP Kp Sawah😇";
        $message = "Pemilu Online-Penatua Tahap 1 sudah ditutup.";



        $this->load->library('fcm');

        $this->fcm->setTitle($title);

        $this->fcm->setMessage($message);



        /**

         * set to true if the notificaton is used to invoke a function

         * in the background

         */

        $this->fcm->setIsBackground(true);



        /**

         * payload is userd to send additional data in the notification

         * This is purticularly useful for invoking functions in background

         * -----------------------------------------------------------------

         * set payload as null if no custom data is passing in the notification

         */

        $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

        $payload = array();

        $this->fcm->setPayload($payload);



        /**

         * Send images in the notification

         */

        $this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/poster-mobile-pnt-01_compressed.jpg');
        //$this->fcm->setImage('https://dev.sisfo-gkpkampungsawah.com/assets/images/poster-mobile-ppj-01_compressed-xs.jpg');

        $this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



        /**

         * Get the compiled notification data as an array

         */

        $json = $this->fcm->getPush();

        //print_r($json);

        $p = $this->fcm->send($token, $json);



        print_r($p);
        //die();

    }

    public function sendNotification_pnt1_thanks()
    {

        //get notification
        $device_id=$this->m_model->select('users_jemaat');
        $device_id2=$this->m_model->select('device_users');
        $ls_device_id=array();

        foreach ($device_id as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id) && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }

        foreach ($device_id2 as $key => $value) {
            // code...
            if(!in_array($value->device_id, $ls_device_id)  && $value->device_id!=''){
                $ls_device_id[]=$value->device_id;
            }
        }
        $token = $ls_device_id;
        //$token = array('cvouvImzTwWq-FPp38ZGRp:APA91bGQavziaUAl5kAbKTPIf-RPSTVQVgHkD5r5NeVNabIMwRnVyA1Ida7f13hiHDR2dK7DFe_z_7l9VNxSenDQ9TU-dq7G66UfRW7qj63B3t1Y0N5oSwq6WXiLglfG4GaBNwnQd5WE'); // push token

        //, 'cZE8m7MuQW-jNDAXFJRymR:APA91bFb1ZqI8MogkKiIlq6WAlwnhU6-nLYapN3jmkD6_b6cUn64LQ0gRvS31JolcJzbWJ5IuCY79blux5zLGg4RnWOCrTcS3sBo8a7ugACw77JomcDmEvxlQlB4RMMDjZsqZ0SR7xiw' //william

        $title = "🔔Sampurasun AngJem GKP Kp Sawah😇";
        //$message = "Terimakasih atas partisipasinya dalam proses pemilihan Penatua Tahap 1 ini. Kami barharap partisipasinya kembali dalam Pemilihan Penatua Tahap 2.\nTuhan Yesus Memberkati 😇";
        $message = "Hasil Pemilihan Penatua Tahap 1 sudah keluar dan dapat dilihat pada Aplikasi GKP Kp. Sawah.\nTuhan Yesus Memberkati 😇";



        $this->load->library('fcm');

        $this->fcm->setTitle($title);

        $this->fcm->setMessage($message);



        /**

         * set to true if the notificaton is used to invoke a function

         * in the background

         */

        $this->fcm->setIsBackground(true);



        /**

         * payload is userd to send additional data in the notification

         * This is purticularly useful for invoking functions in background

         * -----------------------------------------------------------------

         * set payload as null if no custom data is passing in the notification

         */

        $notification= array('title' => 'GKP Kampung Sawah ','body' => $message,'sound' => 'default', 'click_action'=>'');

        $payload = array();

        $this->fcm->setPayload($payload);



        /**

         * Send images in the notification

         */

        //$this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/poster-mobile-pnt-01_compressed.jpg');
        //$this->fcm->setImage('https://dev.sisfo-gkpkampungsawah.com/assets/images/poster-mobile-ppj-01_compressed-xs.jpg');

        //$this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');



        /**

         * Get the compiled notification data as an array

         */

        $json = $this->fcm->getPush();

        //print_r($json);

        $p = $this->fcm->send($token, $json);



        //print_r($p);
        //die();

    }

}

