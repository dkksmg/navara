<?php
defined('BASEPATH') or exit('No direct script access allowed');

class E404 extends CI_Controller
{
    function index()
    {
        // $data['title'] = 'Maaf, halaman tidak ditemukan.';
        $this->output->set_status_header('404');
        $this->load->view('errors/e404');
        // $this->output->set_header('refresh:5;home');
    }
}