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

    public function cek_hadir_hari_ini() {
        $date = date('Y-m-d'); 

        $this->db->select('user_absensi.information, user.id_jurusan');
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('information', 1);
        $this->db->where('date_in', $date);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function cek_sakit_hari_ini() {
        $date = date('Y-m-d'); 

        $this->db->select('user_absensi.information, user.id_jurusan');
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('information', 2);
        $this->db->where('date_in', $date);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function cek_izin_hari_ini() {
        $date = date('Y-m-d'); 

        $this->db->select('user_absensi.information, user.id_jurusan');
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('information', 3);
        $this->db->where('date_in', $date);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function cek_terlambat_hari_ini() {
        $date = date('Y-m-d'); 

        $this->db->select('user_absensi.information, user.id_jurusan');
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('note', 'Terlambat');
        $this->db->where('date_in', $date);
        $query = $this->db->get();

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

    public function get_absensi_by_date($tanggal_awal, $tanggal_akhir) {
        $this->db->select('user.name_user, user.school, user_absensi.*');
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $this->db->where('date_in >=', $tanggal_awal);
            $this->db->where('date_in <=', $tanggal_akhir);
        }
        $this->db->order_by('user_absensi.date_in', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_activities_by_date($tanggal_awal, $tanggal_akhir) {
        $this->db->select('user.name_user, user.school, daily_activities.*');
        $this->db->from('daily_activities');
        $this->db->join('user', 'user.id_user = daily_activities.user_id');
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $this->db->where('date_job >=', $tanggal_awal);
            $this->db->where('date_job <=', $tanggal_akhir);
        }
        $this->db->order_by('daily_activities.date_job', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_absensi_by_userid($user_id) {
        $this->db->select('user.name_user, user.school, user_absensi.*');
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('id_user', $user_id);
        $this->db->order_by('user_absensi.date_in', 'DESC');
    
        $query = $this->db->get(); // Sesuaikan nama tabel
        return $query->result_array();   
    }

    public function get_absensi_by_date_range($user_id, $tanggal_awal, $tanggal_akhir){
        $this->db->select('user.name_user, user.school, user_absensi.*');
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('id_user', $user_id);
        $this->db->where('date_in >=', $tanggal_awal);
        $this->db->where('date_in <=', $tanggal_akhir);
        $this->db->order_by('user_absensi.date_in', 'DESC');
    
        $query = $this->db->get(); // Sesuaikan nama tabel
        return $query->result_array();
    }

    public function get_all_activities_by_userid($user_id){
        $this->db->select('user.name_user, user.school, daily_activities.*');
        $this->db->from('daily_activities');
        $this->db->join('user', 'user.id_user = daily_activities.user_id');
        $this->db->where('id_user', $user_id);
        $this->db->order_by('daily_activities.date_job', 'DESC');
    
        $query = $this->db->get(); // Sesuaikan nama tabel
        return $query->result_array();   
    }

    public function get_activities_by_date_range($user_id, $tanggal_awal, $tanggal_akhir){
        $this->db->select('user.name_user, user.school, daily_activities.*');
        $this->db->from('daily_activities');
        $this->db->join('user', 'user.id_user = daily_activities.user_id');
        $this->db->where('id_user', $user_id);
        $this->db->where('date_job >=', $tanggal_awal);
        $this->db->where('date_job <=', $tanggal_akhir);
        $this->db->order_by('daily_activities.date_job', 'DESC');
    
        $query = $this->db->get(); // Sesuaikan nama tabel
        return $query->result_array();
    }

    public function get_teacher() {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id_role', 4);

        return $this->db->get()->result_array();
    }

    public function get_siswa_by_id_guru($id_guru) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('user_teacher', 'user_teacher.user_id = user.id_user');
        $this->db->where('user_teacher.teacher_id', $id_guru);
        $this->db->where('user.is_active', 1);
        $this->db->order_by('user.id_user', 'DESC');
    
        return $this->db->get()->result_array();
    }
    public function get_guru_by_id_siswa($id_user) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('user_teacher', 'user_teacher.teacher_id = user.id_user');
        $this->db->where('user_teacher.user_id', $id_user);
        $this->db->where('user.is_active', 1);
        $this->db->order_by('user.id_user', 'DESC');
    
        return $this->db->get()->result_array();
    }
    

}