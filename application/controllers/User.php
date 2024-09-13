<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        is_logged_in();
        $this->load->model('absen_model');
        date_default_timezone_set('Asia/Makassar');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index(){
        $data['title'] = 'Profil';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
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
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password</div>');
                redirect('user/changepassword');
            } else {
                if($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New Paaword cannot be the same has current</div>');
                    redirect('user/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email_user', $this->session->userdata('email_user'));
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password change!!!</div>');
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
        $information = $this->input->post('information');

        // Definisikan rentang waktu absensi
        $start_time = '07:00:00';
        $end_time = '08:00:00';

        $sudah_absen= $this->absen_model->cek_absen_hari_ini($user_id);

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
                    'note' => 'Absen Terlambat'
                ];
                $this->absen_model->cek_in($data_insert);
    
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
                Absen Masuk Berhasil Dicatat!, Dengan Status Terlambat
                </div>');
                redirect('user/absensi');
            } else {
                // Simpan data absen masuk
                $data_insert = [
                    'user_id' => $user_id,
                    'date_in' => $current_date,
                    'time' => $current_time,
                    'information' => $information,
                    'note' => '-'
                ];
                $this->absen_model->cek_in($data_insert);
    
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
                Absen Masuk Berhasil Dicatat!
                </div>');
                redirect('user/absensi');
            }
        } 
    }


    public function absen_out() {
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $user_id = $data['user']['id_user']; 
        $current_time = date('H:i:s');

        $start_time_out = '13:00:00';
        $sudah_absen_pulang= $this->absen_model->cek_absen_keluar_hari_ini($user_id);
        if($sudah_absen_pulang){
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">
            Anda Sudah Melakukan Absen Pulang Pada Hari Ini, Terima kasih.
            </div>');
            redirect('user/absensi');
        } else {
            if ($current_time < $start_time_out) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 100%;">
                Absen Pulang Hanya Bisa Dilakukan Pada Jam 16:00 WITA
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
        $user_id = $data['user']['id_user'];
        $data['absensi'] = $this->absen_model->get_absensi_by_user_id($user_id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/historyabsensi', $data);
        $this->load->view('templates/footer');
    }


    //FUNGSI UNTUK MENAMPILKAN DATA DARI DATABASE KE PAGE AKTIVITAS HARIAN
    public function DailyActivities(){
        $data['title'] = 'Kegiatan Harian';
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $this->load->model('activities_model');
        $email_user = $this->session->userdata('email_user');
        $user = $this->db->get_where('user', ['email_user' => $email_user])->row_array();
        if ($user) {
            $user_id = $user['id_user'];
            $data['daily'] = $this->activities_model->get_daily_activities_by_user_id($user_id);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/dailyactivities', $data);
            $this->load->view('templates/footer');
        } else {
            show_error('User not found');
        }
    }

    public function update_modal_dailyactivities() {
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
        redirect('user/dailyactivities');
    }

    public function delete_modal_dailyactivities() {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->delete('daily_activities');
        $this->session->set_flashdata('message', '<div class="alert alert-danger mt-2" role="alert">Data Berhasil DiHapus</div>');
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
            redirect('user/dailyactivities');
        }
    }
}