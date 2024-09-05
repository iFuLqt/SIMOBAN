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
        
        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $school = $this->input->post('school');
            
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

    // FOLDER MAGANG
    public function Absensi() {
        $data['title'] = 'Absensi';
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['value'] = $this->db->get('value_absensi')->result_array();

        
        // Mendapatkan id_user dari database
        $user_id = $data['user']['id_user']; // Mengambil nilai id_user dari array hasil query
        $current_date = time(); //Mengambil tanggal secara realtime (sudah di set di construct)
        $current_time = date('H:i'); // mengambil waktu secara realtime (Mengikuti zona waktu WITA)
        $information = $this->input->post('information'); // Default information jika tidak diisi
    
        // Definisikan rentang waktu absensi
        $start_time = '21:00:00';
        $end_time = '23:00:00';
        // Periksa apakah waktu saat ini dalam rentang yang diizinkan

        // Array untuk hari yang ada 
        // Mendapatkan hari ini dalam bahasa Inggris
        $day = date('l');
        $month = date('F');

        // Array terjemahan dari bahasa Inggris ke Indonesia untuk hari
        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        // Array terjemahan dari bahasa Inggris ke Indonesia untuk bulan
        $bulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        // Mengubah hari dan bulan dari bahasa Inggris ke bahasa Indonesia
        $hari_ini = $hari[$day];
        $bulan_ini = $bulan[$month];

        // Format lengkap tanggal
        $data['hari'] = $hari_ini . ', ' . date('d') . ' ' . $bulan_ini . ' ' . date('Y');
        $sudah_absen = $this->absen_model->cek_absen_hari_ini($user_id);
        // Validasi form
        $this->form_validation->set_rules('information', 'Information', 'required|trim');
        if ($this->form_validation->run() == false) {
            // Menampilkan views
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/absensi', $data);
            $this->load->view('templates/footer');
        } else {
            if ($current_time < $start_time || $current_time > $end_time) {
                // Tampilkan pesan error jika di luar rentang waktu
                $this->session->set_flashdata('message', 
                '<div class="alert alert-danger p-2" role="alert" style="width: 40rem;">
                Absen Hanya Jam 07:00-08:00 WITA 
                </div>');
                redirect('user/absensi');
                return; // Hentikan eksekusi lebih lanjut
            } else {
                if ($sudah_absen) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style="width: 40rem;">
                    Maaf, Anda Sudah Melakukan Absen Hari Ini
                    </div>');
                    redirect('user/absensi'); // Arahkan kembali ke riwayat absensi atau halaman lain
                } else {
                    // Data yang akan disimpan ke database
                    $data_insert = [
                        'user_id' => $user_id,  // Menggunakan nilai user_id yang benar
                        'date_in' => $current_date, // Tanggal check-in
                        'time' => $current_time, // Waktu check-in
                        'information' => $information // Informasi tambahan
                    ];
        
                    // Melakukan insert ke database
                    $this->absen_model->cek_in($data_insert);
            
                    // Redirect setelah berhasil insert
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 40rem;">
                    Absen Berhasil!!!
                    </div>');
                    redirect('user/absensi');
                }
            }
        }
            
    }
    
    
    

    
    public function HistoryAbsensi(){
        $data['title'] = 'Riwayat Absensi';
        $data['user'] = $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $email_user = $this->session->userdata('email_user');
        $user = $this->db->get_where('user', ['email_user' => $email_user])->row_array();
        if ($user) {
            $user_id = $user['id_user'];
            $data['absensi'] = $this->absen_model->get_absensi_by_user_id($user_id);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/historyabsensi', $data);
            $this->load->view('templates/footer');
        } else {
            show_error('User not found');
        }
    }


    //FUNGSI UNTUK MENAMPILKAN DATA DARI DATABASE KE PAGE AKTIVITAS HARIAN
    public function DailyActivities(){
        $data['title'] = 'Aktivitas Harian';
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
                'date_job' => time(),
                'time' => htmlspecialchars($this->input->post('time')),
                'job' => htmlspecialchars($this->input->post('job'))
            ];
            $this->db->insert('daily_activities', $data);
            redirect('user/dailyactivities');
        }
    }
}