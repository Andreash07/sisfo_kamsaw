<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Report extends CI_Controller {



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



	function anggota_jemaat($type_report='reguler'){

		$data=array();
		$data['sts_angjem']='1';

		$where="";

		$param_active="?";

		if($this->input->get('sts_angjem') || $this->input->get('sts_angjem') =='0'){

			$param_active.="sts_anggota=".$this->input->get('sts_angjem')."&";

			$where.=" && A.sts_anggota = '".$this->input->get('sts_angjem')."'";
			$data['sts_angjem']=$this->input->get('sts_angjem');

		}else{
			//$param_active.="sts_anggota=1&";

			$where.=" && A.sts_anggota = '1'";
			//$data['sts_angjem']=$this->input->get('sts_angjem');
		}

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



		/*report baptis start*/

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

		/*report baptis end*/



		/*report sidi start*/

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



		if(!isset($_GET['sts_anggota'])) {
			$sts_anggota=1;
		}
		else if($this->input->get('sts_anggota') || $this->input->get('sts_anggota')==0 ){
			$sts_anggota=$this->input->get('sts_anggota');
			$param_active.="sts_anggota=".$this->input->get('sts_anggota')."&";
		}
		//die($sts_anggota);

		if($this->input->get('tgl_sidi')){

			$param_active.="tgl_sidi=".$this->input->get('tgl_sidi')."&";

			$date=convert_time_ymd($this->input->get('tgl_sidi'));

			$where.=" && A.tgl_sidi ='".clearText($date)."'";

		}

		switch ($type_report) {
			case 'reguler':
				// code...
				//null
				break;
			case 'baptis_sidi':
				// code...
				//$where.=" && A.sts_anggota ='1'";
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

		/*report sidi end*/



		$sql="select A.*, B.kwg_nama, B.kwg_alamat, C.hub_keluarga, B.id as kwg_id, B.kwg_telepon

				from anggota_jemaat A

				join keluarga_jemaat B on B.id = A.kwg_no

				join ags_hub_kwg C on C.idhubkel = A.hub_kwg

				where A.id >0 && A.status=1 ".$where.""; //A.status=1 bearti tidak pernah di delete //&& A.sts_anggota='".$sts_anggota."' 


		$group_by="  ";

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

        

        $data_jemaat=$this->m_model->selectcustom($sql." ".$group_by." ".$field_order." ".$order_by); 
        //die($sql." ".$group_by." ".$field_order." ".$order_by);



        $data['TotalOfData']=count($data_jemaat);

        //TotalOfProduct($query_product." ".$where." ".$group_by." ".$field_order." ".$order_by);

        //$data['TotalOfPage']=TotalOfPage($data['TotalOfProduct'], 30);//30 is limit item per page

        if(!$this->input->get('page')){

            $page_active=1;

        }else{

            $page_active=$this->input->get('page');

        }
        //die($param_active);
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

		switch ($type_report) {

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

						$view='report/print_anggota_jemaat';

						break;

					default:

						// code...

						$view='report/anggota_jemaat';

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

						$view='report/print_anggota_jemaat_sidi';

						break;

					default:

						// code...

						$view='report/anggota_jemaat_sidi';

						break;

				}

				$this->load->view($view,$data);

				break;

			default:

				// code...

				$this->load->view('report/anggota_jemaat',$data);

				break;

		}

	}

}

