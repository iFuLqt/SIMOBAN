<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller{
    public function __construct(){
        parent::__construct();
        is_logged_in();
        $this->load->model('teacher_model');
    }

    public function index() {
        $data['title'] = 'Beranda';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_guru = $data['user']['id_user'];
        $jumlah_orang_hadir = $this->teacher_model->get_absensi_hadir($id_guru);
        $jumlah_orang_sakit = $this->teacher_model->get_absensi_sakit($id_guru);
        $jumlah_orang_izin = $this->teacher_model->get_absensi_izin($id_guru);
        $jumlah_orang_terlambat = $this->teacher_model->get_absensi_terlambat($id_guru);
        $jumlah_siswa_guru= $this->teacher_model->get_guru_siswa($id_guru);

        $jumlah_hadir = count($jumlah_orang_hadir);
        $jumlah_sakit = count($jumlah_orang_sakit);
        $jumlah_izin = count($jumlah_orang_izin);
        $jumlah_terlambat = count($jumlah_orang_terlambat);
        $jumlah_siswa = count($jumlah_siswa_guru);
        
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
        if ($jumlah_siswa > 1) {
            $jumlah_siswa + 1;
        }
        // Kirimkan data ke view
        $data['hadir'] = $jumlah_hadir;
        $data['sakit'] = $jumlah_sakit;
        $data['izin'] = $jumlah_izin;
        $data['terlambat'] = $jumlah_terlambat;
        $data['siswa'] = $jumlah_siswa;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('teacher/index', $data);
        $this->load->view('templates/footer');
    }

    public function select_student(){
        $data['title'] = 'Pilih Siswa';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $data['users'] = $this->teacher_model->get_all_siswa();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('teacher/select_student', $data);
        $this->load->view('templates/footer');
    }
    
    public function modal_select_student(){
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_siswa = $this->input->post('id_siswa');
        $id_guru = $data['user']['id_user'];
        $data = [
                'user_id' => $id_siswa,
                'teacher_id' => $id_guru
        ];
        $this->db->insert('user_teacher', $data);$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
        Siswa Berhasil Di Tambahkan
        </div>');
        redirect('teacher/select_student');
    }
    public function modal_delete_student(){
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_siswa = $this->input->post('id_siswa');
        $id_guru = $data['user']['id_user'];
        $data = [
                'user_id' => $id_siswa,
                'teacher_id' => $id_guru
        ];
        $this->db->delete('user_teacher', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert" style="width: 100%;">
        Siswa Berhasil Di Hapus
        </div>');
        redirect('teacher/datastudent');
    }

    public function DataAbsensi(){
        $data['title'] = 'Data Absensi';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_guru = $data['user']['id_user'];
        $data['absensi'] = $this->teacher_model->get_absensi_siswa($id_guru);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('teacher/dataabsensi', $data);
        $this->load->view('templates/footer');
    }

    public function dataactivities(){
        $data['title'] = 'Data Kegiatan';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_guru = $data['user']['id_user'];
        $data['daily'] = $this->teacher_model->get_activities_siswa($id_guru);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('teacher/dataactivities', $data);
        $this->load->view('templates/footer');
    }

    public function datastudent(){
        $data['title'] = 'Data Siswa';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $id_guru = $data['user']['id_user'];
        $data['users'] = $this->teacher_model->get_guru_siswa($id_guru);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('teacher/datastudent', $data);
        $this->load->view('templates/footer');
    }

    public function profil(){
        $data['title'] = 'Profil';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('teacher/profil', $data);
        $this->load->view('templates/footer');
    }

    public function edit(){
        $data['title'] = 'Ganti Profil';
        $data['user'] =  $this->db->get_where('user', ['email_user' => $this->session->userdata('email_user')])->row_array();

        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('school', 'Sekolah', 'required|trim');
        $this->form_validation->set_rules('nohp', 'No. HP', 'required|trim');
        
        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('teacher/edit', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $name = htmlspecialchars($this->input->post('name')); 
            $email = htmlspecialchars($this->input->post('email')); 
            $school = htmlspecialchars($this->input->post('school'));
            $nohp = htmlspecialchars($this->input->post('nohp'));
            
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
            $this->db->set('no_hp', $nohp);

            $this->db->where('email_user', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your Profile has been updated.</div>');
            redirect('teacher/profil');
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
            $this->load->view('teacher/changepassword', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if(!password_verify($current_password, $data['user']['password'])){
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Lama Salah!!</div>');
                redirect('teacher/changepassword');
            } else {
                if($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Baru Tidak Boleh Sama!!</div>');
                    redirect('teacher/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email_user', $this->session->userdata('email_user'));
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Diganti!!!</div>');
                    redirect('teacher/changepassword');
                }
            }
        }
    }
}