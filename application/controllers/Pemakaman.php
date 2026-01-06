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

		if(!isset($_GET['sts_anggota'])) {
			$sts_anggota=1;
		}
		else if($this->input->get('sts_anggota') || $this->input->get('sts_anggota')==0 ){
			$sts_anggota=$this->input->get('sts_anggota');
			$param_active.="sts_anggota=".$this->input->get('sts_anggota')."&";
		}

		if($this->input->get('sts_angjem') || $this->input->get('sts_angjem') =='0'){

			$param_active.="sts_anggota=".$this->input->get('sts_angjem')."&";

			$where.=" && A.sts_anggota = '".$this->input->get('sts_angjem')."'";
			$data['sts_angjem']=$this->input->get('sts_angjem');

		}else{
			$data['sts_angjem']=1;
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



		$sql="select A.*, B.kwg_nama, B.kwg_alamat, C.hub_keluarga, B.id as kwg_id, B.kwg_telepon, D.id as kpkp_keluarga_jemaat_id

				from anggota_jemaat A

				join keluarga_jemaat B on B.id = A.kwg_no

				join ags_hub_kwg C on C.idhubkel = A.hub_kwg
				left join kpkp_keluarga_jemaat D on D.keluarga_jemaat_id = B.id

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

        $data['sts_anggota']=$sts_anggota;
        $data['page']=$page;

        $data['numStart']=$numStart;

        $limit='LIMIT '.$numStart.', '.$numLimit;

        

        //die($sql." ".$group_by." ".$field_order." ".$order_by);
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
			$data['iuranKpkpp']='5000';
			$data['total_biayaKPKP']='0';
		}

		$this->load->view('pemakaman/data_jemaat', $data);

	}

	public function simpan_pembayaran()
	{
		// code...
		$data=array();
		$param=array();
		$keluarga_jemaat_id=$this->input->post('keluarga_jemaat_id');
		$num_anggota_kpkp=$this->input->post('num_anggota_kpkp');
		$nominal=str_replace('.', '', $this->input->post('nominal'));
		$nominal_sukarela=str_replace('.', '',$this->input->post('nominal_sukarela'));
		$tgl_bayar=$this->input->post('tgl_bayar');
		$option_sukarela=$this->input->post('option_sukarela');
		$note=$this->input->post('note');
		#print_r($this->input->post());die();

		//untuk insert ke kpkp_bayar_bulanan
		$param['keluarga_jemaat_id']=$keluarga_jemaat_id;;
		$param['tgl_bayar']=$tgl_bayar;
		$param['note']=$note;
		$param['created_at']=date('Y-m-d H:i:s');
		$param['created_by']=$this->session->userdata('userdata')->id;
		$param['type']='1'; //ini sebagai tanda bayar bulanan

		//get id keluarga KPKP dari keluarga jemaat id
		$qid_kpkp=$this->m_model->selectas('keluarga_jemaat_id', $keluarga_jemaat_id, 'kpkp_keluarga_jemaat');
		foreach ($qid_kpkp as $key => $value) {
			// code...
			$id_kpkp=$value->id;
			$saldo_akhir=$value->saldo_akhir;
			$saldo_akhir_sukarela=$value->saldo_akhir_sukarela;
		}

		switch ($option_sukarela) {
			case '0':
				// code... //tidak ada dana sukarela
				$param['nominal']=$nominal;
				//insert pembayaran
				$i=$this->m_model->insertgetid($param, 'kpkp_bayar_bulanan');

				break;
			case '1':
				// code... //ini bearti ada sukarelanya dengan nominal yg di tentukan
				$param['nominal']=$nominal-$nominal_sukarela;
				//insert pembayaran
				$i=$this->m_model->insertgetid($param, 'kpkp_bayar_bulanan');

				$nominal_sukarela=$nominal_sukarela;
				//untuk insert ke kpkp_bayar_bulanan
				$param3=array();
				$param3['nominal']=$nominal_sukarela;
				$param3['keluarga_jemaat_id']=$keluarga_jemaat_id;;
				$param3['tgl_bayar']=$tgl_bayar;
				$param3['created_at']=date('Y-m-d H:i:s');
				$param3['created_by']=$this->session->userdata('userdata')->id;
				$param3['type']='3'; //ini sebagai tanda bayar sukarela
				//insert pembayaran sukarela
				$i2=$this->m_model->insertgetid($param3, 'kpkp_bayar_bulanan');


				//$param['note']="Memberikan Iuran Sukarela ".$nominal_sukarela;
				break;

			case '2':
				// code... //ini bearti ada sukarelanya dengan nominal yg di tentukan
				//get nominal pokok_iuran
				$rpokok=$this->m_model->selectas('status', '1', 'kpkp_pokok_iuran');
				$pokok=0;
				foreach ($rpokok as $key => $value) {
					// code...
					$pokok=$value->nominal;
				}
				$pokok_iuranKeluarga=$pokok*$this->input->post('num_anggota_kpkp');
				//potong pembayaran iuran pokok keluarga
				$bulan_terbayar=floor($nominal/$pokok_iuranKeluarga);
				$total_bayar_iuran_wajib=$bulan_terbayar*$pokok_iuranKeluarga;

				//get sisa setelah di potong pokok untuk 
				$nominal_sukarela=$nominal-$total_bayar_iuran_wajib;


				$param['nominal']=$total_bayar_iuran_wajib;
				//insert pembayaran
				$i=$this->m_model->insertgetid($param, 'kpkp_bayar_bulanan');

				$nominal_sukarela=$nominal_sukarela;
				//untuk insert ke kpkp_bayar_bulanan
				$param3=array();
				$param3['nominal']=$nominal_sukarela;
				$param3['keluarga_jemaat_id']=$keluarga_jemaat_id;;
				$param3['tgl_bayar']=$tgl_bayar;
				$param3['created_at']=date('Y-m-d H:i:s');
				$param3['created_by']=$this->session->userdata('userdata')->id;
				$param3['type']='3'; //ini sebagai tanda bayar sukarela
				//insert pembayaran sukarela
				$i2=$this->m_model->insertgetid($param3, 'kpkp_bayar_bulanan');


				//$param['note']="Memberikan Iuran Sukarela ".$nominal_sukarela;
				break;
			
			default:
				// code...
				break;
		}

		if($i){
		#die($i."asdasd");
			//ini jika berhasil update saldo pada akun kpkp anggota jemaat
			//pakai $param['nominal'] karena ada kemungkinan nominal yg dibayakan berubah karena ada potongan sukarela, jadi gunakan yg netto
			$param2=array();
			$param2['saldo_akhir']=$saldo_akhir+$param['nominal'];
			$param2['saldo_akhir_sukarela']=$saldo_akhir_sukarela+$nominal_sukarela;
			$param2['last_pembayaran']=$param['tgl_bayar'];
			$param2['last_update']=date('Y-m-d H:i:s');
			$u=$this->m_model->updateas('id', $id_kpkp, $param2, 'kpkp_keluarga_jemaat');

		}else{
			$u=false;
		}


		redirect(base_url().'pemakaman/DataJemaat?edit=true&id='.$keluarga_jemaat_id);

		//print_r($param); die();
	}

	public function data_blok_makam(){

		$this->load->view('pemakaman/anggota_mantan');
    }

    public function data_makam(){
    	$data=array();
    	$s="select * from kpkp_blok_makam where status=1";
    	$q=$this->m_model->selectcustom($s);
    	$data['blok']=$q;

    	$s1="select * from kpkp_makam";
    	$q1=$this->m_model->selectcustom($s1);
    	$data['data_makam']=array();
    	$data['no_makam']=array();
    	foreach ($q1 as $key => $value) {
    		// code...
    		$data['no_makam'][$value->kpkp_blok_makam_id.'#'.$value->no_makam]=$value->kpkp_blok_makam_id.' '.$value->no_makam;
    		$data['data_makam'][$value->kpkp_blok_makam_id.'#'.$value->no_makam][]=$value;
    	}


		$this->load->view('pemakaman/data_makam');
    }


    public function pembayaran_iuran(){
    	$data=array();
    	$s="select B.kwg_nama, B.kwg_alamat, B.kwg_telepon, D.*, B.kwg_wil, C.num_jiwa_utama, E.num_jiwa_tambahan, 0 as num_jiwa
            from keluarga_jemaat B
            join kpkp_keluarga_jemaat D on D.keluarga_jemaat_id = B.id
            join (select z.kwg_no, COUNT(z.id) as num_jiwa_utama
                    from anggota_jemaat z where z.status=1 && z.sts_kpkp=1 && z.sts_anggota=1 && tgl_meninggal='0000-00-00' && (z.tmpt_meninggal='' || z.tmpt_meninggal is NULL) 
                    group by z.kwg_no
                ) C on C.kwg_no = B.id
            left join (select z.kwg_no_kpkp, COUNT(z.id) as num_jiwa_tambahan
                    from anggota_jemaat z where z.kwg_no_kpkp!=0 &&  z.status=1 && z.sts_kpkp=1 && z.sts_anggota=1 && tgl_meninggal='0000-00-00' && (z.tmpt_meninggal='' || z.tmpt_meninggal is NULL) 
                    group by z.kwg_no_kpkp
                ) E on E.kwg_no_kpkp = B.id
            ";
        $q=$this->m_model->selectcustom($s);

        $rIruranPokok=$this->m_model->selectas('status', '1', 'kpkp_pokok_iuran');
    	$IruranPokok=0;
        foreach ($rIruranPokok as $key1 => $value1) {
        	// code...
        	$IruranPokok=$value1->nominal;
        }

        $iSuccess=0;
        $iFailed=0;
        foreach ($q as $key => $value) {
        	// code...

        	if($value->num_jiwa_tambahan==null){
        		//continue; //ini bearti tidak di proses karena tidak ada jumlah jiwanya
        		//masih ragu
        		$value->num_jiwa_tambahan=0;
        	}


        	if($value->num_jiwa==0){
        		//continue; //ini bearti tidak di proses karena tidak ada jumlah jiwanya
        		//masih ragu
        		$value->num_jiwa=$value->num_jiwa_utama+$value->num_jiwa_tambahan;
        	}
        	$note="";
        	$note.=date('F Y');
        	$periode_bulan=date('Y-m-d');
        	$type='2';//pembayaran iuran
        	$nominal=($value->num_jiwa*$IruranPokok) *-1;//dikali -1 karena ini untuk ngurangin saldo terakhir/tersedia
        	$note.=' ('.$value->num_jiwa.'jiwa @'.$IruranPokok.')';

        	//insert data dulu ke data iuran bulanan
        	$param=array();
        	$param['keluarga_jemaat_id']=$value->keluarga_jemaat_id;
        	$param['periode_bulan']=$periode_bulan;
        	$param['type']=$type;
        	$param['nominal']=$nominal;
        	$param['note']=$note;
        	$param['tgl_bayar']=date('Y-m-d');
        	//$param['tgl_bayar']='2024-02-01';
        	$param['created_at']=date('Y-m-d H:i:s');
        	//$param['created_at']='2024-02-01 00:'.date('i:s');
        	$param['created_by']=1; //administrator

        	$i=$this->m_model->insertgetid($param, 'kpkp_bayar_bulanan');

        	if($i){
        		//jika berhasil maka lanjut untuk update saldo KPKP terakhir kel. jemaat
        		//$qupdate="update kpkp_keluarga_jemaat set saldo_akhir=saldo_akhir+".$nominal.", last_update='".date('Y-m-d H:i:s')."' where id='".$value->id."'";
        		$qupdate="update kpkp_keluarga_jemaat set saldo_akhir=saldo_akhir+".$nominal.", last_update='".$param['created_at']."' where id='".$value->id."'";
        		$update=$this->m_model->querycustom($qupdate);
        		if($update){
        			$iSuccess++;
        		}
        		else{
        			$iFailed++;
        		}
        	}
        	else{
        		$iFailed++;
        	}
        }

        $iTotal=$iSuccess+$iFailed;
        //insert log auto debet
        $param2=array();
        $param2['periode_bulan']=date('Y-m-d');
        $param2['success']=$iSuccess;
        $param2['failed']=$iFailed;
        $param2['total']=$iTotal;
        $param2['created_at']=date('Y-m-d H:i:s');
        $i2=$this->m_model->insertgetid($param2, 'kpkp_log_auto_debet');

        echo 'success: '.$iSuccess;
        echo '<br><br>';
        echo 'error: '.$iFailed;
    }

    function transaksi_mutasi($action="print"){
    	$data=array();
    	$kk_id=$this->input->get('id');
    	//get detail KK
    	//$KK=$this->m_model->selectas2('id',$kk_id,'status', '1',' keluarga_jemaat');
    	$sKK="select A.*, COUNT(B.id) as num_jiwa, C.saldo_akhir, C.saldo_akhir_sukarela, C.last_pembayaran
    			from keluarga_jemaat A 
    			join anggota_jemaat B on B.kwg_no = A.id
    			left join kpkp_keluarga_jemaat C on C.keluarga_jemaat_id = A.id
    			where A.status=1 && B.sts_anggota=1 && B.status=1 && sts_kpkp=1 && A.id = '".$kk_id."'";
    	$KK=$this->m_model->selectcustom($sKK); //die($sKK);
    	$mutasi_transaksi=$this->m_model->selectas('keluarga_jemaat_id',$kk_id, 'kpkp_bayar_bulanan');
    	$dompet_keluarga_kpkp=$this->m_model->selectas('keluarga_jemaat_id',$kk_id, 'kpkp_keluarga_jemaat');

    	$data['KK']=$KK;
    	$data['mutasi_transaksi']=$mutasi_transaksi;
    	$data['dompet_keluarga_kpkp']=$dompet_keluarga_kpkp;

    	$this->load->view('pemakaman/print',$data);

    }

    function laporan_iuran_anggota(){
    	$data=array();
    	$kk_id=$this->input->get('id');

    	//defaultnya dalam 1 minggu ini
    	$dateInWeek=get_dateInWeek(date('N'));
    	$datef=date('Y-').$dateInWeek['date_from'];
    	$datet=date('Y-').$dateInWeek['date_to'];
    	if($this->input->get('datef')){
    		$datef=$this->input->get('datef');
    	}
    	if($this->input->get('datet')){
    		$datet=$this->input->get('datet');
    	}

    	

    	$sKK="select A.kwg_nama, C.saldo_akhir, B.*
    			from keluarga_jemaat A 
    			join kpkp_bayar_bulanan B on B.keluarga_jemaat_id = A.id
    			join kpkp_keluarga_jemaat C on C.keluarga_jemaat_id = A.id
    			where B.type in (1,3) && B.tgl_bayar >='".$datef."' && B.tgl_bayar <='".$datet."'
    			order by B.id DESC
    			";
    	$iuran_anggota=$this->m_model->selectcustom($sKK); //die($sKK);
    	$data_iuran=array();
    	$ls_keluarga_id=array();
    	$ls_keluarga_id[]=-10000;
    	foreach ($iuran_anggota as $key => $value) {
    		// code...
    		if(!isset($data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar])){
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]=array();
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['wajib']=0;
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['sukarela']=0;
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['total']=0;
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['kwg_nama']=$value->kwg_nama;
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['tgl_bayar']=$value->tgl_bayar;
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['saldo_akhir']=$value->saldo_akhir;
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['keluarga_jemaat_id']=$value->keluarga_jemaat_id;
    		}
			$ls_keluarga_id[]=$value->keluarga_jemaat_id;
    		if($value->type==1){
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['wajib']=$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['wajib']+$value->nominal;
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['total']=$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['total']+$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['wajib'];
    		}else if($value->type==3){
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['sukarela']=$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['sukarela']+$value->nominal;
    			$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['total']=$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['total']+$data_iuran[$value->keluarga_jemaat_id.'_'.$value->tgl_bayar]['sukarela'];
    		}




    	}

    	//get anggota KPKP berdasarkan list kwg yg ada di mutasi laporan agar tidak berat
    	$s="select kwg_no, count(id) as num_kpkp, sts_kpkp, sts_anggota, status from anggota_jemaat where sts_kpkp=1 && sts_anggota=1 && status=1 && kwg_no in (".implode(',', $ls_keluarga_id).") group by kwg_no";
    	$qs=$this->m_model->selectcustom($s);
    	$num_anggota=array();
    	foreach($qs as $key => $value){
    		$num_anggota[$value->kwg_no]=$value;
    	}


    	$data['num_anggota']=$num_anggota;
    	//print_r($num_anggota);
    	$data['iuran_anggota']=$data_iuran;
    	$data['dateInWeek']=$dateInWeek;
    	$data['datef']=$datef;
    	$data['datet']=$datet;
    	if($this->input->get('export')=='print'){
    		$this->load->view('pemakaman/print_laporan_iuran_anggota',$data);
    	}else{
    		$this->load->view('pemakaman/laporan_iuran_anggota',$data);
    	}

    }


    function laporan_iuran_makam(){
    	$data=array();
    	$kk_id=$this->input->get('id');

    	//defaultnya dalam 1 minggu ini
    	$dateInWeek=get_dateInWeek(date('N'));
    	$datef=date('Y-').$dateInWeek['date_from'];
    	$datet=date('Y-').$dateInWeek['date_to'];
    	if($this->input->get('datef')){
    		$datef=$this->input->get('datef');
    	}
    	if($this->input->get('datet')){
    		$datet=$this->input->get('datet');
    	}

    	

    	$sKK="select B.*, A.blok, A.lokasi, A.kavling, A.tahun_tercover, A.keanggotaan_makam, B.nominal, B.tgl_bayar, B.created_at as tgl_input_pembayaran, C.nama as penghuni_makam
				from kpkp_blok_makam A
				join kpkp_bayar_tahunan B on B.kpkp_blok_makam_id = A.id
				left join (select * from kpkp_penghuni_makam where sts=1) C on A.id = C.kpkp_blok_makam_id
    			where B.type in (1) && B.tgl_bayar >='".$datef."' && B.tgl_bayar <='".$datet."'
    			order by B.tgl_bayar DESC, A.blok, A.kavling, B.id ASC;
    			";
    	#die(nl2br($sKK));
    	$iuran_anggota=$this->m_model->selectcustom($sKK); 

    	$data['iuran_anggota']=$iuran_anggota;
    	$data['dateInWeek']=$dateInWeek;
    	$data['datef']=$datef;
    	$data['datet']=$datet;
    	if($this->input->get('export')=='print'){
    		$this->load->view('pemakaman/print_laporan_iuran_makam',$data);
    	}else{
    		$this->load->view('pemakaman/laporan_iuran_makam',$data);
    	}

    }


    function bukadompetkpkp(){
    	$data=array();
    	$recid=$this->input->post('recid');
    	$nominal=$this->input->post('nominal');
    	//create dompet KPKP
    	$param=array();
    	$param['keluarga_jemaat_id']=$recid;
    	$param['saldo_akhir']=$nominal;
    	$param['saldo_akhir_sukarela']=0;
    	$param['last_pembayaran']='0000-00-00';
    	$param['created_at']=date('Y-m-d H:i:s');
    	$param['created_by']=$this->session->userdata('userdata')->id;
    	$param['last_update']=NULL;
    	$i=$this->m_model->insertgetid($param, 'kpkp_keluarga_jemaat');

    	//create mutasi transksi
    	$param2=array();
    	$param2['type']=0;
    	$param2['keluarga_jemaat_id']=$recid;
    	$param2['nominal']=$nominal;
    	$param2['tgl_bayar']=date('Y-m-d');
    	$param2['created_at']=date('Y-m-d H:i:s');
    	$param2['created_by']=$this->session->userdata('userdata')->id;
    	$i=$this->m_model->insertgetid($param2, 'kpkp_bayar_bulanan');

    	redirect(base_url().'pemakaman/DataJemaat?edit=true&id='.$recid);

    }


    function form_tautaangjem(){
    	$data=array();
    	$data['keluarga_jemaat_id']=$this->input->get('id');
    	$param=array();
    	

    	$this->load->view('pemakaman/form_tautaangjem', $data);

    }


    function mutasi_keluarga($action){
    	$data=array();
    	$param=array();

    	$kwg_old=$this->input->get('kwg_id');
		$ls_jemaat_id=$this->input->post('jemaat_id'); //id angjem yang di pilih untuk dimasukan kekeluarga yang disedang diedit
		//print_r($this->input->post()); die();
		$kwg_new=$this->input->get('kwg_new');

		$updateAngjem=$this->m_model->updateas('id', $ls_jemaat_id, array('kwg_no_kpkp'=>$kwg_new, 'last_modified'=> date('Y-m-d H:i:s')), 'anggota_jemaat');

		if($updateAngjem){
			$sql="update kpkp_keluarga_jemaat  set num_kpkp=num_kpkp+1 where id='".$kwg_new."'";
			$this->m_model->querycustom($sql);


			$sql1="update kpkp_keluarga_jemaat  set num_kpkp=num_kpkp-1 where id='".$this->input->post('kwg_id')."'";
			$this->m_model->querycustom($sql1);

			$json['status']=1;

			$json['msg']="Wow... Berhasil menambahkan Anggota KPKP ke dalam Keluarga KPKP!";

		}

		else{

			$json['status']=0;

			$json['msg']="Oooppss, Maaf... Ada yang Gagal saat mutasi Anggota Keluarga menjadi Keluarga KPKP!";

		}

		echo json_encode($json);

		return;

    	

    	$this->load->view('pemakaman/form_tautaangjem', $data);

    }

    function form_perbaikan(){
    	$data=array();
    	$param=array();

    	$recid=$this->input->get('id');
    	$s="select * from kpkp_bayar_bulanan where id='".$recid."'";
    	$q=$this->m_model->selectcustom($s);
    	$data['recid']=$recid;
    	$data['data']=$q;
    	$this->load->view('pemakaman/form_perbaikan', $data);
    }

    function submit_perbaikan(){
    	$data=array();
    	$param=array();
    	$recid=$this->input->get('id');
    	foreach ($this->input->post() as $key => $value) {
    		// code...
    		$param[$key]=$value;
    	}
    	$u=$this->m_model->updateas('id', $recid, $param, 'kpkp_bayar_bulanan');
    }
    function cancel_mutasi(){
    	$data=array();
    	$param=array();
    	$recid=$this->input->get('id');

    	#$u=$this->m_model->updateas('id', $recid, $param, 'kpkp_bayar_bulanan');
    	$d=$this->m_model->deleteas('id', $recid, 'kpkp_bayar_bulanan');
    }
    function approve(){
    	$data=array();
    	$recid=$this->input->post('kk_id');
    	$param['saldo_akhir']=$this->input->post('nominal_baru');
    	//$param['keluarga_jemaat_id']=$this->input->post('kk_id');
    	$u=$this->m_model->updateas('keluarga_jemaat_id', $recid, $param, 'kpkp_keluarga_jemaat');

    }

    function copot_tautan(){
    	$data=array();
    	$param=array();
    	$angjem_id=$this->input->post('angjem_id');
    	$kwg_no=$this->input->post('kwg_no');
    	$kwg_no_kpkp=$this->input->post('kwg_no_kpkp');
    	$bulan_tercover=$this->input->post('bulan_tercover');
    	$dana_kpkp=$this->input->post('dana_kpkp');
    	$dana_pindah=$this->input->post('dana_pindah');

    	$id_kpkp_keluarga=0;

    	if($dana_pindah==1){
			//check keluarga tujuan dah ada dompet KPKP apa belum
			$scek="select * from kpkp_keluarga_jemaat where keluarga_jemaat_id='".$kwg_no."'"; //die($scek);
			$qcek=$this->m_model->selectcustom($scek);
			foreach ($qcek as $key => $value) {
				// code...
				$id_kpkp_keluarga=$value->id;
			}

			if($id_kpkp_keluarga==0){
				//ini bikin dompet KPKP nya dulu bearti
				$param2=array();
				$param2['keluarga_jemaat_id']=$kwg_no;
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
			$param3['keluarga_jemaat_id']=$kwg_no;;
			$param3['tgl_bayar']=date("Y-m-d");
			$param3['note']=$note;
			$param3['created_at']=date('Y-m-d H:i:s');
			$param3['nominal']=$dana_kpkp;
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
					$param6['keluarga_jemaat_id']=$kwg_no_kpkp;
					$param6['tgl_bayar']=date("Y-m-d");
					$param6['note']=$note6;
					$param6['created_at']=date('Y-m-d H:i:s');
					$param6['nominal']=$dana_kpkp;
					if($dana_kpkp <0){
						//$param6['nominal']=$this->input->post('saldo_KPKP_angjem')*-1;
						//ini supaya di tetap plus di pembukaannya dan proses pengurangan di mutasinya tetap benar
					}
					$param6['created_by']=$this->session->userdata('userdata')->id;
					$param6['type']='4'; //ini type transaksi untuk pengurangan dari keluarga lama ke keluarga baru
					$u6=$this->m_model->insertgetid($param6, 'kpkp_bayar_bulanan');


					$update5="update kpkp_keluarga_jemaat set saldo_akhir = saldo_akhir - ".$param3['nominal']." where keluarga_jemaat_id='".$kwg_no_kpkp."'";
					$qupdate5=$this->m_model->querycustom($update5);

				}
			}
    	}

    	//update kpkp tautan untuk di lepaskan..
		$update6="update anggota_jemaat set kwg_no_kpkp='0' where id='".$angjem_id."'";
		$qupdate6=$this->m_model->querycustom($update6);

		$json=array();
		if($qupdate6){
			$json['sts']=1;
			$json['msg']='Berhasil';
		}else{
			$json['sts']=0;
			$json['msg']='Tidak Berhasil update';
		}

    }


    public function rincian_makam(){
    	$data=array();
    	$blok="select A.*, B.num_penghuni
    			from kpkp_blok_makam A 
    			join (select *, COUNT(id) as num_penghuni from kpkp_penghuni_makam group by kpkp_blok_makam_id) B on B.kpkp_blok_makam_id = A.id 
    			where A.tahun_tercover is not NULL
    			order by A.blok ASC, A.kavling ASC";

		$blok="select A.*, B.num_penghuni, C.nama as penghuni_makam, C.asal_gereja
    			from kpkp_blok_makam A 
    			left join (select *, COUNT(id) as num_penghuni from kpkp_penghuni_makam group by kpkp_blok_makam_id) B on B.kpkp_blok_makam_id = A.id 
                left join (select * from kpkp_penghuni_makam where sts=1) C on A.id = C.kpkp_blok_makam_id
    			where A.tahun_tercover is not NULL
    			order by A.blok ASC, A.kavling ASC";
    	$rblok=$this->m_model->selectcustom($blok);
    	$data['data']['>0tahun']=array();
    	$data['data']['0tahun']=array();
    	$data['data']['-3tahun']=array();
    	$data['data']['-5tahun']=array();
    	$data['data']['-10tahun']=array();
    	$data['data']['<-10tahun']=array();
    	$th_tercover=0;
    	foreach ($rblok as $key => $value) {
    		// code...
    		$th_tercover=$value->tahun_tercover-date('Y');
    		if($th_tercover == 0){
    			$data['data']['0tahun'][]=$value;
    		}
    		else if($th_tercover > 0){
    			$data['data']['>0tahun'][]=$value;
    		}
    		else if($th_tercover < 0 && $th_tercover > -4){
    			$data['data']['-3tahun'][]=$value;
    		}
    		else if($th_tercover < -3 && $th_tercover > -6){
    			$data['data']['-5tahun'][]=$value;
    		}
    		else if($th_tercover < -5 && $th_tercover > -11){
    			$data['data']['-10tahun'][]=$value;
    		}
    		else if($th_tercover < -10 ){
    			$data['data']['<-10tahun'][]=$value;
    		}
    	}
    	

    	$this->load->view('pemakaman/rincian_makam', $data);
    }
}

