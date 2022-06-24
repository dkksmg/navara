<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('auth_m');
    }

    public function get_hash($username = null)
    {
        $this->db->select(" password ");
        $this->db->limit(1);
        $this->db->where('username', $username);
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
        check_sudah_login();
        $this->load->view('auth/login');
    }
    public function admin()
    {
        check_sudah_login();
        $this->load->view('auth/loginAdmin');
    }
    // Login pemakai
    public function check_login_user()
    {
        check_sudah_login();
        $this->form_validation->set_rules(
            'nip_user',
            'NIP',
            'required|xss_clean|trim',
            ['required' => 'Username wajib diisi']
        );
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|trim', [
            'required' => 'Password wajib diisi',
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('auth/login');
        } else {
            $nip_user = $this->input->post('nip_user', true);
            $password = $this->input->post('password', true);

            $user = $this->db->get_where('users', ['nip_user' => $nip_user]);
            if ($user->num_rows() > 0) {
                $hasil = $user->row();
                if (password_verify($password, $hasil->password) && $hasil->status == 'Aktif') {

                    $session_data = array(
                        'id'        => $hasil->id,
                        'name'      => $hasil->name,
                        'nip_user'  => $hasil->nip_user,
                        'username'  => $hasil->username,
                        'role'      => $hasil->role,
                        'wilayah'   => $hasil->wilayah,
                        'logged_in' => TRUE,
                    );
                    $this->session->set_userdata($session_data);
                    $this->session->set_flashdata('success', 'Login berhasil. Selamat Datang ' . $hasil->name . '');
                    redirect('pemakai');
                } else if (password_verify($password, $hasil->password) && $hasil->status == 'Tidak Aktif') {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show">
						Akun Anda telah dinonaktifkan.<br>Silahkan hubungi Admin Sistem
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>'
                    );
                    $this->session->set_flashdata('nip_user', $nip_user);
                    redirect('auth');
                } else {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show">
						Password yang Anda masukkan tidak sesuai !
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>'
                    );
                    $this->session->set_flashdata('nip_user', $nip_user);
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show">
					NIP & Password yang Anda masukkan tidak sesuai !
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>'
                );
                $this->session->set_flashdata('nip_user', $nip_user);
                redirect('auth');
            }
        }
    }
    // Login Admin
    public function check_login_admin()
    {
        check_sudah_login();
        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|xss_clean|trim',
            ['required' => 'Username wajib diisi']
        );
        $this->form_validation->set_rules('password', 'Password', 'required', [
            'required' => 'Password wajib diisi',
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('auth/loginAdmin');
            // redirect('auth/admin');
        } else {
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);

            $user = $this->db->get_where('users', ['username' => $username]);
            if ($user->num_rows() > 0) {
                $hasil = $user->row();
                if (password_verify($password, $hasil->password) && $hasil->status == 'Aktif') {
                    // Login Superadmin & Admin
                    if ($hasil->role == 'Superadmin' || $hasil->role == 'Admin') {
                        $session_data = array(
                            'id'        => $hasil->id,
                            'name'      => $hasil->name,
                            'username'  => $hasil->username,
                            'role'      => $hasil->role,
                            'wilayah'   => $hasil->wilayah,
                            'logged_in' => TRUE,
                        );
                        $this->session->set_userdata($session_data);
                        $this->session->set_flashdata('success', 'Login berhasil. Selamat Datang ' . $hasil->name . '');
                        redirect('dashboard');
                    } else {
                        $this->session->set_flashdata(
                            'message',
                            '<div class="alert alert-danger alert-dismissible fade show">
                            Maaf, akun tidak ditemukan. Silakan login kembali dengan akun yang sesuai.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                        );
                        $this->session->set_flashdata('username', $username);
                        redirect('auth/admin');
                    }
                } else if (password_verify($password, $hasil->password) && $hasil->status == 'Tidak Aktif') {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show">
						Akun Anda dinonaktifkan.<br>Silahkan hubungi Admin Sistem
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>'
                    );
                    $this->session->set_flashdata('username', $username);
                    redirect('auth/admin');
                } else {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show">
						Password yang Anda masukkan tidak sesuai !
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>'
                    );
                    $this->session->set_flashdata('username', $username);
                    redirect('auth/admin');
                }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show">
					Username & Password yang Anda masukkan tidak sesuai !
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>'
                );
                $this->session->set_flashdata('username', $username);
                redirect('auth/admin');
            }
        }
    }
    public function logout_user()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger alert-dismissible fade show">
            Anda Berhasil Logout
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>'
        );
        redirect('auth');
    }
    public function logout_admin()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger alert-dismissible fade show">
            Anda Berhasil Logout
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>'
        );
        redirect('auth/admin');
    }
}