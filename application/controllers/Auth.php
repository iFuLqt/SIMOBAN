<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller { 

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index() {
        if($this->session->userdata('email_user')) {
            redirect('user');
        }
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('password','Password','trim|required');
        if($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
            
        } else {
            // validasinya sukses
            $this->_login();
        }
    }

    private function _login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email_user' => $email])->row_array();
        // jika usernya ada
        if($user) {
            // jika usernya active
            if($user['is_active'] == 1){
                // cek password
                if(password_verify($password, $user['password'])) {
                    $data = [
                        'email_user' => $user ['email_user'],
                        'id_role' => $user ['id_role']
                    ];
                    $this->session->set_userdata($data);
                    if($user['id_role'] == 1) {
                        redirect('admin');
                    } else if($user['id_role'] == 2) {
                        redirect('mentor');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email has not been activated!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered</div>');
            redirect('auth');
        }
    }
    
    

    public function logout() {
        $this->session->unset_userdata('email_user');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('auth');
    }

    public function blocked(){
        $this->load->view('auth/blocked');
    }

}