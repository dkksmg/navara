 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <!-- <h1 class="m-0"> Data Kendaraan Dinas <small>NAVARA</small></h1> -->
             </div><!-- /.col -->
             <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                 </ol>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <?php if ($kend != '') : ?>
                 <div class="card">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas Anda</h3>
                     </div>
                     <div class="card-body">
                         <table class="table table-striped">
                             <tr>
                                 <th width="30%">ID Aset</th>
                                 <th>:</th>
                                 <th><?= $kend['id_assets'] ?></th>
                             </tr>
                             <tr>
                                 <th>No. Polisi</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['no_polisi']) ?></th>
                             </tr>
                             <tr>
                                 <th>Jenis</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis']) ?></th>
                             </tr>
                             <tr>
                                 <th>Merk</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['merk']) ?></th>
                             </tr>
                             <tr>
                                 <th>Tipe</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['tipe']) ?></th>
                             </tr>
                             <tr>
                                 <th>Bahan Bakar</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis_bb']) ?></th>
                             </tr>
                             <tr>
                                 <th>Masa Berlaku STNK</th>
                                 <th>:</th>
                                 <th><?= date('d-m-Y', strtotime($kend['masa_berlaku_stnk'])) ?></th>
                             </tr>
                             <tr>
                                 <th>Lokasi Unit</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['lokasi_unit']) ?></th>
                             </tr>
                         </table>
                     </div>
                     <div class="card-footer">
                         <a href="<?= site_url('pemakai/riwayatkondisi?id=' . $kend['idk'] . '') ?>"
                             class="btn btn-primary jedatombol"
                             title="Riwayat Kondisi <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                             Kondisi</a>
                         <a href="<?= site_url('pemakai/riwayatservis?id=' . $kend['idk'] . '') ?>"
                             class="btn btn-warning jedatombol"
                             title="Riwayat Servis <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                             Servis</a>
                         <a href="<?= site_url('pemakai/riwayatbbm?id=' . $kend['idk'] . '') ?>"
                             class="btn btn-secondary jedatombol"
                             title="Riwayat BBM <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                             BBM</a>
                         <a href="<?= site_url('pemakai/riwayatpajak?id=' . $kend['idk'] . '') ?>"
                             class="btn btn-danger jedatombol"
                             title="Riwayat Pajak <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                             Pajak</a>
                         <a href="<?= site_url('pemakai/pengajuanservis?id=' . $kend['idk']) ?>"
                             class="btn btn-success jedatombol"
                             title="Pengajuan Servis <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Pengajuan
                             Servis</a>
                     </div>
                 </div>
                 <?php else : ?>
                 <div class="card">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas Anda</h3>
                     </div>
                     <div class="card-body">
                         <h5 class="text-center">Anda Belum Memiliki Kendaraan Aktif</h5>
                     </div>
                     <div class="card-footer">
                     </div>
                 </div>
                 <?php endif ?>
             </div>
         </div>
         <!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->

 <!-- /.modal-dialog -->
 </div>