<?php
defined('BASEPATH') or exit('No direct script access allowed');

Class Mentor_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_jurusan() {
        $this->db->select('*');
        $this->db->from('jurusan');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_activities_by_jurusan($id_jurusan) {
        $this->db->select('daily_activities.*, user.name_user, user.id_jurusan');
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->from('daily_activities');
        $this->db->join('user', 'user.id_user = daily_activities.user_id');
        $this->db->order_by('daily_activities.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_absensi_by_jurusan($id_jurusan) {
        $this->db->select('user_absensi.*, user.name_user, user.school, user.id_jurusan');
        $this->db->from('user_absensi');
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->order_by('user_absensi.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_student_by_jurusan($id_jurusan) {        
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->where('id_role', 3);
        $this->db->order_by('user.date_created', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cek_absen_hari_ini($id_jurusan) {
        $date = date('Y-m-d'); 

        $this->db->select('user_absensi.*, user.id_jurusan');
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('date_in', $date);
        $this->db->where('id_jurusan', $id_jurusan);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function cek_aktivitas_hari_ini($id_jurusan) {
        $date = date('Y-m-d'); 

        $this->db->select('daily_activities.*, user.id_jurusan');
        $this->db->from('daily_activities');
        $this->db->join('user', 'user.id_user = daily_activities.user_id');
        $this->db->where('date_in', $date);
        $this->db->where('id_jurusan', $id_jurusan);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_role_and_jurusan($id_jurusan) {
        $this->db->where('id_role', 3);
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->where('is_active', 1);
        $query = $this->db->get('user');
        return $query->result_array();
    }

    public function get_all_daily_absensi($id_jurusan) {
        $date = date('Y-m-d');  
        
        $this->db->select('user_absensi.*, user.name_user, user.school, user.is_active, user.id_user, user.id_jurusan');
        $this->db->from('user_absensi');
        $this->db->where('date_in', $date);
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_all_daily_activities($id_jurusan) {
        $date = date('Y-m-d'); 
        
        $this->db->select('daily_activities.*, user.name_user, user.school, user.is_active, user.id_user, user.id_jurusan'); // Seleksi kolom yang diinginkan
        $this->db->from('daily_activities');
        $this->db->where('date_in', $date);
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->join('user', 'user.id_user = daily_activities.user_id');
        $this->db->order_by(' daily_activities.date_job', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    
    

}