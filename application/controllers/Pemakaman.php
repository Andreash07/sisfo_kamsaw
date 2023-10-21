<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class pemakaman extends CI_Controller {




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



	function anggota_jemaat($type_pemakaman='reguler'){

		$data=array();

		$where="and A.sts_kpkp = 1";

		$param_active="?";

		if($this->input->get('no_anggota')){

			$param_active.="no_anggota=".$this->input->get('no_anggota')."&";

			$where.=" && lower(A.no_anggota) like '%".$this->input->get('no_anggota')."%'";

		}



		if($this->input->get('nama_anggota')){

			$param_active.="nama_anggota=".rawurldecode($this->input->get('nama_anggota'))."&";

			$where.=" && lower(A.nama_lengkap) like '%".rawurldecode($this->input->get('nama_anggota'))."%'";

		}



		if($this->input->get('jns_kelamin')){

			$param_active.="jns_kelamin=".$this->input->get('jns_kelamin')."&";

			$where.=" && lower(A.jns_kelamin) like '".$this->input->get('jns_kelamin')."'";

		}



		if($this->input->get('alamat')){

			$param_active.="alamat=".rawurldecode($this->input->get('alamat'))."&";

			$where.=" && lower(B.kwg_alamat) like '%".$this->input->get('alamat')."%'";

		}

		if($this->input->get('kwg_wil')){

			$param_active.="kwg_wil=".$this->input->get('kwg_wil')."&";

			$where.=" && A.kwg_wil ='".$this->input->get('kwg_wil')."'";

		}



		if($this->input->get('type') && count($this->input->get('type'))>0){

			$param_active.="type=".$this->input->get('type')."&";

			$where.=" && A.golongandarah in (".implode(',', $this->input->get('type')).")";



		}



		/*pemakaman baptis start*/

		if($this->input->get('status_baptis')){

			$param_active.="status_baptis=".$this->input->get('status_baptis')."&";

			switch (strtolower($this->input->get('status_baptis'))) {

				case 'sudah':

					// code...

					$where.=" && A.status_baptis =1";

					break;

				case 'belum':

					// code...

					$where.=" && (A.status_baptis =0 || A.status_baptis is null)";

					break;

				

				default:

					// code...

					break;

			}

		}



		if($this->input->get('tgl_baptis')){

			$date=convert_time_ymd($this->input->get('tgl_baptis'));

			$param_active.="tgl_baptis=".$this->input->get('tgl_baptis')."&";

			$where.=" && A.tgl_baptis ='".clearText($date)."'";

		}

		/*pemakaman baptis end*/



		/*pemakaman sidi start*/

		if($this->input->get('status_sidi')){

			$param_active.="status_sidi=".$this->input->get('status_sidi')."&";

			switch (strtolower($this->input->get('status_sidi'))) {

				case 'sudah':

					// code...

					$where.=" && A.status_sidi =1";

					break;

				case 'belum':

					// code...

					$where.=" && (A.status_sidi =0 || A.status_sidi is null)";

					break;

				

				default:

					// code...

					break;

			}

		}



		if($this->input->get('tgl_sidi')){

			$param_active.="tgl_sidi=".$this->input->get('tgl_sidi')."&";

			$date=convert_time_ymd($this->input->get('tgl_sidi'));

			$where.=" && A.tgl_sidi ='".clearText($date)."'";

		}

		switch ($type_pemakaman) {
			case 'reguler':
				// code...
				//null
				break;
			case 'baptis_sidi':
				// code...
				$where.=" && A.sts_anggota ='1'";
				break;
			default:
				// code...
				break;
		}

		if($this->input->get('tahun_dari') && $this->input->get('tahun_dari') !=''){

			$param_active.="tahun_dari=".$this->input->get('tahun_dari')."&";

			$date=$this->input->get('tahun_dari');

			$where.=" && YEAR(A.tgl_lahir) >= '".clearText($date)."'";

		}

		if($this->input->get('tahun_sampai') && $this->input->get('tahun_sampai') !=''){

			$param_active.="tahun_sampai=".$this->input->get('tahun_sampai')."&";

			$date=$this->input->get('tahun_sampai');

			$where.=" && YEAR(A.tgl_lahir) <= '".clearText($date)."'";

		}

		/*pemakaman sidi end*/



		$sql="select A.*, B.kwg_nama, B.kwg_alamat, C.hub_keluarga, B.id as kwg_id, B.kwg_telepon

				from anggota_jemaat A

				join keluarga_jemaat B on B.id = A.kwg_no

				join ags_hub_kwg C on C.idhubkel = A.hub_kwg

				where A.id >0 && A.status=1 && A.sts_anggota=1 ".$where.""; //A.status=1 bearti tidak pernah di delete


		$group_by="  ";

		//echo $sql; exit();

        $field_order=" order by ";
        if($this->input->get('tahun_dari') && $this->input->get('tahun_dari') !=''){
        	$field_order.=" A.tgl_lahir ASC, ";
        }
        if($this->input->get('tahun_sampai') && $this->input->get('tahun_sampai') !='' && $this->input->get('tahun_dari') == '' ){
        	$field_order.=" A.tgl_lahir DESC, ";
        }
        $field_order.=" A.nama_lengkap ";

        if($this->input->get('export')){

        	$field_order=" order by A.kwg_wil, B.kwg_nama,  B.id, B.kwg_nama, A.no_urut, A.hub_kwg ";

        }

        $order_by=" ASC ";

        $numLimit=50;

        $numStart=0;

        if(!$this->input->get('page')){

            $page=1;

            $numStart=($numLimit*$page)-$numLimit;

        }

        else{

            $page=$this->input->get('page');

            $numStart=($numLimit*$page)-$numLimit;

        }

        $data['page']=$page;

        $data['numStart']=$numStart;

        $limit='LIMIT '.$numStart.', '.$numLimit;

        

        $data_jemaat=$this->m_model->selectcustom($sql." ".$group_by." ".$field_order." ".$order_by);



        $data['TotalOfData']=count($data_jemaat);

        //TotalOfProduct($query_product." ".$where." ".$group_by." ".$field_order." ".$order_by);

        //$data['TotalOfPage']=TotalOfPage($data['TotalOfProduct'], 30);//30 is limit item per page

        if(!$this->input->get('page')){

            $page_active=1;

        }else{

            $page_active=$this->input->get('page');

        }

        $data['pagingnation']=pagingnation($data['TotalOfData'], $numLimit, $page_active, $param_active, $links=2);



        if(!$this->input->get('export')){

        	//kalau export tidak perlu di slice untuk pagination

	        if($page>1){

	            array_splice($data_jemaat, 0, $numStart);

	            array_splice($data_jemaat,$numLimit );

	        }

	        else{

	            array_splice($data_jemaat, $numStart+$numLimit);

	        }

        }



		$data['data_jemaat']=$data_jemaat;

		switch ($type_pemakaman) {

			case 'reguler':

				// code...

				switch(strtolower($this->input->get('export'))){

					case 'print':

					//die("asdasd");	

						// code...
						$data['field']=array();
						$data['title_field']=array();
						if($this->input->post('field')){
							foreach ($this->input->post('field') as $key => $value) {
								// code...
								$rawField=explode('#', $value);
								$data['field'][]=$rawField[0];
								$data['title_field'][]=$rawField[1];
							}
						}

						$view='pemakaman/print_anggota_jemaat';

						break;

					default:

						// code...

						$view='pemakaman/anggota_jemaat';

						break;

				}
				$this->load->view($view, $data);


				break;

			case 'baptis_sidi':

				// code...

				switch(strtolower($this->input->get('export'))){

					case 'print':

					//die("asdasd");	

						// code...

						$view='pemakaman/print_anggota_jemaat_sidi';

						break;

					default:

						// code...

						$view='pemakaman/anggota_jemaat_sidi';

						break;

				}

				$this->load->view($view,$data);

				break;

			default:

				// code...

				$this->load->view('pemakaman/anggota_jemaat',$data);

				break;

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


			redirect(base_url().'pemakaman/'.$this->uri->segment(2).'?edit=true&id='.$insert_id);

			//die();

		}

		else if($this->input->get('addAnggota')){

				$data['type']='addAnggota';

				$data['kwg_no']=$this->input->get('kwg_no');


				$this->load->view('pemakaman/modalDataJemaat', $data);

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

			redirect(base_url().'pemakaman/'.$this->uri->segment(2).'?edit=true&id='.$this->input->post('keluarga_jemaat_id'));

			//die();

		}

		else if($this->input->get('editAnggota')){

				$data['type']='editAnggota';



				$data['AnggotaId']=$this->input->get('id');

				$this->load->view('pemakaman/modalDataJemaat', $data);

			return;

		}

		else if($this->input->get('viewAnggota')){

				$data['type']='viewAnggota';

				$data['AnggotaId']=$this->input->get('id');


				$this->load->view('pemakaman/modalDataJemaat', $data);

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



			redirect(base_url().'pemakaman/'.$this->uri->segment(2).'?edit=true&id='.$id);

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

				$deleteSoftAnggota=$this->m_model->updateas('kwg_no', $this->input->get('id'), $param, 'anggota_jemaat');

				$this->session->set_userdata(array('status_remove'=>'berhasil'));

			}

			else{

				$this->session->set_userdata(array('status_remove'=>'gagal'));

			}

			redirect(base_url().'pemakaman/'.$this->uri->segment(2));

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

			//redirect(base_url().'pemakaman/'.$this->uri->segment(2));

			redirect($_SERVER['HTTP_REFERER']);

		}

		else if($this->input->get('editHobyProfesi')=='true'){

			if (!$this->input->is_ajax_request()) {

				die('No direct script access allowed');

			}

			$data['AnggotaId']=$this->input->get('id');

			$this->load->view('pemakaman/modal_hoby-profesi', $data);

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
	        
	        $where.="where (A.delete_user is NULL || A.delete_user = '') ";

	        //dicomment supaya keluarga yang sudah tidak aktif tapi belum di delete tetap muncul sehingga pemakaman bisa mengetahui jejak record keluarga tersebut
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


	        $whereKPKP='and sts_kpkp = 1';
			$data['TotalOfProduct']=TotalOfProduct($query_data." ".$where." ".$field_order." ".$order_by);

			$data['pagingnation']=pagingnation($data['TotalOfProduct'], $numLimit, $page_active, $param_active, $links=2);

			$data['dataKK']=$this->m_model->selectcustom($query_data." ".$where."  ".$field_order." ".$order_by." ".$limit);

			//$data['dataKK']=$this->m_model->selectas('status', 1, 'keluarga_jemaat', 'kwg_nama', 'ASC');

		}


		$this->load->view('pemakaman/data_jemaat', $data);

	}

}

