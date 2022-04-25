<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

function check_sudah_login()
{
    $ci = &get_instance();
    $session = $ci->session->userdata('logged_in');
    if ($session == TRUE) {
        redirect('home');
    }
}
function check_session()
{
    $ci = &get_instance();
    $session = $ci->session->userdata('logged_in');
    if ($session != TRUE) {
        $ci->session->set_flashdata(
            'message',
            '<div class="alert alert-danger alert-dismissible fade show">
		Silahkan Masuk terlebih dahulu !
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>'
        );
        redirect('auth');
    }
}
function id_aset()
{
    $ci = &get_instance();
    $ci->db->select('RIGHT(kendaraan.id_assets,4) as id_aset', FALSE);
    $ci->db->order_by('id_aset', 'DESC');
    $ci->db->limit(1);
    $query = $ci->db->get('kendaraan');

    if ($query->num_rows() <> 0) {
        $data = $query->row();
        $kode = intval($data->id_aset) + 1;
    } else {
        $kode = 1;
    }
    $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);
    $kodetampil = "KDN-" . $batas;
    return $kodetampil;
}