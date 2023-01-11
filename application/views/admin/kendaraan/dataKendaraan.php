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
<<<<<<< HEAD
   <div class="container">
     <div class="row">
       <div class="col-lg-12">
         <div class="card">
           <div class="card-header" style="background-color:#4a2f3a;">
             <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
           </div>
           <div class="card-header">
             <?php if ($this->session->userdata('role') == 'Superadmin') : ?>
             <a href="<?= site_url('home/tambahKendaraanDinas') ?>" class="btn btn-sm btn-success">Tambah
               Data
               Kendaraan</a>
             <?php endif; ?>
           </div>
           <div class="card-body">
             <table class="table table-bordered table-striped" width="100%" height="auto" id="kendaraan">
               <thead>
                 <tr>
                   <th class="text-center" rowspan="2">No</th>
                   <th class="text-center" colspan="2">Aksi</th>
                   <th class="text-center" rowspan="2">ID Aset</th>
                   <th class="text-center" rowspan="2">Pemakai</th>
                   <th class="text-center" rowspan="2">Lokasi Unit</th>
                   <th class="text-center" rowspan="2">No. Polisi</th>
                   <th class="text-center" rowspan="2">Jenis</th>
                   <th class="text-center" rowspan="2">Merk</th>
                   <th class="text-center" rowspan="2">Tipe</th>
                   <th class="text-center" rowspan="2">Tahun Kendaraan</th>
                   <th class="text-center" rowspan="2">Jenis Bahan Bakar</th>
                   <th class="text-center" rowspan="2">Besar CC</th>
                   <th class="text-center" rowspan="2">Masa Berlaku STNK</th>
                   <th class="text-center" rowspan="2">No. STNK</th>
                   <th class="text-center" rowspan="2">No. Mesin</th>
                   <th class="text-center" rowspan="2">No. Rangka</th>
                 </tr>
                 <tr>
                   <th class="text-center"></th>
                   <th class="text-center"></th>
                 </tr>
               </thead>
               <tbody>
