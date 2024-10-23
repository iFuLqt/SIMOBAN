<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        is_logged_in();
        $this->load->model('admin_model');
    }

    public function index(){
        $data['title'] = 'Beranda';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();

        $jumlah_orang_hadir = $this->admin_model->cek_hadir_hari_ini();
        $jumlah_orang_sakit = $this->admin_model->cek_sakit_hari_ini();
        $jumlah_orang_izin = $this->admin_model->cek_izin_hari_ini();
        $jumlah_orang_terlambat = $this->admin_model->cek_terlambat_hari_ini();
        $jumlah_idrole_3 = $this->admin_model->get_role_3();
        $jumlah_idrole_2 = $this->admin_model->get_role_2();

        $jumlah_hadir = count($jumlah_orang_hadir);
        $jumlah_sakit = count($jumlah_orang_sakit);
        $jumlah_izin = count($jumlah_orang_izin);
        $jumlah_terlambat = count($jumlah_orang_terlambat);
        $jumlah_idrole_3 = count($jumlah_idrole_3);
        $jumlah_idrole_2 = count($jumlah_idrole_2);
        
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
        if ($jumlah_idrole_3 > 1) {
            $jumlah_idrole_3 + 1;
        }
        if ($jumlah_idrole_2 > 1) {
            $jumlah_idrole_2 + 1;
        }
        // Kirimkan data ke view
        $data['hadir'] = $jumlah_hadir;
        $data['sakit'] = $jumlah_sakit;
        $data['izin'] = $jumlah_izin;
        $data['terlambat'] = $jumlah_terlambat;
        $data['jumlah_idrole_3'] = $jumlah_idrole_3;
        $data['jumlah_idrole_2'] = $jumlah_idrole_2;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');

    }

    public function role(){
        $data['title'] = 'Role';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleAccess($role_id){
        $data['title'] = 'Role Access';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess() {
        $menu_id = $this->input->post('menuId');
        $id_role = $this->input->post('roleId');

        $data = [
            'id_role' => $id_role,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_acces_menu', $data);
        
        if($result->num_rows() < 1) {
            $this->db->insert('user_acces_menu', $data);
        } else {
            $this->db->delete('user_acces_menu', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!!</div>');
    }

    public function DataStudent(){
        $data['title'] = 'Data Siswa';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['users'] = $this->admin_model->get_all_data_student();
        $data['jurusan'] = $this->admin_model->get_jurusan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/datastudent', $data);
        $this->load->view('templates/footer');
    }

    public function update_modal_datastudent() {
        $id = $this->input->post('id');
        $active = $this->input->post('active');
        $jurusan = $this->input->post('jurusan');

        $data = [
            'is_active' => $active,
            'id_jurusan' => $jurusan
        ];
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success mt-2" role="alert">Data Berhasil DiUbah</div>');
        redirect('admin/datastudent');
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
        redirect('admin/datastudent');
    }

    public function DataActivities(){
        $data['title'] = 'Data Kegiatan';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['student'] = $this->admin_model->get_all_data_student();
        
        $tanggal_awal = $this->input->post('start_date_admin');
        $tanggal_akhir = $this->input->post('end_date_admin');
        if(!empty($tanggal_awal) && !empty($tanggal_akhir)){
            $data['daily'] = $this->admin_model->get_activities_by_date($tanggal_awal, $tanggal_akhir);
        } else {
            $data['daily'] = $this->admin_model->get_activities_by_date($tanggal_awal, $tanggal_akhir);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/dataactivities', $data);
        $this->load->view('templates/footer');
    }

    public function print_DataActivities(){
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();

        $user_id = $this->input->post('nama');
        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date');
        $centang = $this->input->post('check');
    
        if ($user_id != 0) {
            if (($centang == 1) && (empty($tanggal_awal) && empty($tanggal_akhir))) {
                $data['print'] = $this->admin_model->get_all_activities_by_userid($user_id);
            } 
            else if(($centang == 1) && (!empty($tanggal_awal) && !empty($tanggal_akhir))){
                $data['print'] = $this->admin_model->get_all_activities_by_userid($user_id);
            } else if(!empty($tanggal_awal) && !empty($tanggal_akhir)){
                $data['print'] = $this->admin_model->get_activities_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
            }
            if (empty($data['print'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert" style="width: 100%;">
                    Data Kegiatan Kosong 
                    </div>');
                redirect('admin/dataactivities');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">
                    Nama Siswa Tidak Boleh Kosong!!
                    </div>');
            redirect('admin/dataactivities');
        }
        $this->load->view('admin/print_dataactivities', $data);
    }

    public function refresh_dataactivities(){
        redirect('admin/dataactivities');
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
        redirect('admin/dataactivities');
    }

    public function delete_modal_dataactivities() {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->delete('daily_activities');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
                    Data Kegiatan Berhasil Di Hapus
                    </div>');
        redirect('admin/dataactivities');
    }


    public function DataAbsensi(){
        $data['title'] = 'Data Absensi';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['student'] = $this->admin_model->get_all_data_student();

        $tanggal_awal = $this->input->post('start_date_admin');
        $tanggal_akhir = $this->input->post('end_date_admin');
        if(!empty($tanggal_awal) && !empty($tanggal_akhir)){
            $data['absensi'] = $this->admin_model->get_absensi_by_date($tanggal_awal, $tanggal_akhir);
        } else {
            $data['absensi'] = $this->admin_model->get_absensi_by_date($tanggal_awal, $tanggal_akhir);
        }
        $data['value'] = $this->db->get('value_absensi')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/dataabsensi', $data);
        $this->load->view('templates/footer');
    }

    public function print_DataAbsensi(){
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();

        $user_id = $this->input->post('nama');
        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date');
        $centang = $this->input->post('check');
    
        if ($user_id != 0) {
            if (($centang == 1) && (empty($tanggal_awal) && empty($tanggal_akhir))) {
                $data['print'] = $this->admin_model->get_all_absensi_by_userid($user_id);
            } 
            else if(($centang == 1) && (!empty($tanggal_awal) && !empty($tanggal_akhir))){
                $data['print'] = $this->admin_model->get_all_absensi_by_userid($user_id);
            } else if(!empty($tanggal_awal) && !empty($tanggal_akhir)){
                $data['print'] = $this->admin_model->get_absensi_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
            }
            if (empty($data['print'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert" style="width: 100%;">
                    Data Absensi Kosong 
                    </div>');
                redirect('admin/dataabsensi');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">
                    Nama Siswa Tidak Boleh Kosong!!
                    </div>');
            redirect('admin/dataabsensi');
        }
        $this->load->view('admin/print_dataabsensi', $data);
    }

    public function refresh_dataabsensi(){
        redirect('admin/dataabsensi');
    }
    
    public function update_modal_dataabsensi() {
        $id = $this->input->post('id');
        $tanggal = $this->input->post('datee');
        $datang = $this->input->post('timee');
        $pulang = $this->input->post('timee2');
        $information = $this->input->post('information');
        $catatan = $this->input->post('notee');
        
        $data = [
            'date_in' => $tanggal,
            'time' => $datang,
            'time_out' => $pulang,
            'information' => $information,
            'note' => $catatan
        ];
        $this->db->where('id', $id);
        $this->db->update('user_absensi', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
                    Data Absensi Berhasil Di Perbaharui
                    </div>');
        redirect('admin/dataabsensi');
    }       

    public function delete_modal_dataabsensi() {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->delete('user_absensi');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
                    Data Absensi Berhasil Di Hapus
                    </div>');
        redirect('admin/dataabsensi');
    }

    public function CreateMagang(){
        $data['title'] = 'Buatkan Akun';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['jur'] = $this->admin_model->get_jurusan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/createmagang', $data);
        $this->load->view('templates/footer');
    }
    
    public function registration() {
        $this->form_validation->set_rules('name','Name','required|trim');
        $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email_user]', ['is_unique' => 'This email has already registered!']);
        $this->form_validation->set_rules('school','School','required|trim');
        $this->form_validation->set_rules('id_jurusan','required|trim');
        $this->form_validation->set_rules('password1','Password','required|trim|min_length[3]|matches[password2]',['matches' => 'Password dont match!', 'min_length' => 'Password too short!']);
        $this->form_validation->set_rules('password2','Password','required|trim|min_length[3]|matches[password1]');
        
        if($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf!!, Silahkan Isi Semua Data</div>');
            redirect('admin/createmagang');
        } else {
            $data = [
                'name_user' => htmlspecialchars($this->input->post('name', true)),
                'email_user' => htmlspecialchars($this->input->post('email', true)),
                'school' => htmlspecialchars($this->input->post('school', true)),
                'id_jurusan' => $this->input->post('id_jurusan', true),
                'image'=> 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'id_role' => 3,
                'is_active' => 1,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratuliation! your account has been created. Please Login</div>');
            redirect('admin/createmagang');
        }
    }

    public function detail_datastudent($id_user){
        $data['title'] = 'Detail Siswa';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['users'] = $this->db->get_where('user', ['id_user' => $id_user])->row_array();
        $data['guru'] = $this->admin_model->get_guru_by_id_siswa($id_user);
        if ($data['users']['id_role'] != 3) {
            redirect('admin/datastudent');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/detail_datastudent', $data);
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
            $this->load->view('admin/changepassword', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if(!password_verify($current_password, $data['user']['password'])){
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Lama Salah!!</div>');
                redirect('admin/changepassword');
            } else {
                if($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Baru Tidak Boleh Sama!!</div>');
                    redirect('admin/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email_user', $this->session->userdata('email_user'));
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Diganti!!!</div>');
                    redirect('admin/changepassword');
                }
            }
        }
    }

    public function get_jurusan_siswa(){
        $role = $this->input->post('role');

        // Cek apakah role bukan siswa
        if ($role == 4) {
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

    public function datateacher(){
        $data['title'] = 'Data Guru';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array(); 
        $data['users'] = $this->admin_model->get_teacher();
            
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/datateacher', $data);
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
        redirect('admin/datateacher');
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
        redirect('admin/datateacher');
    }

    public function detail_datateacher($id_guru){
        $data['title'] = 'Detail Guru';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['users'] = $this->db->get_where('user', ['id_user' => $id_guru])->row_array();
        $data['siswa'] = $this->admin_model->get_siswa_by_id_guru($id_guru);
        if (($data['users']['id_role'] != 4) || ($data['users']['id_jurusan'] != null)) {
            redirect('admin/datateacher');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/detail_datateacher', $data);
            $this->load->view('templates/footer');
        }
        
    }

}