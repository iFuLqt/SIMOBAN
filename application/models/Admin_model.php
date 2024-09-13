<?php
defined('BASEPATH') or exit('No direct script access allowed');

Class Admin_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_data_activities() {
        $this->db->select('daily_activities.*, user.name_user'); // Seleksi kolom yang diinginkan
        $this->db->from('daily_activities');
        $this->db->join('user', 'user.id_user = daily_activities.user_id'); // Lakukan join jika diperlukan
        $this->db->order_by('daily_activities.date_job', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_all_data_absensi() {
        $this->db->select('user_absensi.*, user.name_user, user.school'); // Seleksi kolom yang diinginkan
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id'); // Lakukan join jika diperlukan
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_data_student() {
        $this->db->select('*'); // Seleksi kolom yang diinginkan
        $this->db->from('user');
        $this->db->where('id_role', 3);
        $this->db->order_by('user.date_created', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cek_absen_hari_ini() {
        $date = date('Y-m-d'); 

        $this->db->where('date_in', $date);
        $query = $this->db->get('user_absensi');

        return $query->result_array();
    }
    public function cek_aktivitas_hari_ini() {
        $date = date('Y-m-d'); 

        $this->db->where('date_in', $date);
        $query = $this->db->get('daily_activities');

        return $query->result_array();
    }

    public function get_role_3() {
        $this->db->where('id_role', 3);
        $this->db->where('is_active', 1);
        $query = $this->db->get('user');
        return $query->result_array();
    }

    public function get_role_2() {
        $this->db->where('id_role', 2);
        $this->db->where('is_active', 1);
        $query = $this->db->get('user');
        return $query->result_array();
    }

    public function get_all_daily_absensi() {
        $date = date('Y-m-d');

        $this->db->select('user_absensi.*, user.name_user, user.school, user.is_active, user.id_user'); // Seleksi kolom yang diinginkan
        $this->db->from('user_absensi');
        $this->db->where('date_in', $date);
        $this->db->join('user', 'user.id_user = user_absensi.user_id'); // Lakukan join jika diperlukan
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_jurusan() {
        $this->db->select('*');
        $this->db->from('jurusan');
        $query = $this->db->get();
        return $query->result_array();
    }
    

}