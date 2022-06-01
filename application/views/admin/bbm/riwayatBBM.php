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
                 <div class="card">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas</h3>
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
                                 <th>CC</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['besar_cc']) ?> CC</th>
                             </tr>
                             <tr>
                                 <th>Bahan Bakar</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis_bb']) ?></th>
                             </tr>
                             <tr>
                                 <th>Pagu Kendaraan Tahun <?= date('Y') ?></th>
                                 <th>:</th>
                                 <th>Rp. <?= isset($pagu) ? number_format($pagu['pagu_awal'], 2, ',', '.') : 0 ?></th>
                             </tr>
                             <?php
                                if (isset($pagu)) {
                                    $terpakai = $pagu['total_biaya_pajak'] + $pagu['total_biaya_servis'] + $pagu['total_biaya_bbm'];
                                    $sisa = $pagu['pagu_awal'] - $terpakai;
                                }
                                ?>
                             <tr>
                                 <th>Pagu Terpakai</th>
                                 <th>:</th>
                                 <th>Rp. <?= isset($terpakai) ? number_format($terpakai, 2, ',', '.') : 0 ?></th>
                             </tr>
                             <tr>
                                 <th>Sisa Pagu</th>
                                 <th>:</th>
                                 <th>Rp. <?= isset($sisa) ? number_format($sisa, 2, ',', '.') : 0 ?></th>
                             </tr>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-header">
                         <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                             data-target="#modal-xl">
                             Tambah Riwayat BBM
                         </button>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="auto" height="auto">
                             <thead>
                                 <tr>
                                     <th class="text-center">No</th>
                                     <th class="text-center">Aksi</th>
                                     <th class="text-center">Tanggal</th>
                                     <th class="text-center">Total Harga BBM</th>
                                     <th class="text-center">Foto Struk BBM</th>
                                     <th class="text-center">Status</th>
                                     <th class="text-center">Last Update By</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if ($rbbm != '') :
                                        foreach ($rbbm as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= $no; ?></td>
                                     <td class="text-center">
                                         <a onclick="deleteConfirm('<?= site_url('home/hapusrbbm?id=' . ($value['id_bbm']) . '&idkend=' . ($value['id_kendaraan'])) ?>')"
                                             href="#" class="btn btn-danger btn-sm jedatombol"
                                             title="Hapus Riwayat BBM <?= $kend['no_polisi'] ?>"><i
                                                 class="fas fa-trash"></i></a>
                                         <a onclick="editConfirm('<?= site_url('home/editrbbm?id=' . ($value['id_bbm']) . '&idkend=' . ($value['id_kendaraan'])) ?>')"
                                             href="#" class="btn btn-warning btn-sm jedatombol"
                                             title="Edit Riwayat BBM <?= $kend['no_polisi'] ?>"><i
                                                 class="fas fa-pen"></i></a>
                                         <?php if ($value['status_rbm'] == 'No' || $value['status_rbm'] == 'Wait') : ?>
                                         <a href="#"
                                             onclick="approveConfirm('<?= site_url('home/approve_riwayatbbm?id=' . $value['id_bbm'] . '') ?>')"
                                             class="btn btn-sm btn-success jedatombol"
                                             title="Setujui Riwayat BBM <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                                             <i class="fa-solid fa-badge-check"></i></a>
                                         <a href="#"
                                             onclick="waitConfirm('<?= site_url('home/wait_riwayatbbm?id=' . $value['id_bbm'] . '') ?>')"
                                             class="btn btn-sm btn-dark jedatombol <?php if ($value['status_rbm'] == 'Wait') : ?> disabled <?php endif; ?>"
                                             title="Set Wait Riwayat BBM <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                                             <i class="fa-solid fa-circle-pause"></i></a>
                                         <a href="#" data-toggle="modal" data-target="#modal_reject<?php echo $no ?>"
                                             class="btn btn-sm btn-danger jedatombol <?php if ($value['status_rbm'] == 'No') : ?> disabled <?php endif; ?>"
                                             title="Tolak Riwayat BBM <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa-solid fa-circle-xmark"></i></a>
                                         <?php else : ?>
                                         <a href="#" data-toggle="modal" data-target="#modal_reject<?php echo $no ?>"
                                             class="btn btn-sm btn-danger jedatombol"
                                             title="Tolak Riwayat BBM <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa-solid fa-circle-xmark"></i></a>
                                         <a href="#"
                                             onclick="waitConfirm('<?= site_url('home/wait_riwayatbbm?id=' . $value['id_bbm'] . '') ?>')"
                                             class="btn btn-sm btn-dark jedatombol"
                                             title="Set Wait Riwayat BBM <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                                             <i class="fa-solid fa-circle-pause"></i></a>
                                         <?php endif; ?>
                                     </td>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pencatatan'])); ?>
                                     </td>
                                     <td class="text-center">
                                         <?= "Rp. " . number_format((float)$value['total_bbm'], 2, ',', '.'); ?>
                                     </td>
                                     <td class="text-center"><img
                                             src="<?= base_url('assets/upload/struk_bbm/' . $value['struk_bbm'] . '') ?>"
                                             alt="Foto Struk BBM" data-toggle="modal" width="30%"
                                             data-target="#strukModal<?php echo $no ?>">
                                     </td>
                                     <td class="text-center" width="15%">
                                         <?php if ($value['status_rbm'] == 'Wait') : ?>
                                         Perlu dicek <br><i style="color:red"
                                             class="fa-solid fa-triangle-exclamation"></i>
                                         <?php elseif ($value['status_rbm'] == 'No') : ?>
                                         Ditolak <i class=" fa-solid fa-circle-info"
                                             title="<?= $value['reject_reason'] ?>">
                                         </i><br><i style="color:red;font-size:12px">
                                             Pengguna dapat menginput data kembali. <br>Reject on
                                             <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                                         <?php else : ?>
                                         <?php if ($value['role'] == 'Superadmin' || $value['role'] == 'Admin') : ?>
                                         Disetujui Oleh <?= $value['name'] ?>
                                         <br><i style="color:green;font-size:12px">Approved on
                                             <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                                         <?php else : ?>
                                         Disetujui
                                         <br><i style="color:green;font-size:12px">Approved on
                                             <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                                         <?php endif ?>
                                         <?php endif ?>
                                     </td>
                                     <td class="text-center">
                                         <?= $value['name'] ?><br>
                                         <i
                                             style="color:black;font-size:12px"><b><?= date('d-m-Y H:i:s', strtotime($value['last_time_update'])) ?></b></i>
                                     </td>

                                 </tr>
                                 <?php $no++;
                                        endforeach;
                                    endif ?>
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

 <?php
    $no = 1;
    if ($rbbm != '') :
        foreach ($rbbm as $value) : ?>
 <justify>
     <div class="modal fade" id="modal_reject<?= $no ?>" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel">
         <div class="modal-dialog" role="document">
             <?= form_open('home/reject_riwayatbbm?id=' . $value['id_bbm']) ?>
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Yakin ingin menolak Data ini ?</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Alasan Penolakan</label>
                                 <input type="text" class="form-control" name="reason_reject"
                                     placeholder="Masukkan Alasan Penolakan"
                                     value="<?= isset($value) ? $value['reject_reason'] : ""; ?>" required>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer justify-content-between">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="sumbit" class="btn btn-primary">Simpan</button>

                 </div>
             </div>
             <?= form_close() ?>
         </div>
     </div>
     <div class="modal fade" id="strukModal<?php echo $no ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
                 </div>
                 <div class="modal-body">
                     <center>
                         <img src="<?= base_url('assets/upload/struk_bbm/' . $value['struk_bbm'] . '') ?>"
                             alt="Foto Struk BBM" class="img-responsive" width="70%" height="auto">
                     </center>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>
 </justify>
 <?php $no++;
        endforeach;
    endif ?>

 <div class="modal fade" id="modal-xl">
     <div class="modal-dialog modal-xl">
         <?php echo form_open_multipart(
                'home/prosestambahbbm?id=' . ($kend['idk']) . '',
                'class="form-horizontal"'
            ) ?>
         <?php echo form_hidden('id_kend', ($kend['idk']));
            echo form_hidden('tipe', ($kend['tipe']));
            echo form_hidden('no_pol', ($kend['no_polisi'])) ?>
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Form Riwayat BBM</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-md-6">
                         <div class="form-group">
                             <label>Tanggal</label>
                             <input type="text" class="form-control pilihtanggal" name="tgl_bbm"
                                 value="<?= date('d-m-Y') ?>" required>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="form-group">
                             <label>Total Biaya BBM</label>
                             <input type="number" class="form-control" name="harga_bbm" required
                                 placeholder="Masukkan Total Biaya BBM">
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="form-group">
                             <label>Struk BBM</label>
                             <input type="file" class="form-control" name="struk_bbm" accept="image/*" required>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="modal-footer justify-content-between">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="sumbit" class="btn btn-primary">Simpan</button>

             </div>
         </div>
         <?php echo form_close() ?>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>