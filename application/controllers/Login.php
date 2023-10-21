<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends CI_Controller {



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

		//die("asdasd");

    	date_default_timezone_set('Asia/Jakarta');

        parent::__construct();



        //$this->keyHash="#17aosipas25jkladwikj96#Asthajkasld"; //ini keyhash untuk login sebagai ID Pengguna
        $this->keyHash="#17ashdkj25ahsdkja96#Asthaaksjdha"; //ini keyhash untuk login sebagai ID Pengguna sama seperti token login QrCode

    }



    public function index(){

    	$data=array();

    	$param=array();

    	if($this->input->post('btn_login')){

    		$username=$this->input->post('Username');

    		$password=md5($this->input->post('Password'));

    		$check=$this->m_model->selectas2('username', $username, 'password', $password, 'ags_users');

            //return $check;
            //exit();

    		if(count($check)==1){

    			$data['status_login']='success';

    			$data['userdata']=$check[0];

    		}

    		else{

    			$data['status_login']='failed';

    		}

			$this->session->set_userdata($data);

			header('Location:'.base_url().'home/');

    	}

    	else if($this->session->userdata('userdata')){

			header('Location:'.base_url().'home/');

    	}

    	else{

    		$this->load->view('login/index');

    	}

    }



    public function keluarga(){

        $this->load->view('login/keluarga');

    }





    public function auth_user_keluarga($token=null){

        //jika $token tidak null bearti itu login dari APK dengan ID Pengguna

        if($token!=null){

            //$this->keyHash

            $sql="select A.*

                    from keluarga_jemaat A 

                    where MD5(CONCAT(A.id,'".$this->keyHash."')) = '".clearText($token)."' ";

            $check_token=$this->m_model->selectcustom($sql);

            if(count($check_token)>0){

                $data['sess_token']=$token;

                $data['sess_token_valid']=1;

                $data['sess_keluarga']=$check_token[0];

                $data['sess_nama_user']=$check_token[0]->kwg_nama;

                $data['sess_id_user']=$check_token[0]->id;

                $data['sess_num_login']=$check_token[0]->num_login;

                

                $supdate_numLogin="update keluarga_jemaat set num_login=num_login+1 where id='".$data['sess_id_user']."'";

                $this->m_model->querycustom($supdate_numLogin);



                $this->session->set_userdata($data);



                redirect(base_url()."beranda");

            }

            else{

                die("Access Denied, Token Login Invalid!");

            }

        }

        else{

            $username=$this->input->post('username');

            $password=$this->input->post('password'); // ini sudah di md5 dari apk/apps nya



            //$check_token=$this->m_model->selectas2('username', , 'password', md5($password), 'users_jemaat' );

            $sql="select B.*

                    from keluarga_jemaat B 

                    join users_jemaat A on A.keluarga_jemaat_id = B.id

                    where A.username ='".clearText($username)."' && A.password ='".md5($password)."'";

            $check_token=$this->m_model->selectcustom($sql);



            if(count($check_token)>0){

                $token=MD5($check_token[0]->id.$this->keyHash);

                $data['sess_token']=$token;

                $data['sess_token_valid']=1;

                $data['sess_keluarga']=$check_token[0];

                $data['sess_nama_user']=$check_token[0]->kwg_nama;

                $data['sess_id_user']=$check_token[0]->id;

                $data['sess_num_login']=$check_token[0]->num_login;

                

                $supdate_numLogin="update keluarga_jemaat set num_login=num_login+1 where id='".$data['sess_id_user']."'";

                $this->m_model->querycustom($supdate_numLogin);

                $this->session->set_userdata($data);



                redirect(base_url()."beranda");

            }

            else{

                $token=MD5('0'.$this->keyHash);

                $data['sess_token']=$token;

                $data['sess_token_valid']=-1;

                $data['sess_keluarga']=false;   

                $data['sess_nama_user']=false;

                $data['sess_id_user']=false;

                $data['sess_num_login']=false;

                $this->session->set_userdata($data);



                redirect(base_url()."login/keluarga");

            }



        }



    }

    public function authAPI_user_keluarga(){
        header('Content-Type: application/json');

        $data=array();

        $username=$this->input->post('username');

        $password=md5($this->input->post('password'));



        $check=$this->m_model->selectas2('username', clearText($username), 'password', clearText($password), 'users_jemaat' );

        if(count($check)>0){

            $kwg_id=$check[0]->keluarga_jemaat_id;

            $data['status']=1; //success

            $data['msg']="Proses Login Berhasil!"; //success

            $data['url']=base_url()."login/auth_user_keluarga/".md5($kwg_id.$this->keyHash); //success

        }

        else{

            $data['status']=0; //failed

            $data['msg']="Maaf, Proses Login Gagal! (ID Penggunan dan Kata Sandi tidak cocok)"; //failed

            $data['url']=NULL; //success

        }

        echo json_encode($data, JSON_PRETTY_PRINT);

    }

}

