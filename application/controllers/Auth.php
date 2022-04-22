<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('auth_m');
    } 

    public function get_hash($username=null)
    {
        $this->db->select(" password ");
        $this->db->limit(1);
        $this->db->where('username',$username);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row['password'];
            }
            return $hasil;
        }
    }

	public function index()
	{
        $this->load->view('auth/login');
	}

    public function pemakai()
    {
        $this->load->view('auth/loginPemakai');
    }

    public function loginadminProses(){
        if ($this->input->post()) {
                $username = $this->input->post("username", TRUE);
                $hash = $this->get_hash($username);
                $password = $this->input->post('password');
                $fixpass = password_verify($password, $hash);
                if ($fixpass) {
                    $pass =  "cocok";
                }else{
                    $pass = "tidak cocok";
                }
                $checking = $this->auth_m->check_login('users', array('username' => $username), array('password' => $password));
                    if ($pass=="cocok"&&$checking != FALSE) {
                        foreach ($checking as $apps) {  
                            $rule = $apps->rule;
                            $session_data = array(
                                'id'        => $apps->id,
                                'name'      => $apps->name,
                                'username'  => $apps->username,
                                'rule'      => $apps->role,
                                'wilayah'   => $apps->wilayah,
                                'kode'      => $apps->kode,
                                'logged_in' => TRUE,                            
                                'logged_in_admin' => TRUE                            
                            );
                            //set session userdata
                            $this->session->set_userdata($session_data);
                            $this->session->set_flashdata('success','login berhasil');
                            redirect('home/');      

                        }
                    }else{
                        $this->session->set_flashdata('danger','username atau password anda salah');
                        redirect('auth/');      

                    }                    

        }   
    }
    public function loginuserProses(){
        if ($this->input->post()) {
                $nopol  = $this->input->post("nopol", TRUE);
                $nik    = $this->input->post("nik", TRUE);
   
                $checking = $this->auth_m->check_login_users('riwayat_pemakai', array('no_polisi' => $nopol), array('nip_pemakai' => $nik));
                    if ($checking != FALSE) {
                        foreach ($checking as $apps) {  
                            $rule = $apps->rule;
                            $session_data = array(
                                'id'        => $apps->id_rp,
                                'idkend'    => $apps->id_kendaraan,
                                'name'      => $apps->nama_pemakai,
                                'nik'       => $apps->nik,
                                'rule'      => "pemakai",
                                'logged_in' => TRUE,                            
                                'logged_in_user' => TRUE                            
                            );
                            //set session userdata
                            $this->session->set_userdata($session_data);
                            $this->session->set_flashdata('success','login berhasil');
                            redirect('pemakai/');      

                        }
                    }else{
                        $this->session->set_flashdata('danger','username atau password anda salah');
                        redirect('auth/pemakai');      

                    }                    

        }   
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth','refresh');
    }  
}
