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
        $jumlah_orang_absen = $this->mentor_model->cek_absen_hari_ini();
        $jumlah_orang_aktivitas = $this->mentor_model->cek_aktivitas_hari_ini();

        $jumlah_orang_absen = count($jumlah_orang_absen);
        $jumlah_orang_aktivitas = count($jumlah_orang_aktivitas);
        
        // Tambahkan 1 jika jumlah item lebih dari 1
        if ($jumlah_orang_absen > 1) {
            $jumlah_orang_absen + 1;
        }
        if ($jumlah_orang_aktivitas > 1) {
            $jumlah_orang_aktivitas + 1;
        }
        $id_jurusan = $data['user']['id_jurusan'];
        $data['jumlah_orang_absen'] = $jumlah_orang_absen;
        $data['jumlah_orang_aktivitas'] = $jumlah_orang_aktivitas;
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
        $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Berhasil DiHapus</div>');
        redirect('mentor/dataactivities');
    }

    public function DataActivities(){
        $data['title'] = 'Data Kegiatan';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_jurusan = $data['user']['id_jurusan'];
        $data['daily'] = $this->mentor_model->get_activities_by_jurusan($id_jurusan);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/dataactivities', $data);
        $this->load->view('templates/footer');
    }

    public function update_modal_dataactivities() {
        $id = $this->input->post('id');
        $time = $this->input->post('time');
        $job = $this->input->post('job');

        $data = [
            'time' => $time,
            'job' => $job 
        ];
        $this->db->where('id', $id);
        $this->db->update('daily_activities', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success mt-2" role="alert">Data Berhasil DiUbah</div>');
        redirect('mentor/dataactivities');
    }

    public function delete_modal_dataactivities() {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->delete('daily_activities');
        $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Berhasil DiHapus</div>');
        redirect('mentor/dataactivities');
    }


    public function DataAbsensi(){
        $data['title'] = 'Data Absensi';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_jurusan = $data['user']['id_jurusan'];
        $data['absensi'] = $this->mentor_model->get_absensi_by_jurusan($id_jurusan);
        $data['value'] = $this->db->get('value_absensi')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/dataabsensi', $data);
        $this->load->view('templates/footer');
        
    }

    public function update_modal_dataabsensi() {
        $id = $this->input->post('id');
        $information = $this->input->post('information');

        $data = [
            'information' => $information
        ];
        $this->db->where('id', $id);
        $this->db->update('user_absensi', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success mt-2" role="alert">Data Berhasil DiUbah</div>');
        redirect('mentor/dataabsensi');
    }       

    public function delete_modal_dataabsensi() {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->delete('user_absensi');
        $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Berhasil DiHapus</div>');
        redirect('mentor/dataabsensi');
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
                'id_jurusan' => $this->input->post('id_jurusan', true),
                'image'=> 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'id_role' => 2,
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
        if ($data['users']['id_role'] != 3) {
            redirect('mentor/datastudent');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('mentor/detail_datastudent', $data);
            $this->load->view('templates/footer');
        }
        
    }

    public function daily_absensi() {
        $data['title'] = 'Absensi (Harian)';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_jurusan = $data['user']['id_jurusan'];
        $data['users'] = $this->mentor_model->get_all_daily_absensi($id_jurusan);   
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/dailyabsensi', $data);
        $this->load->view('templates/footer');
    }

    public function daily_activities() {
        $data['title'] = 'Kegiatan (Harian)';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_jurusan = $data['user']['id_jurusan'];
        $data['users'] = $this->mentor_model->get_all_daily_activities($id_jurusan);   
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mentor/dailyactivities', $data);
        $this->load->view('templates/footer');
    }

    
}