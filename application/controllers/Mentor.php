<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentor extends CI_Controller {

    public function __construct(){
        parent::__construct();
        is_logged_in();
        $this->load->model('mentor_model');
    }

    public function index() {
        $data['title'] = 'Beranda';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_jurusan = $data['user']['id_jurusan'];
        $jumlah_orang_hadir = $this->mentor_model->cek_hadir_hari_ini($id_jurusan);
        $jumlah_orang_sakit = $this->mentor_model->cek_sakit_hari_ini($id_jurusan);
        $jumlah_orang_izin = $this->mentor_model->cek_izin_hari_ini($id_jurusan);
        $jumlah_orang_terlambat = $this->mentor_model->cek_terlambat_hari_ini($id_jurusan);

        $jumlah_hadir = count($jumlah_orang_hadir);
        $jumlah_sakit = count($jumlah_orang_sakit);
        $jumlah_izin = count($jumlah_orang_izin);
        $jumlah_terlambat = count($jumlah_orang_terlambat);
        
        // Tambahkan 1 jika jumlah item lebih dari 1
        if ($jumlah_hadir > 1) {
            $jumlah_hadir + 1;
        }
        if ($jumlah_sakit > 1) {
            $jumlah_sakit + 1;
        }
        if ($jumlah_izin > 1) {
            $jumlah_izin + 1;
        }
        if ($jumlah_terlambat > 1) {
            $jumlah_terlambat + 1;
        }
        
        $data['hadir'] = $jumlah_hadir;
        $data['sakit'] = $jumlah_sakit;
        $data['izin'] = $jumlah_izin;
        $data['terlambat'] = $jumlah_terlambat;
        $jumlah_idrole_3 = count($this->mentor_model->get_role_and_jurusan($id_jurusan));
        $data['jumlah_idrole_3'] = $jumlah_idrole_3;
        if ($jumlah_idrole_3 > 1) {
            $jumlah_idrole_3 + 1;
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/index', $data);
        $this->load->view('templates/footer');
        
        
    }

    public function DataStudent(){
        $data['title'] = 'Data Siswa';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array(); 
        $id_jurusan = $data['user']['id_jurusan'];
        $data['users'] = $this->mentor_model->get_student_by_jurusan($id_jurusan);
            
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/datastudent', $data);
        $this->load->view('templates/footer');
    }

    public function update_modal_datastudent() {
        $id = $this->input->post('id');
        $active = $this->input->post('active');

        $data = [
            'is_active' => $active
        ];
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success mt-2" role="alert">Data Berhasil DiUbah</div>');
        redirect('mentor/datastudent');
    }

    public function delete_modal_datastudent() {
        $id = $this->input->post('id');

        $this->db->where('id_user', $id);
        $this->db->delete('user');
        $this->db->where('user_id', $id);
        $this->db->delete('daily_activities');
        $this->db->where('user_id', $id);
        $this->db->delete('user_absensi');
        $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Berhasil DiHapus</div>');
        redirect('mentor/datastudent');
    }

    public function DataAbsensi(){
        $data['title'] = 'Data Absensi';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_jurusan = $data['user']['id_jurusan'];
        $data['student'] = $this->mentor_model->get_student_by_jurusan($id_jurusan);

        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date') ;
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $data['absensi'] = $this->mentor_model->get_all_absensi_by_date_range($tanggal_awal, $tanggal_akhir);
        } else {
            $data['absensi'] = $this->mentor_model->get_absensi_by_jurusan($id_jurusan);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/dataabsensi', $data);
        $this->load->view('templates/footer');
    }

    public function print_DataAbsensi(){
        // Ambil data user yang sedang login
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
    
        // Ambil input dari form
        $user_id = $this->input->post('nama');
        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date');
    
        // Cek jika user_id tidak kosong
        if ($user_id != 0) {
            // Jika tanggal awal dan akhir tidak diisi, ambil semua data absensi berdasarkan user_id
            if (empty($tanggal_awal) && empty($tanggal_akhir)) {
                $data['print'] = $this->mentor_model->get_all_absensi_by_userid($user_id);
            } 
            // Jika tanggal awal dan akhir diisi, ambil data absensi berdasarkan rentang tanggal
            else {
                $data['print'] = $this->mentor_model->get_absensi_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
            }
    
            // Jika tidak ada data yang ditemukan, redirect kembali ke halaman awal dengan alert
            if (empty($data['print'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Absensi Kosong.</div>');
                redirect('mentor/dataabsensi'); // Ganti dengan halaman yang sesuai
            }
    
        } else {
            // Jika user_id kosong, berikan pesan kesalahan
            $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Nama Siswa Tidak Boleh Kosong.</div>');
            redirect('mentor/dataabsensi'); // Redirect ke halaman yang sesuai
        }
    
        // Jika ada data, tampilkan view untuk mencetak data absensi
        $this->load->view('mentor/print_dataabsensi', $data);
    }
    
    

    public function refresh_dataabsensi() {
        redirect('mentor/dataabsensi');
    }

    public function DataActivities(){
        $data['title'] = 'Data Kegiatan';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_jurusan = $data['user']['id_jurusan'];
        $data['student'] = $this->mentor_model->get_student_by_jurusan($id_jurusan);

        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date') ;
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $data['daily'] = $this->mentor_model->get_all_activities_by_date_range($tanggal_awal, $tanggal_akhir);
        } else {
            $data['daily'] = $this->mentor_model->get_activities_by_jurusan($id_jurusan);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/dataactivities', $data);
        $this->load->view('templates/footer');
    }

    public function print_DataActivities(){
        // Ambil data user yang sedang login
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
    
        // Ambil input dari form
        $user_id = $this->input->post('nama');
        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date');
    
        // Cek jika user_id tidak kosong
        if ($user_id != 0) {
            // Jika tanggal awal dan akhir tidak diisi, ambil semua data absensi berdasarkan user_id
            if (empty($tanggal_awal) && empty($tanggal_akhir)) {
                $data['print'] = $this->mentor_model->get_all_activities_by_userid($user_id);
            } 
            // Jika tanggal awal dan akhir diisi, ambil data absensi berdasarkan rentang tanggal
            else {
                $data['print'] = $this->mentor_model->get_activities_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
            }
    
            // Jika tidak ada data yang ditemukan, redirect kembali ke halaman awal dengan alert
            if (empty($data['print'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Kegiatan kosong.</div>');
                redirect('mentor/dataactivities'); // Ganti dengan halaman yang sesuai
            }
    
        } else {
            // Jika user_id kosong, berikan pesan kesalahan
            $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Nama Siswa tidak boleh kosong.</div>');
            redirect('mentor/dataactivities'); // Redirect ke halaman yang sesuai
        }
    
        // Jika ada data, tampilkan view untuk mencetak data absensi
        $this->load->view('mentor/print_dataactivities', $data);
    }
    

    public function refresh_dataactivities() {
        redirect('mentor/dataactivities');
    }

    public function CreateMagang(){
        $data['title'] = 'Buat Akun Magang';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['jur'] = $this->mentor_model->get_jurusan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/createmagang', $data);
        $this->load->view('templates/footer');
    }
    
    public function registration() {
        $this->form_validation->set_rules('name','Name','required|trim');
        $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email_user]', ['is_unique' => 'This email has already registered!']);
        $this->form_validation->set_rules('school','School','required|trim');
        $this->form_validation->set_rules('id_jurusan', 'required|trim');
        $this->form_validation->set_rules('gedu', 'Gedu', 'required|trim');
        $this->form_validation->set_rules('password1','Password','required|trim|min_length[3]|matches[password2]',['matches' => 'Password dont match!', 'min_length' => 'Password too short!']);
        $this->form_validation->set_rules('password2','Password','required|trim|min_length[3]|matches[password1]');
        
        if($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf!!, Silahkan Isi Semua Data</div>');
            redirect('mentor/createmagang');
        } else {
            $data = [
                'name_user' => htmlspecialchars($this->input->post('name', true)),
                'email_user' => htmlspecialchars($this->input->post('email', true)),
                'school' => htmlspecialchars($this->input->post('school', true)),
                'id_jurusan' => $this->input->post('id_jurusan', true),
                'gedung' => htmlspecialchars($this->input->post('gedu', true)),
                'image'=> 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'id_role' => 3,
                'is_active' => 1,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratuliation! your account has been created. Please Login</div>');
            redirect('mentor/createmagang');
        }
    }

    public function detail_datastudent($id_user){
        $data['title'] = 'Detail Siswa';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['users'] = $this->db->get_where('user', ['id_user' => $id_user])->row_array();
        $jurusan = $data['user']['id_jurusan'];
        if (($data['users']['id_role'] != 3) || ($data['users']['id_jurusan'] != $jurusan)) {
            redirect('mentor/datastudent');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('mentor/detail_datastudent', $data);
            $this->load->view('templates/footer');
        }
        
    }

    
}