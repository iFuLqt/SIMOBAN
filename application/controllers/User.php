<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        is_logged_in();
        $this->load->model('absen_model');
        $this->load->model('activities_model');
        date_default_timezone_set('Asia/Makassar');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index(){
        $data['title'] = 'Profil';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_siswa = $data['user']['id_user'];
        $data['users'] = $this->absen_model->get_guru_by_id_siswa($id_siswa);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit(){
        $data['title'] = 'Ganti Profil';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();

        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('school', 'Sekolah', 'required|trim');
        $this->form_validation->set_rules('gedung', 'Gedung', 'required|trim');
        $this->form_validation->set_rules('nohp', 'No. HP', 'required|trim');
        $this->form_validation->set_rules('namapembimbing', 'Nama Pembimbing', 'required|trim');
        $this->form_validation->set_rules('nohppembimbing', 'No. HP Pembimbing', 'required|trim');  
        
        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $name = htmlspecialchars($this->input->post('name')); 
            $email = htmlspecialchars($this->input->post('email')); 
            $school = htmlspecialchars($this->input->post('school'));
            $gedung = htmlspecialchars($this->input->post('gedung'));
            $nohp = htmlspecialchars($this->input->post('nohp'));
            $namapembimbing = htmlspecialchars($this->input->post('namapembimbing'));
            $nohppembimbing = htmlspecialchars($this->input->post('nohppembimbing'));
            
            //cek jika ada gambar yang di upload
            $upload_image = $_FILES['image']['name'];

            if($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile';
                $this->load->library('upload', $config);

                if($this->upload->do_upload('image')){
                    $old_image = $data['user']['image'];
                    if($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }


            $this->db->set('name_user', $name);
            $this->db->set('school', $school);
            $this->db->set('gedung', $gedung);
            $this->db->set('no_hp', $nohp);
            $this->db->set('nama_pembimbing', $namapembimbing);
            $this->db->set('nohp_pembimbing', $nohppembimbing);

            $this->db->where('email_user', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your Profile has been updated.</div>');
            redirect('user');
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
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if(!password_verify($current_password, $data['user']['password'])){
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Lama Salah!!</div>');
                redirect('user/changepassword');
            } else {
                if($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Baru Tidak Boleh Sama!!</div>');
                    redirect('user/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email_user', $this->session->userdata('email_user'));
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Diganti!!!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    public function absen_in() {
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        
        $user_id = $data['user']['id_user']; 
        $current_date = date('Y-m-d'); 
        $current_time = date('H:i:s'); 
        $information = htmlspecialchars($this->input->post('information'));

        $start_time = '07:00:00';
        $end_time = '08:00:00';

        $sudah_absen= $this->absen_model->cek_absen_hari_ini($user_id);

        if($information != null) {
            if ($sudah_absen) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">
                Anda sudah melakukan absen pada hari ini, Silahkan menunggu absen pulang
                </div>');
                redirect('user/absensi');
            } else {
                if ($current_time < $start_time) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">
                    Absen Masuk Hanya Bisa Dilakukan Pada Jam 07:00-08:00 WITA
                    </div>');
                    redirect('user/absensi');
                } else if($current_time > $end_time) {
                    $data_insert = [
                        'user_id' => $user_id,
                        'date_in' => $current_date,
                        'time' => $current_time,
                        'information' => $information,
                        'note' => 'Terlambat'
                    ];
                    $this->absen_model->cek_in($data_insert);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
                    Absen Masuk Berhasil Dicatat!, Dengan Catatan Terlambat
                    </div>');
                    redirect('user/absensi');
                } else {
                    // Simpan data absen masuk
                    $data_insert = [
                        'user_id' => $user_id,
                        'date_in' => $current_date,
                        'time' => $current_time,
                        'information' => $information,
                        'note' => 'Tepat'
                    ];
                    $this->absen_model->cek_in($data_insert);
        
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
                    Absen Masuk Berhasil Dicatat!
                    </div>');
                    redirect('user/absensi');
                }
            } 
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">
            Silahkan Pilih Keterangan Absensi!!
            </div>');
            redirect('user/absensi');
        }

    }


    public function absen_out() {
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $user_id = $data['user']['id_user']; 
        $current_time = date('H:i:s');

        $sudah_absen= $this->absen_model->cek_absen_hari_ini($user_id);
        $sudah_absen_pulang= $this->absen_model->cek_absen_keluar_hari_ini($user_id);

        if($sudah_absen_pulang) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">
            Anda Sudah Melakukan Absen Pulang Pada Hari Ini, Terima kasih.
            </div>');
            redirect('user/absensi');
        } else if(!$sudah_absen) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">
            Anda Tidak Melakukan Absen Masuk Pada Hari Ini!!
            </div>');
            redirect('user/absensi');
        } else {
            $data_update = [
               'time_out' => $current_time
            ];
            $this->absen_model->cek_out($user_id, $data_update);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
            Absen Pulang Berhasil Dicatat!
            </div>');
            redirect('user/absensi');
        }
    }
    

    // FOLDER MAGANG
    public function Absensi() {
        $data['title'] = 'Absensi';
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['value'] = $this->db->get('value_absensi')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/absensi', $data);
        $this->load->view('templates/footer');
    }
    
    
    
    public function HistoryAbsensi(){
        $data['title'] = 'Riwayat Absensi';
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();

        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date') ;
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $user_id = $data['user']['id_user'];
            $data['absensi'] = $this->absen_model->get_data_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
        } else {
            $user_id = $data['user']['id_user'];
            $data['absensi'] = $this->absen_model->get_absensi_by_user_id($user_id);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/historyabsensi', $data);
        $this->load->view('templates/footer');
    }

    public function refresh_historyabsensi() {
        redirect('user/historyabsensi');
    }


    public function DailyActivities(){
        $data['title'] = 'Kegiatan Harian';
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $user_id = $data['user']['id_user'];
        $data['absen'] = $this->absen_model->cek_absen_hari_ini($user_id);

        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date');
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $data['daily'] = $this->activities_model->get_data_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
        } else {
            $data['daily'] = $this->activities_model->get_daily_activities_by_user_id($user_id);    
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/dailyactivities', $data);
        $this->load->view('templates/footer');
    }

    public function refresh_dailyactivities() {
        redirect('user/dailyactivities');
    }

    public function update_modal_dailyactivities() {
        $id = $this->input->post('id');
        $time = htmlspecialchars($this->input->post('time'));
        $job = htmlspecialchars($this->input->post('job'));

        $data = [
            'time' => $time,
            'job' => $job 
        ];
        $this->db->where('id', $id);
        $this->db->update('daily_activities', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">Data Kegiatan Berhasil Di Ubah</div>');
        redirect('user/dailyactivities');
    }

    public function delete_modal_dailyactivities() {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->delete('daily_activities');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">Data Kegiatan Berhasil Di Hapus</div>');
        redirect('user/dailyactivities');
    }

    //FUNGSI UNTUK MODAL DI PAGE AKTIVITAS HARIAN
    public function Modal_DailyActivities() {
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $user_id = $data['user']['id_user'];
        $this->form_validation->set_rules('time', 'Time', 'required');
        $this->form_validation->set_rules('job', 'Job', 'required');
        if($this->form_validation->run() == false){
            redirect('user/dailyactivities');
        } else {
            $data = [
                'user_id' => $user_id,
                'date_job' => date('Y-m-d'),
                'time' => htmlspecialchars($this->input->post('time')),
                'job' => htmlspecialchars($this->input->post('job'))
            ];
            $this->db->insert('daily_activities', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
            Data Kegiatan Hari ini, Berhasil Di Catat
            </div>');
            redirect('user/dailyactivities');
        }
    }

    public function print_dailyactivities() {
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $user_id = $data['user']['id_user'];
        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date');
        $cek = $this->input->post('check');

        if(empty($cek)&&empty($tanggal_awal)&&empty($tanggal_akhir)){
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert" style="width: 100%;">
            Data Tidak Ditemukan
            </div>');
            redirect('user/dailyactivities');
        } else if(($cek == 1 && (!empty($tanggal_awal) && !empty($tanggal_akhir))) || ($cek == 1 && (empty($tanggal_awal) && empty($tanggal_akhir)))) {
            $data['print'] = $this->activities_model->get_daily_activities_by_user_id($user_id);
        } else if(!empty($tanggal_awal) && !empty($tanggal_akhir)){
            $data['print'] = $this->activities_model->get_data_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
        } else{
            $this->session->set_flashdata('message', '<div class="alert alert-warning mt-2" role="alert">Data Tidak Ditemukan.</div>');
            redirect('user/dailyactivities');
        }
        $this->load->view('user/print_dailyactivities', $data); 
    }

    public function print_historyabsensi() {
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $user_id = $data['user']['id_user'];
        $tanggal_awal = $this->input->post('start_date');
        $tanggal_akhir = $this->input->post('end_date');
        $cek = $this->input->post('check');
        
        if(empty($cek)&&empty($tanggal_awal)&&empty($tanggal_akhir)){
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert" style="width: 100%;">
            Data Tidak Ditemukan
            </div>');
            redirect('user/historyabsensi');
        }
        else if(($cek == 1 && (!empty($tanggal_awal) && !empty($tanggal_akhir))) || ($cek == 1 && (empty($tanggal_awal) && empty($tanggal_akhir)))) {
            $data['print'] = $this->absen_model->get_absensi_by_user_id($user_id);
        } else if(!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $data['print'] = $this->absen_model->get_data_by_date_range($user_id, $tanggal_awal, $tanggal_akhir);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning mt-2" role="alert">Data Tidak Ditemukan.</div>');
            redirect('user/historyabsensi');
        }
        $this->load->view('user/print_historyabsensi', $data);
    }

}