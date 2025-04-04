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


    $data = array();
    $data['data'] = $this->db->query($query, $params)->result();
    #print_r($data['data']);die();
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

    $kpkp_bayar_tahunan=$this->m_model->selectas('kpkp_blok_makam_id', $recid, 'kpkp_bayar_tahunan');
    
    $pokok_iuran=$this->m_model->selectas('status','1','kpkp_pokok_iuran_makam');
    $data['pokok_iuran']=$pokok_iuran[0];
    //$penghuni_makam=$this->m_model->selectas2('kpkp_blok_makam_id', $recid,'deleted_at is NULL',NULL, 'kpkp_penghuni_makam', 'id', 'ASC');
    $penghuni_makam=$this->m_model->selectcustom("select * from kpkp_penghuni_makam where kpkp_blok_makam_id='".$recid."' && deleted_at is NULL order by sts DESC, id ASC");
    $data['penghuni_makam']=$penghuni_makam;
    $data['kpkp_bayar_tahunan']=$kpkp_bayar_tahunan;
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
    if($this->input->post('tgl_lahir') == '30-11-0' || $this->input->post('tgl_lahir') == '00-00-0000'){
      $param['tgl_lahir']='00-00-0000';
    }
    $param['tgl_meninggal']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_meninggal'))));
    if($this->input->post('tgl_meninggal') == '30-11-0' || $this->input->post('tgl_meninggal') == '00-00-0000'){
      $param['tgl_meninggal']='00-00-0000';
    }
    $param['tgl_dimakamkan']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_dimakamkan'))));
    if($this->input->post('tgl_dimakamkan') == '30-11-0' || $this->input->post('tgl_dimakamkan') == '00-00-0000'){
      $param['tgl_dimakamkan']='00-00-0000';
    }
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
    if($this->input->post('tgl_lahir') == '30-11-0' || $this->input->post('tgl_lahir') == '00-00-0000'){
      $param['tgl_lahir']='00-00-0000';
    }
    $param['tgl_meninggal']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_meninggal'))));
    if($this->input->post('tgl_meninggal') == '30-11-0' || $this->input->post('tgl_meninggal') == '00-00-0000'){
      $param['tgl_meninggal']='00-00-0000';
    }
    $param['tgl_dimakamkan']=date('Y-m-d', strtotime(clearText($this->input->post('tgl_dimakamkan'))));
    if($this->input->post('tgl_dimakamkan') == '30-11-0' || $this->input->post('tgl_dimakamkan') == '00-00-0000'){
      $param['tgl_dimakamkan']='00-00-0000';
    }

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
    $pokok_iuran=str_replace('.', '', $this->input->post('pokok_iuran') ) ;

    $pilih_perhitungan_saldo=$this->input->post('pilih_perhitungan_saldo');
    if($pilih_perhitungan_saldo==1){
      //ini bearti berdasarkan tahun pembayaran terakhir
      $tahun_pembayaran=$this->input->post('tahun_terakhir');
      $selisih_tahun_berajalan=$tahun_pembayaran - date('Y');
      //echo $pokok_iuran." "; echo($selisih_tahun_berajalan); die();
      $saldo_awal=$selisih_tahun_berajalan*$pokok_iuran;
      $param['saldo']=$saldo_awal;
      $param['tahun_tercover']=$tahun_pembayaran;
      $param['tgl_terakhir_bayar']=null;

    }
    else if($pilih_perhitungan_saldo==2){
      //ini langsung isi nominal yg tertera
      $param['saldo']=$this->input->post('nominal'); 
      //cari selisih/lebih tahun dari saldo terakhir
      $TahunTercover=countTahunTercover($pokok_iuran, $param['saldo'], date('Y'));
      $param['tahun_pembayaran']=$TahunTercover['tahun_tercover'];
      $param['tgl_terakhir_bayar']='-';
    }
    $u=$this->m_model->updateas('id',$kpkp_blok_makam_id, $param, 'kpkp_blok_makam');

    if($u){
      //buat mutasi transksinya
      $param2=array();
      $param2['type']=0;//saldo awal
      $param2['note']='Saldo awal';//saldo awal
      $param2['kpkp_blok_makam_id']=$kpkp_blok_makam_id;
      $param2['nominal']=$param['saldo'];//nominal saldo
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

  public function add_pembayaran(){
    $data=array();
    $param=array();
    $tgl_pembayaran=explode('-', clearText($this->input->post('tgl_pembayaran'))) ;
    $param['tgl_bayar']=$tgl_pembayaran[2].'-'.$tgl_pembayaran[1].'-'.$tgl_pembayaran[0];
    $param['nominal']=str_replace('.', '', clearText($this->input->post('nominal_pembayaran'))) ;
    $param['note']=clearText($this->input->post('metode_pembayaran'));
    $param['kpkp_blok_makam_id']=clearText($this->input->post('kpkp_blok_makam_id'));
    $param['created_at']=date('Y-m-d H:i:s');
    $param['created_by']=$this->session->userdata('userdata')->id;
    $param['type']=1;
    if($this->input->post('catatan') !='' && $this->input->post('catatan') !=NULL){
      $param['note']=clearText($this->input->post('catatan')).'('.$param['note'].')';
    }
    $i=$this->m_model->insertgetid($param, 'kpkp_bayar_tahunan');
    if($i){
      $this->session->set_flashdata('sts_add', '1');
      $this->session->set_flashdata('Title_add', 'Berhasil!');
      $this->session->set_flashdata('msg_add', 'Setor Iuran Makam!');
      $this->session->set_flashdata('class', 'iziToast-success');

      //lakukan update saldo akhir
      $saldo=$param['nominal'];
      $tahun_tercover= floor($param['nominal']/$this->input->post('pokok_iuran'));
      $tgl_terakhir_bayar= $param['tgl_bayar'];
      $u1="update kpkp_blok_makam set saldo = saldo+".$saldo.", tahun_tercover=tahun_tercover+".$tahun_tercover.", tgl_terakhir_bayar='".$tgl_terakhir_bayar."' where id='".$param['kpkp_blok_makam_id']."'";
      $qu1=$this->m_model->querycustom($u1);
    }
    else{
      $this->session->set_flashdata('sts_add', '0');
      $this->session->set_flashdata('Title_add', 'Gagal!');
      $this->session->set_flashdata('msg_add', 'Setor Iuran Makam!');
      $this->session->set_flashdata('class', 'iziToast-danger');
    }
    redirect(base_url().'Data_Blok_Makam/detail?id='.$param['kpkp_blok_makam_id']);
  }


  public function update_sts(){
    $data=array();
    $param=array();
    $param['sts']=$this->input->post('sts');
    $param['updated_at']=date('Y-m-d H:i:s');
    $param['updated_by']=$this->session->userdata('userdata')->id;
    $recid=$this->input->post('recid');

    $u=$this->m_model->updateas('id', $recid, $param, 'kpkp_penghuni_makam');
    $json=array('sts'=>0, 'title'=>'Oopps Maaf.. ','msg'=>"Status Makan Gagal diupdate" , 'class'=>"iziToast-danger");
    if($u){
      $json=array('sts'=>1, 'title'=>'Wow.. ','msg'=>"Status Makam Berhasil di perbarui!", 'class'=>"iziToast-success");
    }
    echo json_encode($json);



  }
}
