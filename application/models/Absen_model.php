<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    protected $table = 'user_absensi'; // Nama tabel Anda
    
    public function cek_in($data_insert) {
        return $this->db->insert($this->table, $data_insert);
    }

    public function cek_out($user_id, $data_update) {
        $current_date = date('Y-m-d'); // Ambil tanggal hari ini

        // Update time_out untuk user pada hari ini
        $this->db->where('user_id', $user_id);
        $this->db->where('date_in', $current_date);
        $this->db->update('user_absensi', $data_update); // Update kolom time_out
    }

    // method yang mengambil user_id dan tanggal
    // untuk di lakukan pengecekan apakah sdh ada yang absen hari ini
    public function cek_absen_hari_ini($user_id) {
        $date = date('Y-m-d');
    
        // Query untuk mengecek apakah ada data absensi untuk user_id dan tanggal hari ini
        $this->db->where('user_id', $user_id);
        $this->db->where('date_in ', $date);
        $query = $this->db->get('user_absensi');
    
        if ($query->num_rows() > 0) {
            return true; // Sudah absen
        } else {
            return false; // Belum absen
        }
    }

    public function cek_absen_keluar_hari_ini($user_id) {
        $current_date = date('Y-m-d');
        
        // Query untuk cek apakah user sudah absen keluar (cek kolom time_out)
        $this->db->where('user_id', $user_id);
        $this->db->where('date_in', $current_date);
        $this->db->where('time_out >=', '00:00:01'); // Mengecek apakah time_out sudah diisi
        $query = $this->db->get('user_absensi');

        if ($query->num_rows() > 0) {
            return true; // Sudah absen keluar
        } else {
            return false; // Belum absen keluar
        }
    }
    

    // Method untuk mengambil riwayat absensi berdasarkan user_id
    public function get_absensi_by_user_id($user_id) {
        $this->db->select('user.name_user as Nama_Siswa, user.school as Sekolah, user_absensi.date_in as Tanggal, user_absensi.time as Waktu, user_absensi.information as Keterangan, user_absensi.time_out as Keluar, user_absensi.note as Catatan');
        $this->db->from('user_absensi');
        $this->db->join('user', 'user.id_user = user_absensi.user_id');
        $this->db->where('user_absensi.user_id', $user_id);
        $this->db->order_by('user_absensi.date_in', 'DESC');
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan hasil sebagai array
    }

    public function get_all_attendance() {
        // Ambil semua data dari tabel 'attendance'
        $this->db->select('*');
        $this->db->from('user_absensi'); // Nama tabel 'attendance' di database
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan data sebagai array
    }
    
}