<?php

class Ulasan_Pengguna extends CI_Controller
{
  public function index()
  {
    $query = $this->db->get('ulasan_user');
    $data['ulasan'] = $query->result();
    $this->load->view('frontend/mjppj/ulasan_pengguna', $data);
  }
}

?>