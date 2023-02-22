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
        if ($this->session->userdata('role') == 'Admin') {
            $data['user'] = $this->db
                ->get_where('users', [
                    'id' => $this->session->userdata('id'),
                ])
                ->row_array();
            $lokasi = $data['user']['wilayah'];
            $query = $this->db
                ->join('riwayat_pemakai', 'riwayat_pemakai.id_kendaraan = kendaraan.idk', 'left')
                ->join('ref_lokasi_unit', 'riwayat_pemakai.lokasi_unit = ref_lokasi_unit.lokasi_unit', 'inner')
                ->join('users as us', 'us.id = riwayat_pemakai.id_user', 'left')
                ->order_by('idk', 'asc')
                ->group_start()
                ->where(array('riwayat_pemakai.status' => 'aktif', 'riwayat_pemakai.lokasi_unit' => $lokasi))
                // ->or_where('riwayat_pemakai.status is null')
                ->group_end()
                ->get('kendaraan');
        } else {
            $query = $this->db
                ->order_by('rp.lokasi_unit', 'DESC')
                ->order_by('kn.idk', 'DESC')
                ->join('riwayat_pemakai as rp', 'kn.idk = rp.id_kendaraan', 'left')
                ->join('users as us', 'us.id = rp.id_user', 'left')
                ->where('kn.status', 'aktif')
                ->group_start()
                ->where(array('rp.status' => 'aktif'))
                // ->or_where('rp.status', 'tidak_aktif')
                ->or_where('rp.status is null')
                ->group_end()
                ->get('kendaraan as kn');
        }
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_kendaraan_all()
    {
        if ($this->session->userdata('role') == 'Admin') {

            $data['user'] = $this->db
                ->get_where('users', [
                    'id' => $this->session->userdata('id'),
                ])
                ->row_array();
            $lokasi = $data['user']['wilayah'];
            $query = $this->db
                ->join('riwayat_pemakai', 'riwayat_pemakai.id_kendaraan = kendaraan.idk', 'left')
                ->join('ref_lokasi_unit', 'riwayat_pemakai.lokasi_unit = ref_lokasi_unit.lokasi_unit', 'inner')
                ->join('users as us', 'us.id = riwayat_pemakai.id_user', 'left')
                ->order_by('idk', 'asc')
                ->group_start()
                ->where(array('riwayat_pemakai.status' => 'aktif', 'riwayat_pemakai.lokasi_unit' => $lokasi))
                // ->or_where('riwayat_pemakai.status is null')
                ->group_end()
                ->get('kendaraan');
        } else {
            $query = $this->db
                // ->order_by('rp.is_pejabat', 'DESC')
                ->order_by('kn.idk', 'ASC')
                ->join('riwayat_pemakai as rp', 'kn.idk = rp.id_kendaraan', 'left')
                ->join('users as us', 'us.id = rp.id_user', 'left')
                ->where('kn.status', 'aktif')
                ->group_start()
                ->where(array('rp.status' => 'aktif'))
                // ->or_where('rp.status', 'tidak_aktif')
                ->or_where('rp.status is null')
                ->group_end()
                ->get('kendaraan as kn');
        }

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
            // ->order_by('rp.is_pejabat', 'DESC')
            // ->order_by('cast(ps.pagu_awal as int)', 'DESC')
            // ->order_by('kn.merk', 'ASC')
            // ->order_by('kn.tipe', 'ASC')
            // ->order_by('kn.no_polisi', 'ASC')
            ->order_by('rp.is_pejabat', 'DESC')
            ->order_by('kn.jenis', 'ASC')
            // ->order_by('us.name', 'DESC')
            ->order_by('kn.idk')
            ->select('kn.jenis,kn.merk,kn.tipe,kn.no_polisi,us.name,ps.pagu_awal')
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

    public function data_servis_bulan($tahun = null, $bulan = null)
    {
        $this->db
            // ->order_by('rp.is_pejabat', 'DESC')
            // ->order_by('cast(ps.pagu_awal as int)', 'DESC')
            // ->order_by('kn.merk', 'ASC')
            // ->order_by('kn.tipe', 'ASC')
            // ->order_by('kn.no_polisi', 'ASC')
            ->order_by('rp.is_pejabat', 'DESC')
            ->order_by('kn.jenis', 'ASC')
            // ->order_by('us.name', 'DESC')
            ->order_by('kn.idk')
            ->select('kn.jenis,kn.merk,kn.tipe,kn.no_polisi,us.name,ps.pagu_awal')
            ->join('pagu_service as ps', 'ps.id_kend = kn.idk', 'left')
            ->join('riwayat_pemakai as rp', 'rp.id_kendaraan=kn.idk', 'left')
            ->join('riwayat_servis as rsk', 'rsk.id_kendaraan=kn.idk', 'left')
            ->join('users as us', 'us.id=rp.id_user', 'left')
            ->where('kn.status', 'aktif')
            ->where('ps.tahun', $tahun)
            ->where('MONTH(rsk.tgl_servis)', $bulan)
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

    public function servis_bbm_bulanan($tahun = null, $bulan = null)
    {
        $query = $this->db
            ->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
                LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
                LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
                LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
                LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)=' . $bulan . ' and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
                LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)=' . $bulan . ' and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
                LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)=' . $bulan . ' and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function servis_bbm_bulanan_idkend($tahun = null, $bulan = null, $id_kend = null)
    {
        $query = $this->db
            ->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
                LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
                LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
                LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
                LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)=' . $bulan . ' and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
                LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)=' . $bulan . ' and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
                LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)=' . $bulan . ' and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_jan($tahun = null)
    {
        $query = $this->db
            ->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
                LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
                LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
                LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
                LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="1" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
                LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="1" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
                LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="1" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_jan($tahun = null)
    {
        $query = $this->db
            ->query('SELECT total_sparepart as total_sp_jan,total_oli as total_ol_jan,total_servis as total_sv_jan,total_bbm as total_bm_jan,total_pajak as total_pj_jan FROM `kendaraan` as `kn` 
                LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
                LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
                LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
                LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="1" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
                LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="1" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
                LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="1" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_feb($tahun = null)
    {
        $query = $this->db
            ->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="2" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="2" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="2" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_feb($tahun = null)
    {
        $query = $this->db
            ->query('SELECT total_sparepart as total_sp_feb,total_oli as total_ol_feb,total_servis as total_sv_feb,total_bbm as total_bm_feb,total_pajak as total_pj_feb FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="2" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="2" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="2" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_mar($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="3" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="3" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="3" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_mar($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_mar,total_oli as total_ol_mar,total_servis as total_sv_mar,total_bbm as total_bm_mar,total_pajak as total_pj_mar FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="3" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="3" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="3" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_apr($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="4" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="4" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="4" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_apr($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_apr,total_oli as total_ol_apr,total_servis as total_sv_apr,total_bbm as total_bm_apr,total_pajak as total_pj_apr FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="4" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="4" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="4" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_mei($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="5" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="5" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="5" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_mei($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_mei,total_oli as total_ol_mei,total_servis as total_sv_mei,total_bbm as total_bm_mei,total_pajak as total_pj_mei FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="5" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="5" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="5" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_jun($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="6" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="6" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="6" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_jun($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_jun,total_oli as total_ol_jun,total_servis as total_sv_jun,total_bbm as total_bm_jun,total_pajak as total_pj_jun FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="6" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="6" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="6" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_jul($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="7" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="7" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="7" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_jul($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_jul,total_oli as total_ol_jul,total_servis as total_sv_jul,total_bbm as total_bm_jul,total_pajak as total_pj_jul FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="7" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="7" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="7" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_ags($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="8" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="8" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="8" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_ags($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_ags,total_oli as total_ol_ags,total_servis as total_sv_ags,total_bbm as total_bm_ags,total_pajak as total_pj_ags FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="8" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="8" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="8" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_sept($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="9" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="9" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="9" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_sept($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_sept,total_oli as total_ol_sept,total_servis as total_sv_sept,total_bbm as total_bm_sept,total_pajak as total_pj_sept FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="9" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="9" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="9" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_okt($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="10" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="10" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="10" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_okt($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_okt,total_oli as total_ol_okt,total_servis as total_sv_okt,total_bbm as total_bm_okt,total_pajak as total_pj_okt FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="10" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="10" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="10" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_nov($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="11" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="11" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="11" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_nov($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_nov,total_oli as total_ol_nov,total_servis as total_sv_nov,total_bbm as total_bm_nov,total_pajak as total_pj_nov FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="11" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="11" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="11" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function servis_bbm_des($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart,total_oli,total_servis,total_bbm,total_pajak FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="12" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="12" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="12" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function laporan_des($tahun = null)
    {
        $query = $this->db->query('SELECT total_sparepart as total_sp_des,total_oli as total_ol_des,total_servis as total_sv_des,total_bbm as total_bm_des,total_pajak as total_pj_des FROM `kendaraan` as `kn` 
        LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
        LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
        LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)="12" and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
        LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)="12" and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
        LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)="12" and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatKondisi($id = null, $tahun = null)
    {
        $this->db
            ->join('users as us', 'us.id=rk.input_user', 'left')
            ->order_by('rk.tgl_pencatatan', 'DESC')
            ->where('rk.id_kendaraan', $id)
            ->like('rk.tgl_pencatatan', $tahun);
        $query = $this->db->get('riwayat_kondisi as rk');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function data_riwayatbbm($id = null, $tahun = null)
    {
        $this->db
            ->order_by('rbm.tgl_pencatatan', 'DESC')
            ->order_by('rbm.created_bbm', 'DESC')
            ->join('users as us', 'us.id=rbm.input_user', 'left')
            ->where('rbm.id_kendaraan', $id)
            ->like('rbm.tgl_pencatatan', $tahun);
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
        // $this->db->where('rpk.tahun', $tahun);
        $query = $this->db->get('riwayat_pajak as rpk');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function data_riwayatpajaktahun($id = null, $tahun = null)
    {
        $this->db->order_by('rpk.tahun', 'DESC')
            ->join('users as us', 'us.id=rpk.input_user', 'left');
        $this->db->where('rpk.id_kendaraan', $id);
        $this->db->where('rpk.tahun', $tahun);
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

        $this->db->select('id,name,nip_user,wilayah,role,status')->order_by('name', 'ASC')->order_by('id', 'DESC')->where('role', 'Pemakai');
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpemakai($id = null, $tahun = null)
    {
        $this->db
            ->join('users as us', 'rp.id_user=us.id')
            ->select('rp.id_rp,rp.id_kendaraan,rp.id_user,rp.lokasi_unit,rp.tgl_awal,rp.tgl_akhir,rp.status, us.id, us.name, us.nip_user')
            ->where('rp.id_kend_last', $id)
            ->like('rp.tgl_awal', $tahun);
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
        $this->db
            ->join('kendaraan', 'riwayat_pemakai.id_kendaraan = kendaraan.idk')
            ->join('users as us', 'us.id = riwayat_pemakai.id_user', 'left')
            ->where('id_rp', $id);
        $query = $this->db->get('riwayat_pemakai')->row_array();
        return $query;
    }
    public function nonaktifkanpemakai($id = null)
    {

        $data['status'] = "tidak_aktif";
        $data['id_kendaraan'] = null;
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
    public function aktifkanpemakai($id, $id_kend_last)
    {

        $data['status'] = "aktif";
        $data['id_kendaraan'] = $id_kend_last;
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
    public function data_riwayatservis($id = null, $tahun = null)
    {
        $this->db
            ->join('users as us', 'us.id=rs.input_user', 'left')
            ->where('rs.id_kendaraan', $id)
            ->like('rs.tgl_servis', $tahun);
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
            ->join('kendaraan as kn', 'riwayat_kondisi.id_kendaraan = kn.idk')
            ->join('riwayat_pemakai as rp', 'rp.id_kendaraan = kn.idk', 'left')
            ->join('users as us', 'rp.id_user = us.id', 'left')
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
        $query = $this->db
            ->get('kendaraan as kn');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function pemakaiKendById($id = null)
    {
        $query = $this->db
            ->select('us.name,us.nip_user,rp.status,kn.merk,kn.jenis,kn.tipe,kn.no_polisi')
            ->join('riwayat_pemakai as rp', 'rp.id_kendaraan = kn.idk', 'left')
            ->join('users as us', 'rp.id_user = us.id', 'left')
            ->where('idk', $id)
            ->where('rp.status', 'aktif')
            ->get('kendaraan as kn');
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
        // if($dari==null){
        if($this->input->post('dari')==null){
            $data['tgl_pencatatan']     = date('Y-m-d');    
        }
        else{
            $data['tgl_pencatatan']     = date('Y-m-d', strtotime($this->input->post('dari')));    
        }
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
        $data['id_kend_last']   = $idk;
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
        $data['service']            = $this->input->post('service');
        $data['sparepart']          = $this->input->post('sparepart');
        $data['oli']          = $this->input->post('oli');
        $data['total_biaya']        = $this->input->post('biaya');
        $data['input_pemakai'] = $this->session->userdata('name');
        $data['input_user'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['status_srs']         = 'Wait';

        $q = $this->db->insert('riwayat_servis', $data);
        return $q;
    }
    public function tambahriwayatserviskendaraanwithoutnota($idk = null, $fotoservis = null)
    {

        $data['id_kendaraan'] = $idk;
        $data['foto_servis']  = $fotoservis;
        $data['tgl_servis']         = date('Y-m-d', strtotime($this->input->post('tgl')));
        $data['lokasi']             = $this->input->post('bengkel');
        $data['service']            = $this->input->post('service');
        $data['sparepart']          = $this->input->post('sparepart');
        $data['oli']          = $this->input->post('oli');
        $data['total_biaya']        = $this->input->post('biaya');
        $data['input_pemakai'] = $this->session->userdata('name');
        $data['input_user'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['status_srs']         = 'Wait';

        $q = $this->db->insert('riwayat_servis', $data);
        return $q;
    }
    public function tambahriwayatserviskendaraanwithoutservis($idk = null, $nota = null)
    {

        $data['id_kendaraan'] = $idk;
        $data['foto_nota']  = $nota;
        $data['tgl_servis']         = date('Y-m-d', strtotime($this->input->post('tgl')));
        $data['lokasi']             = $this->input->post('bengkel');
        $data['service']            = $this->input->post('service');
        $data['sparepart']          = $this->input->post('sparepart');
        $data['oli']          = $this->input->post('oli');
        $data['total_biaya']        = $this->input->post('biaya');
        $data['input_pemakai'] = $this->session->userdata('name');
        $data['input_user'] = $this->session->userdata('id');
        $data['last_time_update'] = date('Y-m-d H:i:s');
        $data['status_srs']         = 'Wait';

        $q = $this->db->insert('riwayat_servis', $data);
        return $q;
    }
    public function tambahriwayatserviskendaraanwithoutimage($idk = null)
    {

        $data['id_kendaraan'] = $idk;
        $data['tgl_servis']         = date('Y-m-d', strtotime($this->input->post('tgl')));
        $data['lokasi']             = $this->input->post('bengkel');
        $data['service']            = $this->input->post('service');
        $data['sparepart']          = $this->input->post('sparepart');
        $data['oli']          = $this->input->post('oli');
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
            $data['service']            = $this->input->post('service');
            $data['sparepart']          = $this->input->post('sparepart');
            $data['oli']          = $this->input->post('oli');
            $data['total_biaya']        = $this->input->post('biaya');
            $data['input_user'] = $this->session->userdata('id');
            $data['last_time_update'] = date('Y-m-d H:i:s');
            $data['status_srs']         = 'Wait';
        } else {
            $data['foto_servis']  = $fotoservis;
            $data['foto_nota']  = $nota;
            $data['tgl_servis']         = date('Y-m-d', strtotime($this->input->post('tgl')));
            $data['lokasi']             = $this->input->post('bengkel');
            $data['service']            = $this->input->post('service');
            $data['sparepart']          = $this->input->post('sparepart');
            $data['oli']          = $this->input->post('oli');
            $data['total_biaya']        = $this->input->post('biaya');
            $data['input_user'] = $this->session->userdata('id');
            $data['last_time_update'] = date('Y-m-d H:i:s');
        }

        $q = $this->db->where('id_rs', $id_rs)->update('riwayat_servis', $data);
        return $q;
    }
    public function updateriwayatserviskendaraanwithoutimage($id_rs = null)
    {
        if ($this->session->userdata('role') == 'Pemakai') {
            $data['tgl_servis']         = date('Y-m-d', strtotime($this->input->post('tgl')));
            $data['lokasi']             = $this->input->post('bengkel');
            $data['service']            = $this->input->post('service');
            $data['sparepart']          = $this->input->post('sparepart');
            $data['oli']          = $this->input->post('oli');
            $data['total_biaya']        = $this->input->post('biaya');
            $data['input_user'] = $this->session->userdata('id');
            $data['last_time_update'] = date('Y-m-d H:i:s');
            $data['status_srs']         = 'Wait';
        } else {
            $data['tgl_servis']         = date('Y-m-d', strtotime($this->input->post('tgl')));
            $data['lokasi']             = $this->input->post('bengkel');
            $data['service']            = $this->input->post('service');
            $data['sparepart']          = $this->input->post('sparepart');
            $data['oli']          = $this->input->post('oli');
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
    public function tambahriwayatbbmwithoutimage($id = null)
    {

        $data['id_kendaraan'] = $id;
        $data['tgl_pencatatan'] = date('Y-m-d', strtotime($this->input->post('tgl_bbm')));
        $data['total_bbm'] = $this->input->post('harga_bbm');
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
    public function updateriwayatbbmwithoutimage($id_bbm = null)
    {

        $data['tgl_pencatatan'] = date('Y-m-d', strtotime($this->input->post('tgl_bbm')));
        $data['total_bbm'] = $this->input->post('harga_bbm');
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
    public function data_riwayatpengajuanservis_pemakai($id = null, $tahun)
    {
        $this->db
            ->order_by('id_pengajuan', 'DESC');
        $this->db->where('id_kendaraan', $id);
        $this->db->where('YEAR(tgl_pengajuan)', $tahun);
        $query = $this->db->get('riwayat_pengajuan_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function data_riwayatpengajuanservis_admin($id = null, $tahun = null)
    {
        $this->db
            // ->join('users', 'users.id = riwayat_pengajuan_servis.id_admin', 'left');
            ->join('users as us', 'us.id=rps.input_user', 'left');
        $this->db->order_by('rps.id_pengajuan', 'DESC');
        $this->db->where('rps.id_kendaraan', $id);
        $this->db->like('rps.tgl_pengajuan', $tahun);
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
            if($this->input->post('dari')==null){
                $data['tgl_pengajuan'] = date('Y-m-d');
            }
            else{
                $data['tgl_pengajuan'] = date('Y-m-d', strtotime($this->input->post('dari')));   
            }
            $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
            $data['keluhan'] = $this->input->post('keluhan_kendaraan');
            $data['km_service'] = $this->input->post('km_service');
            $data['service'] = $this->input->post('servis_kendaraan');
            $data['lain_lain'] = $this->input->post('lain_lain_kendaraan');
            $data['id_user'] = $this->session->userdata('id');
            $data['last_time_update'] = date('Y-m-d H:i:s');
            $data['input_user'] = $this->session->userdata('id');
            $data['status_pengajuan'] = 'Wait';
        } else {
            $data['id_kendaraan'] = $idkend;
            // $data['tgl_pengajuan'] = date('Y-m-d');
            if($this->input->post('dari')==null){
                $data['tgl_pengajuan'] = date('Y-m-d');
            }
            else{
                $data['tgl_pengajuan'] = date('Y-m-d', strtotime($this->input->post('dari')));   
            }
            $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
            $data['keluhan'] = $this->input->post('keluhan_kendaraan');
            $data['km_service'] = $this->input->post('km_service');
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
            // if($this->input->post('dari')!=null){
            //     $data['tgl_pengajuan'] = $this->input->post('dari');
            // }
            $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
            $data['km_service'] = $this->input->post('km_service');
            $data['keluhan'] = $this->input->post('keluhan_kendaraan');
            $data['service'] = $this->input->post('servis_kendaraan');
            $data['lain_lain'] = $this->input->post('lain_lain_kendaraan');
            $data['id_user'] = $this->session->userdata('id');
            $data['input_user'] = $this->session->userdata('id');
            $data['status_pengajuan'] = 'Wait';
            $data['last_time_update'] = date('Y-m-d H:i:s');
        } else {
            // if($this->input->post('dari')!=null){
            //     $data['tgl_pengajuan'] = $this->input->post('dari');
            // }
            $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
            $data['km_service'] = $this->input->post('km_service');
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

        $this->db->join('users', 'users.id= riwayat_pengajuan_servis.id_user', 'left')->where('id_pengajuan', $id);
        $query = $this->db->get('riwayat_pengajuan_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function pengajuan_admin($id = null)
    {

        $this->db->join('users', 'users.id= riwayat_pengajuan_servis.id_admin')->where('id_pengajuan', $id);
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


    public function data_peralatan_all()
    {
        // if ($this->session->userdata('role') == 'Admin') {

            // $data['user'] = $this->db
            //     ->get_where('users', [
            //         'id' => $this->session->userdata('id'),
            //     ])
            //     ->row_array();
            // $lokasi = $data['user']['wilayah'];
            // $query = $this->db
            //     ->join('riwayat_pemakai_peralatan', 'riwayat_pemakai_peralatan.id_alat = peralatan.id', 'left')
            //     ->join('ref_lokasi_unit', 'riwayat_pemakai_peralatan.lokasi_unit = ref_lokasi_unit.lokasi_unit', 'inner')
            //     ->join('users as us', 'us.id = riwayat_pemakai_peralatan.id_user', 'left')
            //     ->order_by('id_rp', 'asc')
                // ->group_start()
                // ->where(array('riwayat_pemakai_peralatan.status' => 'aktif', 'riwayat_pemakai_peralatan.lokasi_unit' => $lokasi))
                // ->or_where('riwayat_pemakai_peralatan.status is null')
                // ->group_end()
                // ->get('peralatan');
            $this->db->select('*');
            $this->db->from('peralatan');

            $query = $this->db
                ->get();
            // print_r($query->result());
            // die();
            return $query->result();
            
            
        // } else {
        //     $query = $this->db
        //         // ->order_by('rp.is_pejabat', 'DESC')
        //         ->order_by('kn.idk', 'ASC')
        //         ->join('riwayat_pemakai as rp', 'kn.idk = rp.id_kendaraan', 'left')
        //         ->join('users as us', 'us.id = rp.id_user', 'left')
        //         ->where('kn.status', 'aktif')
        //         ->group_start()
        //         ->where(array('rp.status' => 'aktif'))
        //         // ->or_where('rp.status', 'tidak_aktif')
        //         ->or_where('rp.status is null')
        //         ->group_end()
        //         ->get('kendaraan as kn');
        // }

        // if ($query->num_rows() > 0) {
        //     foreach ($query->result_array() as $row) {
        //         $hasil[] = $row;
        //     }
        //     // print_r($hasil);
        //     // die();
        //     return $hasil;
        // }
    }

    public function data_peralatan()
    {
        // print_r("halo");
        // die();
        if ($this->session->userdata('role') == 'Admin') {

            $data['user'] = $this->db
                ->get_where('users', [
                    'id' => $this->session->userdata('id'),
                ])
                ->row_array();
            $lokasi = $data['user']['wilayah'];
            $query = $this->db
                ->join('riwayat_pemakai_peralatan', 'riwayat_pemakai_peralatan.id_alat = peralatan.id', 'left')
                ->join('ref_lokasi_unit', 'riwayat_pemakai_peralatan.lokasi_unit = ref_lokasi_unit.lokasi_unit', 'inner')
                ->join('users as us', 'us.id = riwayat_pemakai_peralatan.id_user', 'left')
                ->order_by('id', 'asc')
                ->group_start()
                ->where(array('riwayat_pemakai_peralatan.status' => 'aktif', 'riwayat_pemakai_peralatan.bidang' => $lokasi))
                // ->or_where('riwayat_pemakai.status is null')
                ->group_end()
                ->get('peralatan');
            // print_r("ahlp");
            // die();
        } else {
            $query = $this->db
                ->order_by('rp.bidang', 'DESC')
                ->order_by('al.id', 'DESC')
                ->join('riwayat_pemakai_peralatan as rp', 'al.id = rp.id_alat', 'left')
                ->join('users as us', 'us.id = rp.id_user', 'left')
                ->where('al.status', 'aktif')
                ->group_start()
                ->where(array('rp.status' => 'aktif'))
                // ->or_where('rp.status', 'tidak_aktif')
                // ->or_where('rp.status is null')
                ->group_end()
                ->get('peralatan as al');
            // print_r($query->result());
            // die();
        }
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            // print_r($hasil);
            // die();
            return $hasil;
        }


        // print_r("halo");
        // die();

        //     $this->db->select('*');
        //     $this->db->from('peralatan');

        //     $query = $this->db
        //         // ->select('*')
        //         // ->from('peralatan')
        //         ->get();
        //     return $query->result();
    }

    public function tambahPeralatanDinas()
    {

        $data['id_asset']           = id_aset_alat();
        $data['bidang']             = $this->input->post('bidang');
        $data['jenis']              = $this->input->post('jenis');
        $data['merk']               = $this->input->post('merk');
        // $data['tipe']               = $this->input->post('tipe');
        // $data['nama']               = $this->input->post('nama');
        $data['tahun_perolehan']    = $this->input->post('tahun_perolehan');
        $data['garansi']            = date('Y-m-d', strtotime($this->input->post('garansi')));
        // $data['foto_garansi']       = $this->input->post('foto');
        
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './assets/upload/foto_garansi_peralatan/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_garansi_peralatan' . $data['jenis'] . '_' . $data['merk'] . '_' . date('Y-m-d') . '_' . uniqid();

            $this->load->library('upload', $config, 'foto');
            $this->foto->initialize($config);
            $this->foto->do_upload('foto');
            $foto = $this->foto->data();

            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/foto_garansi_peralatan/' . $foto['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/foto_garansi_peralatan/' . $foto['file_name'];
            $this->load->library('image_lib', $config, 'resizenota');
            $res = $this->resizenota->resize();
            $namanota = $foto['file_name'];

            $data['foto_garansi'] = $namanota;
        }
        // without foto
        else{
            $data['foto_garansi']  = "";
        }
        
        // $data['pemegang']           = $this->input->post('pemegang');
        // $data['lokasi_unit']        = $this->input->post('lokasi_unit');//bidang
        // $data['tahun_perolehan']    = $this->input->post('tahun_perolehan');
        $data['keterangan']         = $this->input->post('keterangan');
        $data['status']             = "aktif";
        $data['created_al']         = date('Y-m-d H:i:s');
        $data['update_al']          = date('Y-m-d H:i:s');
        
        $q = $this->db->insert('peralatan', $data);
        return $q;
    }

    public function dataPeralatanByid($id = null)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function editPeralatanDinas($id = null)
    {
        // print_r($this->input->post());
        // die();
        $data['id_asset']           = $this->input->post('id_asset');
        $data['jenis']              = $this->input->post('jenis');
        $data['merk']               = $this->input->post('merk');
        // $data['tipe']               = $this->input->post('tipe');
        // $data['nama']               = $this->input->post('nama');
        $data['tahun_perolehan']    = $this->input->post('tahun_perolehan');
        $data['bidang']             = $this->input->post('bidang');//bidang
        // $data['f']    = $this->input->post('tahun_perolehan');
        $data['garansi']            = date('Y-m-d', strtotime($this->input->post('garansi')));
        // $data['foto_garansi']       = $this->input->post('foto');
        // print_r($_FILES['foto']['name']);
        // die();
        if (!empty($_FILES['foto']['name'])) {
            unlink('./assets/upload/foto_garansi_peralatan/' . $this->input->post('foto_lama'));

            $config['upload_path'] = './assets/upload/foto_garansi_peralatan/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_garansi_peralatan' . $data['jenis'] . '_' . $data['merk'] . '_' . date('Y-m-d') . '_' . uniqid();

            $this->load->library('upload', $config, 'foto');
            $this->foto->initialize($config);
            $this->foto->do_upload('foto');
            $foto = $this->foto->data();

            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/foto_garansi_peralatan/' . $foto['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/foto_garansi_peralatan/' . $foto['file_name'];
            $this->load->library('image_lib', $config, 'resizenota');
            $res = $this->resizenota->resize();
            $namanota = $foto['file_name'];

            $data['foto_garansi'] = $namanota;
            // print_r($namanota);
            // die();
        }
        // without foto
        // else{
        //     $data['foto_garansi']  = "";
        // }
        $data['keterangan']         = $this->input->post('keterangan');
        $data['update_al']          = date('Y-m-d H:i:s');
        
        $q = $this->db->where('id', $id)->update('peralatan', $data);
        return $q;
    }

    public function hapus_data_peralatan($id = null)
    {
        // $this->db->where('id', $id);
        $namafoto = $this->db->select('foto_garansi')->where('id', $id)->get('peralatan')->result_array();
        // print_r($namafoto[0]['foto_garansi']);
        // die();
        unlink('./assets/upload/foto_garansi_peralatan/' . $namafoto[0]['foto_garansi']);
        $this->db->where('id', $id);
        $q = $this->db->delete('peralatan');
        return $q;
    }

    public function paguperalatanById($id = null, $tahun = null)
    {
        // $query = $this->db->query('SELECT * FROM pagu_service as ps 
        // LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_bbm.tgl_pencatatan)=' . $tahun . ' AND riwayat_bbm.status_rbm="Yes", riwayat_bbm.total_bbm,0)) as total_biaya_bbm FROM riwayat_bbm group by id_kendaraan ) rb ON rb.id_kendaraan=ps.id_kend
        // LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_servis.tgl_servis)=' . $tahun . ' AND riwayat_servis.status_srs="Yes",riwayat_servis.total_biaya,0)) as total_biaya_servis FROM riwayat_servis group by id_kendaraan ) rs ON rs.id_kendaraan=ps.id_kend
        // LEFT JOIN (SELECT id_kendaraan, sum(if(riwayat_pajak.tahun=' . $tahun . ' AND riwayat_pajak.status_pjk="Yes",riwayat_pajak.total_pajak,0)) as total_biaya_pajak FROM riwayat_pajak group by id_kendaraan ) rpk ON rpk.id_kendaraan=ps.id_kend
        // WHERE ps.id_kend = ' . $id . ' AND ps.tahun = ' . $tahun . '')->row_array(); 
        $query = $this->db->select('*')
            ->from('pagu_service_peralatan')
            ->where('id_alat', $id)
            ->where('tahun', $tahun)
            ->get();
        // if($query==null){
        //     $query=null;
        // }
        // print_r($query->row());
        // die();
        return $query->row_array();
    }

    public function peralatanByid($id = null)
    {
        $this->db
            ->where('id', $id);
        $query = $this->db
            ->get('peralatan as al');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function data_riwayatpengajuanservisperalatan_pemakai($id = null, $tahun)
    {
        $this->db
            ->order_by('id_pengajuan', 'DESC');
        $this->db->where('id_alat', $id);
        $this->db->where('YEAR(tgl_pengajuan)', $tahun);
        $query = $this->db->get('riwayat_pengajuan_servis_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function data_riwayatpengajuanservisperalatan_admin($id = null, $tahun = null)
    {
        $this->db
            // ->join('users', 'users.id = riwayat_pengajuan_servis.id_admin', 'left');
            ->join('users as us', 'us.id=rps.input_user', 'left');
        $this->db->order_by('rps.id_pengajuan', 'DESC');
        // $this->db->like('rps.tgl_pengajuan', $tahun);
        $this->db->where('YEAR(rps.tgl_pengajuan)', $tahun);
        $this->db->where('rps.id_alat', $id);
        $query = $this->db->get('riwayat_pengajuan_servis_peralatan as rps');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function cek_data_pengajuan_peralatan($id_alat = null)
    {
        $this->db->limit('1')->order_by('id_pengajuan', 'DESC')->where('id_alat', $id_alat);
        $query = $this->db->get('riwayat_pengajuan_servis_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function tambahpengajuanservisperalatan($id_alat = null)
    {
        // if ($this->session->userdata('role') == 'Pemakai') {
        //     $data['id_kendaraan'] = $idkend;
        //     $data['tgl_pengajuan'] = date('Y-m-d');
        //     $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
        //     $data['keluhan'] = $this->input->post('keluhan_kendaraan');
        //     $data['km_service'] = $this->input->post('km_service');
        //     $data['service'] = $this->input->post('servis_kendaraan');
        //     $data['lain_lain'] = $this->input->post('lain_lain_kendaraan');
        //     $data['id_user'] = $this->session->userdata('id');
        //     $data['last_time_update'] = date('Y-m-d H:i:s');
        //     $data['input_user'] = $this->session->userdata('id');
        //     $data['status_pengajuan'] = 'Wait';
        // } else {
            $data['id_alat'] = $id_alat;
            if($this->input->post('dari')==null){
                $data['tgl_pengajuan'] = date('Y-m-d');
            }
            else{
                $data['tgl_pengajuan'] = date('Y-m-d', strtotime($this->input->post('dari')));
            }
            $data['tempat_servis'] = $this->input->post('tempat_servis');
            $data['keluhan'] = $this->input->post('keluhan_peralatan');
            $data['servis'] = $this->input->post('servis_peralatan');
            $data['lain_lain'] = $this->input->post('lain_lain_peralatan');
            $data['update_pengajuan'] = date('Y-m-d H:i:s');
            $data['input_user'] = $this->session->userdata('id');
            // $data['id_admin'] = $this->session->userdata('id_admin');
            $data['status_pengajuan'] = 'Wait';
        // }
        // $data['id_admin'] = '1'; //set default id admin ketika tambah pengajuan servis
        $q = $this->db->insert('riwayat_pengajuan_servis_peralatan', $data);
        return $q;
    }

    public function data_riwayatpengajuanperalatanbyidrp($id = null)
    {

        $this->db->join('users', 'users.id= riwayat_pengajuan_servis_peralatan.input_user', 'left')->where('id_pengajuan', $id);
        $query = $this->db->get('riwayat_pengajuan_servis_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function hapus_data_pengajuan_peralatan($id = null)
    {
        $this->db->where('id_pengajuan', $id);
        $q = $this->db->delete('riwayat_pengajuan_servis_peralatan');
        return $q;
    }

    public function cek_id_edit_riwayat_pengajuan_servis_peralatan($id_pengajuan = null)
    {
        $this->db->where('id_pengajuan', $id_pengajuan);
        $query = $this->db->get('riwayat_pengajuan_servis_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function data_riwayatpengajuanservisperalatan_pemakaibyidpen($id_pengajuan = null)
    {
        $this->db->join('peralatan', 'peralatan.id=riwayat_pengajuan_servis_peralatan.id_alat')->where('id_pengajuan', $id_pengajuan);
        $query = $this->db->get('riwayat_pengajuan_servis_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function editpengajuanservisperalatan($id_pen = null)
    {
        // if ($this->session->userdata('role') == 'Pemakai') {
        //     $data['bengkel_tujuan'] = $this->input->post('nama_bengkel');
        //     $data['km_service'] = $this->input->post('km_service');
        //     $data['keluhan'] = $this->input->post('keluhan_kendaraan');
        //     $data['service'] = $this->input->post('servis_kendaraan');
        //     $data['lain_lain'] = $this->input->post('lain_lain_kendaraan');
        //     $data['id_user'] = $this->session->userdata('id');
        //     $data['input_user'] = $this->session->userdata('id');
        //     $data['status_pengajuan'] = 'Wait';
        //     $data['last_time_update'] = date('Y-m-d H:i:s');
        // } else {
            $data['tgl_pengajuan'] = date('Y-m-d', strtotime($this->input->post('dari')));
            $data['tempat_servis'] = $this->input->post('tempat_servis');
            $data['keluhan'] = $this->input->post('keluhan_peralatan');
            $data['servis'] = $this->input->post('servis_peralatan');
            $data['lain_lain'] = $this->input->post('lain_lain_peralatan');
            $data['input_user'] = $this->session->userdata('id');
            // $data['status_pengajuan'] = 'Wait';
            $data['update_pengajuan'] = date('Y-m-d H:i:s');

        // }
        $q = $this->db->where('id_pengajuan', $id_pen)->update('riwayat_pengajuan_servis_peralatan', $data);
        return $q;
    }

    public function approve_pengajuan_peralatan($id = null)
    {
        $data['status_pengajuan'] = "Yes";
        $data['update_pengajuan'] = date('Y-m-d H:i:s');
        $data['tgl_terima'] = date('Y-m-d H:i:s');
        // $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_pengajuan', $id);
        $q = $this->db->update('riwayat_pengajuan_servis_peralatan', $data);
        return $q;
    }
    public function reject_pengajuan_peralatan($id = null)
    {
        $data['status_pengajuan'] = "No";
        $data['update_pengajuan'] = date('Y-m-d H:i:s');
        // $data['datetime_approve'] = date('Y-m-d H:i:s');
        $data['reject_reason'] = $this->input->post('reason_reject');
        $data['input_user'] = $this->session->userdata('id');
        // $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_pengajuan', $id);
        $q = $this->db->update('riwayat_pengajuan_servis_peralatan', $data);
        return $q;
    }
    public function wait_pengajuan_peralatan($id = null)
    {
        $data['status_pengajuan'] = "Wait";
        $data['update_pengajuan'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin'] = $this->session->userdata('id');
        $this->db->where('id_pengajuan', $id);
        $q = $this->db->update('riwayat_pengajuan_servis_peralatan', $data);
        return $q;
    }

    public function cek_id_riwayat_pengajuan_peralatan($id_pengajuan = null, $id_alat = null)
    {
        $this->db->join('riwayat_pengajuan_servis_peralatan', 'riwayat_pengajuan_servis_peralatan.id_alat = peralatan.id', 'left');
        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->where('id_alat', $id_alat);
        $query = $this->db->get('peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function cek_id_riwayat_servis_peralatan($id = null)
    {
        $this->db->join('riwayat_servis_peralatan', 'riwayat_servis_peralatan.id_alat = peralatan.id', 'left');
        $this->db->where('id', $id);
        $query = $this->db->get('peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function datasummary_peralatanbyid($id = null)
    {
        $this->db
            ->join('riwayat_pemakai_peralatan as rp', 'rp.id_alat = alat.id', 'left')
            ->join('users as us', 'rp.id_user = us.id')
            ->where('id_alat', $id)
            ->group_start()
            ->where('rp.status', 'aktif')
            ->or_where('rp.status is null')
            ->group_end();
        $query = $this->db->get('peralatan as alat');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
        //riwayat pemakai tidak ada
        $query2 = $this->db->get('peralatan as alat');
        if ($query2->num_rows() > 0) {
            foreach ($query2->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    
    public function pengajuan_peralatan_admin($id = null)
    {

        $this->db->join('users', 'users.id= riwayat_pengajuan_servis_peralatan.id_admin')
        ->where('id_pengajuan', $id);
        $query = $this->db->get('riwayat_pengajuan_servis_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function data_riwayatservisperalatan($id = null, $tahun = null)
    {
        $this->db
            ->join('users as us', 'us.id=rs.input_user', 'left')
            // ->like('rs.tgl_servis', $tahun)
            ->where('YEAR(rs.tgl_servis)', $tahun)
            ->where('rs.id_alat', $id);
        $query = $this->db
            ->order_by('rs.tgl_servis', 'DESC')
            ->order_by('rs.id_rs', 'DESC')
            ->get('riwayat_servis_peralatan as rs');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function cek_data_srs_peralatan($id = null)
    {
        $this->db->limit('1')->order_by('id_rs', 'DESC')->where('id_alat', $id);
        $query = $this->db->get('riwayat_servis_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function tambahriwayatservisperalatan($id = null, $nota = null)
    {

        $data['id_alat']        = $id;
        $data['foto_nota']      = $nota;
        $data['tgl_servis']     = date('Y-m-d', strtotime($this->input->post('tgl')));
        $data['tempat_servis']  = $this->input->post('tempat_servis');
        $data['biaya']          = $this->input->post('biaya');
        $data['ket_servis']     = $this->input->post('keterangan');
        $data['input_pemakai']  = $this->session->userdata('name');
        $data['input_user']     = $this->session->userdata('id');
        $data['created_srv']    = date('Y-m-d H:i:s');
        $data['update_srv']     = date('Y-m-d H:i:s');
        $data['status_srv']     = 'Wait';

        $q = $this->db->insert('riwayat_servis_peralatan', $data);
        return $q;
    }

    public function updateriwayatservisperalatan($id_rs = null, $nota = null)
    {
        // print_r($this->session->userdata('role'));
        // die();
        if ($this->session->userdata('role') == 'Pemakai') {
            $data['foto_nota']      = $nota;
            $data['tgl_servis']     = date('Y-m-d', strtotime($this->input->post('tgl')));
            $data['tempat_servis']  = $this->input->post('tempat_servis');
            $data['biaya']          = $this->input->post('biaya');
            $data['input_user']     = $this->session->userdata('id');
            $data['ket_servis']     = $this->input->post('keterangan');
            $data['update_srv']     = date('Y-m-d H:i:s');
            $data['status_srv']     = 'Wait';
        } else {
            $data['foto_nota']      = $nota;
            $data['tgl_servis']     = date('Y-m-d', strtotime($this->input->post('tgl')));
            $data['tempat_servis']  = $this->input->post('tempat_servis');
            $data['biaya']          = $this->input->post('biaya');
            $data['ket_servis']     = $this->input->post('keterangan');
            $data['input_user']     = $this->session->userdata('id');
            $data['update_srv']     = date('Y-m-d H:i:s');
        }

        $q = $this->db->where('id_rs', $id_rs)->update('riwayat_servis_peralatan', $data);
        return $q;
    }

    public function cek_id_edit_riwayat_servis_peralatan($id = null)
    {
        $this->db->where('id_rs', $id);
        $query = $this->db->get('riwayat_servis_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function data_servis_peralatanById($id)
    {
        $query = $this->db
            ->join('peralatan', 'riwayat_servis_peralatan.id_alat = peralatan.id')
            ->get_where('riwayat_servis_peralatan', ['id_rs' => $id])
            ->row_array();
        return $query;
    }


    public function data_riwayatservisperalatan_byidrp($id = null)
    {
        $this->db->where('id_rs', $id);
        $query = $this->db->get('riwayat_servis_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function approve_servis_peralatan($id = null)
    {

        $data['status_srv'] = "Yes";
        $data['update_srv'] = date('Y-m-d H:i:s');
        $data['tgl_terima'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin']   = $this->session->userdata('id');
        $this->db->where('id_rs', $id);
        $q = $this->db->update('riwayat_servis_peralatan', $data);
        return $q;
    }
    public function wait_servis_peralatan($id = null)
    {
        $data['status_srv'] = "Wait";
        $data['update_srv'] = date('Y-m-d H:i:s');
        $data['input_user'] = $this->session->userdata('id');
        $data['id_admin']   = $this->session->userdata('id');
        $this->db->where('id_rs', $id);
        $q = $this->db->update('riwayat_servis_peralatan', $data);
        return $q;
    }
    public function reject_servis_peralatan($id = null)
    {

        $data['status_srv']    = "No";
        $data['update_srv']    = date('Y-m-d H:i:s');
        $data['tgl_terima']    = date('Y-m-d H:i:s');
        $data['reject_reason'] = $this->input->post('reason_reject');
        $data['input_user']    = $this->session->userdata('id');
        $data['id_admin']      = $this->session->userdata('id');
        $this->db->where('id_rs', $id);
        $q = $this->db->update('riwayat_servis_peralatan', $data);
        return $q;
    }

    public function pemakaiAlatById($id = null)
    {
        $query = $this->db
            // ->select('us.name,us.nip_user,rp.status,al.merk,al.jenis,al.tipe')
            ->select('us.name,us.nip_user,rp.status,al.merk,al.jenis')
            ->join('riwayat_pemakai_peralatan as rp', 'rp.id_alat = al.id', 'left')
            ->join('users as us', 'rp.id_user = us.id', 'left')
            ->where('id_alat', $id)
            ->where('rp.status', 'aktif')
            ->get('peralatan as al');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function cek_id_riwayat_pemakai_peralatan($id = null)
    {
        $this->db->join('riwayat_pemakai_peralatan', 'riwayat_pemakai_peralatan.id_alat = peralatan.id', 'left');
        $this->db->where('id', $id);
        $query = $this->db->get('peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function data_riwayatpemakai_peralatan($id = null, $tahun = null)
    {
        $this->db
            ->join('users as us', 'rp.id_user=us.id')
            // ->select('rp.id_rp,rp.id_alat,rp.id_user,rp.lokasi_unit,rp.tgl_awal,rp.tgl_akhir,rp.status, us.id, us.name, us.nip_user')
            ->select('rp.id_rp,rp.id_alat,rp.id_user,rp.bidang,rp.tgl_awal,rp.tgl_akhir,rp.status, us.id, us.name, us.nip_user')
            ->like('rp.tgl_awal', $tahun)
            ->where('rp.id_alat', $id);
        $query = $this->db->get('riwayat_pemakai_peralatan as rp');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            // print_r($hasil);
            // die();
            return $hasil;
        }
    }

    public function data_riwayatpemakaiperalatan_bystatus($id_alat = null)
    {
        $this->db->join('peralatan', 'riwayat_pemakai_peralatan.id_alat=peralatan.id');
        $this->db->where('riwayat_pemakai_peralatan.status', 'aktif');
        $this->db->where('peralatan.id', $id_alat);
        $query = $this->db->get('riwayat_pemakai_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function data_riwayatpemakaibypilihanpemakaiperalatan($id_nama_pemakai = null)
    {
        $this->db->join('peralatan', 'riwayat_pemakai_peralatan.id_alat=peralatan.id');
        $this->db->join('users', 'users.id=riwayat_pemakai_peralatan.id_user');
        $this->db->where('riwayat_pemakai_peralatan.status', 'aktif');
        $this->db->where('riwayat_pemakai_peralatan.id_user', $id_nama_pemakai);
        $query = $this->db->get('riwayat_pemakai_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function prosestambahPemakaiPeralatan($id = null)
    {

        $data['id_alat']   = $id;
        // $data['id_kend_last']   = $id;
        $data['status']         = "aktif";
        $data['id_user'] = $this->input->post('nama');
        // $data['nama_pemakai']   = $this->input->post('nama');
        // $data['nip_pemakai']    = $this->input->post('nip');
        // $data['lokasi_unit']    = $this->input->post('lokasi_unit');
        $data['bidang']    = $this->input->post('bidang');
        $data['tgl_awal']       = date('Y-m-d', strtotime($this->input->post('dari')));
        $data['tgl_akhir']      = date('Y-m-d', strtotime($this->input->post('sampai')));

        // $q = $this->db->insert('riwayat_pemakai_peralatan', $data);
        $this->db->insert('riwayat_pemakai_peralatan', $data);

        // $query = $this->db
        //         ->join('peralatan', 'peralatan.id = riwayat_pemakai_peralatan.id_alat', 'left')
                // ->Where('peralatan.id', $id);

        // $this->db->select('lokasi_unit')
        $this->db->select('bidang')
                 ->from('peralatan')
                 ->where('id', $id);
        $data2['bidang']    = $this->input->post('bidang');
        $q = $this->db->update('peralatan', $data2);

        return $q;
    }

    public function cek_id_edit_riwayat_pemakai_peralatan($id = null)
    {
        $this->db->where('id_rp', $id);
        $query = $this->db->get('riwayat_pemakai_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function data_pemakai_peralatanbyid($id = null)
    {
        $this->db
            ->join('peralatan', 'riwayat_pemakai_peralatan.id_alat = peralatan.id')
            ->join('users as us', 'us.id = riwayat_pemakai_peralatan.id_user', 'left')
            ->where('id_rp', $id);
        $query = $this->db->get('riwayat_pemakai_peralatan')->row_array();
        return $query;
    }

    public function proseseditPemakaiPeralatan($id = null, $id_alat = null)
    {
        $data['id_user'] = $this->input->post('nama');
        // $data['nama_pemakai']   = $this->input->post('nama');
        // $data['nip_pemakai']    = $this->input->post('nip');
        $data['bidang']    = $this->input->post('bidang');
        $data['tgl_awal']       = date('Y-m-d', strtotime($this->input->post('dari')));
        $data['tgl_akhir']      = date('Y-m-d', strtotime($this->input->post('sampai')));

        // $q = $this->db
        //     ->where('id_rp', $id)
        //     ->update('riwayat_pemakai_peralatan', $data);
        $this->db
            ->where('id_rp', $id)
            ->update('riwayat_pemakai_peralatan', $data);

        $data2['bidang']    = $this->input->post('bidang');
        $this->db
             ->select('bidang')
             ->from('peralatan')
             ->where('id', $id_alat);
        $q  = $this->db->update('peralatan', $data2);
        return $q;
    }


    public function data_riwayatpemakaiperalatan_byidrp($id = null)
    {
        $this->db->where('id_rp', $id);
        $query = $this->db->get('riwayat_pemakai_peralatan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }

    public function hapus_pemakai_peralatan($id = null)
    {
        $this->db->where('id_rp', $id);
        $q = $this->db->delete('riwayat_pemakai_peralatan');
        return $q;
    }
    public function nonaktifkanpemakaiperalatan($id = null)
    {

        $data['status'] = "tidak_aktif";
        // $data['id_alat'] = null;
        // $data['id_alat'] = null;
        $this->db->Where('id_rp', $id);
        $q = $this->db->update('riwayat_pemakai_peralatan', $data);
        return $q;
    }
    public function aktifkanpemakaiperalatan($id, $id_alat)
    {

        $data['status'] = "aktif";
        // $data['id_alat'] = $id_alat;
        $this->db->Where('id_rp', $id);
        $q = $this->db->update('riwayat_pemakai_peralatan', $data);
        return $q;
    }

    public function cek_datapagu_peralatan($id = null, $tahun = null)
    {
        // $query = $this->db
        // // ->select('*')
        // ->select_sum('biaya')
        // // ->select('*')
        // ->from('riwayat_servis_peralatan')
        // ->where('id_alat', $id)
        // ->where('YEAR(tgl_servis)', $tahun)
        // ->get()->result_array();

        $query = $this->db->query(
        "SELECT * FROM `pagu_service_peralatan` 
        LEFT JOIN (SELECT id_alat, sum(if(YEAR(riwayat_servis_peralatan.tgl_servis)='$tahun' AND riwayat_servis_peralatan.status_srv='Yes', riwayat_servis_peralatan.biaya,0)) as total_biaya FROM riwayat_servis_peralatan group by id_alat ) rp ON `rp`.`id_alat`=`pagu_service_peralatan`.`id_alat`
        WHERE pagu_service_peralatan.id_alat='$id' AND pagu_service_peralatan.tahun='$tahun'")->result_array();

        return $query;
    }

    public function data_servis_peralatan($tahun = null)
    {
        $this->db
            // ->order_by('rp.is_pejabat', 'DESC')
            ->order_by('al.jenis', 'ASC')
            ->order_by('al.id')
            // ->select('al.jenis,al.merk,al.tipe,us.name,us.id, rp.bidang, ps.pagu_awal')
            ->select('al.jenis,al.merk,us.name,rp.bidang, ps.pagu_awal')
            ->join('pagu_service_peralatan as ps', 'ps.id_alat = al.id', 'left')
            ->join('riwayat_pemakai_peralatan as rp', 'rp.id_alat=al.id', 'left')
            // ->join('riwayat_servis_peralatan as rsp', 'rsp.id_alat=al.id', 'left')//
            ->join('users as us', 'us.id=rp.id_user', 'left')
            ->where('al.status', 'aktif')
            ->where('ps.tahun', $tahun)
            // ->where('rsp.biaya is NOT NULL', NULL, FALSE)//
            // ->where('rsp.status_srv', "Yes")
            ->group_start()
            ->where(array('rp.status' => 'aktif'))
            ->or_where('rp.status is null')
            // ->group_by('rsp.id_alat')//
            ->group_end();
        $query = $this->db->get('peralatan as al');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function data_servis_peralatan_bulan($tahun = null, $bulan = null)
    {
        $this->db
            // ->order_by('rp.is_pejabat', 'DESC')
            ->order_by('al.jenis', 'ASC')
            ->order_by('al.id')
            // ->select('al.jenis,al.merk,al.tipe,us.name,us.id, rp.bidang, ps.pagu_awal')
            ->select('al.jenis,al.merk,us.name,rp.bidang, ps.pagu_awal')
            ->join('pagu_service_peralatan as ps', 'ps.id_alat = al.id', 'left')
            ->join('riwayat_pemakai_peralatan as rp', 'rp.id_alat=al.id', 'left')
            ->join('riwayat_servis_peralatan as rsp', 'rsp.id_alat=al.id', 'left')
            ->join('users as us', 'us.id=rp.id_user', 'left')
            ->where('al.status', 'aktif')
            ->where('ps.tahun', $tahun)
            ->where('YEAR(rsp.tgl_servis)', $tahun)
            ->where('MONTH(rsp.tgl_servis)', $bulan)
            ->where('rsp.biaya is NOT NULL', NULL, FALSE)
            ->where('rsp.status_srv', "Yes")
            ->group_start()
            ->where(array('rp.status' => 'aktif'))
            ->or_where('rp.status is null')
            ->group_end()
            ->group_by('al.id');
        $query = $this->db->get('peralatan as al');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function data_servis_peralatan_iduser($tahun = null)
    {
        $this->db
            // ->order_by('rp.is_pejabat', 'DESC')
            ->order_by('al.jenis', 'ASC')
            ->order_by('al.id')
            ->select('al.jenis,al.merk,us.name,us.id, rp.bidang, ps.pagu_awal')
            // ->select('al.jenis,al.merk,al.tipe,us.name,rp.bidang, ps.pagu_awal')
            ->join('pagu_service_peralatan as ps', 'ps.id_alat = al.id', 'left')
            ->join('riwayat_pemakai_peralatan as rp', 'rp.id_alat=al.id', 'left')
            ->join('users as us', 'us.id=rp.id_user', 'left')
            ->where('al.status', 'aktif')
            ->where('ps.tahun', $tahun)
            ->group_start()
            ->where(array('rp.status' => 'aktif'))
            ->or_where('rp.status is null')
            ->group_end();
        $query = $this->db->get('peralatan as al');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function data_servis_peralatan_iduser_bulan($tahun = null, $bulan = null)
    {
        $this->db
            // ->order_by('rp.is_pejabat', 'DESC')
            ->order_by('al.jenis', 'ASC')
            ->order_by('al.id')
            ->select('al.jenis,al.merk,us.name,us.id, rp.bidang, ps.pagu_awal, rsp.tgl_servis')
            // ->select('al.jenis,al.merk,al.tipe,us.name,rp.bidang, ps.pagu_awal')
            ->join('pagu_service_peralatan as ps', 'ps.id_alat = al.id', 'left')
            ->join('riwayat_pemakai_peralatan as rp', 'rp.id_alat=al.id', 'left')
            ->join('riwayat_servis_peralatan as rsp', 'rsp.id_alat=al.id', 'left') 
            ->join('users as us', 'us.id=rp.id_user', 'left')
            ->where('al.status', 'aktif')
            ->where('ps.tahun', $tahun)
            ->where('rsp.status_srv', "Yes")
            ->where('MONTH(rsp.tgl_servis)', $bulan)
            // ->where('rsp.id_alat', 'al.id')
            // ->where('ps.tahun', $tahun)
            ->group_start()
            ->where(array('rp.status' => 'aktif'))
            ->or_where('rp.status is null')
            ->group_end()
            ->group_by('al.id');
        $query = $this->db->get('peralatan as al');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function servis_peralatan_all_bulan($tahun = null, $bulan = null)
    {
        $query = $this->db
            ->query('
                SELECT total_servis 
                FROM `peralatan` as `al` 
                LEFT JOIN `pagu_service_peralatan` as `ps` ON `ps`.`id_alat` = `al`.`id`                
                LEFT JOIN `riwayat_pemakai_peralatan` as `rp` ON `rp`.`id_alat`=`al`.`id` 
                LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
                LEFT JOIN (
                    SELECT rsp.id_alat, YEAR(rsp.tgl_servis) as tahun_servis, 
                    MONTHNAME(rsp.tgl_servis) as bulan_servis, 
                    sum(rsp.biaya) as total_servis 
                    FROM riwayat_servis_peralatan as rsp 
                    where rsp.status_srv="Yes" 
                        and month(rsp.tgl_servis)='.$bulan.' and year(rsp.tgl_servis)=' . $tahun . ' 
                    group by rsp.id_alat,YEAR(rsp.tgl_servis), MONTH(rsp.tgl_servis))rsp ON rsp.id_alat = al.id      
                WHERE `al`.`status` = "aktif" 
                    AND `ps`.`tahun` = ' . $tahun . ' 
                    
                    AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null )
                
                GROUP BY `al`.`id`');
        // $query = $this->db
        //     ->query('SELECT total_servis, tangga FROM `peralatan` as `al` 
        //         LEFT JOIN `pagu_service_peralatan` as `ps` ON `ps`.`id_alat` = `al`.`id`                
        //         LEFT JOIN `riwayat_pemakai_peralatan` as `rp` ON `rp`.`id_alat`=`al`.`id` 
        //         LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        //         LEFT JOIN (SELECT rsp.id_alat, YEAR(rsp.tgl_servis) as tahun_servis, MONTHNAME(rsp.tgl_servis) as bulan_servis,sum(rsp.biaya) as total_servis FROM riwayat_servis_peralatan as rsp where rsp.status_srv="Yes" and month(rsp.tgl_servis)='.$bulan.' and year(rsp.tgl_servis)=' . $tahun . ' group by rsp.id_alat,YEAR(rsp.tgl_servis), MONTH(rsp.tgl_servis))rsp ON rsp.id_alat = al.id      
        //         WHERE `al`.`status` = "aktif" 
        //             AND `ps`.`tahun` = ' . $tahun . ' 
        //             AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `al`.`jenis` ASC, `al`.`id`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function servis_peralatan_bulan($tahun = null, $bulan = null)
    {
        $query = $this->db
            ->query('
                SELECT total_servis 
                FROM `peralatan` as `al` 
                LEFT JOIN `pagu_service_peralatan` as `ps` ON `ps`.`id_alat` = `al`.`id`                
                LEFT JOIN `riwayat_pemakai_peralatan` as `rp` ON `rp`.`id_alat`=`al`.`id` 
                LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
                LEFT JOIN (
                    SELECT rsp.id_alat, YEAR(rsp.tgl_servis) as tahun_servis, 
                    MONTHNAME(rsp.tgl_servis) as bulan_servis, 
                    MONTH(rsp.tgl_servis) as bulan_srv,
                    sum(rsp.biaya) as total_servis 
                    FROM riwayat_servis_peralatan as rsp 
                    where rsp.status_srv="Yes" 
                        and month(rsp.tgl_servis)='.$bulan.' and year(rsp.tgl_servis)=' . $tahun . ' 
                    group by rsp.id_alat,YEAR(rsp.tgl_servis), MONTH(rsp.tgl_servis))rsp ON rsp.id_alat = al.id      
                WHERE `al`.`status` = "aktif" 
                    AND `ps`.`tahun` = ' . $tahun . ' 
                    AND `bulan_srv` = '.$bulan. '
                    AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null )
                
                GROUP BY `al`.`id`');
        // $query = $this->db
        //     ->query('SELECT total_servis, tangga FROM `peralatan` as `al` 
        //         LEFT JOIN `pagu_service_peralatan` as `ps` ON `ps`.`id_alat` = `al`.`id`                
        //         LEFT JOIN `riwayat_pemakai_peralatan` as `rp` ON `rp`.`id_alat`=`al`.`id` 
        //         LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        //         LEFT JOIN (SELECT rsp.id_alat, YEAR(rsp.tgl_servis) as tahun_servis, MONTHNAME(rsp.tgl_servis) as bulan_servis,sum(rsp.biaya) as total_servis FROM riwayat_servis_peralatan as rsp where rsp.status_srv="Yes" and month(rsp.tgl_servis)='.$bulan.' and year(rsp.tgl_servis)=' . $tahun . ' group by rsp.id_alat,YEAR(rsp.tgl_servis), MONTH(rsp.tgl_servis))rsp ON rsp.id_alat = al.id      
        //         WHERE `al`.`status` = "aktif" 
        //             AND `ps`.`tahun` = ' . $tahun . ' 
        //             AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `al`.`jenis` ASC, `al`.`id`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function laporan_alat($tahun = null, $bulan = null)
    {
        // $query = $this->db
        //     ->query('SELECT * FROM `peralatan` as `al` 
        //         LEFT JOIN `pagu_service_peralatan` as `ps` ON `ps`.`id_alat` = `al`.`id`                
        //         LEFT JOIN `riwayat_pemakai_peralatan` as `rp` ON `rp`.`id_alat`=`al`.`id` 
        //         LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
        //         LEFT JOIN (
        //             SELECT rsp.id_alat, 
        //                    YEAR(rsp.tgl_servis) as tahun_servis,
        //                    MONTH(rsp.tgl_servis) as bulan_servis
        //             FROM riwayat_servis_peralatan as rsp 
        //             where rsp.status_srv="Yes" 
        //                 AND month(rsp.tgl_servis)= '. $bulan . ' 
        //                 AND year(rsp.tgl_servis)= '. $tahun . ' 
        //             group by 
        //                 rsp.id_alat,
        //                 YEAR(rsp.tgl_servis),
        //                 MONTH(rsp.tgl_servis))
        //                 rsp ON rsp.id_alat = al.id      
        //             ORDER BY `al`.`jenis` ASC, `al`.`id`;');
            $query = $this->db
            ->query('SELECT
                        rsp.id_alat, 
                        rsp.tgl_servis, 
                        rsp.tempat_servis, 
                        YEAR(rsp.tgl_servis) as tahun_servis,
                        MONTH(rsp.tgl_servis) as bulan_servis,
                        rsp.ket_servis,
                        rp.id_user 
                    FROM `riwayat_servis_peralatan` as `rsp` 
                    -- LEFT JOIN `pagu_service_peralatan` as `ps` ON `ps`.`id_alat` = `rsp`.`id_alat`                
                    JOIN `riwayat_pemakai_peralatan` as `rp` 
                        ON `rp`.`id_alat` = `rsp`.`id_alat`
                    JOIN `users` as `us` 
                        ON `us`.`id`=`rp`.`id_user` 
                    WHERE rsp.status_srv="Yes"
                        AND month(rsp.tgl_servis)='.$bulan.' 
                        AND year(rsp.tgl_servis)='.$tahun.'
                        AND rp.id_user="118"   
                    ');
            // $query['id_user']
            // $query = $this->db->select("id_alat, 
            //             tgl_servis, 
            //             tempat_servis, 
            //             YEAR(tgl_servis) as tahun_servis,
            //             MONTH(tgl_servis) as bulan_servis,
            //             ket_servis ")
            //         ->from('riwayat_servis_peralatan as rsp')
            //         ->where(rsp.status_srv,"Yes")
            //         ->where(month(rsp.tgl_servis), $bulan)
            //         ->where(year(rsp.tgl_servis), $tahun);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

     public function lap_alat($tahun = null, $bulan = null, $id_user = null)
    {
        $query = $this->db
            ->query('SELECT
                        rsp.id_alat, 
                        rsp.tgl_servis, 
                        rsp.tempat_servis, 
                        YEAR(rsp.tgl_servis) as tahun_servis,
                        MONTH(rsp.tgl_servis) as bulan_servis,
                        rsp.ket_servis,
                        rp.id_user,
                        rsp.biaya 
                    FROM `riwayat_servis_peralatan` as `rsp` 
                    -- LEFT JOIN `pagu_service_peralatan` as `ps` ON `ps`.`id_alat` = `rsp`.`id_alat`                
                    JOIN `riwayat_pemakai_peralatan` as `rp` 
                        ON `rp`.`id_alat` = `rsp`.`id_alat`
                    JOIN `users` as `us` 
                        ON `us`.`id`=`rp`.`id_user` 
                    WHERE rsp.status_srv="Yes"
                        AND month(rsp.tgl_servis)='.$bulan.' 
                        AND year(rsp.tgl_servis)='.$tahun.'
                        AND rp.id_user='.$id_user.'   
                    ');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function laporan_kendaraan_bulan($tahun = null, $bulan = null)
    {
        $query = $this->db
            ->query('SELECT total_sparepart as total_sp,total_oli as total_ol,total_servis as total_sv,total_bbm as total_bm,total_pajak as total_pj FROM `kendaraan` as `kn` 
                LEFT JOIN `pagu_service` as `ps` ON `ps`.`id_kend` = `kn`.`idk`                
                LEFT JOIN `riwayat_pemakai` as `rp` ON `rp`.`id_kendaraan`=`kn`.`idk` 
                LEFT JOIN `users` as `us` ON `us`.`id`=`rp`.`id_user` 
                LEFT JOIN (SELECT srs.id_kendaraan, YEAR(srs.tgl_servis) as tahun_servis, MONTHNAME(srs.tgl_servis) as bulan_servis,sum(srs.service) as total_servis,sum(srs.sparepart) as total_sparepart,sum(srs.oli) as total_oli FROM riwayat_servis as srs where srs.status_srs="Yes" and month(srs.tgl_servis)=' . $bulan . ' and year(srs.tgl_servis)=' . $tahun . ' group by srs.id_kendaraan,YEAR(srs.tgl_servis), MONTH(srs.tgl_servis))srs ON srs.id_kendaraan = kn.idk      
                LEFT JOIN (SELECT rbm.id_kendaraan,MONTHNAME(rbm.tgl_pencatatan) as bulan_catat_bbm,year(rbm.tgl_pencatatan) as tahun_catat_bbm, sum(rbm.total_bbm) as total_bbm from riwayat_bbm as rbm where rbm.status_rbm="Yes" and month(rbm.tgl_pencatatan)=' . $bulan . ' and year(rbm.tgl_pencatatan)=' . $tahun . ' group by rbm.id_kendaraan,YEAR(rbm.tgl_pencatatan), MONTH(rbm.tgl_pencatatan))rbm ON rbm.id_kendaraan = kn.idk 
                LEFT JOIN (SELECT pjk.id_kendaraan,MONTHNAME(pjk.tgl_pencatatan) as bulan_catat_pajak,year(pjk.tgl_pencatatan) as tahun_catat_pajak, sum(pjk.total_pajak) as total_pajak from riwayat_pajak as pjk where pjk.status_pjk="Yes" and month(pjk.tgl_pencatatan)=' . $bulan . ' and year(pjk.tgl_pencatatan)=' . $tahun . ' group by pjk.id_kendaraan,YEAR(pjk.tgl_pencatatan), MONTH(pjk.tgl_pencatatan))pjk ON pjk.id_kendaraan = kn.idk WHERE `kn`.`status` = "aktif" AND `ps`.`tahun` = ' . $tahun . ' AND ( `rp`.`status` = "aktif" OR `rp`.`status` is null ) ORDER BY `rp`.`is_pejabat` DESC, `kn`.`jenis` ASC, `kn`.`idk`;');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }

    public function peralatanUser($id = null, $tahun = null)
    {
        $query = $this->db->query('SELECT * FROM users as us 
        JOIN riwayat_pemakai_peralatan as rp ON rp.id_user = us.id 
        JOIN peralatan as al ON al.id = rp.id_alat 
        LEFT JOIN pagu_service_peralatan as ps ON ps.id_alat = al.id 
        LEFT JOIN (SELECT id_alat, sum(if(YEAR(riwayat_servis_peralatan.tgl_servis)=' . $tahun . ' AND riwayat_servis_peralatan.status_srv="Yes",riwayat_servis_peralatan.biaya,0)) as total_biaya_servis 
            FROM riwayat_servis_peralatan group by id_alat ) rs ON rs.id_alat=ps.id_alat
        WHERE us.id = ' . $id . ' AND (CASE WHEN ps.tahun is null THEN ps.tahun is null ELSE ps.tahun=' . $tahun . ' END) AND rp.status = "aktif"')->result_array();
        return $query;
    }

    public function peralatanByidwithpagu($id = null, $tahun = null)
    {
        $query = $this->db->query('SELECT * FROM peralatan as al 
        LEFT JOIN pagu_service_peralatan as ps ON ps.id_alat=al.id 
        LEFT JOIN (SELECT id_alat, sum(if(YEAR(riwayat_servis_peralatan.tgl_servis)=' . $tahun . ' AND riwayat_servis_peralatan.status_srv="Yes",riwayat_servis_peralatan.biaya,0)) as total_biaya_servis FROM riwayat_servis_peralatan group by id_alat ) rs ON rs.id_alat=ps.id_alat
        WHERE al.id = ' . $id . ' AND ps.tahun = ' . $tahun . '')->row_array();
        return $query;
    }

    public function tambahriwayatservisperalatanwithoutnota($id = null)
    {
        $data['id_alat']        = $id;
        // $data['foto_nota']      = $nota;
        $data['foto_nota']      = "";
        $data['tgl_servis']     = date('Y-m-d', strtotime($this->input->post('tgl')));
        $data['tempat_servis']  = $this->input->post('tempat_servis');
        $data['biaya']          = $this->input->post('biaya');
        $data['ket_servis']     = $this->input->post('keterangan');
        $data['input_pemakai']  = $this->session->userdata('name');
        $data['input_user']     = $this->session->userdata('id');
        $data['created_srv']    = date('Y-m-d H:i:s');
        $data['update_srv']     = date('Y-m-d H:i:s');
        $data['status_srv']     = 'Wait';


        $q = $this->db->insert('riwayat_servis', $data);
        return $q;
    }

   

    public function tambahpengajuanservisperalatan_pemakai($idalat = null)
    {
            $data['id_alat'] = $idalat;
            if($this->input->post('dari')==null){
                $data['tgl_pengajuan'] = date('Y-m-d');
            }
            else{
                $data['tgl_pengajuan'] = date('Y-m-d', strtotime($this->input->post('dari')));   
            }
            // $data['id_alat'] = $id_alat;
            $data['tempat_servis'] = $this->input->post('tempat_servis');
            $data['keluhan'] = $this->input->post('keluhan_peralatan');
            $data['servis'] = $this->input->post('servis_peralatan');
            $data['lain_lain'] = $this->input->post('lain_lain_peralatan');
            $data['update_pengajuan'] = date('Y-m-d H:i:s');
            $data['input_user'] = $this->session->userdata('id');
            $data['status_pengajuan'] = 'Wait';
        
        // $data['id_admin'] = '1'; //set default id admin ketika tambah pengajuan servis
        $q = $this->db->insert('riwayat_pengajuan_servis_peralatan', $data);
        return $q;
    }
}