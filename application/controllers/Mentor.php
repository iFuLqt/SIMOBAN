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

    public function datateacher(){
        $data['title'] = 'Data Guru';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array(); 
        $data['users'] = $this->mentor_model->get_teacher();
            
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/datateacher', $data);
        $this->load->view('templates/footer');
    }

    public function update_modal_datateacher() {
        $id = $this->input->post('id');
        $active = $this->input->post('active');

        $data = [
            'is_active' => $active
        ];
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success mt-2" role="alert">Data Berhasil DiUbah</div>');
        redirect('mentor/datateacher');
    }

    public function delete_modal_datateacher() {
        $id = $this->input->post('id');

        $this->db->where('id_user', $id);
        $this->db->delete('user');
        $this->db->where('user_id', $id);
        $this->db->delete('daily_activities');
        $this->db->where('user_id', $id);
        $this->db->delete('user_absensi');
        $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Berhasil DiHapus</div>');
        redirect('mentor/datateacher');
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
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
    
        $user_id = $this->input->post('nama');
        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date');
        $cek = $this->input->post('checkk');
    
        if ($user_id != 0) {
            if ($cek == 1 && (empty($tanggal_awal) && empty($tanggal_akhir))) {
                $data['print'] = $this->mentor_model->get_all_absensi_by_userid($user_id);
            } 
            else if($cek == 1 && (!empty($tanggal_awal) && !empty($tanggal_akhir))) {
                $data['print'] = $this->mentor_model->get_all_absensi_by_userid($user_id);
            } else if(!empty($tanggal_awal) && !empty($tanggal_akhir)){
                $data['print'] = $this->mentor_model->get_absensi_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
            }
            if (empty($data['print'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Absensi Kosong.</div>');
                redirect('mentor/dataabsensi');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Nama Siswa Tidak Boleh Kosong.</div>');
            redirect('mentor/dataabsensi');
        }
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
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
    
        // Ambil input dari form
        $user_id = $this->input->post('nama');
        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date');
        $cek = $this->input->post('checkk');
    
        if ($user_id != 0) {
            if ($cek == 1 && (empty($tanggal_awal) && empty($tanggal_akhir))) {
                $data['print'] = $this->mentor_model->get_all_activities_by_userid($user_id);
            } 
            else if($cek == 1 && (!empty($tanggal_awal) && !empty($tanggal_akhir))) {
                $data['print'] = $this->mentor_model->get_all_activities_by_userid($user_id);
            } else if(!empty($tanggal_awal) && !empty($tanggal_akhir)){
                $data['print'] = $this->mentor_model->get_activities_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
            }
            if (empty($data['print'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Kegiatan kosong.</div>');
                redirect('mentor/dataactivities');
            }
    
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Nama Siswa tidak boleh kosong.</div>');
            redirect('mentor/dataactivities');
        }
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
                'id_jurusan' => $this->input->post('id_jurusan', true) ? $this->input->post('id_jurusan') : NULL, // Null jika tidak diisi
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
        $data['guru'] = $this->mentor_model->get_guru_by_id_siswa($id_user);
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

    public function detail_datateacher($id_guru){
        $data['title'] = 'Detail Guru';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['users'] = $this->db->get_where('user', ['id_user' => $id_guru])->row_array();
        $data['siswa'] = $this->mentor_model->get_siswa_by_id_guru($id_guru);
        if (($data['users']['id_role'] != 4) || ($data['users']['id_jurusan'] != null)) {
            redirect('mentor/datateacher');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('mentor/detail_datateacher', $data);
            $this->load->view('templates/footer');
        }
        
    }

    public function ChangePassword(){
        $data['title'] = 'Ganti Password';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');
        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('mentor/changepassword', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if(!password_verify($current_password, $data['user']['password'])){
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Lama Salah!!</div>');
                redirect('mentor/changepassword');
            } else {
                if($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Baru Tidak Boleh Sama!!</div>');
                    redirect('mentor/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email_user', $this->session->userdata('email_user'));
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Diganti!!!</div>');
                    redirect('mentor/changepassword');
                }
            }
        }
    }

    public function get_jurusan_siswa(){
        $role = $this->input->post('role');

        // Cek apakah role bukan siswa
        if ($role != 3) {
            echo '<option value=""> --> Pilih Jurusan Magang <-- </option>';
            return;
        }

        // Jika role adalah siswa, ambil data jurusan
        $this->db->select('*');
        $this->db->from('jurusan');
        $kelas_list = $this->db->get()->result();

        // Buat output untuk option select jurusan
        $output = '<option value=""> --> Pilih Jurusan Magang <-- </option>';
        foreach ($kelas_list as $kelas) {
            $output .= '<option value="' . $kelas->id . '">' . $kelas->jurusan . '</option>';
        }
        echo $output; // Kirim ke JavaScript
    }


    
}