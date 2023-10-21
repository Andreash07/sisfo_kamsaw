<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Qrcode extends CI_Controller {



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

	public function scan()

	{

		if(!$this->uri->segment(3)){

			die('Token null, Access Denied!');

		}



		$data=array();

		//check qrcode

		$token=$this->uri->segment(3);


		//die(print_r($this->input->get()));
		$check_token=$this->m_model->selectas2("MD5(CONCAT(id,'#17ashdkj25ahsdkja96#Asthaaksjdha')) like '".clearText($token)."' ", null, "status", 1, 'keluarga_jemaat');

		if(count($check_token)==1){

			//ini qrcode valid

			$data['sess_token']=$token;

			$data['sess_token_valid']=1;

			$data['sess_keluarga']=$check_token[0];

			$data['sess_nama_user']=$check_token[0]->kwg_nama;

			$data['sess_id_user']=$check_token[0]->id;

			$data['sess_num_login']=$check_token[0]->num_login;



			//check sudah mempunya username dan password login belum

			//atau baru login dengan barcode saja

			$checkUsers=$this->m_model->selectas2('keluarga_jemaat_id', $check_token[0]->id, 'status', 1, 'users_jemaat');

			if(count($checkUsers)==0){

				//ini bearti belum pernah login buatkan username password secara otomatis



				//ambil index pertama untuk sebagai username dan password default

				$arr_Kwg_nama=explode(' ', $check_token[0]->kwg_nama);

				$username=strtolower($arr_Kwg_nama[0].rand(1000,10000)); //angka random 4 digit

				$users_jemaat=array();

				$users_jemaat['username']=$username;

				$users_jemaat['password']=md5($username);

				$users_jemaat['status']=1; 

				$users_jemaat['created_by']=1; //ini bearti dari barcode

				$users_jemaat['created_at']=date('Y-m-d H:i:s'); 

				$users_jemaat['keluarga_jemaat_id']=$check_token[0]->id;
				$users_jemaat['device_id']=$this->input->get('device_id');

				//input ke users_jemaat

				$createUsers_jemaat=$this->m_model->insertgetid($users_jemaat, 'users_jemaat');

			}

			else{

				$users_jemaat['username']=$checkUsers[0]->username;

			}



			$data['sess_username']=$users_jemaat['username'];

			//$data['sess_password']=$password;

			



			$supdate_numLogin="update keluarga_jemaat set num_login=num_login+1 where id='".$data['sess_id_user']."'";

			$this->m_model->querycustom($supdate_numLogin);

		}

		else{

			$data['sess_token']=$token;

			$data['sess_token_valid']=0;

			$data['sess_keluarga']=false;	

			$data['sess_nama_user']=false;

			$data['sess_id_user']=false;

			$data['sess_num_login']=false;

		}



		$this->session->set_userdata($data);

		/*if($data['sess_token_valid']==1){

			redirect(base_url().'beranda', 'location', 301);

		}*/

		//print_r($check_token);



		$this->load->view('frontend/notification/qrcodelogin', $data);

	}

}

?>