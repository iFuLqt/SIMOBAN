<?php
defined('BASEPATH') or exit('No direct script access allowed');

Class Teacher_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_siswa() {
        $this->db->select('*');
        $this->db->from('user');
        // Left Join untuk memastikan siswa yang belum ada di tabel user_teacher juga muncul
        $this->db->join('user_teacher', 'user_teacher.user_id = user.id_user', 'left');
        $this->db->where('user.id_role', 3); // Kondisi untuk siswa (role = 4)
        $this->db->where('user_teacher.user_id IS NULL'); // Cek jika siswa belum ada di user_teacher
        $this->db->where('user.is_active', 1); // Hanya siswa yang aktif
        $this->db->order_by('user.id_user', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    public function get_guru_siswa($id_guru) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('user_teacher', 'user_teacher.user_id = user.id_user');
        $this->db->where('user_teacher.teacher_id', $id_guru);
        $this->db->where('user.is_active', 1);
        $this->db->order_by('user.id_user', 'DESC');
    
        return $this->db->get()->result_array();
    }

    public function get_absensi_siswa($id_guru) {
        $this->db->select('user.name_user, user.school, user_absensi.date_in, user_absensi.time, user_absensi.time_out, user_absensi.information, user_absensi.note');
        $this->db->from('user_absensi');
        $this->db->join('user_teacher', 'user_teacher.user_id = user_absensi.user_id');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('user_teacher.teacher_id', $id_guru);
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $this->db->order_by('user_absensi.time', 'DESC');
    
        return $this->db->get()->result_array();
    }

    public function get_activities_siswa($id_guru) {
        $this->db->select('user.name_user, user.school, daily_activities.date_job, daily_activities.time, daily_activities.job');
        $this->db->from('daily_activities');
        $this->db->join('user_teacher', 'user_teacher.user_id = daily_activities.user_id');
        $this->db->join('user', 'user.id_user = daily_activities.user_id');
        $this->db->where('user_teacher.teacher_id', $id_guru);
        $this->db->order_by('daily_activities.date_job', 'DESC');
        $this->db->order_by('daily_activities.id', 'DESC');
    
        return $this->db->get()->result_array();
    }

    public function get_absensi_hadir($id_guru) {
        $date = date('Y-m-d');

        $this->db->select('user.name_user, user.school, user_absensi.date_in, user_absensi.time, user_absensi.time_out, user_absensi.information, user_absensi.note');
        $this->db->from('user_absensi');
        $this->db->join('user_teacher', 'user_teacher.user_id = user_absensi.user_id');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('user_teacher.teacher_id', $id_guru);
        $this->db->where('user_absensi.date_in', $date);
        $this->db->where('user_absensi.information', 1);
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $this->db->order_by('user_absensi.time', 'DESC');
        
        return $this->db->get()->result_array();
    }
    public function get_absensi_sakit($id_guru) {
        $date = date('Y-m-d');
        $this->db->select('user.name_user, user.school, user_absensi.date_in, user_absensi.time, user_absensi.time_out, user_absensi.information, user_absensi.note');
        $this->db->from('user_absensi');
        $this->db->join('user_teacher', 'user_teacher.user_id = user_absensi.user_id');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('user_teacher.teacher_id', $id_guru);
        $this->db->where('user_absensi.date_in', $date);
        $this->db->where('user_absensi.information', 2);
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $this->db->order_by('user_absensi.time', 'DESC');
        
        return $this->db->get()->result_array();
    }
    public function get_absensi_izin($id_guru) {
        $date = date('Y-m-d');
        $this->db->select('user.name_user, user.school, user_absensi.date_in, user_absensi.time, user_absensi.time_out, user_absensi.information, user_absensi.note');
        $this->db->from('user_absensi');
        $this->db->join('user_teacher', 'user_teacher.user_id = user_absensi.user_id');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('user_teacher.teacher_id', $id_guru);
        $this->db->where('user_absensi.date_in', $date);
        $this->db->where('user_absensi.information', 3);
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $this->db->order_by('user_absensi.time', 'DESC');
        
        return $this->db->get()->result_array();
    }
    public function get_absensi_terlambat($id_guru) {
        $date = date('Y-m-d');
        $this->db->select('user.name_user, user.school, user_absensi.date_in, user_absensi.time, user_absensi.time_out, user_absensi.information, user_absensi.note');
        $this->db->from('user_absensi');
        $this->db->join('user_teacher', 'user_teacher.user_id = user_absensi.user_id');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('user_teacher.teacher_id', $id_guru);
        $this->db->where('user_absensi.date_in', $date);
        $this->db->where('user_absensi.note', 'Terlambat');
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $this->db->order_by('user_absensi.time', 'DESC');
    
        return $this->db->get()->result_array();
    }
    

}