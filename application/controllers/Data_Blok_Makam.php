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
<<<<<<< Updated upstream
=======

  public function detail()
  {
    $data=array();
    $recid=$this->input->get('id');
    $makam=$this->m_model->selectas('id', $recid, 'kpkp_blok_makam');
    $data['makam']=array('lokasi'=>'Tidak diketahui!', 'blok'=>'0', 'kavling'=>'0');
    if(count($makam)>0){
      $data['makam']=$makam[0];
    }
    $this->load->view('kpkp/blok_detail', $data);
  }
>>>>>>> Stashed changes
}
