<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function data_kendaraan()
    {
        if ($this->session->userdata('role') == 'Admin') :
            $data['user'] = $this->db
                ->get_where('users', [
                    'id' => $this->session->userdata('id'),
                ])
                ->row_array();
            $lokasi = $data['user']['wilayah'];
            $query = $this->db->join('riwayat_pemakai', 'riwayat_pemakai.id_kendaraan = kendaraan.idk', 'left')
                ->join('ref_lokasi_unit', 'riwayat_pemakai.lokasi_unit = ref_lokasi_unit.lokasi_unit', 'inner')
                ->join('users as us', 'us.id = riwayat_pemakai.id_user', 'left')
                ->order_by('idk', 'asc')
                ->group_start()
                ->where(array('riwayat_pemakai.status' => 'aktif', 'riwayat_pemakai.lokasi_unit' => $lokasi))
                // ->or_where('riwayat_pemakai.status is null')
                ->group_end()
                ->get('kendaraan');
        else :
            $query = $this->db
                // ->order_by('rp.is_pejabat', 'DESC')
                ->order_by('kn.idk', 'ASC')
                ->join('riwayat_pemakai as rp', 'kn.idk = rp.id_kendaraan', 'left')
                ->join('users as us', 'us.id = rp.id_user', 'left')
                ->where('kn.status', 'aktif')
                ->group_start()
                ->where(array('rp.status' => 'aktif'))
                ->or_where('rp.status is null')
                ->group_end()
                ->get('kendaraan as kn');
        endif;

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_kendaraan_all()
    {
        $query = $this->db
            // ->order_by('rp.is_pejabat', 'DESC')
            ->order_by('kn.idk', 'ASC')
            // ->join('riwayat_pemakai as rp', 'kn.idk = rp.id_kendaraan', 'left')
            // ->join('users as us', 'us.id = rp.id_user', 'left')
            ->where('kn.status', 'aktif')
            // ->group_start()
            // ->where(array('rp.status' => 'aktif'))
            // ->or_where('rp.status is null')
            // ->group_end()
            ->get('kendaraan as kn');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function dataKendaraanByid($id = null)
    {
        $this->db->where('idk', $id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_rekap($dari = null, $sampai = null)
    {

        $this->db->select(" count(*) as jml, sum(if(riwayat_kondisi.kondisi = 'Baik',1,0)) as baik,sum(if(riwayat_kondisi.kondisi = 'Rusak Ringan',1,0)) as ringan,sum(if(riwayat_kondisi.kondisi = 'Rusak Sedang',1,0)) as sedang,sum(if(riwayat_kondisi.kondisi = 'Rusak Berat',1,0)) as berat ");
        $this->db->join('(SELECT * from riwayat_kondisi group by id_kendaraan order BY created_rk DESC) riwayat_kondisi', 'riwayat_kondisi.id_kendaraan=kendaraan.idk');
        $this->db->where("tgl_pencatatan BETWEEN '$dari' AND '$sampai'");
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_servis($tahun = null)
    {
        $this->db
            ->order_by('rp.is_pejabat', 'DESC')
            ->order_by('cast(ps.pagu_awal as int)', 'DESC')
            ->order_by('kn.jenis', 'DESC')
            ->order_by('kn.merk', 'ASC')
            ->order_by('kn.tipe', 'DESC')
            ->order_by('kn.no_polisi', 'ASC')
            // ->order_by('us.name', 'DESC')
            ->join('pagu_service as ps', 'ps.id_kend = kn.idk', 'left')
            ->join('riwayat_pemakai as rp', 'rp.id_kendaraan=kn.idk', 'left')
            ->join('users as us', 'us.id=rp.id_user', 'left')
            ->where('kn.status', 'aktif')
            ->where('ps.tahun', $tahun)
            ->group_start()
            ->where(array('rp.status' => 'aktif'))
            ->or_where('rp.status is null')
            ->group_end();
        $query = $this->db->get('kendaraan as kn');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatKondisi($id = null)
    {
        $this->db
            ->join('users as us', 'us.id=rk.input_user', 'left')
            ->order_by('rk.tgl_pencatatan', 'DESC')
            ->where('rk.id_kendaraan', $id);
        $query = $this->db->get('riwayat_kondisi as rk');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatbbm($id = null)
    {
        $this->db
            ->order_by('rbm.tgl_pencatatan', 'DESC')
            ->order_by('rbm.created_bbm', 'DESC')
            ->join('users as us', 'us.id=rbm.input_user', 'left')
            ->where('rbm.id_kendaraan', $id);
        $query = $this->db->get('riwayat_bbm as rbm');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatbbm_byid($id_bbm = null)
    {
        $this->db->where('id_bbm', $id_bbm);
        $query = $this->db->get('riwayat_bbm')->row_array();
        return $query;
    }
    public function data_riwayatpajak($id = null)
    {
        $this->db->order_by('rpk.tahun', 'DESC')
            ->join('users as us', 'us.id=rpk.input_user', 'left');
        $this->db->where('rpk.id_kendaraan', $id);
        $query = $this->db->get('riwayat_pajak as rpk');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function cek_tahun_pajak($id = null, $tahun = null)
    {
        $this->db->where('id_kendaraan', $id);
        $this->db->where('tahun', $tahun);
        $query = $this->db->get('riwayat_pajak');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_kendaraan($id = null)
    {
        $this->db->where('idk', $id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_riwayat_kondisi($id = null)
    {
        $this->db->join('riwayat_kondisi as rk', 'rk.id_kendaraan = kn.idk', 'left');
        $this->db->where('kn.idk', $id);
        $query = $this->db->get('kendaraan as kn');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_edit_riwayat_kondisi($id = null)
    {
        $this->db->where('id_rk', $id);
        $query = $this->db->get('riwayat_kondisi');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_riwayat_pengajuan_servis($id = null)
    {
        $this->db->join('riwayat_pengajuan_servis', 'riwayat_pengajuan_servis.id_kendaraan = kendaraan.idk', 'left');
        $this->db->where('idk', $id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_edit_riwayat_pengajuan_servis($id_pen = null)
    {
        $this->db->where('id_pengajuan', $id_pen);
        $query = $this->db->get('riwayat_pengajuan_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_riwayat_pemakai($id = null)
    {
        $this->db->join('riwayat_pemakai', 'riwayat_pemakai.id_kendaraan = kendaraan.idk', 'left');
        $this->db->where('idk', $id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_edit_riwayat_pemakai($id = null)
    {
        $this->db->where('id_rp', $id);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_riwayat_servis($id = null)
    {
        $this->db->join('riwayat_servis', 'riwayat_servis.id_kendaraan = kendaraan.idk', 'left');
        $this->db->where('idk', $id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_edit_riwayat_servis($id = null)
    {
        $this->db->where('id_rs', $id);
        $query = $this->db->get('riwayat_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_riwayat_bbm($id = null)
    {
        $this->db->join('riwayat_bbm', 'riwayat_bbm.id_kendaraan = kendaraan.idk', 'left');
        $this->db->where('idk', $id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_edit_riwayat_bbm($id_bbm = null, $id_kend = null)
    {
        $this->db->where('id_bbm', $id_bbm);
        $this->db->where('id_kendaraan', $id_kend);
        $query = $this->db->get('riwayat_bbm');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_riwayat_pajak($id = null)
    {
        $this->db->join('riwayat_pajak', 'riwayat_pajak.id_kendaraan = kendaraan.idk', 'left');
        $this->db->where('idk', $id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_edit_riwayat_pajak($id = null)
    {
        $this->db->where('id_pjk', $id);
        $query = $this->db->get('riwayat_pajak');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_riwayat_pagu($id = null)
    {
        $this->db->join('pagu_service', 'pagu_service.id_kend = kendaraan.idk', 'left');
        $this->db->where('idk', $id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_edit_riwayat_pagu($id = null)
    {
        $this->db->where('id_ps', $id);
        $query = $this->db->get('pagu_service');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_riwayat_pengajuan($id_pengajuan = null, $id_kend = null)
    {
        $this->db->join('riwayat_pengajuan_servis', 'riwayat_pengajuan_servis.id_kendaraan = kendaraan.idk', 'left');
        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->where('id_kendaraan', $id_kend);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_id_riwayat_kondisi_pemakai($id = null)
    {
        $this->db->join('riwayat_kondisi as rk', 'rk.id_kendaraan = kn.idk', 'left');
        $this->db->where('kn.idk', $id);
        $query = $this->db->get('kendaraan as kn');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function listdata_pemakai()
    {

        $this->db->select('id,name,nip_user,wilayah,role,status')->order_by('id', 'DESC')->where('role', 'Pemakai');
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpemakai($id = null)
    {
        $this->db->join('users as us', 'rp.id_user=us.id')->select('rp.id_rp,rp.id_kendaraan,rp.id_user,rp.lokasi_unit,rp.tgl_awal,rp.tgl_akhir,rp.status, us.id, us.name, us.nip_user')->where('rp.id_kendaraan', $id);
        $query = $this->db->get('riwayat_pemakai as rp');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_pemakaibyid($id = null)
    {
        $this->db->join('kendaraan', 'riwayat_pemakai.id_kendaraan = kendaraan.idk');
        $this->db->where('id_rp', $id);
        $query = $this->db->get('riwayat_pemakai')->row_array();
        return $query;
    }
    public function nonaktifkanpemakai($id = null)
    {

        $data['status'] = "tidak_aktif";
        $this->db->Where('id_rp', $id);
        $q = $this->db->update('riwayat_pemakai', $data);
        return $q;
    }
    public function hapus_pemakai($id = null)
    {
        $this->db->where('id_rp', $id);
        $q = $this->db->delete('riwayat_pemakai');
        return $q;
    }
    public function aktifkanpemakai($id = null)
    {

        $data['status'] = "aktif";
        $this->db->Where('id_rp', $id);
        $q = $this->db->update('riwayat_pemakai', $data);
        return $q;
    }

    public function data_riwayatpemakaibyid($id = null)
    {
        $this->db->where('id_kendaraan', $id);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpemakaibyidrp($id = null)
    {
        $this->db->where('id_rp', $id);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatservisbyidrp($id = null)
    {
        $this->db->where('id_rs', $id);
        $query = $this->db->get('riwayat_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpemakaibynip($nopol = null)
    {
        $this->db->join('kendaraan', 'riwayat_pemakai.id_kendaraan=kendaraan.idk');
        // $this->db->where('nip_pemakai',$nip);
        $this->db->where('kendaraan.no_polisi', $nopol);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpemakaibynopolandstatus($id_kend = null)
    {
        $this->db->join('kendaraan', 'riwayat_pemakai.id_kendaraan=kendaraan.idk');
        $this->db->where('riwayat_pemakai.status', 'aktif');
        $this->db->where('kendaraan.idk', $id_kend);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpemakaibypilihanpemakai($id_nama_pemakai = null)
    {
        $this->db->join('kendaraan', 'riwayat_pemakai.id_kendaraan=kendaraan.idk');
        $this->db->join('users', 'users.id=riwayat_pemakai.id_user');
        $this->db->where('riwayat_pemakai.status', 'aktif');
        $this->db->where('riwayat_pemakai.id_user', $id_nama_pemakai);
        $query = $this->db->get('riwayat_pemakai');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatservis($id = null)
    {
        $this->db
            ->join('users as us', 'us.id=rs.input_user', 'left')
            ->where('rs.id_kendaraan', $id);
        $query = $this->db
            ->order_by('rs.tgl_servis', 'DESC')
            ->order_by('rs.created_rs', 'DESC')
            ->get('riwayat_servis as rs');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function data_servisById($id)
    {
        $query = $this->db
            ->join('kendaraan', 'riwayat_servis.id_kendaraan = kendaraan.idk')
            ->get_where('riwayat_servis', ['id_rs' => $id])
            ->row_array();
        return $query;
    }
    public function data_kondisiById($id)
    {
        $query = $this->db
            ->join('kendaraan', 'riwayat_kondisi.id_kendaraan = kendaraan.idk')
            ->get_where('riwayat_kondisi', ['id_rk' => $id])
            ->row_array();
        return $query;
    }
    public function data_riwayatKondisibyid($id = null)
    {
        $this->db->where('id_rk', $id);
        $query = $this->db->get('riwayat_kondisi');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatBBMbyid($id = null)
    {
        $this->db->where('id_bbm', $id);
        $query = $this->db->get('riwayat_bbm');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatPajakbyid($id = null)
    {
        $this->db->where('id_pjk', $id);
        $query = $this->db->get('riwayat_pajak');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function kendaraanByid($id = null)
    {
        $this->db
            ->where('idk', $id);
        $query = $this->db->get('kendaraan as kn');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function pagukendaraanById($id = null, $tahun = null)
    {
        $query = $this->db->query('SELECT * FROM pagu_service as ps 
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_bbm.tgl_pencatatan)=' . $tahun . ' AND riwayat_bbm.status_rbm="Yes", riwayat_bbm.total_bbm,0)) as total_biaya_bbm FROM riwayat_bbm group by id_kendaraan ) rb ON rb.id_kendaraan=ps.id_kend
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_servis.tgl_servis)=' . $tahun . ' AND riwayat_servis.status_srs="Yes",riwayat_servis.total_biaya,0)) as total_biaya_servis FROM riwayat_servis group by id_kendaraan ) rs ON rs.id_kendaraan=ps.id_kend
        LEFT JOIN (SELECT id_kendaraan, sum(if(riwayat_pajak.tahun=' . $tahun . ' AND riwayat_pajak.status_pjk="Yes",riwayat_pajak.total_pajak,0)) as total_biaya_pajak FROM riwayat_pajak group by id_kendaraan ) rpk ON rpk.id_kendaraan=ps.id_kend
        WHERE ps.id_kend = ' . $id . ' AND ps.tahun = ' . $tahun . '')->row_array();
        return $query;
    }
    public function kendaraanByidwithpagu($id = null, $tahun = null)
    {
        $query = $this->db->query('SELECT * FROM kendaraan as kn 
        LEFT JOIN pagu_service as ps ON ps.id_kend=kn.idk 
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_bbm.tgl_pencatatan)=' . $tahun . ' AND riwayat_bbm.status_rbm="Yes", riwayat_bbm.total_bbm,0)) as total_biaya_bbm FROM riwayat_bbm group by id_kendaraan ) rb ON rb.id_kendaraan=ps.id_kend
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_servis.tgl_servis)=' . $tahun . ' AND riwayat_servis.status_srs="Yes",riwayat_servis.total_biaya,0)) as total_biaya_servis FROM riwayat_servis group by id_kendaraan ) rs ON rs.id_kendaraan=ps.id_kend
        LEFT JOIN (SELECT id_kendaraan, sum(if(riwayat_pajak.tahun=' . $tahun . ' AND riwayat_pajak.status_pjk="Yes",riwayat_pajak.total_pajak,0)) as total_biaya_pajak FROM riwayat_pajak group by id_kendaraan ) rpk ON rpk.id_kendaraan=ps.id_kend
        WHERE kn.idk = ' . $id . ' AND ps.tahun = ' . $tahun . '')->row_array();
        return $query;
    }
    public function kendaraanByidwithpaguadmin($id = null, $tahun = null)
    {
        $query = $this->db->query('SELECT * FROM kendaraan as kn 
        LEFT JOIN pagu_service as ps ON ps.id_kend=kn.idk 
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_bbm.tgl_pencatatan)=' . $tahun . ' AND riwayat_bbm.status_rbm="Yes", riwayat_bbm.total_bbm,0)) as total_biaya_bbm FROM riwayat_bbm group by id_kendaraan ) rb ON rb.id_kendaraan=ps.id_kend
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_servis.tgl_servis)=' . $tahun . ' AND riwayat_servis.status_srs="Yes",riwayat_servis.total_biaya,0)) as total_biaya_servis FROM riwayat_servis group by id_kendaraan ) rs ON rs.id_kendaraan=ps.id_kend
        LEFT JOIN (SELECT id_kendaraan, sum(if(riwayat_pajak.tahun=' . $tahun . ' AND riwayat_pajak.status_pjk="Yes",riwayat_pajak.total_pajak,0)) as total_biaya_pajak FROM riwayat_pajak group by id_kendaraan ) rpk ON rpk.id_kendaraan=ps.id_kend
        WHERE kn.idk = ' . $id . ' AND ps.tahun = ' . $tahun . '')->row_array();
        return $query;
    }
    public function kendaraanUser_old($id = null, $tahun = null)
    {
        $this->db
            ->join('riwayat_pemakai as rp', 'rp.id_user = us.id')
            ->join('kendaraan as kd', 'kd.idk = rp.id_kendaraan')
            ->where('us.id', $id)
            ->where('rp.status', 'aktif');
        $query = $this->db->get('users as us');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function kendaraanUser($id = null, $tahun = null)
    {
        $query = $this->db->query('SELECT * FROM users as us 
        JOIN riwayat_pemakai as rp ON rp.id_user = us.id 
        JOIN kendaraan as kd ON kd.idk = rp.id_kendaraan 
        LEFT JOIN pagu_service as ps ON ps.id_kend = kd.idk 
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_bbm.tgl_pencatatan)=' . $tahun . ' AND riwayat_bbm.status_rbm="Yes" , riwayat_bbm.total_bbm,0)) as total_biaya_bbm FROM riwayat_bbm group by id_kendaraan ) rb ON rb.id_kendaraan=ps.id_kend
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_servis.tgl_servis)=' . $tahun . ' AND riwayat_servis.status_srs="Yes",riwayat_servis.total_biaya,0)) as total_biaya_servis FROM riwayat_servis group by id_kendaraan ) rs ON rs.id_kendaraan=ps.id_kend
        LEFT JOIN (SELECT id_kendaraan, sum(if(riwayat_pajak.tahun=' . $tahun . ' AND riwayat_pajak.status_pjk="Yes",riwayat_pajak.total_pajak,0)) as total_biaya_pajak FROM riwayat_pajak group by id_kendaraan ) rpk ON rpk.id_kendaraan=ps.id_kend
        WHERE us.id = ' . $id . ' AND (CASE WHEN ps.tahun is null THEN ps.tahun is null ELSE ps.tahun=' . $tahun . ' END) AND rp.status = "aktif"')->result_array();
        return $query;
    }
    public function cek_datapagu($id = null, $tahun = null)
    {
        $query = $this->db->query("SELECT * FROM `pagu_service` 
        LEFT JOIN (SELECT id_kendaraan, sum(if(riwayat_pajak.tahun='$tahun' AND riwayat_pajak.status_pjk='Yes', riwayat_pajak.total_pajak,0)) as total_biaya_pajak FROM riwayat_pajak group by id_kendaraan ) rp ON `rp`.`id_kendaraan`=`pagu_service`.`id_kend` 
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_servis.tgl_servis)='$tahun' AND riwayat_servis.status_srs='Yes', riwayat_servis.total_biaya,0)) as total_biaya_servis FROM riwayat_servis group by id_kendaraan ) rs ON `rs`.`id_kendaraan`=`pagu_service`.`id_kend` 
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_bbm.tgl_pencatatan)='$tahun' AND riwayat_bbm.status_rbm='Yes', riwayat_bbm.total_bbm,0)) as total_biaya_bbm FROM riwayat_bbm group by id_kendaraan ) rb ON `rb`.`id_kendaraan`=`pagu_service`.`id_kend` 
        WHERE pagu_service.id_kend='$id' AND pagu_service.tahun='$tahun'")->result_array();
        return $query;
    }
    public function cekkendaraanUser($id = null)
    {
        $query = $this->db
            ->join('riwayat_pemakai as rp', 'rp.id_user = us.id')
            ->join('kendaraan as kd', 'kd.idk = rp.id_kendaraan')
            ->where('us.id', $id)
            ->where('rp.status', 'aktif')->get('users as us')->result_array();
        return $query;
    }
    public function cekkendaraanUserwithriwayatkondisi($id_user = null, $id = null)
    {
        $query = $this->db
            ->join('riwayat_pemakai as rp', 'rp.id_user = us.id')
            ->join('riwayat_kondisi as rk', ' rk.id_kendaraan=rp.id_kendaraan')
            ->join('kendaraan as kd', 'kd.idk = rp.id_kendaraan')
            ->where('rk.status_rk', 'No')
            ->where('rk.id_rk', $id)
            ->where('us.id', $id_user)
            ->where('rp.status', 'aktif')->get('users as us')->result_array();
        return $query;
    }
    public function cekkendaraanUserwithriwayatbbm($id_user = null, $id = null)
    {
        $query = $this->db
            ->join('riwayat_pemakai as rp', 'rp.id_user = us.id')
            ->join('riwayat_bbm as rbm', ' rbm.id_kendaraan=rp.id_kendaraan')
            ->join('kendaraan as kd', 'kd.idk = rp.id_kendaraan')
            ->where('rbm.status_rbm', 'No')
            ->where('rbm.id_bbm', $id)
            ->where('us.id', $id_user)
            ->where('rp.status', 'aktif')->get('users as us')->result_array();
        return $query;
    }
    public function cekkendaraanUserwithriwayatpajak($id_user = null, $id = null)
    {
        $query = $this->db
            ->join('riwayat_pemakai as rp', 'rp.id_user = us.id')
            ->join('riwayat_pajak as pjk', ' pjk.id_kendaraan=rp.id_kendaraan')
            ->join('kendaraan as kd', 'kd.idk = rp.id_kendaraan')
            ->where('pjk.status_pjk', 'No')
            ->where('pjk.id_pjk', $id)
            ->where('us.id', $id_user)
            ->where('rp.status', 'aktif')->get('users as us')->result_array();
        return $query;
    }
    public function cekkendaraanUserwithriwayatservis($id_user = null, $id = null)
    {
        $query = $this->db
            ->join('riwayat_pemakai as rp', 'rp.id_user = us.id')
            ->join('riwayat_servis as rs', ' rs.id_kendaraan=rp.id_kendaraan')
            ->join('kendaraan as kd', 'kd.idk = rp.id_kendaraan')
            ->where('rs.status_srs', 'No')
            ->where('rs.id_rs', $id)
            ->where('us.id', $id_user)
            ->where('rp.status', 'aktif')->get('users as us')->result_array();
        return $query;
    }
    public function cekkendaraanUserwithpengajuanservis($id_user = null, $id = null)
    {
        $query = $this->db
            ->join('riwayat_pemakai as rp', 'rp.id_user = us.id')
            ->join('riwayat_pengajuan_servis as rps', ' rps.id_kendaraan=rp.id_kendaraan')
            ->join('kendaraan as kd', 'kd.idk = rp.id_kendaraan')
            ->where('rps.status_pengajuan', 'No')
            ->where('rps.id_pengajuan', $id)
            ->where('us.id', $id_user)
            ->where('rp.status', 'aktif')->get('users as us')->result_array();
        return $query;
    }
    public function data_lokasiunit()
    {
        $query = $this->db->get('ref_lokasi_unit');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function tambahKendaraanDinas()
    {

        $data['id_assets']          = id_aset();
        $data['no_polisi']          = $this->input->post('nopolawaal') . " " . $this->input->post('nopolangka') . " " . $this->input->post('nopolakhir');
        $data['merk']               = $this->input->post('merk');
        $data['tipe']               = $this->input->post('tipe');
        $data['jenis']              = $this->input->post('jeniskendaraan');
        $data['no_stnk']            = $this->input->post('nostnk');
        $data['no_mesin']           = $this->input->post('nomesin');
        $data['no_rangka']          = $this->input->post('norangka');
        $data['tahun_perolehan']    = $this->input->post('tahunperolehan');
        $data['jenis_bb']           = $this->input->post('jenisbb');
        $data['besar_cc']           = $this->input->post('besarcc');
        $data['masa_berlaku_stnk']  = date('Y-m-d', strtotime($this->input->post('tgl_stnk')));
        $data['status']             = "aktif";

        $data['user_id']            = $this->session->userdata('id');

        $q = $this->db->insert('kendaraan', $data);
        return $q;
    }
    public function editKendaraanDinas($idk = null)
    {

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
        $data['masa_berlaku_stnk']  = date('Y-m-d', strtotime($this->input->post('tgl_stnk')));

        $q = $this->db->where('idk', $idk)->update('kendaraan', $data);
        return $q;
    }
    public function tambahriwayatkendaraan($dpn = null, $blkg = null, $kiri = null, $kanan = null, $idk = null)
    {
        $data['foto_tampak_depan']      = $dpn;
        $data['foto_tampak_belakang']    = $blkg;
        $data['foto_tampak_kiri']       = $kiri;
        $data['foto_tampak_kanan']      = $kanan;
        $data['id_kendaraan']           = $idk;
        $data['tgl_pencatatan']         = date('Y-m-d');
        $data['status_rk']         = 'Wait';
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['kondisi']          = $this->input->post('kondisi');
        $data['input_pemakai']          = $this->session->userdata('name');
        if ($this->session->userdata('rule') == 'admin' || $this->session->userdata('rule') == 'superadmin') {
            $data['input_user']             = $this->session->userdata('id');
        }
        if ($this->session->userdata('rule') == 'pemakai') {
            $data['id_pemakai']             = $this->session->userdata('id');
        }
        $data['input_user']             = $this->session->userdata('id');
        $q = $this->db->insert('riwayat_kondisi', $data);
        return $idk;
    }
    public function updateriwayatkondisikendaraan($dpn = null, $blkg = null, $kiri = null, $kanan = null, $id_rk = null)
    {
        $data['foto_tampak_depan']      = $dpn;
        $data['foto_tampak_belakang']    = $blkg;
        $data['foto_tampak_kiri']       = $kiri;
        $data['foto_tampak_kanan']      = $kanan;
        $data['kondisi']          = $this->input->post('kondisi');
        $data['status_rk']          = 'Wait';
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['input_pemakai']          = $this->session->userdata('name');
        if ($this->session->userdata('rule') == 'admin' || $this->session->userdata('rule') == 'superadmin') {
            $data['input_user']             = $this->session->userdata('id');
        }
        if ($this->session->userdata('rule') == 'pemakai') {
            $data['id_pemakai']             = $this->session->userdata('id');
        }
        $data['input_user']             = $this->session->userdata('id');
        $this->db->where('id_rk', $id_rk);
        $q = $this->db->update('riwayat_kondisi', $data);
        return $q;
    }

    public function hapusriwayatkondisi($idrk = null)
    {

        $rkbyid = $this->data_riwayatKondisibyid($idrk);
        if (isset($rkbyid['foto_tampak_depan'])) {
            unlink('./assets/file_kendaraan/' . $rkbyid['foto_tampak_depan']);
        }
        if (isset($rkbyid['foto_tampak_blakang'])) {
            unlink('./assets/file_kendaraan/' . $rkbyid['foto_tampak_blakang']);
        }
        if (isset($rkbyid['foto_tampak_kiri'])) {
            unlink('./assets/file_kendaraan/' . $rkbyid['foto_tampak_kiri']);
        }
        if (isset($rkbyid['foto_tampak_kanan'])) {
            unlink('./assets/file_kendaraan/' . $rkbyid['foto_tampak_kanan']);
        }

        $this->db->where('id_rk', $idrk);
        $q = $this->db->delete('riwayat_kondisi');
        return $rkbyid['id_kendaraan'];
    }

    public function prosestambahPemakai($idk = null)
    {

        $data['id_kendaraan']   = $idk;
        $data['status']         = "aktif";
        $data['id_user'] = $this->input->post('nama');
        // $data['nama_pemakai']   = $this->input->post('nama');
        // $data['nip_pemakai']    = $this->input->post('nip');
        $data['lokasi_unit']    = $this->input->post('lokunit');
        $data['tgl_awal']       = date('Y-m-d', strtotime($this->input->post('dari')));
        $data['tgl_akhir']      = date('Y-m-d', strtotime($this->input->post('sampai')));

        $q = $this->db->insert('riwayat_pemakai', $data);
        return $q;
    }
    public function proseseditPemakai($idk = null)
    {
        $data['id_user'] = $this->input->post('nama');
        // $data['nama_pemakai']   = $this->input->post('nama');
        // $data['nip_pemakai']    = $this->input->post('nip');
        $data['lokasi_unit']    = $this->input->post('lokunit');
        $data['tgl_awal']       = date('Y-m-d', strtotime($this->input->post('dari')));
        $data['tgl_akhir']      = date('Y-m-d', strtotime($this->input->post('sampai')));

        $q = $this->db->where('id_rp', $idk)->update('riwayat_pemakai', $data);
        return $q;
    }


    public function tambahriwayatserviskendaraan($fotoservis = null, $idk = null, $nota = null)
    {

        $data['id_kendaraan'] = $idk;
        $data['foto_servis']  = $fotoservis;
        $data['foto_nota']  = $nota;
        $data['tgl_servis']         = date('Y-m-d', strtotime($this->input->post('tgl')));
        $data['lokasi']             = $this->input->post('bengkel');
        $data['keluhan']            = $this->input->post('keluhan');
        $data['perbaikan']          = $this->input->post('perbaikan');
        $data['lain_lain']          = $this->input->post('lain_lain');
        $data['total_biaya']        = $this->input->post('biaya');
        $data['input_pemakai'] = $this->session->userdata('name');
        $data['input_user'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['status_srs']         = 'Wait';

        $q = $this->db->insert('riwayat_servis', $data);
        return $q;
    }
    public function updateriwayatserviskendaraan($fotoservis = null, $id_rs = null, $nota = null)
    {
        if ($this->session->userdata('role') == 'Pemakai') {
            $data['foto_servis']  = $fotoservis;
            $data['foto_nota']  = $nota;
            $data['tgl_servis']         = date('Y-m-d', strtotime($this->input->post('tgl')));
            $data['lokasi']             = $this->input->post('bengkel');
            $data['keluhan']            = $this->input->post('keluhan');
            $data['perbaikan']          = $this->input->post('perbaikan');
            $data['lain_lain']          = $this->input->post('lain_lain');
            $data['total_biaya']        = $this->input->post('biaya');
            $data['input_user'] = $this->session->userdata('id');
            $data['last_time_update'] = date('Y-m-d H:i:s');
            $data['status_srs']         = 'Wait';
        } else {
            $data['foto_servis']  = $fotoservis;
            $data['foto_nota']  = $nota;
            $data['tgl_servis']         = date('Y-m-d', strtotime($this->input->post('tgl')));
            $data['lokasi']             = $this->input->post('bengkel');
            $data['keluhan']            = $this->input->post('keluhan');
            $data['perbaikan']          = $this->input->post('perbaikan');
            $data['lain_lain']          = $this->input->post('lain_lain');
            $data['total_biaya']        = $this->input->post('biaya');
            $data['input_user'] = $this->session->userdata('id');
            $data['last_time_update'] = date('Y-m-d H:i:s');
        }

        $q = $this->db->where('id_rs', $id_rs)->update('riwayat_servis', $data);
        return $q;
    }

    public function tambahriwayatbbm($id = null, $nama_struk_bbm = null)
    {

        $data['id_kendaraan'] = $id;
        $data['tgl_pencatatan'] = date('Y-m-d', strtotime($this->input->post('tgl_bbm')));
        $data['total_bbm'] = $this->input->post('harga_bbm');
        $data['struk_bbm'] = $nama_struk_bbm;
        $data['user_id'] = $this->session->userdata('id');
        $data['input_user'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['status_rbm']         = 'Wait';


        $q = $this->db->insert('riwayat_bbm', $data);
        return $q;
    }
    public function updateriwayatbbm($id_bbm = null, $nama_struk_bbm = null)
    {

        $data['tgl_pencatatan'] = date('Y-m-d', strtotime($this->input->post('tgl_bbm')));
        $data['total_bbm'] = $this->input->post('harga_bbm');
        $data['struk_bbm'] = $nama_struk_bbm;
        $data['status_rbm']         = 'Wait';
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['user_id'] = $this->session->userdata('id');
        $data['input_user'] = $this->session->userdata('id');
        $q = $this->db->where('id_bbm', $id_bbm)->update('riwayat_bbm', $data);
        return $q;
    }
    public function tambahriwayatpajak($id = null)
    {
        $data['id_kendaraan'] = $id;
        $data['tgl_pencatatan'] = date('Y-m-d');
        $data['total_pajak'] = $this->input->post('total_pajak');
        $data['user_id'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['status_pjk']  = 'Wait';
        $data['tahun'] = $this->input->post('tahun_pajak');

        $q = $this->db->insert('riwayat_pajak', $data);
        return $q;
    }
    public function updateriwayatpajak($id_pjk = null)
    {
        $data['total_pajak'] = $this->input->post('total_pajak');
        $data['tahun'] = $this->input->post('tahun_pajak');
        $data['user_id'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['status_pjk']  = 'Wait';
        // $data['tahun'] = $this->input->post('tahun_pajak');

        $q = $this->db->where('id_pjk', $id_pjk)->update('riwayat_pajak', $data);
        return $q;
    }
    public function hapusriwayatpajak($id_pjk = null)
    {
        $this->db->where('id_pjk', $id_pjk);
        $q = $this->db->delete('riwayat_pajak');
        return $q;
    }
    public function datapajakById($id)
    {
        $query = $this->db
            ->join('kendaraan', 'riwayat_pajak.id_kendaraan = kendaraan.idk')
            ->get_where('riwayat_pajak', ['id_pjk' => $id])
            ->row_array();
        return $query;
    }

    public function hapusbbm($id = null)
    {
        $this->db->where('id_bbm', $id);
        $q = $this->db->delete('riwayat_bbm');
        return $q;
    }
    public function hapus_data_kendaraan($id_kend = null)
    {
        $this->db->where('idk', $id_kend);
        $q = $this->db->delete('kendaraan');
        return $q;
    }
    public function datasummary_kendaraanbyid($id = null)
    {
        $this->db
            ->join('riwayat_pemakai as rp', 'rp.id_kendaraan = kend.idk', 'left')
            ->join('users as us', 'rp.id_user = us.id')
            ->where('idk', $id)
            ->group_start()
            ->where('rp.status', 'aktif')
            ->or_where('rp.status is null')
            ->group_end();
        $query = $this->db->get('kendaraan as kend');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function datasummary_riwayatkondisibyid($id = null)
    {
        $this->db->where('id_kendaraan', $id);
        $query = $this->db->order_by('tgl_pencatatan', 'DESC')->get('riwayat_kondisi');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function datasummary_riwayatbbmbyid($id = null)
    {
        $this->db->where('id_kendaraan', $id);
        $query = $this->db->order_by('tgl_pencatatan', 'DESC')->get('riwayat_bbm');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function datasummary_riwayatpajakbyid($id = null)
    {
        $this->db->where('id_kendaraan', $id);
        $query = $this->db->order_by('tgl_pencatatan', 'DESC')->get('riwayat_pajak');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function datasummary_riwayatservisbyid($id = null)
    {
        $this->db->where('id_kendaraan', $id);
        $query = $this->db->order_by('tgl_servis', 'DESC')->get('riwayat_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function cek_data_pengajuan($idkend = null)
    {
        $this->db->limit('1')->order_by('id_pengajuan', 'DESC')->where('id_kendaraan', $idkend);
        $query = $this->db->get('riwayat_pengajuan_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpengajuanservis_pemakai($id = null)
    {
        $this->db
            ->order_by('id_pengajuan', 'DESC');
        $this->db->where('id_kendaraan', $id);
        $query = $this->db->get('riwayat_pengajuan_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpengajuanservis_admin($id = null)
    {
        $this->db
            // ->join('users', 'users.id = riwayat_pengajuan_servis.id_admin', 'left');
            ->join('users as us', 'us.id=rps.input_user', 'left');
        $this->db->order_by('rps.id_pengajuan', 'DESC');
        $this->db->where('rps.id_kendaraan', $id);
        $query = $this->db->get('riwayat_pengajuan_servis as rps');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpengajuanservis_pemakaibyidpen($id_pen = null)
    {
        $this->db->join('kendaraan', 'kendaraan.idk=riwayat_pengajuan_servis.id_kendaraan')->where('id_pengajuan', $id_pen);
        $query = $this->db->get('riwayat_pengajuan_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function tambahpengajuanservis($idkend = null)
    {
        if ($this->session->userdata('role') == 'Pemakai') {
            $data['id_kendaraan'] = $idkend;
            $data['tgl_pengajuan'] = date('Y-m-d');
            $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
            $data['keluhan'] = $this->input->post('keluhan_kendaraan');
            $data['service'] = $this->input->post('servis_kendaraan');
            $data['lain_lain'] = $this->input->post('lain_lain_kendaraan');
            $data['id_user'] = $this->session->userdata('id');
            $data['last_time_update'] = date('Y-m-d H:i:s');
            $data['input_user'] = $this->session->userdata('id');
            $data['status_pengajuan'] = 'Wait';
        } else {
            $data['id_kendaraan'] = $idkend;
            $data['tgl_pengajuan'] = date('Y-m-d');
            $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
            $data['keluhan'] = $this->input->post('keluhan_kendaraan');
            $data['service'] = $this->input->post('servis_kendaraan');
            $data['lain_lain'] = $this->input->post('lain_lain_kendaraan');
            $data['last_time_update'] = date('Y-m-d H:i:s');
            $data['input_user'] = $this->session->userdata('id');
            $data['status_pengajuan'] = 'Wait';
        }
        // $data['id_admin'] = '1'; //set default id admin ketika tambah pengajuan servis
        $q = $this->db->insert('riwayat_pengajuan_servis', $data);
        return $q;
    }
    public function editpengajuanservis($id_pen = null)
    {
        if ($this->session->userdata('role') == 'Pemakai') {
            $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
            $data['keluhan'] = $this->input->post('keluhan_kendaraan');
            $data['service'] = $this->input->post('servis_kendaraan');
            $data['lain_lain'] = $this->input->post('lain_lain_kendaraan');
            $data['id_user'] = $this->session->userdata('id');
            $data['input_user'] = $this->session->userdata('id');
            $data['status_pengajuan'] = 'Wait';
            $data['last_time_update'] = date('Y-m-d H:i:s');
        } else {
            $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
            $data['keluhan'] = $this->input->post('keluhan_kendaraan');
            $data['service'] = $this->input->post('servis_kendaraan');
            $data['lain_lain'] = $this->input->post('lain_lain_kendaraan');
            $data['input_user'] = $this->session->userdata('id');
            $data['last_time_update'] = date('Y-m-d H:i:s');
        }
        $q = $this->db->where('id_pengajuan', $id_pen)->update('riwayat_pengajuan_servis', $data);
        return $q;
    }
    public function data_riwayatpengajuanbyidrp($id = null)
    {

        $this->db->join('users', 'users.id= riwayat_pengajuan_servis.id_user')->where('id_pengajuan', $id);
        $query = $this->db->get('riwayat_pengajuan_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatkondisiidrp($id = null)
    {

        $this->db
            ->where('id_rk', $id);
        $query = $this->db->get('riwayat_kondisi');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function hapus_data_pengajuan($id = null)
    {
        $this->db->where('id_pengajuan', $id);
        $q = $this->db->delete('riwayat_pengajuan_servis');
        return $q;
    }
    public function cek_data_rk($idk = null)
    {
        $this->db->limit('1')->order_by('id_rk', 'DESC')->where('id_kendaraan', $idk);
        $query = $this->db->get('riwayat_kondisi');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_data_srs($idk = null)
    {
        $this->db->limit('1')->order_by('id_rs', 'DESC')->where('id_kendaraan', $idk);
        $query = $this->db->get('riwayat_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_data_rbm($id_kend = null)
    {
        $this->db->limit('1')->order_by('id_bbm', 'DESC')->where('id_kendaraan', $id_kend);
        $query = $this->db->get('riwayat_bbm');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function cek_data_pajak($id_kend = null)
    {
        $this->db->limit('1')->order_by('id_pjk', 'DESC')->where('id_kendaraan', $id_kend);
        $query = $this->db->get('riwayat_pajak');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function approve_rk($id = null)
    {
        $data['status_rk'] = "Yes";
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $this->db->where('id_rk', $id);
        $q = $this->db->update('riwayat_kondisi', $data);
        return $q;
    }
    public function reject_rk($id = null)
    {
        $data['status_rk'] = "No";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['reject_reason'] = $this->input->post('reason_reject');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_rk', $id);
        $q = $this->db->update('riwayat_kondisi', $data);
        return $q;
    }
    public function wait_rk($id = null)
    {
        $data['status_rk'] = "Wait";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_rk', $id);
        $q = $this->db->update('riwayat_kondisi', $data);
        return $q;
    }
    public function approve_rbm($id = null)
    {
        $data['status_rbm'] = "Yes";
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $this->db->where('id_bbm', $id);
        $q = $this->db->update('riwayat_bbm', $data);
        return $q;
    }
    public function reject_rbm($id = null)
    {
        $data['status_rbm'] = "No";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['reject_reason'] = $this->input->post('reason_reject');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_bbm', $id);
        $q = $this->db->update('riwayat_bbm', $data);
        return $q;
    }
    public function wait_rbm($id = null)
    {
        $data['status_rbm']         = "Wait";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_bbm', $id);
        $q = $this->db->update('riwayat_bbm', $data);
        return $q;
    }
    public function approve_pjk($id = null)
    {
        $data['status_pjk'] = "Yes";
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $this->db->where('id_pjk', $id);
        $q = $this->db->update('riwayat_pajak', $data);
        return $q;
    }
    public function reject_pjk($id = null)
    {
        $data['status_pjk'] = "No";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['reject_reason'] = $this->input->post('reason_reject');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_pjk', $id);
        $q = $this->db->update('riwayat_pajak', $data);
        return $q;
    }
    public function wait_pjk($id = null)
    {
        $data['status_pjk']         = "Wait";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_pjk', $id);
        $q = $this->db->update('riwayat_pajak', $data);
        return $q;
    }
    public function reject_servis($id = null)
    {

        $data['status_srs']         = "No";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['reject_reason'] = $this->input->post('reason_reject');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_rs', $id);
        $q = $this->db->update('riwayat_servis', $data);
        return $q;
    }
    public function approve_servis($id = null)
    {

        $data['status_srs']         = "Yes";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_rs', $id);
        $q = $this->db->update('riwayat_servis', $data);
        return $q;
    }
    public function wait_servis($id = null)
    {
        $data['status_srs']         = "Wait";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_rs', $id);
        $q = $this->db->update('riwayat_servis', $data);
        return $q;
    }
    public function reject_pengajuan($id = null)
    {
        $data['status_pengajuan'] = "No";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['reject_reason'] = $this->input->post('reason_reject');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_pengajuan', $id);
        $q = $this->db->update('riwayat_pengajuan_servis', $data);
        return $q;
    }
    public function approve_pengajuan($id = null)
    {
        $data['status_pengajuan'] = "Yes";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_pengajuan', $id);
        $q = $this->db->update('riwayat_pengajuan_servis', $data);
        return $q;
    }
    public function wait_pengajuan($id = null)
    {
        $data['status_pengajuan'] = "Wait";
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_pengajuan', $id);
        $q = $this->db->update('riwayat_pengajuan_servis', $data);
        return $q;
    }
}