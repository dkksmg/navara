<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_m extends CI_Model {

	function __construct()
	{
		parent :: __construct();
	}

    public function data_kendaraan()
    {   
        if ($this->session->userdata('rule')=='admin') {
            $this->db->where('user_id',$this->session->userdata('id'));
        }
        $query = $this->db->get('kendaraan');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    }
    public function dataKendaraanByid($id=null)
    {   
        $this->db->where('idk',$id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil=$row ; }
            return $hasil;
        }
    }
    public function data_rekap($dari=null,$sampai=null)
    {   
        
        $this->db->select(" count(*) as jml, sum(if(riwayat_kondisi.kondisi = 'Baik',1,0)) as baik,sum(if(riwayat_kondisi.kondisi = 'Rusak Ringan',1,0)) as ringan,sum(if(riwayat_kondisi.kondisi = 'Rusak Sedang',1,0)) as sedang,sum(if(riwayat_kondisi.kondisi = 'Rusak Berat',1,0)) as berat ");
        $this->db->join('(SELECT * from riwayat_kondisi group by id_kendaraan ) riwayat_kondisi','riwayat_kondisi.id_kendaraan=kendaraan.idk');
        $query = $this->db->get('kendaraan');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatKondisi($id=null)
    {   
        $this->db->where('id_kendaraan',$id);
        $query = $this->db->get('riwayat_kondisi');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatbbm($id=null)
    {   
        $this->db->where('id_kendaraan',$id);
        $query = $this->db->get('riwayat_bbm');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatpajak($id=null)
    {   
        $this->db->where('id_kendaraan',$id);
        $query = $this->db->get('riwayat_pajak');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    }
    public function cek_tahun_pajak($id=null,$tahun=null)
    {   
        $this->db->where('id_kendaraan',$id);
        $this->db->where('tahun',$tahun);
        $query = $this->db->get('riwayat_pajak');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatpemakai($id=null)
    {   
        $this->db->where('id_kendaraan',$id);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatpemakaibyid($id=null)
    {   
        $this->db->where('id_kendaraan',$id);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatpemakaibyidrp($id=null)
    {   
        $this->db->where('id_rp',$id);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatpemakaibynip($nopol=null)
    {   
        $this->db->join('kendaraan','riwayat_pemakai.id_kendaraan=kendaraan.idk');
        // $this->db->where('nip_pemakai',$nip);
        $this->db->where('kendaraan.no_polisi',$nopol);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatpemakaibynopolandstatus($nopol=null)
    {   
        $this->db->join('kendaraan','riwayat_pemakai.id_kendaraan=kendaraan.idk');
        $this->db->where('riwayat_pemakai.status','aktif');
        $this->db->where('kendaraan.no_polisi',$nopol);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatservis($id=null)
    {   
        $this->db->where('id_kendaraan',$id);
        $query = $this->db->get('riwayat_servis');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    }
    public function data_riwayatKondisibyid($id=null)
    {   
        $this->db->where('id_rk',$id);
        $query = $this->db->get('riwayat_kondisi');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil=$row ; }
            return $hasil;
        }
    } 
    public function kendaraanByid($id=null)
    {   
        $this->db->where('idk',$id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil=$row ; }
            return $hasil;
        }
    } 
    public function data_lokasiunit()
    {   
        $query = $this->db->get('ref_lokasi_unit');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    } 

    public function tambahKendaraanDinas(){

        $data['id_assets']          = $this->input->post('idassets');
        $data['no_polisi']          = $this->input->post('nopolawaal')." ".$this->input->post('nopolangka')." ".$this->input->post('nopolakhir');
        $data['merk']               = $this->input->post('merk');
        $data['tipe']               = $this->input->post('tipe');
        $data['jenis']              = $this->input->post('jeniskendaraan');
        $data['no_stnk']            = $this->input->post('nostnk');
        $data['no_mesin']           = $this->input->post('nomesin');
        $data['no_rangka']          = $this->input->post('norangka');
        $data['tahun_perolehan']    = $this->input->post('tahunperolehan');
        $data['jenis_bb']           = $this->input->post('jenisbb');
        $data['besar_cc']           = $this->input->post('besarcc');
        $data['masa_berlaku_stnk']  = date('Y-m-d',strtotime($this->input->post('tgl_stnk')));
        $data['status']             = "aktif";

        $data['user_id']            = $this->session->userdata('id');

        $q = $this->db->insert('kendaraan',$data);
        return $q;
    }
    public function edit_kendaraan($id=null){

        $data['id_assets']          = $this->input->post('idassets');
        $data['no_polisi']          = $this->input->post('nopol');
        $data['merk']               = $this->input->post('merk');
        $data['tipe']               = $this->input->post('tipe');
        $data['jenis']              = $this->input->post('jeniskendaraan');
        $data['no_stnk']            = $this->input->post('nostnk');
        $data['no_mesin']           = $this->input->post('nomesin');
        $data['no_rangka']          = $this->input->post('norangka');
        $data['tahun_perolehan']    = $this->input->post('tahunperolehan');
        $data['jenis_bb']           = $this->input->post('jenisbb');
        $data['besar_cc']           = $this->input->post('besarcc');
        $data['masa_berlaku_stnk']  = date('Y-m-d',strtotime($this->input->post('tgl_stnk')));

        $this->db->where('idk',$id);
        $q = $this->db->update('kendaraan',$data);
        return $q;
    }

    public function tambahriwayatkendaraan($dpn=null,$blkg=null,$kiri=null,$kanan=null,$idk=null){
        $data['foto_tampak_depan']      = $dpn;
        $data['foto_tampak_blakang']    = $blkg;
        $data['foto_tampak_kiri']       = $kiri;
        $data['foto_tampak_kanan']      = $kanan;
        $data['id_kendaraan']           = $idk;
        $data['tgl_pencatatan']         = date('Y-m-d');

        $data['kondisi']          = $this->input->post('kondisi');
        $data['input_pemakai']          = $this->session->userdata('name');
        if ($this->session->userdata('rule')=='admin'||$this->session->userdata('rule')=='superadmin') {
            $data['input_user']             = $this->session->userdata('id');
        }
        if ($this->session->userdata('rule')=='pemakai') {
            $data['id_pemakai']             = $this->session->userdata('id');
        }
        $data['input_user']             = $this->session->userdata('id');
        $q = $this->db->insert('riwayat_kondisi',$data);
        return $idk;

    }

    public function hapusriwayatkondisi($idrk=null){

        $rkbyid = $this->data_riwayatKondisibyid($idrk);
        if (isset($rkbyid['foto_tampak_depan'])) { unlink('./assets/file_kendaraan/'.$rkbyid['foto_tampak_depan']); }
        if (isset($rkbyid['foto_tampak_blakang'])) { unlink('./assets/file_kendaraan/'.$rkbyid['foto_tampak_blakang']); }
        if (isset($rkbyid['foto_tampak_kiri'])) { unlink('./assets/file_kendaraan/'.$rkbyid['foto_tampak_kiri']); }
        if (isset($rkbyid['foto_tampak_kanan'])) { unlink('./assets/file_kendaraan/'.$rkbyid['foto_tampak_kanan']); }

        $this->db->where('id_rk',$idrk);
        $q = $this->db->delete('riwayat_kondisi');
        return $rkbyid['id_kendaraan'];
    }

    public function prosestambahPemakai($idk=null){

        $data['id_kendaraan']   = $idk;
        $data['status']         = "aktif";
        $data['nama_pemakai']   = $this->input->post('nama');   
        $data['lokasi_unit']    = $this->input->post('lokunit');   
        $data['nip_pemakai']    = $this->input->post('nip');   
        $data['tgl_awal']       = date('Y-m-d',strtotime($this->input->post('dari')));   
        $data['tgl_akhir']      = date('Y-m-d',strtotime($this->input->post('sampai')));

        $q = $this->db->insert('riwayat_pemakai',$data);
        return $q;   
    }

    public function tambahriwayatserviskendaraan($fotoservis=null,$idk=null,$nota=null){

        $data['id_kendaraan'] = $idk;
        $data['foto_servis']  = $fotoservis;
        $data['foto_nota']  = $nota;

        $data['tgl_servis']         = date('Y-m-d',strtotime($this->input->post('tgl')));
        $data['lokasi']             = $this->input->post('bengkel');
        $data['keluhan']            = $this->input->post('keluhan');
        $data['perbaikan']          = $this->input->post('perbaikan');
        $data['total_biaya']        = $this->input->post('biaya');

        $q = $this->db->insert('riwayat_servis',$data);
        return $q;
    }

    public function nonaktifkanpemakai($id=null){

        $data['status'] = "tidak_aktif";
        $this->db->Where('id_rp',$id);
        $q = $this->db->update('riwayat_pemakai',$data);
        return $q;
    }
    public function aktifkanpemakai($id=null){

        $data['status'] = "aktif";
        $this->db->Where('id_rp',$id);
        $q = $this->db->update('riwayat_pemakai',$data);
        return $q;
    }

    public function tambahriwayatbbm($id=null){

        $data['id_kendaraan'] = $id;
        $data['tgl_pencatatan'] = date('Y-m-d',strtotime($this->input->post('tgl_bbm')));
        $data['total_bbm'] = $this->input->post('harga_bbm');
        $data['user_id'] = $this->session->userdata('id');

        $q = $this->db->insert('riwayat_bbm',$data);
        return $q;
    }
    public function tambahriwayatpajak($id=null){

        $data['id_kendaraan'] = $id;
        $data['tgl_pencatatan'] = date('Y-m-d');
        $data['total_harga'] = $this->input->post('total_pajak');
        $data['user_id'] = $this->session->userdata('id');
        $data['tahun'] = $this->input->post('tahun');

        $q = $this->db->insert('riwayat_pajak',$data);
        return $q;
    }

    public function hapusbbm($id=null){
        $this->db->where('id_bbm',$id);
        $q = $this->db->delete('riwayat_bbm');
        return $q;
    }

}
