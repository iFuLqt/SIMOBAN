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

    // method yang mengambil user_id dan tanggal
    // untuk di lakukan pengecekan apakah sdh ada yang absen hari ini
    public function cek_absen_hari_ini($user_id) {
        $start_of_day = strtotime("today midnight"); // Mendapatkan timestamp untuk awal hari ini 00:00
        $end_of_day = strtotime("tomorrow midnight") - 1; // Mendapatkan timestamp untuk akhir hari ini 23:59 
    
        // Query untuk mengecek apakah ada data absensi untuk user_id dan tanggal hari ini
        $this->db->where('user_id', $user_id);
        $this->db->where('date_in >=', $start_of_day);
        $this->db->where('date_in <=', $end_of_day);
        $query = $this->db->get('user_absensi');
    
        if ($query->num_rows() > 0) {
            return true; // Sudah absen
        } else {
            return false; // Belum absen
        }
    }
    

    // Method untuk mengambil riwayat absensi berdasarkan user_id
    public function get_absensi_by_user_id($user_id) {
        $this->db->select('user.name_user as Nama_Siswa, user.school as Sekolah, user_absensi.date_in as Tanggal, user_absensi.time as Waktu, user_absensi.information as Keterangan');
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