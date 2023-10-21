<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class kebaktian extends CI_Controller {




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




	public function kebaktian_gereja(){

		$data=array();

				if($this->input->post('Add_kebaktian')){

			

			$param=array(

						"tgl_kebaktian"=>$this->input->post('tgl_kbt'),

						"jam_kebaktian"=>$this->input->post('jns_ibadah'),

						"pria_kebaktian"=>$this->input->post('jml_pria'),

						"wanita_kebaktian"=>$this->input->post('jml_wanita'),

						"ket_kebaktian"=>$this->input->post('ket_kebaktian'), //keluarga baru bukan dari migrasi data lama

					);

			$insert_id=$this->m_model->insertgetid($param, 'kebaktian');


			$where='';

        	$order_by='ASC';

        	$field_order='order by A.tgl_kebaktian';

      		$param_active='?';

			$numLimit=5;

	        $numStart=0;

	        $query_data="select * from kebaktian A";
	        
	        $where.="where A.tgl_kebaktian != '' ";

	        //dicomment supaya keluarga yang sudah tidak aktif tapi belum di delete tetap muncul sehingga admin bisa mengetahui jejak record keluarga tersebut


    
	        if(!$this->input->get('page')){

	            $page=1;

	            $numStart=($numLimit*$page)-$numLimit;
	        	$data['numStart']=$numStart;

	        }

	        else{

	            $page=$this->input->get('page');

	            $numStart=($numLimit*$page)-$numLimit;
	        	$data['numStart']=$numStart;

	        }

	        if(!$this->input->get('page')){

	            $page_active=1;

	        }else{

	            $page_active=$this->input->get('page');

	        }



	        $data['page']=$page;

	        $limit='LIMIT '.$numStart.', '.$numLimit;



			$data['TotalOfProduct']=TotalOfProduct($query_data." ".$where." ".$field_order." ".$order_by);

			$data['pagingnation']=pagingnation($data['TotalOfProduct'], $numLimit, $page_active, $param_active, $links=2);

			$data['datakebaktian']=$this->m_model->selectcustom($query_data." ".$where." ".$field_order." ".$order_by." ".$limit);


			$datacountkebaktian =$this->m_model->selectcustom($query_data." ".$where." ".$field_order." ".$order_by." ".$limit); 
			$data['TotalOfData']=count($datacountkebaktian);
			//$data['dataKK']=$this->m_model->selectas('status', 1, 'keluarga_jemaat', 'kwg_nama', 'ASC');

			//setelah insert update no KWG karen baru dapetin urutan dari id insert di database
		}else if($this->input->get('editKebaktian')){

				$data['type']='editKebaktian';
				

				$data['KebaktianId']=$this->input->get('id');
			

				

				$this->load->view('kebaktian/modalKebaktian', $data);

			return;


		}else if($this->input->post('saveEditKebaktian')){

			
		

			$param=array(
						

						"tgl_kebaktian"=>$this->input->post('tgl_kbt'),

						"jam_kebaktian"=>$this->input->post('jns_ibadah'),

						"pria_kebaktian"=>$this->input->post('jml_pria'),

						"wanita_kebaktian"=>$this->input->post('jml_wanita'),

						"ket_kebaktian"=>$this->input->post('ket_kebaktian'),

					);

			

			$updateAnggotaJemaat=$this->m_model->updateas('id', $id, $param, 'kebaktian');

			redirect($_SERVER['HTTP_REFERER']);

			

		}

			else  {



			$where='';

        	$order_by='ASC';

        	$field_order='order by A.tgl_kebaktian';

      		$param_active='?';

			$numLimit=5;

	        $numStart=0;

	        $query_data="select * from kebaktian A";
	        
	        $where.="where A.tgl_kebaktian != '' ";

	        //dicomment supaya keluarga yang sudah tidak aktif tapi belum di delete tetap muncul sehingga admin bisa mengetahui jejak record keluarga tersebut


    
	        if(!$this->input->get('page')){

	            $page=1;

	            $numStart=($numLimit*$page)-$numLimit;
	        	$data['numStart']=$numStart;

	        }

	        else{

	            $page=$this->input->get('page');

	            $numStart=($numLimit*$page)-$numLimit;
	        	$data['numStart']=$numStart;

	        }

	        if(!$this->input->get('page')){

	            $page_active=1;

	        }else{

	            $page_active=$this->input->get('page');

	        }



	        $data['page']=$page;

	        $limit='LIMIT '.$numStart.', '.$numLimit;



			$data['TotalOfProduct']=TotalOfProduct($query_data." ".$where." ".$field_order." ".$order_by);

			$data['pagingnation']=pagingnation($data['TotalOfProduct'], $numLimit, $page_active, $param_active, $links=2);

			$data['datakebaktian']=$this->m_model->selectcustom($query_data." ".$where." ".$field_order." ".$order_by." ".$limit);


			$datacountkebaktian =$this->m_model->selectcustom($query_data." ".$where." ".$field_order." ".$order_by." ".$limit); 
			$data['TotalOfData']=count($datacountkebaktian);
			//$data['dataKK']=$this->m_model->selectas('status', 1, 'keluarga_jemaat', 'kwg_nama', 'ASC');

	}
			

			
			$this->load->view('kebaktian/kebaktian_gereja',$data);

	}

}

