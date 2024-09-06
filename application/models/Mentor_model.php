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
        $this->db->select('daily_activities.*, user.name_user, user.id_jurusan'); // Seleksi kolom yang diinginkan
        $this->db->from('daily_activities');
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->join('user', 'user.id_user = daily_activities.user_id'); // Lakukan join jika diperlukan
        $this->db->order_by('daily_activities.date_job', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_absensi_by_jurusan($id_jurusan) {
        $this->db->select('user_absensi.*, user.name_user, user.school, user.id_jurusan'); // Seleksi kolom yang diinginkan
        $this->db->from('user_absensi');
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->join('user', 'user.id_user = user_absensi.user_id'); // Lakukan join jika diperlukan
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_student_by_jurusan($id_jurusan) {        
        $this->db->select('*');
        $this->db->from('user'); // Ganti dengan nama tabel siswa Anda jika berbeda
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->where('id_role', 3);
        $this->db->order_by('user.date_created', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cek_absen_hari_ini() {
        $start_of_day = strtotime("today midnight"); // Mendapatkan timestamp untuk awal hari ini 00:00
        $end_of_day = strtotime("tomorrow midnight") - 1; // Mendapatkan timestamp untuk akhir hari ini 23:59 

        $this->db->where('date_in >=', $start_of_day);
        $this->db->where('date_in <=', $end_of_day);
        $query = $this->db->get('user_absensi');

        return $query->result_array();
    }
    public function cek_aktivitas_hari_ini() {
        $start_of_day = strtotime("today midnight"); // Mendapatkan timestamp untuk awal hari ini 00:00
        $end_of_day = strtotime("tomorrow midnight") - 1; // Mendapatkan timestamp untuk akhir hari ini 23:59 

        $this->db->where('date_job >=', $start_of_day);
        $this->db->where('date_job <=', $end_of_day);
        $query = $this->db->get('daily_activities');

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
        $start_of_day = strtotime("today midnight"); // Mendapatkan timestamp untuk awal hari ini 00:00
        $end_of_day = strtotime("tomorrow midnight") - 1; // Mendapatkan timestamp untuk akhir hari ini 23:59 
        
        $this->db->select('user_absensi.*, user.name_user, user.school, user.is_active, user.id_user, user.id_jurusan'); // Seleksi kolom yang diinginkan
        $this->db->from('user_absensi');
        $this->db->where('date_in >=', $start_of_day);
        $this->db->where('date_in <=', $end_of_day);
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->join('user', 'user.id_user = user_absensi.user_id'); // Lakukan join jika diperlukan
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_all_daily_activities($id_jurusan) {
        $start_of_day = strtotime("today midnight"); // Mendapatkan timestamp untuk awal hari ini 00:00
        $end_of_day = strtotime("tomorrow midnight") - 1; // Mendapatkan timestamp untuk akhir hari ini 23:59 
        
        $this->db->select('daily_activities.*, user.name_user, user.school, user.is_active, user.id_user, user.id_jurusan'); // Seleksi kolom yang diinginkan
        $this->db->from('daily_activities');
        $this->db->where('date_job >=', $start_of_day);
        $this->db->where('date_job <=', $end_of_day);
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->join('user', 'user.id_user = daily_activities.user_id'); // Lakukan join jika diperlukan
        $this->db->order_by(' daily_activities.date_job', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    
    

}