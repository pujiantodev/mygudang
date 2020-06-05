<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{


    /**
     * @return void
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('modelusers');
    }

    /**
     * @return void
     */
    public function index()
    {
        check_not_login(); // cek login atau belum

        $data['user_login'] = $this->fungsi->user_login(); // mengambil data dari libraries Fungsi.PHP
        $data['users'] = $this->fungsi->getUsers(); 

        //load view
        $data['title'] = "MyGudang | List User";
        $this->load->view('template/header', $data);
        $this->template->load('template/viewMainTemplate', 'user/users');
        $this->load->view('template/footer');
    }

    public function add()
    {

        // cek login atau belum
        check_not_login();

        // mengambil data dari libraries >> Fungsi.PHP
        $data['user_login'] = $this->fungsi->user_login();
        $data['title'] = "MyGudang | Add User";

        /**
         * proses validasi inputan user
         */
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]', [
            'is_unique' => 'This username has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|matches[password2]', [
            'matches' => 'Password not match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'trim|required|min_length[3]|matches[password]');



        /**
         * cecking validation 
         */
        if ($this->form_validation->run() ==false) {
            $this->load->view('template/header', $data);
            $this->template->load('template/viewMainTemplate', 'user/user_add_form');
            $this->load->view('template/footer');
        }else {
            $this->modelusers->regUser();
            redirect('users');
            
        }

    }


}
