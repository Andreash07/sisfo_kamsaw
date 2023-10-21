<?php



defined('BASEPATH') or exit('No direct script access allowed');







class appnotification extends CI_Controller



{







    public function  __construct()



    {



        parent::__construct();


    }







    public function index()



    {







        $this->load->view('includes/newHeader');



        $this->load->view('other/notification');



        $this->load->view('includes/footer');



    }







    public function send()



    {











        $topic = $this->input->post('topic');



        $title = $this->input->post('title');



        $message = $this->input->post('message');



        $this->notif->send_notif($title, $message, $topic);



        $this->session->set_flashdata('send', 'Notification Has Been Send');



        redirect('other/notification');



    }



    public function sendNotification()



    {



        $token = array('fdxNjem8R_ieVmyEp7VPV_:APA91bH2Ekforfe9JW9d90fShcBHY3Adtbd0pUMxpDvie1oZjhfKn-2VsR9fxG2c55inHnjtcK0rAZRXvdO3A_BxD-8x6ALESiLx4gFvKXe3dAFx6c-fohwOE8qykkGzDJF1MDcYf8QA'); // push token



        $message = "Test notification message CI";







        $this->load->library('fcm_ash');



        $this->fcm_ash->setTitle('Test FCM Notification');



        $this->fcm_ash->setMessage($message);







        /**



         * set to true if the notificaton is used to invoke a function



         * in the background



         */



        $this->fcm_ash->setIsBackground(true);







        /**



         * payload is userd to send additional data in the notification



         * This is purticularly useful for invoking functions in background



         * -----------------------------------------------------------------



         * set payload as null if no custom data is passing in the notification



         */



        $notification= array('title' => 'Homvis Noftif ','body' => $message,'sound' => 'default', 'click_action'=>'');



        $payload = array();



        $this->fcm_ash->setPayload($payload);







        /**



         * Send images in the notification



         */



        //$this->fcm->setImage('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp_compressed.png');



        //$this->fcm->setIcon('https://sisfo-gkpkampungsawah.com/assets/images/logo-gkp-36.png');







        /**



         * Get the compiled notification data as an array



         */



        $json = $this->fcm_ash->getPush();



        //print_r($json);



        $p = $this->fcm_ash->send($token, $json);







        print_r($p);



    }



}