=======
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-header">
                         <?php if ($this->session->userdata('role') == 'Superadmin') : ?>
                         <a href="<?= site_url('home/tambahKendaraanDinas') ?>" class="btn btn-sm btn-success">Tambah
                             Data
                             Kendaraan</a>
                         <?php endif; ?>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%" height="auto">
                             <thead>
                                 <tr>
                                     <th class="text-center" rowspan="2">No</th>
                                     <th class="text-center" colspan="2">Aksi</th>
                                     <th class="text-center" rowspan="2">ID Aset</th>
                                     <th class="text-center" rowspan="2">Pemakai</th>
                                     <th class="text-center" rowspan="2">Lokasi Unit</th>
                                     <th class="text-center" rowspan="2">No. Polisi</th>
                                     <th class="text-center" rowspan="2">Jenis</th>
                                     <th class="text-center" rowspan="2">Merk</th>
                                     <th class="text-center" rowspan="2">Tipe</th>
                                     <th class="text-center" rowspan="2">No. STNK</th>
                                     <th class="text-center" rowspan="2">Masa Berlaku STNK</th>
                                     <th class="text-center" rowspan="2">No. Mesin</th>
                                     <th class="text-center" rowspan="2">No. Rangka</th>
                                     <th class="text-center" rowspan="2">Tahun Motor</th>
                                     <th class="text-center" rowspan="2">Jenis Bahan Bakar</th>
                                     <th class="text-center" rowspan="2">Besar CC</th>
                                 </tr>
                                 <tr>
                                     <th class="text-center"></th>
                                     <th class="text-center"></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if ($kendaraan != '') {
                                        foreach ($kendaraan as $kend) { ?>
                                 <tr>
                                     <td class="text-center"><?= $no++; ?></td>
                                     <td class="text-center">
                                         <a href="<?= site_url('home/riwayat_kondisi?id=' . $kend['idk'] . '') ?>"
                                             class="btn btn-sm btn-warning jedatombol"
                                             title="Riwayat Kondisi <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa fa-motorcycle"></i></a>
                                         <a href="<?= site_url('home/riwayat_pemakai?id=' . $kend['idk'] . '') ?>"
                                             class="btn btn-sm btn-success jedatombol"
                                             title="Riwayat Pemakai <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa fa-users"></i></a>
                                         <a href="<?= site_url('home/riwayat_servis?id=' . $kend['idk'] . '') ?>"
                                             class="btn btn-sm btn-primary jedatombol"
                                             title="Riwayat Service <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa fa-tools"></i></a>
                                         <?php if ($this->session->userdata('role') != "Admin") : ?>
                                         <a href="<?= site_url('admin/pagu?id=' . $kend['idk'] . '') ?>"
                                             class="btn btn-sm btn-dark jedatombol"
                                             title="Pagu Tahunan Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa fa-wallet"></i></a>
                                         <a href="<?= site_url('home/print_data_kendaraan?id=' . $kend['idk'] . '') ?>"
                                             class="btn btn-sm btn-dark jedatombol"
                                             title="Print Data Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa fa-print"></i></a>
                                         <?php endif ?>
                                     </td>
                                     <td class="text-center">
                                         <a href="<?= site_url('home/riwayat_bbm?id=' . ($kend['idk']) . '') ?>"
                                             class="btn btn-sm btn-primary jedatombol"
                                             title="Riwayat BBM <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa fa-gas-pump"></i></a>
                                         <a href="<?= site_url('home/riwayat_pajak?id=' . $kend['idk'] . '') ?>"
                                             class="btn btn-sm btn-primary jedatombol"
                                             title="Riwayat Pajak Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa fa-align-justify"></i></a>
                                         <?php if ($this->session->userdata('role') != "Admin") : ?>
                                         <a href="<?= site_url('home/pengajuan_servis?id=' . $kend['idk'] . '') ?>"
                                             class="btn btn-sm btn-info jedatombol"
                                             title="Pengajuan Servis Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa-solid fa-ballot"></i></a>
                                         <a onclick="editConfirm('<?= site_url('home/edit_kendaraan?id=' . $kend['idk'] . '') ?>')"
                                             href="#" class="btn btn-sm btn-warning jedatombol"
                                             title="Edit Data Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa fa-pen"></i></a>
                                         <a onclick="deleteConfirm('<?= site_url('home/hapus_data_kendaraan?id=' . $kend['idk'] . '') ?>')"
                                             href="#" class="btn btn-sm btn-danger jedatombol"
                                             title="Hapus Data Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa fa-trash"></i></a>
                                         <?php endif ?>
                                     </td>
                                     <td class="text-center"><?= $kend['id_assets'] ?></td>
                                     <td class="text-center">
                                         <?php if (empty($kend['name'])) : ?>
                                         <p> - <br><i style="color:red" class="fa-solid fa-circle-exclamation"
                                                 title="Data Masih Kosong. Silakan diperbarui"></i></p>
                                         <?php else : ?>
                                         <?= strtoupper($kend['name'] . '<br>(' . $kend['nip_user'] . ')') ?>
                                         <?php endif ?>
                                     </td>
                                     <td class="text-center">
                                         <?php if (empty($kend['lokasi_unit'])) : ?>
                                         <p> - <br><i style="color:red" class="fa-solid fa-circle-exclamation"
                                                 title="Data Masih Kosong. Silakan diperbarui"></i></p>
                                         <?php else : ?>
                                         <?= strtoupper($kend['lokasi_unit']) ?>
                                         <?php endif ?>
                                     </td>
                                     <td class="text-center">
                                         <?php if (empty($kend['no_polisi'])) : ?>
                                         <p> - <br><i style="color:red" class="fa-solid fa-circle-exclamation"
                                                 title="Data Masih Kosong. Silakan diperbarui"></i></p>
                                         <?php else : ?>
                                         <?= strtoupper($kend['no_polisi']) ?>
                                         <?php endif ?>
>>>>>>> 316cdd9c350e7cdeffa7b00461fea08d732b474c

               </tbody>
             </table>
           </div>
         </div>
       </div>
     </div>
     <!-- /.row -->
   </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->