<?php

Class M_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'file'));
        $this->load->library('session');
    }

    function exist($data, $dbase) {
        $this->db->select('id');
        foreach ($data as $key => $val) {
            $this->db->where($key, $val);
        }

        $query = $this->db->get($dbase);
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    function create($data, $dbase) {
        if ($this->db->insert($dbase, $data)) {
            return 1;
        } else {
            return 0;
        }
    }

    function insertgetid($data, $dbase) {
        $this->db->insert($dbase, $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    function select($dbase, $colom_order=null, $order_type=null) {
        $this->db->select('*');
        if($colom_order!=null){
            if($order_type ==null){
                $order_type='ASC';
            }
            $this->db->order_by($colom_order, $order_type);
        }
        $query = $this->db->get($dbase);

        return $query->result();
    }

    function selectaslike($as, $data, $dbase, $colom_order=null, $order_type=null) {
        $this->db->select('*');
        $this->db->like($as, clearText($data));
        if($colom_order!=null && $order_type!=null){
            $this->db->order_by($colom_order, $order_type);
        }
        $query = $this->db->get($dbase);
        return $query->result();
    }

    function selectasnotlikemax($as, $like, $max, $dbase) {
        $this->db->select("*");
        $this->db->where($as.'!='.clearText($like));
        $this->db->limit($max);
        $query = $this->db->get($dbase);
        return $query->result();
    }

    function selectmax($max, $dbase) {
        $this->db->select("*");
        $this->db->limit($max);
        $query = $this->db->get($dbase);
        return $query->result();
    }

    function selectasmax($max, $where, $dbase, $key_order=null, $type_order=null) {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->limit($max);
        if($key_order!=null){
            if($type_order ==null){
                $type_order='ASC';
            }
            $this->db->order_by($key_order, $type_order);
        }
        $query = $this->db->get($dbase);
        return $query->result();
    }

    function selectas($as, $data, $dbase, $key_order=null, $type_order=null) {
        $this->db->select('*');
        $this->db->where($as, clearText($data));
        if($key_order!=null){
            if($type_order ==null){
                $type_order='ASC';
            }
            $this->db->order_by($key_order, $type_order);
        }
        $query = $this->db->get($dbase);

        return $query->result();
    }

    function selectasgroup($as, $data, $group, $dbase, $key_order=null, $type_order=null) {
        $this->db->select('*');
        $this->db->where($as, clearText($data));
        $this->db->group_by($group);
        if($key_order !=null){
            if($type_order ==null){
                $type_order='ASC';
            }
            $this->db->order_by(strtolower($key_order), $type_order);
        }
        $query = $this->db->get($dbase);

        return $query->result();
    }

    function selectas2($as, $data, $as2, $data2, $dbase, $key_order=null, $type_order=null) {
        $this->db->select('*');
        $this->db->where($as, clearText($data));
        $this->db->where($as2, clearText($data2));
        if($key_order !=null){
            if($type_order ==null){
                $type_order='ASC';
            }
            $this->db->order_by(strtolower($key_order), $type_order);
        }
        $query = $this->db->get($dbase);

        return $query->result();
    }

    function selectas3($as, $data, $as2, $data2, $as3, $data3, $dbase, $key_order=null, $type_order=null) {
        $this->db->select('*');
        $this->db->where($as, clearText($data));
        $this->db->where($as2, clearText($data2));
        $this->db->where($as3, clearText($data3));
        $query = $this->db->get($dbase);

        return $query->result();
    }

    function selectas4($as, $data, $as2, $data2, $dbase, $custom_query=null) {
        $this->db->select('*');
        $this->db->where($as, clearText($data));
        $this->db->where($as2, clearText($data2));
        $this->db->where($as3, clearText($data3));
        $this->db->where($custom_query);
        $query = $this->db->get($dbase);

        return $query->result();
    }

    function selectcustom($query) {
        $query = $this->db->query($query);

        return $query->result();
    }

    function querycustom($query) {
        $query = $this->db->query($query);
        if($query){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function updateas($as, $asid, $data, $dbase) {
        $this->db->where($as, clearText($asid));
        if ($this->db->update($dbase, $data)) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateas2($as, $asid, $as2, $asid2, $data, $dbase) {
        $this->db->where($as, clearText($asid));
        $this->db->where($as2, clearText($asid2));
        if ($this->db->update($dbase, $data)) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateas3($as, $asid, $as2, $asid2, $as3, $asid3, $data, $dbase) {
        $this->db->where($as, clearText($asid));
        $this->db->where($as2, clearText($asid2));
        $this->db->where($as3, clearText($asid3));
        if ($this->db->update($dbase, $data)) {
            return 1;
        } else {
            return 0;
        }
    }

    function selecteng($dbase) {
        $this->db->select('*');
        $this->db->where("lang", "eng");
        $query = $this->db->get($dbase);

        return $query->result();
    }

    function selectaslang($as, $data, $dbase) {
        $this->db->select('*');
        $this->db->where($as, clearText($data));
        if (get_cookie('lang_is') === 'en') {
            $this->db->where('lang', 'en');
        } else {
            $this->db->where('lang', 'id');
        }
        $query = $this->db->get($dbase);

        return $query->result();
    }

    function selectaslang2($as, $data, $as2, $data2, $by, $dbase) {
        $this->db->select('*');
        $this->db->where($as, $data);
        $this->db->where($as2, $data2);
        if (get_cookie('lang_is') === 'en') {
            $this->db->where('lang', 'en');
        } else {
            $this->db->where('lang', 'id');
        }
        $query = $this->db->get($dbase);

        return $query->result();
    }

    function updateall($data, $dbase) {
        if ($this->db->update($dbase, $data)) {
            return 1;
        } else {
            return 0;
        }
    }

    function deleteas($as, $data, $dbase) {
        $this->db->where($as, $data);
        if ($this->db->delete($dbase)) {
            return 1;
        } else {
            return 0;
        }
    }
    function deleteas2($as, $data, $as2, $data2, $dbase) {
        $this->db->where($as, $data);
        $this->db->where($as2, $data2);
        if ($this->db->delete($dbase)) {
            return 1;
        } else {
            return 0;
        }
    }

    function loginData($data) {
        $condition = "email ="."'".$data['email']."' AND "."password ="."'".md5($data['password'])
            ."' AND "."user_role ="."'".$data['user_role']."'";
        $this->db->select('*');
        $this->db->where($condition);
        $this->db->where('active', 1);
        $this->db->limit(1);
        $query = $this->db->get('user');
        return $query->result();
    }

    function loginSession($data) {
        $condition = "email ="."'".$data['email']."' AND "."password ="."'".md5($data['password'])
            ."' AND "."user_role ="."'".$data['user_role']."'";
        $this->db->select('*');
        $this->db->where($condition);
        $this->db->where('active', 1);
        $this->db->limit(1);
        $query = $this->db->get('user');
        $row = $query->row();
        if ($query->num_rows() == 1) {
            $sess_data = array(
                'user_data' => $query->row(),
            );
            $this->session->set_userdata($sess_data);

            return 1;
        } else {
            return 0;
        }
    }

    function updateSession($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get('user');
        $row = $query->row();
        if ($query->num_rows() == 1) {
            $sess_data = array(
                'user_data' => $query->row(),
            );
            $this->session->set_userdata($sess_data);

            return 1;
        } else {
            return 0;
        }
    }

    function loginadmin($data) {
        $condition = "email ="."'".$data['email']."' AND "."password ="."'".md5($data['password'])
            ."'";
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        $row   = $query->row();
        if ($query->num_rows() == 1) {
            $sess_data = array(
                'admin'      => 1,
                'admin_data' => $query->row(),
            );
            $this->session->set_userdata($sess_data);

            return 1;
        } else {
            return 0;
        }
    }

//==================================
}

?>