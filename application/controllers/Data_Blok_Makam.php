<?php

class Data_Blok_Makam extends CI_Controller
{
  public function index()
  {
    if ($this->input->server('REQUEST_METHOD') === 'POST') {
      $this->add();
      return;
    }

    if ($this->input->server('REQUEST_METHOD') === 'DELETE') {
      $this->delete();
      return;
    }

    if ($this->input->server('REQUEST_METHOD') === 'PATCH') {
      $this->edit();
      return;
    }

    // filter by blok & kavling
    $blok = $this->input->get('blok');
    $kavling= $this->input->get('kavling');
    $query = 'SELECT * FROM kpkp_blok_makam WHERE deleted = 0';
    $params = array();

    if ($blok) {
      $query .= ' AND blok = ?';
      $params[] = $blok;
    }

    if ($kavling) {
      $query .= ' AND kavling = ?';
      $params[] = $kavling;
    }

    $data = array();
    $data['data'] = $this->db->query($query, $params)->result();
    $this->load->view('kpkp/data_blok_makam', $data);
  }

  private function add()
  {
    $lokasi = $this->input->post('lokasi');
    $blok = $this->input->post('blok');
    $kavling = $this->input->post('kavling');

    $query = 'INSERT INTO kpkp_blok_makam (lokasi, blok, kavling) VALUES (?, ?, ?)';
    $params = array($lokasi, $blok, $kavling);
    $result = $this->db->query($query, $params);

    if ($result) {
      $response = array('status' => 'success', 'message' => 'Data added successfully');
    } else {
      $response = array('status' => 'failed', 'message' => 'Failed to add data');
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  private function delete()
  {
    $id = $this->input->input_stream('id');
    $query = 'UPDATE kpkp_blok_makam SET deleted = 1 WHERE id = ' . $id;
    $result = $this->db->query($query);

    if ($result) {
      $response = array('status' => 'success', 'message' => 'Data deleted successfully');
    } else {
      $response = array('status' => 'failed', 'message' => 'Failed to delete data');
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  public function edit()
  {
    $id = $this->input->input_stream('id');
    $lokasi = $this->input->input_stream('lokasi');
    $blok = $this->input->input_stream('blok');
    $kavling = $this->input->input_stream('kavling');

    $query = 'UPDATE kpkp_blok_makam SET lokasi = ?, blok = ?, kavling = ? WHERE id = ?';
    $params = array($lokasi, $blok, $kavling, $id);
    $result = $this->db->query($query, $params);

    if ($result) {
      $response = array('status' => 'success', 'message' => 'Data updated successfully');
    } else {
      $response = array('status' => 'failed', 'message' => 'Failed to update data');
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }
  public function detail()
  {
    $data=array();
    $recid=$this->input->get('id');
    $makam=$this->m_model->selectas('id', $recid, 'kpkp_blok_makam');
    $pokok_iuran=$this->m_model->selectas('status','1','kpkp_pokok_iuran_makam');
    $data['pokok_iuran']=$pokok_iuran[0];
    $penghuni_makam=$this->m_model->selectas2('kpkp_blok_makam_id', $recid,'deleted_at is NULL',NULL, 'kpkp_penghuni_makam', 'id', 'ASC');
    $data['penghuni_makam']=$penghuni_makam;
    $data['makam']=array('lokasi'=>'Tidak diketahui!', 'blok'=>'0', 'kavling'=>'0');
    if(count($makam)>0){
      $data['makam']=$makam[0];
    }
    $this->load->view('kpkp/blok_detail', $data);
  }

  public function delete_penghuni_makam(){
    $data=array();
    $param=array();

    $auth=$this->input->get('auth'); //ini blok makam id
    $token=$this->input->get('token'); //id penghuni makam
    $param['deleted_at']=date('Y-m-d H:i:s');
    $param['deleted_by']=$this->session->userdata('userdata')->id;
    $udelete=$this->m_model->updateas('MD5(id)', $token, $param, 'kpkp_penghuni_makam');
    if($udelete){
      //get data penghuni terakhir
      $spenghuni=$this->m_model->selectcustom("select * from kpkp_penghuni_makam where md5(kpkp_blok_makam_id)='".$auth."' && deleted_at is NULL order by id ASC "); //limit 1 

      $param2=array();
      $param2['sts_keanggotaan_makam']=0;
      $param2['keanggotaan_makam']=NULL;
      $param2['update_at']=date('Y-m-d H:i:s');
      $param2['jumlah_makam']=0;
      foreach ($spenghuni as $key => $value) {
        // code...
        //ini bearti penghuni makam terakhir
        $param2['sts_keanggotaan_makam']=$value->sts_keanggotaan;
        $param2['keanggotaan_makam']=$value->asal_gereja;
        $param2['update_at']=date('Y-m-d H:i:s');
        $param2['jumlah_makam']=$param2['jumlah_makam']+1;
      }
      $ukpkp_blok_makam=$this->m_model->updateas('md5(id)', $auth, $param2, 'kpkp_blok_makam');

      $this->session->set_flashdata('sts_add', '1');
      $this->session->set_flashdata('Title_add', 'Berhasil!');
      $this->session->set_flashdata('msg_add', 'Data Penghuni Makam Dihapus!');
      $this->session->set_flashdata('class', 'iziToast-success');
      redirect($_SERVER['HTTP_REFERER']);

    }


  }

  public function save_penghuni_makam()
  {
    $data=array();
    //print_r($this->input->post()); die();
    $param=array();
    $param['kpkp_blok_makam_id']=clearText($this->input->post('kpkp_blok_makam_id'));
    $param['gender']=clearText($this->input->post('gender'));
    $param['nama']=clearText($this->input->post('nama_jenazah'));
    $param['tgl_lahir']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_lahir'))));
    $param['tgl_meninggal']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_meninggal'))));
    $param['tgl_dimakamkan']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_dimakamkan'))));
    $param['sts_keanggotaan']=clearText($this->input->post('sts_keanggotaan_jenazah'));
    $param['asal_gereja']=clearText($this->input->post('asal_gereja_jenazah'));
    $param['nama_ahli_waris']=clearText($this->input->post('nama_ahli_waris'));
    $param['no_telp_ahli_waris']=clearText($this->input->post('no_telp_ahli_waris'));
    $param['alamat_ahli_waris']=clearText($this->input->post('alamat_ahli_waris'));
    $param['gereja_asal_ahli_waris']=clearText($this->input->post('gereja_asal_ahli_waris'));
    $param['created_at']=date('Y-m-d H:i:s');
    $param['created_by']=$this->session->userdata('userdata')->id;

    $id_insert=$this->m_model->insertgetid($param, 'kpkp_penghuni_makam');
    if($id_insert>0){
      //get jumlah makan
      $count=$this->m_model->selectcustom("select id as num_makam from kpkp_penghuni_makam where kpkp_blok_makam_id='".$param['kpkp_blok_makam_id']."' && deleted_at is NULL");
      //update data di blok makam
      $param2=array();
      $param2['sts_keanggotaan_makam']=$param['sts_keanggotaan'];
      $param2['keanggotaan_makam']=$param['asal_gereja'];
      $param2['update_at']=date('Y-m-d H:i:s');
      $param2['jumlah_makam']=count($count);
      $u=$this->m_model->updateas('id', $param['kpkp_blok_makam_id'], $param2, 'kpkp_blok_makam');

      $this->session->set_flashdata('sts_add', '1');
      $this->session->set_flashdata('Title_add', 'Berhasil!');
      $this->session->set_flashdata('msg_add', 'Data Penghuni Makam Ditambahkan!');
      $this->session->set_flashdata('class', 'iziToast-success');
    }else{
      $this->session->set_flashdata('sts_add', '-1');
      $this->session->set_flashdata('Title_add', 'Gagal!');
      $this->session->set_flashdata('msg_add', 'Data Penghuni Makam Ditambahkan!');
      $this->session->set_flashdata('class', 'iziToast-danger');
    }
    redirect(base_url().'Data_Blok_Makam/detail?id='.$param['kpkp_blok_makam_id']);
    //$this->load->view('kpkp/blok_detail', $data);
  }


  public function view_penghuni_makam(){
    $data=array();
    $param=array();
    $recid=$this->input->get('auth');
    $penghuni_makam=$this->m_model->selectas("MD5(CONCAT('JHk1812#',id))", $recid, "kpkp_penghuni_makam");
    $data['penghuni_makam']=$penghuni_makam;
    $this->load->view('kpkp/form_ubah_penghuni_makam', $data);
  }


  public function update_penghuni_makam()
  {
    $data=array();
    //print_r($this->input->post()); die();
    $recid=$this->input->post('recid');
    $kpkp_blok_makam_id=clearText($this->input->post('kpkp_blok_makam_id'));
    $param=array();
    $param['gender']=clearText($this->input->post('gender'));
    $param['nama']=clearText($this->input->post('nama_jenazah'));
    $param['tgl_lahir']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_lahir'))));
    $param['tgl_meninggal']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_meninggal'))));
    $param['tgl_dimakamkan']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_dimakamkan'))));
    $param['sts_keanggotaan']=clearText($this->input->post('sts_keanggotaan_jenazah'));
    $param['asal_gereja']=clearText($this->input->post('asal_gereja_jenazah'));
    $param['nama_ahli_waris']=clearText($this->input->post('nama_ahli_waris'));
    $param['no_telp_ahli_waris']=clearText($this->input->post('no_telp_ahli_waris'));
    $param['alamat_ahli_waris']=clearText($this->input->post('alamat_ahli_waris'));
    $param['gereja_asal_ahli_waris']=clearText($this->input->post('gereja_asal_ahli_waris'));
    $param['updated_at']=date('Y-m-d H:i:s');
    $param['updated_by']=$this->session->userdata('userdata')->id;

    $id_insert=$this->m_model->updateas('id', $recid, $param, 'kpkp_penghuni_makam');
    if($id_insert>0){
      //get jumlah makan
      $count=$this->m_model->selectcustom("select id as num_makam from kpkp_penghuni_makam where kpkp_blok_makam_id='".$kpkp_blok_makam_id."' && deleted_at is NULL order by id ASC");
      //update data di blok makam
      $param2=array();
      $param2['sts_keanggotaan_makam']=$param['sts_keanggotaan'];
      $param2['keanggotaan_makam']=$param['asal_gereja'];
      $param2['update_at']=date('Y-m-d H:i:s');
      $param2['jumlah_makam']=count($count);
      $u=$this->m_model->updateas('id', $kpkp_blok_makam_id, $param2, 'kpkp_blok_makam');

      $this->session->set_flashdata('sts_add', '1');
      $this->session->set_flashdata('Title_add', 'Berhasil!');
      $this->session->set_flashdata('msg_add', 'Data Penghuni Makam Diubah!');
      $this->session->set_flashdata('class', 'iziToast-success');
    }else{
      $this->session->set_flashdata('sts_add', '-1');
      $this->session->set_flashdata('Title_add', 'Gagal!');
      $this->session->set_flashdata('msg_add', 'Data Penghuni Makam Diubah!');
      $this->session->set_flashdata('class', 'iziToast-danger');
    }
    redirect(base_url().'Data_Blok_Makam/detail?id='.$kpkp_blok_makam_id);
    //$this->load->view('kpkp/blok_detail', $data);
  }

  public function aktifasi_dompet_iuran_makam()
  {
    $data=array();
    $param=array();
    $param['sts_dompet_digital']='1';
    $param['update_at']=date('Y-m-d H:i:s');
    $param['update_by']=$this->session->userdata('userdata')->id;

    //get pokok_iuran_makam
    //$pokok_iuran=$this->m_model->select('kpkp_pokok_iuran_makam');
    $kpkp_blok_makam_id=$this->input->post('kpkp_blok_makam_id');
    $pokok_iuran=$this->input->post('pokok_iuran');

    $pilih_perhitungan_saldo=$this->input->post('pilih_perhitungan_saldo');
    if($pilih_perhitungan_saldo==1){
      //ini bearti berdasarkan tahun pembayaran terakhir
      $tahun_pembayaran=$this->input->post('tahun_terakhir');
      $selisih_tahun_berajalan=$tahun_pembayaran - date('Y');
      $saldo_awal=$selisih_tahun_berajalan*$pokok_iuran;
      $param['saldo']=$saldo_awal;
      $param['tahun_tercover']=$tahun_pembayaran;
      $param['tgl_terakhir_bayar']='-';

    }
    else if($pilih_perhitungan_saldo==2){
      //ini langsung isi nominal yg tertera
      $param['saldo']=$this->input->post('nominal'); 
      //cari selisih/lebih tahun dari saldo terakhir
      $TahunTercover=countTahunTercover($pokok_iuran, $param['saldo'], date('Y'));
      $param['$tahun_pembayaran']=$TahunTercover['tahun_tercover'];
      $param['tgl_terakhir_bayar']='-';
    }
    $u=$this->m_model->updateas('id',$kpkp_blok_makam_id, $param, 'kpkp_blok_makam');

    if($u){
      //buat mutasi transksinya
      $param2=array();
      $param2['type']=0;//saldo awal
      $param2['note']='Saldo awal';//saldo awal
      $param2['kpkp_blok_makam_id']=$kpkp_blok_makam_id;
      $param2['saldo']=$param['saldo'];//nominal saldo
      $param2['tgl_bayar']=date('Y-m-d');//tgl input data
      $param2['created_at']=date('Y-m-d H:i:s');//tgl input data
      $param2['created_by']=$this->session->userdata('userdata')->id;
      $imutasi=$this->m_model->insertgetid($param2, 'kpkp_bayar_tahunan');

      $this->session->set_flashdata('sts_add', '1');
      $this->session->set_flashdata('Title_add', 'Berhasil!');
      $this->session->set_flashdata('msg_add', 'Aktifasi Dompet Digital Iuran Perawatan Makam!');
      $this->session->set_flashdata('class', 'iziToast-success');

      if(!$imutasi){
        $this->session->set_flashdata('sts_add', '-1');
        $this->session->set_flashdata('Title_add', 'Gagal!');
        $this->session->set_flashdata('msg_add', 'Memasukan saldo awal pada Mutasi Iuran!');
        $this->session->set_flashdata('class', 'iziToast-danger');
      }
    }
    else{
      $this->session->set_flashdata('sts_add', '-1');
      $this->session->set_flashdata('Title_add', 'Gagal!');
      $this->session->set_flashdata('msg_add', 'Aktifasi Dompet Digital Iuran Perawatan Makam!');
      $this->session->set_flashdata('class', 'iziToast-danger');
    }

    redirect(base_url().'Data_Blok_Makam/detail?id='.$kpkp_blok_makam_id);


  }


}
