<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Admin extends CI_Controller {



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

        if(count($this->session->userdata('userdata')) == 0 || !isset($this->session->userdata('userdata')->id) ){
        	redirect(base_url());
        }


    }

	public function DataJemaat()

	{

		$data=array();

		if($this->input->post('add')){

			$kwg_wil=$this->input->post('wilayah');

			$param=array(

						"kwg_nama"=>$this->input->post('nama_kk'),

						"kwg_alamat"=>$this->input->post('alamat'),

						"kwg_telepon"=>$this->input->post('telepon'),

						"kwg_wil"=>$this->input->post('wilayah'),

						"status_migration"=>2, //keluarga baru bukan dari migrasi data lama

					);

			$insert_id=$this->m_model->insertgetid($param, 'keluarga_jemaat');

			//setelah insert update no KWG karen baru dapetin urutan dari id insert di database



			$param2=array(

						'kwg_no'=>$kwg_wil.date('dmy').sprintf("%03d", $insert_id),

						'last_modified'=>'0000-00-00 00:00:00',

						'kwg_no_old' =>0

					);

			$this->m_model->updateas('id', $insert_id, $param2, 'keluarga_jemaat');

			redirect(base_url().'admin/'.$this->uri->segment(2).'?edit=true&id='.$insert_id);

			//die();

		}

		else if($this->input->get('addAnggota')){

				$data['type']='addAnggota';

				$data['kwg_no']=$this->input->get('kwg_no');

				$this->load->view('admin/modalDataJemaat', $data);

			return;

		}

		else if($this->input->post('SaveEditKeluarga')){

			$param=array(

						"kwg_nama"=>$this->input->post('kwg_nama'),

						"kwg_alamat"=>$this->input->post('kwg_alamat'),

						"kwg_telepon"=>$this->input->post('kwg_telepon'),

						"kwg_wil"=>$this->input->post('kwg_wil'),

						"user_modified "=>$this->session->userdata('userdata')->username,

					);

			$update=$this->m_model->updateas('id', $this->input->post('keluarga_jemaat_id'), $param, 'keluarga_jemaat');

			redirect(base_url().'admin/'.$this->uri->segment(2).'?edit=true&id='.$this->input->post('keluarga_jemaat_id'));

			//die();

		}

		else if($this->input->get('editAnggota')){

				$data['type']='editAnggota';

				$data['AnggotaId']=$this->input->get('id');

				$this->load->view('admin/modalDataJemaat', $data);

			return;

		}

		else if($this->input->get('viewAnggota')){

				$data['type']='viewAnggota';

				$data['AnggotaId']=$this->input->get('id');

				$this->load->view('admin/modalDataJemaat', $data);

			return;

		}

		else if($this->input->post('SaveEditAnggota')){

			$param['lampiran_baptis']=0;

			$param['lampiran_sidi']=0;

			$param['lampiran_ktp']=0;

			$param['lampiran_kk']=0;

			$param['lampiran_nikah']=0;

			$param['user_modified_dorkas']=$this->session->userdata('userdata')->username;

			$param['last_modified_dorkas']=date('Y-m-d H:i:s');

			foreach ($this->input->post() as $key => $value) {

				# code...

				if($key!='migrasi_anggota' && $key!='ags_kwg_detail_id' && $key!='profesi' && $key!='hoby'&& $key!='profesi_new' && $key!='talenta_new' && $key!='SaveEditAnggota'){

					if($key!='pndk_akhir_new' && $key!='pndk_akhir' && $key!='tgl_lahir' && $key!='tgl_baptis'&& $key!='tgl_sidi' && $key!='tgl_nikah' && $key!='tgl_daftar' && $key!='tgl_keluar'&& $key!='tgl_meninggal' && $key!='tgl_attestasi_masuk'){

						$param[$key]=$value;

					}

					else if($key=='pndk_akhir_new'){

						if($value!=null){

							$param['pndk_akhir']=$value;

						}

					}

					else if($key=='pndk_akhir'){

						if($value!=null){

							$param['pndk_akhir']=$value;

						}	

					}

					else if($key=='tgl_lahir' || $key=='tgl_baptis' || $key=='tgl_sidi'|| $key=='tgl_nikah' || $key=='tgl_daftar' || $key=='tgl_keluar'|| $key=='tgl_meninggal' || $key=='tgl_attestasi_masuk'){

						$param[$key]=convert_time_ymd($value);

						$date_raw[$key]=$value;

					}

				}

				else{

					$id_anggota=$this->input->post('ags_kwg_detail_id');

				}

			}

			$updateAnggotaJemaat=$this->m_model->updateas('id', $id_anggota, $param, 'anggota_jemaat');

			redirect($_SERVER['HTTP_REFERER']);

		}

		else if($this->input->post('SaveAddAnggota')){

			$id=$this->input->get('id');

			$keluarga_jemaat_id=$id;

			$param=array();

			foreach ($this->input->post() as $key => $value) {

				# code...

				if($key!='SaveAddAnggota' && $key!='ags_kwg_detail_id' && $key!='profesi' && $key!='hoby'&& $key!='profesi_new' && $key!='talenta_new'){

					if($key!='pndk_akhir_new' && $key!='pndk_akhir' && $key!='tgl_lahir' && $key!='tgl_baptis'&& $key!='tgl_sidi' && $key!='tgl_nikah' && $key!='tgl_daftar' && $key!='tgl_keluar'&& $key!='tgl_meninggal' && $key!='tgl_attestasi_masuk'){

						$param[$key]= strtoupper($value);

					}

					else if($key=='pndk_akhir_new'){

						if($value!=null){

							$param['pndk_akhir']=ucfirst(strtolower($value));

						}

					}

					else if($key=='pndk_akhir'){

						if($value!=null){

							$param['pndk_akhir']=ucfirst(strtolower($value));

						}	

					}

					else if($key=='tgl_lahir' || $key=='tgl_baptis' || $key=='tgl_sidi'|| $key=='tgl_nikah' || $key=='tgl_daftar' || $key=='tgl_keluar'|| $key=='tgl_meninggal' || $key=='tgl_attestasi_masuk'){

						$param[$key]=convert_time_ymd($value);

						$date_raw[$key]=$value;

					}

				}

			}

			$param['status_migration']=0;

			$param['created_user']=$this->session->userdata('userdata')->username;

			$anggota_jemaat_id=$this->m_model->insertgetid($param, 'anggota_jemaat');

			//get keluarga jemaat yang related dengan paramter get('id')  pada anggota jemaat

			$keluargaJemaat=$this->m_model->selectas('id', $id, 'keluarga_jemaat');

			//get detail anggota keluar dalam keluarga terkait

			$AnggotakeluargaJemaat=$this->m_model->selectas2('kwg_no', $id, 'status', 1, 'anggota_jemaat');

			$numAnggotaKeluarga=count($AnggotakeluargaJemaat);

			if(count($keluargaJemaat)>0){

				$keluarga_jemaat_id=$keluargaJemaat[0]->id;

				$kwg_no_old=$keluargaJemaat[0]->kwg_no_old;

				$partofnokk=substr($keluargaJemaat[0]->kwg_no, 4);

			}

			else{

				$kwg_no_old='0';

				$keluarga_jemaat_id='0';

				$partofnokk='000000';

			}

			//update untuk nomor anggota jemaat yang baru

			$no_urut=$numAnggotaKeluarga+1; //selalu ditambah 1

			$param2=array(

						'no_urut'=>$no_urut, 

						'kwg_no'=>$keluarga_jemaat_id,

						'no_anggota'=>$param['kwg_wil'].$partofnokk.convert_time_ddmmyy($date_raw['tgl_lahir']).sprintf("%02d", $no_urut),

						'last_modified'=>'0000-00-00 00:00:00',

					);



			//update untuk no_anggota dan no_kwg menjadi id keluarga_jemaat untuk penghubung ke table keluarga jemaat

			$this->m_model->updateas('id', $anggota_jemaat_id, $param2, 'anggota_jemaat');



			//update status migration anggota keluarga di table lama

			$this->m_model->updateas('id', $this->input->post('ags_kwg_detail_id'), array('status_migration'=>'1'), 'ags_kwg_detail_table');

			$sql1="UPDATE keluarga_jemaat SET num_anggota=num_anggota+1 where kwg_no='".$keluarga_jemaat_id."'";

			$this->m_model->querycustom($sql1);



			if($this->input->post('profesi_new')!=null){

				$this->createNewProfesi($anggota_jemaat_id, $this->input->post('profesi_new'));

			}

			if($this->input->post('talenta_new')!=null){

				$this->createNewHoby($anggota_jemaat_id, $this->input->post('talenta_new'));

			}

			// input profesi dan hoby

			$this->insertHoby($anggota_jemaat_id, $this->input->post('hoby'));

			$this->insertProfesi($anggota_jemaat_id, $this->input->post('profesi'));

			redirect(base_url().'admin/'.$this->uri->segment(2).'?edit=true&id='.$id);

		}

		else if($this->input->get('delete') && $this->input->get('kode') == md5(base64_encode($this->input->get('id').'delete'))){

			$param=array(

						"delete_user"	=> $this->session->userdata('userdata')->username,

						"status"		=> 0

					);

			//ini hanya soft delete, ditambahkan delete_user agar tidak kebaca saat di view

			$deleteSoft=$this->m_model->updateas('id', $this->input->get('id'), $param, 'keluarga_jemaat');

			if($deleteSoft){

				//jika berhasil maka anggota keluarga juda di soft delete
				$param['sts_anggota']=0;
				$param['last_modified_dorkas']=date('Y-m-d H:i:s');
				$param['last_modified']=date('Y-m-d H:i:s');
				$param['user_modified']=$this->session->userdata('userdata')->username;
				$deleteSoftAnggota=$this->m_model->updateas('kwg_no', $this->input->get('id'), $param, 'anggota_jemaat');

				$this->session->set_userdata(array('status_remove'=>'berhasil'));

			}

			else{

				$this->session->set_userdata(array('status_remove'=>'gagal'));

			}

			redirect(base_url().'admin/'.$this->uri->segment(2));

		}

		else if($this->input->get('deleteanggota') && $this->input->get('kode') == md5(base64_encode($this->input->get('id').'delete'))){

			$param=array(

						"delete_user"	=> $this->session->userdata('userdata')->username,

						"status"		=> 0

					);

			//ini hanya soft delete, ditambahkan delete_user agar terdetek siapa yang telah mendelete

			$deleteSoft=$this->m_model->updateas('id', $this->input->get('id'), $param, 'anggota_jemaat');

			if($deleteSoft){

				$this->session->set_userdata(array('status_remove'=>'berhasil'));

			}

			else{

				$this->session->set_userdata(array('status_remove'=>'gagal'));

			}

			//redirect(base_url().'admin/'.$this->uri->segment(2));

			redirect($_SERVER['HTTP_REFERER']);

		}

		else if($this->input->get('editHobyProfesi')=='true'){

			if (!$this->input->is_ajax_request()) {

				die('No direct script access allowed');

			}

			$data['AnggotaId']=$this->input->get('id');

			$this->load->view('admin/modal_hoby-profesi', $data);

			return;

		}

		else{

			$where='';

        	$order_by='ASC';

        	$field_order='order by A.kwg_nama';

      		$param_active='?';

			$numLimit=30;

	        $numStart=0;

	        $query_data="select * from keluarga_jemaat A";
	        
	        #$where.="where (A.delete_user is NULL || A.delete_user = '') ";
	        $where.="where A.id>0 ";

	        //dicomment supaya keluarga yang sudah tidak aktif tapi belum di delete tetap muncul sehingga admin bisa mengetahui jejak record keluarga tersebut
            if($this->input->get('status')){
        		$kwg_status=$this->input->get('status');
            	if($this->input->get('status') == -1){
            		$kwg_status=0;
            	}
        		$where.=" && A.status=".clearText($kwg_status);
            }


	        //inisiasi untuk key

            if($this->input->get('kwg_nama')){

                $where.=" AND LOWER(A.kwg_nama) REGEXP '".strtolower($this->input->get('kwg_nama'))."'";

                $param_active.="kwg_nama=".$this->input->get('kwg_nama')."&";

            }

            if($this->input->get('wilayah')){

                $where.=" AND A.kwg_wil='".strtolower($this->input->get('wilayah'))."'";

                $param_active.="wilayah=".$this->input->get('wilayah')."&";

            }

            if($this->input->get('status')){
            	$status=$this->input->get('status');
            	if($this->input->get('status')==-1){
            		$status=0;
            	}
            	$where.=" AND A.status='".strtolower($status)."'";


                $param_active.="status=".$this->input->get('status')."&";

            }



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

			$data['dataKK']=$this->m_model->selectcustom($query_data." ".$where." ".$field_order." ".$order_by." ".$limit);

			//$data['dataKK']=$this->m_model->selectas('status', 1, 'keluarga_jemaat', 'kwg_nama', 'ASC');

		}

		$this->load->view('admin/data_jemaat', $data);

	}



	public function DataJemaatOld()

	{

		$data=array();

		if($this->input->post('add')){

			$param=array(

						"kwg_nama"=>$this->input->post('nama_kk'),

						"kwg_alamat"=>$this->input->post('alamat'),

						"kwg_telepon"=>$this->input->post('telepon'),

						"kwg_wil"=>$this->input->post('wilayah'),

					);

			$insert_id=$this->m_model->insertgetid($param, 'ags_kwg_table');

			redirect(base_url().'admin/'.$this->uri->segement(2).'?edit=true&id='.$insert_id);

			//die();

		}

		else if($this->input->post('edit')){

			$id=$this->input->get('id');

			$param=array(

						"kwg_nama"=>$this->input->post('nama_kk'),

						"kwg_alamat"=>$this->input->post('alamat'),

						"kwg_telepon"=>$this->input->post('telepon'),

						"kwg_wil"=>$this->input->post('wilayah'),

					);

			$this->m_model->updateas('id', $id, $param, 'ags_kwg_table');

			redirect(base_url().'admin/'.$this->uri->segment(2));

		}

		else if($this->input->post('migrasi_keluarga')){

			$id=$this->input->get('id'); //ini adalah kwg_no pada table ags_kwg_table

			$param=array();

			foreach ($this->input->post() as $key => $value) {

				# code...

				if($key!='migrasi_keluarga'){

					$param[$key]=$value;

				}

			}

			$param['status_migration']=1;

			$param['created_user']=$this->session->userdata('userdata')->username;

			$new_kwg_id=$this->m_model->insertgetid($param, 'keluarga_jemaat');

			$param2=array(

						'kwg_no'=>$param['kwg_wil'].date('dmy').sprintf("%03d", $new_kwg_id),

						'last_modified'=>'0000-00-00 00:00:00',

						'kwg_no_old' => $id

					);

			//update untuk kwg_no

			$this->m_model->updateas('id', $new_kwg_id, $param2, 'keluarga_jemaat');



			//update status migrasi keluarga pada table lama

			$this->m_model->updateas('kwg_no', $id, array('status_migration'=>1), 'ags_kwg_table');



			//update status migrasi anggota keluarga pada table lama untuk siap dimigrasi

			$this->m_model->updateas('kwg_no', $id, array('status_migration'=>2), 'ags_kwg_detail_table');

			redirect(base_url().'admin/'.$this->uri->segment(2).'?edit=true&id='.$id);

		}

		else if($this->input->post('migrasi_anggota')){

			$id=$this->input->get('id');

			$param=array();

			foreach ($this->input->post() as $key => $value) {

				# code...

				if($key!='migrasi_anggota' && $key!='ags_kwg_detail_id' && $key!='profesi' && $key!='hoby'&& $key!='profesi_new' && $key!='talenta_new'){

					if($key!='pndk_akhir_new' && $key!='pndk_akhir' && $key!='tgl_lahir' && $key!='tgl_baptis'&& $key!='tgl_sidi' && $key!='tgl_nikah' && $key!='tgl_daftar' && $key!='tgl_keluar'&& $key!='tgl_meninggal' && $key!='tgl_attestasi_masuk'){

						$param[$key]=$value;

					}

					else if($key=='pndk_akhir_new'){

						if($value!=null){

							$param['pndk_akhir']=$value;

						}

					}

					else if($key=='pndk_akhir'){

						if($value!=null){

							$param['pndk_akhir']=$value;

						}	

					}

					else if($key=='tgl_lahir' || $key=='tgl_baptis' || $key=='tgl_sidi'|| $key=='tgl_nikah' || $key=='tgl_daftar' || $key=='tgl_keluar'|| $key=='tgl_meninggal' || $key=='tgl_attestasi_masuk'){

						$param[$key]=convert_time_ymd($value);

						$date_raw[$key]=$value;

					}

				}

			}

			$param['status_migration']=1;

			$param['created_user']=$this->session->userdata('userdata')->username;

			$anggota_jemaat_id=$this->m_model->insertgetid($param, 'anggota_jemaat');

			//get keluarga jemaat yang related dengan kwg_no pada anggota jemaat

			$keluargaJemaat=$this->m_model->selectas2('kwg_no_old', $param['kwg_no'], 'status', 1, 'keluarga_jemaat');

			if(count($keluargaJemaat)>0){

				$keluarga_jemaat_id=$keluargaJemaat[0]->id;

				$kwg_no_old=$keluargaJemaat[0]->kwg_no_old;

				$partofnokk=substr($keluargaJemaat[0]->kwg_no, 4);

			}

			else{

				$kwg_no_old='0';

				$keluarga_jemaat_id='0';

				$partofnokk='000000';

			}

			//update untuk nomor anggota jemaat yang baru

			$param2=array(

						'kwg_no'=>$keluarga_jemaat_id,

						'no_anggota'=>$param['kwg_wil'].$partofnokk.convert_time_ddmmyy($date_raw['tgl_lahir']).sprintf("%02d", $param['no_urut']),

						'last_modified'=>'0000-00-00 00:00:00',

					);



			//update untuk no_anggota dan no_kwg menjadi id keluarga_jemaat untuk penghubung ke table keluarga jemaat

			$this->m_model->updateas('id', $anggota_jemaat_id, $param2, 'anggota_jemaat');



			//update status migration anggota keluarga di table lama

			$this->m_model->updateas('id', $this->input->post('ags_kwg_detail_id'), array('status_migration'=>'1'), 'ags_kwg_detail_table');

			$sql1="UPDATE keluarga_jemaat SET num_anggota=num_anggota+1 where kwg_no='".$param['kwg_no']."'";

			$this->m_model->querycustom($sql1);



			if($this->input->post('profesi_new')!=null){

				$this->createNewProfesi($anggota_jemaat_id, $this->input->post('profesi_new'));

			}

			if($this->input->post('talenta_new')!=null){

				$this->createNewHoby($anggota_jemaat_id, $this->input->post('talenta_new'));

			}

			// input profesi dan hoby

			$this->insertHoby($anggota_jemaat_id, $this->input->post('hoby'));

			$this->insertProfesi($anggota_jemaat_id, $this->input->post('profesi'));

			redirect(base_url().'admin/'.$this->uri->segment(2).'?edit=true&id='.$id);

		}

		else if($this->input->get('delete') && $this->input->get('kode') == md5(base64_encode($this->input->get('id').'delete'))){

			$param=array(

						"delete_user"	=> $this->session->userdata('userdata')->username,

						"status"		=> 0

					);

			//ini hanya soft delete, ditambahkan delete_user agar tidak kebaca saat di view

			$deleteSoft=$this->m_model->updateas('kwg_no', $this->input->get('id'), $param, 'ags_kwg_table');

			if($deleteSoft){

				//jika berhasil maka anggota keluarga juda di soft delete

				$deleteSoftAnggota=$this->m_model->updateas('kwg_no', $this->input->get('id'), $param, 'anggota_jemaat');

				$this->session->set_userdata(array('status_remove'=>'berhasil'));

			}

			else{

				$this->session->set_userdata(array('status_remove'=>'gagal'));

			}

			redirect(base_url().'admin/'.$this->uri->segment(2));

		}

		else if($this->input->get('addAnggota')){

			if($this->input->post('SaveAddAnggota')){



			}

			else{

				$data['type']='addAnggota';

				$this->load->view('admin/modalDataJemaatOld', $data);

			}

			return;

		}

		else if($this->input->get('editAnggota')){

			if($this->input->post('SaveEditAnggota')){



			}

			else{

				$data['type']='editAnggota';

				$data['AnggotaId']=$this->input->get('id');

				$this->load->view('admin/modalDataJemaatOld', $data);

			}

			return;

		}

		else{

			$where='';

        	$order_by='ASC';

        	$field_order='order by A.kwg_nama';

      		$param_active='?';

			$numLimit=30;

	        $numStart=0;

	        $query_data="select * from ags_kwg_table A";

	        //inisiasi untuk key

            if($this->input->get('kwg_nama')){

                $where.="where LOWER(A.kwg_nama) REGEXP '".strtolower($this->input->get('kwg_nama'))."'";

                $param_active.="kwg_nama=".$this->input->get('kwg_nama')."&";

            }

            if($this->input->get('wilayah')){

                $where.=" AND (A.kwg_wil) '".strtolower($this->input->get('wilayah'))."'";

                $param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";

            }

            if($this->input->get('status')){

                $where.=" AND (A.kwg_wil) '".strtolower($this->input->get('wilayah'))."'";

                $param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";

            }



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

			$data['dataKK']=$this->m_model->selectcustom($query_data." ".$where." ".$field_order." ".$order_by." ".$limit);

			//$data['dataKK']=$this->m_model->selectas('status', 1, 'ags_kwg_table', 'kwg_nama', 'ASC');

		}

		$this->load->view('admin/data_jemaatOld', $data);

	}



	public function insertHoby($anggota_jemaat_id=null, $hoby=null){

		if($anggota_jemaat_id==null || $hoby==null){

			return false;

		}

		foreach ($hoby as $key => $value) {

			# code...

			//$check=$this->m_model->selectas2('anggota_jemaat_id', $anggota_jemaat_id, 'hoby_id', $value, 'hoby_jemaat');

			//if()

			$this->m_model->create(array('anggota_jemaat_id'=> $anggota_jemaat_id, 'hoby_id'=>$value), 'hoby_jemaat');

		}

		return true;

	}



	public function insertProfesi($anggota_jemaat_id=null, $Profesi=null){

		if($anggota_jemaat_id==null || $Profesi==null){

			return false;

		}

		foreach ($Profesi as $key => $value) {

			# code...

			$this->m_model->create(array('anggota_jemaat_id'=> $anggota_jemaat_id, 'profesi_id'=>$value), 'profesi_jemaat');

		}

		return true;

	}



	public function createNewHoby($anggota_jemaat_id=null, $Hoby=null){

		if($anggota_jemaat_id==null || $Hoby==null){

			return false;

		}

		

		//check hoby bener belum atau sudah sebenarnya sudah ada

		$check=$this->m_model->selectas('LOWER(name)', strtolower($Hoby), 'hoby');

		if(count($check)){

			$hoby_id=$check[0]->id;

		}

		else{

			$param=array('name'=>$Hoby, 'user_created'=>$this->session->userdata('userdata')->username);

			$hoby_id=$this->m_model->insertgetid($param, 'hoby');

		}

		$this->m_model->create(array('anggota_jemaat_id'=> $anggota_jemaat_id, 'hoby_id'=>$hoby_id), 'hoby_jemaat');

		return true;

	}



	public function createNewProfesi($anggota_jemaat_id=null, $Profesi=null){

		if($anggota_jemaat_id==null || $Profesi==null){

			return false;

		}

		//check profesi bener belum atau sudah sebenarnya sudah ada

		$check=$this->m_model->selectas('LOWER(name)', strtolower($Profesi), 'profesi');

		if(count($check)){

			$profesi_id=$check[0]->id;

		}

		else{

			$param=array('name'=>$Profesi, 'user_created'=>$this->session->userdata('userdata')->username);

			$profesi_id=$this->m_model->insertgetid($param, 'profesi');

		}

		$this->m_model->create(array('anggota_jemaat_id'=> $anggota_jemaat_id, 'profesi_id'=>$profesi_id), 'profesi_jemaat');



		return true;

	}



	public function removeHoby(){

		if(!$this->input->get('anggota_jemaat') || !$this->input->get('hoby_id')){

			echo json_encode(array('status'=> 0));

			return;

		}

			$delet=$this->m_model->deleteas2('anggota_jemaat_id', $this->input->get('anggota_jemaat'), 'hoby_id', $this->input->get('hoby_id'), 'hoby_jemaat');

			if($delet==true){

				echo json_encode(array('status'=> 1));

			}

			else{

				echo json_encode(array('status'=> 0));

			}

		return;

	}



	public function removeProfesi(){

		if(!$this->input->get('anggota_jemaat') || !$this->input->get('profesi_id')){

			echo json_encode(array('status'=> 0));

			return;

		}

			$delet=$this->m_model->deleteas2('anggota_jemaat_id', $this->input->get('anggota_jemaat'), 'profesi_id', $this->input->get('profesi_id'), 'profesi_jemaat');

			if($delet==true){

				echo json_encode(array('status'=> 1));

			}

			else{

				echo json_encode(array('status'=> 0));

			}

		return;

	}





	public function addHoby(){

		if(!$this->input->get('anggota_jemaat') || !$this->input->get('hoby_id')){

			echo json_encode(array('status'=> 0));

			return;

		}

			//$delet=$this->m_model->deleteas2('anggota_jemaat_id', $this->input->get('anggota_jemaat'), 'hoby_id', $this->input->get('hoby_id'), 'hoby_jemaat');

			$add=$this->m_model->create(array('anggota_jemaat_id'=> $this->input->get('anggota_jemaat'), 'hoby_id'=> $this->input->get('hoby_id')), 'hoby_jemaat');

			if($add==true){

				echo json_encode(array('status'=> 1));

			}

			else{

				echo json_encode(array('status'=> 0));

			}

		return;

	}



	public function addProfesi(){

		if(!$this->input->get('anggota_jemaat') || !$this->input->get('profesi_id')){

			echo json_encode(array('status'=> 0));

			return;

		}

			//$delet=$this->m_model->deleteas2('anggota_jemaat_id', $this->input->get('anggota_jemaat'), 'profesi_id', $this->input->get('profesi_id'), 'profesi_jemaat');

			$add=$this->m_model->create(array('anggota_jemaat_id'=> $this->input->get('anggota_jemaat'), 'profesi_id'=> $this->input->get('profesi_id')), 'profesi_jemaat');

			if($add==true){

				echo json_encode(array('status'=> 1));

			}

			else{

				echo json_encode(array('status'=> 0));

			}

		return;

	}



	public function mutasi_keluarga($action=null){

		$data=array();

		if($action==null){

			$data['ls_wilayah']=$this->m_model->select('wilayah', 'wilayah', 'ASC');

			$this->load->view('admin/mutasi_jemaat/index', $data);

		}

		else if($action=='add'){

			//create keluarga baru dulu

			$kwg_wil=$this->input->post('wilayah');

			$param=array(

						"kwg_nama"=>$this->input->post('nama_kk'),

						"kwg_alamat"=>$this->input->post('alamat'),

						"kwg_telepon"=>$this->input->post('telepon'),

						"kwg_wil"=>$this->input->post('wilayah'),

						"status_migration"=>2, //keluarga baru bukan dari migrasi data lama

					);

			$insert_id=$this->m_model->insertgetid($param, 'keluarga_jemaat');

			//setelah insert update no KWG karen baru dapetin urutan dari id insert di database



			$param2=array(

						'kwg_no'=>$kwg_wil.date('dmy').sprintf("%03d", $insert_id),

						'last_modified'=>'0000-00-00 00:00:00',

						'kwg_no_old' =>0

					);

			$this->m_model->updateas('id', $insert_id, $param2, 'keluarga_jemaat');

			//the end of create keluarga baru dulu

			$ls_jemaat_id=$this->input->post('jemaat_id');

			$failed=0;

			$success=0;

			$no_urut=0;
			$id_kpkp_keluarga=0;
			$tot_saldoKPKP_new=0;

			foreach ( $ls_jemaat_id as $key => $value) {

				# code...

				$param=array();

				//get data jemaat dari database

				$dataJemaat=$this->m_model->selectas('id', $value, 'anggota_jemaat');

				if(count($dataJemaat)==0){

					//ini bearti di skip karena data tidak ada

					$failed++;

					continue;

				}

				//jika data ada lanjut kebawah

				//update id keluarga dengan id yang baru

				$param['kwg_no']=$insert_id;

				$param['no_urut']=$no_urut+1;

				$param['sts_kawin']=$this->input->post('status_kawin'.$value);

				$param['hub_kwg']=$this->input->post('hub_keluarga'.$value);

				$update=$this->m_model->updateas('id', $value, $param, 'anggota_jemaat');

				//lalukan update pada keluarga lama untu pengurangan num anggota

				$sql="update keluarga_jemaat set num_anggota=num_anggota-1 where id='".$this->input->post('kwg_id'.$value)."'"; //die($sql);

				$update2=$this->m_model->querycustom($sql);

				if($update){

					$success++;

				}


				//lanjut proses KPKP kalau status aktif
				if($this->input->post('sts_kpkp'.$value)==1){
					if($id_kpkp_keluarga==0){
						//ini bikin dompet KPKP nya dulu bearti
						$param2=array();
						$param2['keluarga_jemaat_id']=$insert_id;
						$param2['saldo_akhir']=0;
						$param2['num_kpkp']=0;
						$param2['last_pembayaran']='0000-00-00';
						$param2['last_update']=NULL;
						$param2['created_at']=date("Y-m-d H:i:s");
						$param2['created_by']=$this->session->userdata('userdata')->id;
						$ikpkp_keluarga=$this->m_model->insertgetid($param2, 'kpkp_keluarga_jemaat');
						$id_kpkp_keluarga=$ikpkp_keluarga;
					}

					//proses saldo
					//untuk insert ke kpkp_bayar_bulanan
					$param3=array();
					$note="Mutasi Saldo ".$this->input->post('namaangjem'.$value)." dari keluarga sebelumnya.";
					$param3['keluarga_jemaat_id']=$insert_id;;
					$param3['tgl_bayar']=date("Y-m-d");
					$param3['note']=$note;
					$param3['created_at']=date('Y-m-d H:i:s');
					$param3['nominal']=$this->input->post('saldo_KPKP_angjem'.$value);
					$param3['created_by']=$this->session->userdata('userdata')->id;
					$param3['type']='5'; //ini sebagai mutasi dana dari keluarga sebelumnya
					$i3=$this->m_model->insertgetid($param3, 'kpkp_bayar_bulanan');
					if($i3>0){
						//update saldo KPKP keluarga yg baru dibuat
						$update4="update kpkp_keluarga_jemaat set saldo_akhir = saldo_akhir + ".$param3['nominal']." where id='".$id_kpkp_keluarga."'";
						$qupdate4=$this->m_model->querycustom($update4);
						if($qupdate4){

							//kalau sudah berhasil update saldo di KPKP keluarga baru dan lakukan pencatatan mutasi transaksi, lakukan pengurangan di KPKP keluarga lama
							$note6="Mutasi Saldo ".$this->input->post('namaangjem'.$value)." ke keluarga barunya.";
							$param6=array();
							$param6['keluarga_jemaat_id']=$this->input->post('kwg_id'.$value);
							$param6['tgl_bayar']=date("Y-m-d");
							$param6['note']=$note6;
							$param6['created_at']=date('Y-m-d H:i:s');
							$param6['nominal']=$this->input->post('saldo_KPKP_angjem'.$value);
							if($this->input->post('saldo_KPKP_angjem'.$value) <0){
								//$param6['nominal']=$this->input->post('saldo_KPKP_angjem'.$value)*-1;
								//ini supaya di tetap plus di pembukaannya dan proses pengurangan di mutasinya tetap benar
							}
							$param6['created_by']=$this->session->userdata('userdata')->id;
							$param6['type']='4'; //ini type transaksi untuk pengurangan dari keluarga lama ke keluarga baru
							$u6=$this->m_model->insertgetid($param6, 'kpkp_bayar_bulanan');


							$update5="update kpkp_keluarga_jemaat set saldo_akhir = saldo_akhir - ".$param3['nominal']." where id='".$this->input->post('kpkp_keluarga_jemaat_id'.$value)."'";
							$qupdate5=$this->m_model->querycustom($update5);
						}
					}

				}

			}



			if($success ==  count($ls_jemaat_id)){

				$json['status']=1;

				$json['msg']="Wow... Berhasil mutasi Anggota Keluarga menjadi Keluarga Baru!";

			}

			else{

				$json['status']=0;

				$json['msg']="Oooppss, Maaf... Ada yang Gagal saat mutasi Anggota Keluarga menjadi Keluarga Baru!";

			}

			echo json_encode($json);

			return;

		}
		else if($action=='add_anggota_to_keluarga'){
			$kwg_old=$this->input->get('kwg_id');
			$ls_jemaat_id=$this->input->post('jemaat_id'); //id angjem yang di pilih untuk dimasukan kekeluarga yang disedang diedit
			//print_r($this->input->post()); die();
			$kwg_new=$this->input->get('kwg_new');

			$updateAngjem=$this->m_model->updateas('id', $ls_jemaat_id, array('kwg_no'=>$kwg_new, 'last_modified'=> date('Y-m-d H:i:s')), 'anggota_jemaat');


			//lanjut proses KPKP kalau status aktif
			if($this->input->post('sts_kpkp')==1){
				$id_kpkp_keluarga=0;

				//check keluarga tujuan dah ada dompet KPKP apa belum
				$scek="select * from kpkp_keluarga_jemaat where keluarga_jemaat_id='".$kwg_new."'";
				$qcek=$this->m_model->selectcustom($scek);
				foreach ($qcek as $key => $value) {
					// code...
					$id_kpkp_keluarga=$value->id;
				}

				if($id_kpkp_keluarga==0){
					//ini bikin dompet KPKP nya dulu bearti
					$param2=array();
					$param2['keluarga_jemaat_id']=$kwg_new;
					$param2['saldo_akhir']=0;
					$param2['num_kpkp']=0;
					$param2['last_pembayaran']='0000-00-00';
					$param2['last_update']=NULL;
					$param2['created_at']=date("Y-m-d H:i:s");
					$param2['created_by']=$this->session->userdata('userdata')->id;
					$ikpkp_keluarga=$this->m_model->insertgetid($param2, 'kpkp_keluarga_jemaat');
					$id_kpkp_keluarga=$ikpkp_keluarga;
				}

				//proses saldo
				//untuk insert ke kpkp_bayar_bulanan
				$param3=array();
				$note="Mutasi Saldo ".$this->input->post('jemaat_name')." dari keluarga sebelumnya.";
				$param3['keluarga_jemaat_id']=$kwg_new;;
				$param3['tgl_bayar']=date("Y-m-d");
				$param3['note']=$note;
				$param3['created_at']=date('Y-m-d H:i:s');
				$param3['nominal']=$this->input->post('saldo_KPKP_angjem');
				$param3['created_by']=$this->session->userdata('userdata')->id;
				$param3['type']='5'; //ini sebagai mutasi dana dari keluarga sebelumnya
				$i3=$this->m_model->insertgetid($param3, 'kpkp_bayar_bulanan');
				if($i3>0){
					//update saldo KPKP keluarga yg baru dibuat
					$update4="update kpkp_keluarga_jemaat set saldo_akhir = saldo_akhir + ".$param3['nominal']." where id='".$id_kpkp_keluarga."'";
					$qupdate4=$this->m_model->querycustom($update4);
					if($qupdate4){

						//kalau sudah berhasil update saldo di KPKP keluarga baru dan lakukan pencatatan mutasi transaksi, lakukan pengurangan di KPKP keluarga lama
						$note6="Mutasi Saldo ".$this->input->post('jemaat_name')." ke keluarga barunya.";
						$param6=array();
						$param6['keluarga_jemaat_id']=$this->input->post('kwg_id');
						$param6['tgl_bayar']=date("Y-m-d");
						$param6['note']=$note6;
						$param6['created_at']=date('Y-m-d H:i:s');
						$param6['nominal']=$this->input->post('saldo_KPKP_angjem');
						if($this->input->post('saldo_KPKP_angjem') <0){
							//$param6['nominal']=$this->input->post('saldo_KPKP_angjem')*-1;
							//ini supaya di tetap plus di pembukaannya dan proses pengurangan di mutasinya tetap benar
						}
						$param6['created_by']=$this->session->userdata('userdata')->id;
						$param6['type']='4'; //ini type transaksi untuk pengurangan dari keluarga lama ke keluarga baru
						$u6=$this->m_model->insertgetid($param6, 'kpkp_bayar_bulanan');


						$update5="update kpkp_keluarga_jemaat set saldo_akhir = saldo_akhir - ".$param3['nominal']." where id='".$this->input->post('id_KPKP_kelangjem')."'";
						$qupdate5=$this->m_model->querycustom($update5);
					}
				}

			}



			if($updateAngjem){
				$sql="update keluarga_jemaat set num_anggota=num_anggota+1 where id='".$kwg_new."'";
				$this->m_model->querycustom($sql);


				$sql1="update keluarga_jemaat set num_anggota=num_anggota-1 where id='".$this->input->post('kwg_id')."'";
				$this->m_model->querycustom($sql1);

				$json['status']=1;

				$json['msg']="Wow... Berhasil mutasi Anggota Keluarga ke dalam Keluarga Baru!";

			}

			else{

				$json['status']=0;

				$json['msg']="Oooppss, Maaf... Ada yang Gagal saat mutasi Anggota Keluarga menjadi Keluarga Baru!";

			}

			echo json_encode($json);

			return;
		}

	}

	function changeKategoryPelayanan(){
		if (!$this->input->is_ajax_request()) {
			die('No direct script access allowed');
		}

		$data=array();
		$recid=$this->input->post('recid');
		$value=explode('#', $this->input->post('value'));

		$param=array();
		$param['kd_group_id']=$value[0];
		$param['kd_group']=$value[1];

		$q=$this->m_model->updateas('id', $recid, $param, 'anggota_jemaat');
		if($q){
			$json=array('status'=>1, 'msg'=>"Wow... Berhasil memperbarui Kategori Pelayanan pada Anggota Jemaat");
		}
		else{
			$json=array('status'=>0, 'msg'=>"Oooppss... Gagal memperbarui Kategori Pelayanan pada Anggota Jemaat");
		}

		echo json_encode($json);

	}


	public function livestreaming()
	{
		// code...

		$data=array();

		$livestreaming=$this->m_model->select('live_streaming');
		$data['livestreaming']=$livestreaming;

		$this->load->view('admin/livestreaming', $data);
	}

	public function addlivestreaming(){
		$param=array();
		$param['date']=$this->input->post('date');
		$param['url']=$this->input->post('url');
		$i=$this->m_model->insertgetid($param, 'live_streaming');

		redirect(base_url().'admin/livestreaming');
	}
	public function udpatestatus_link(){
		$param=array();
		$param['status']=$this->input->post('locked');
		$i=$this->m_model->updateas('id',$this->input->post('recid'), $param, 'live_streaming');

		//redirect(base_url().'admin/livestreaming');
	}


	public function update_sts_kpkp(){
		$param=array();
		$param['sts_kpkp']=$this->input->post('sts_kpkp');

		$u=$this->m_model->updateas('id', $this->input->post('recid'), $param, 'anggota_jemaat');
		if($u){
			$json['status']=1;
			$json['msg']='success';
		}
		else {
			$json['status']=0;
			$json['msg']='failed';
		}

		echo json_encode($json);
	}

	public function update_aturan_kpkp(){
		$param=array();
		$param['aturan_kpkp']=$this->input->post('aturan_kpkp');

		$u=$this->m_model->updateas('id', $this->input->post('recid'), $param, 'anggota_jemaat');
		if($u){
			$json['status']=1;
			$json['msg']='success';
		}
		else {
			$json['status']=0;
			$json['msg']='failed';
		}

		echo json_encode($json);
	}

	public function form_upload_att($angjem_id){
		$data=array();
		$data['no_Anggota']=$this->input->post('no_anggota');
		$data['nama_Anggota']=$this->input->post('nama_anggota');
		$data['angjem_id']=$angjem_id;
		$data['lampiran']=$this->m_model->selectas2('anggota_jemaat_id', $angjem_id, 'status', 1, ' lampiran_angjem');

		$this->load->view('admin/modal_form_upload_att', $data);
	}

	public function get_lampiran_angjem(){
		$data=array();
		$anggota_jemaat_id=$this->input->post('angjem_id');
		$r=$this->m_model->selectas2('anggota_jemaat_id', $anggota_jemaat_id, 'status', 1, 'lampiran_angjem');
		foreach ($r as $key => $value) {
			// code...
			$data['lampiran'][$value->kategori_lampiran][]=$value;
		}
		$this->load->view('admin/list_file_lampiran_angjem', $data);
	}

	public function upload_lampiran(){
		error_reporting(-1);
		ini_set('display_errors', 1);
		$data=array();
		$param=array();
		//print_r($this->input->post()); die();
		$kategori_lampiran=$this->input->post('kategori_lampiran');
		$angjem_id=$this->input->post('recid');
		if(isset($_FILES['file']) && $_FILES['file']['error']==0){
			$file_form = $_FILES['file'];
		}
		else{
			$json['files']=$_FILES['file'];
			$json['size']=$_FILES['file']['size'];
			$json['error']=$_FILES['file']['error'];
			$json['sts']=0;
			$json['msg']='no file';
			echo json_encode($json);
			return;
		}
		$json['size']=$_FILES['file']['size'];
		$json['error']=$_FILES['file']['error'];

//		print_r($file_form);		die();

	 	$config['upload_path']          = FCPATH.'/images/lampiran';
	 	$config['file_name']          	= $angjem_id.'_'.$kategori_lampiran."-".uniqid();
	 	$config['allowed_types']        = 'jpg|png|jpeg|gif';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file'))
        {
            //$error = array('error' => $this->upload->display_errors());
            echo $this->upload->display_errors();
            echo json_encode(array('autoload'=>0, 'sts'=>0, 'msg'=>'Failed Upload!'));
        }
        else
        {
        	$nameFileNew=$this->upload->data('file_name');
        	$config['image_library'] = 'gd2';
			$config['source_image'] = FCPATH.'/images/lampiran/'.$nameFileNew;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 120;
			//$config['height']         = 120;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			//after resize update field foto 
			$param=array();
			$param['kategori_lampiran ']=$kategori_lampiran;
			$param['anggota_jemaat_id ']=$angjem_id;
			$param['name_file']=$_FILES['file']['name'];
			$param['size']=$_FILES['file']['size'];
			$param['type']=$_FILES['file']['type'];
			$param['path']="images/lampiran/".$nameFileNew;
			$param['path_compress']="images/lampiran/".$this->upload->data('raw_name')."_thumb".$this->upload->data('file_ext');
			$param['created_by']=$this->session->userdata('userdata')->username;
			$param['created_at']=date('Y-m-d H:i:s');
			//$this->m_model->updateas('id', $recid, $param, 'anggota_jemaat');
			$i=$this->m_model->insertgetid($param, 'lampiran_angjem');
			// ini jika berhasil lalukan update di table anggota_jemaat pada status lampiran
			switch ($kategori_lampiran) {
				case '1':
					// code...
					$kategori_lampiran_field='lampiran_baptis';
					break;
				case '2':
					// code...
					$kategori_lampiran_field='lampiran_sidi';
					break;
				case '3':
					// code...
					$kategori_lampiran_field='lampiran_nikah';
					break;
				case '4':
					// code...
					$kategori_lampiran_field='lampiran_ktp';
					break;
				case '5':
					// code...
					$kategori_lampiran_field='lampiran_kk';
					break;
				
				default:
					// code...
					$kategori_lampiran_field='lampiran_ktp';
					break;
			}
			$u2=$this->m_model->updateas('id', $angjem_id, array($kategori_lampiran_field=>1), 'anggota_jemaat' );
			

			echo json_encode(array('autoload'=>1, 'sts'=>1, 'msg'=>'Success!'));
        }
	}

	public function delete_lampiran(){
		$data=array();
		$recid=$this->input->get('id');
		$angjem_id=$this->input->get('angjem_id');
		$kategori_lampiran=$this->input->get('kategori_lampiran');
		$kategori_lampiran_field=$this->input->get('lampiran');
		$check_dulu=$this->m_model->selectas3('kategori_lampiran', $kategori_lampiran, 'anggota_jemaat_id', $angjem_id, 'status', 1, 'lampiran_angjem');
		$num_lampiran=count($check_dulu);

		//update to unactivated data
		$u=$this->m_model->updateas('id', $recid, array('status'=>0, 'update_at'=>date('Y-m-d H:i:s')), 'lampiran_angjem');
		if($u){
			if($num_lampiran-1 == 0){
				//ini bearti tidak lampiran yg aktif jadi status lampiran di anggota_jemaat table harus di ubah juga
				$u=$this->m_model->updateas('id', $angjem_id, array($kategori_lampiran_field=>0), 'anggota_jemaat');
			}
			$json['sts']=1;
			$json['msg']='Success';
		}
		else{
			$json['sts']=0;
			$json['msg']='Failed';
		}
		echo json_encode($json);

	}
}

