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
                                 <th><?php if ($kend['besar_cc'] == '') :  ?> -
                                     <?php else : ?><?= strtoupper($kend['besar_cc']) ?> CC <?php endif ?></th>
                             </tr>
                             <tr>
                                 <th>Bahan Bakar</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis_bb']) ?></th>
                             </tr>
                             <tr>
                                 <th>Pagu Kendaraan Tahun <?= date('Y') ?></th>
                                 <th>:</th>
                                 <th>Rp. <?= number_format($kend['pagu_awal'], 2, ',', '.') ?></th>
                             </tr>
                             <?php
                                $terpakai = $kend['total_biaya_pajak'] + $kend['total_biaya_servis'] + $kend['total_biaya_bbm'];
                                $sisa = $kend['pagu_awal'] - $terpakai; ?>
                             <tr>
                                 <th>Pagu Terpakai</th>
                                 <th>:</th>
                                 <th>Rp. <?= number_format($terpakai, 2, ',', '.') ?></th>
                             </tr>
                             <tr>
                                 <th>Sisa Pagu</th>
                                 <th>:</th>
                                 <th>Rp. <?= number_format($sisa, 2, ',', '.') ?></th>
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
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if ($rbbm != '') :
                                        foreach ($rbbm as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= $no; ?></td>
                                     <td class="text-center">
                                         <?php if ($value['status_rbm'] == 'Wait') : ?>
                                         <a onclick="editConfirm('#')" href="#"
                                             class="btn btn-sm btn-warning jedatombol disabled"><i class="fas fa-pen"
                                                 title="Edit Riwayat BBM <?= $kend['no_polisi'] ?>"></i></a>
                                         <?php elseif ($value['status_rbm'] == 'Yes') : ?>
                                         <a onclick="editConfirm('#')" href="#"
                                             class="btn btn-sm btn-warning jedatombol disabled"><i class="fas fa-pen"
                                                 title="Edit Riwayat BBM <?= $kend['no_polisi'] ?>"></i></a>
                                         <?php else : ?>
                                         <a style="display: none" onclick="deleteConfirm('#')" href="#"
                                             class="btn btn-sm btn-danger jedatombol disabled"><i class="fas fa-trash"
                                                 title="Hapus Riwayat BBM <?= $kend['no_polisi'] ?>"></i></a>
                                         <a onclick="editConfirm('<?= site_url('pemakai/editrbbm?id=' . ($value['id_bbm']) . '&idkend=' . ($value['id_kendaraan'])) ?>')"
                                             href="#" class="btn btn-warning btn-sm jedatombol"
                                             title="Edit Riwayat BBM <?= $kend['no_polisi'] ?>"><i
                                                 class="fas fa-pen"></i></a>
                                         <?php endif ?>
                                     </td>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pencatatan'])); ?>
                                     </td>
                                     <td class="text-center">
                                         <?= "Rp. " . number_format($value['total_bbm'], 2, ',', '.'); ?>
                                     </td>
                                     <td class="text-center"><img
                                             src="<?= base_url('assets/upload/struk_bbm/' . $value['struk_bbm'] . '') ?>"
                                             alt="Foto Struk BBM" data-toggle="modal" width="30%"
                                             data-target="#strukModal<?php echo $no ?>">
                                     </td>
                                     <td class="text-center" width="20%">
                                         <?php if ($value['status_rbm'] == 'Wait') : ?>
                                         <p>Sedang Diverifikasi</p>
                                         <?php elseif ($value['status_rbm'] == 'No') : ?>
                                         Ditolak<br><i style="color:red;font-size:12px">
                                             <?= $value['reject_reason'] ?>.
                                             Silakan melakukan input/edit data kembali.<br>Reject on
                                             <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                                         <?php else : ?>
                                         Disetujui
                                         <br><i style="color:green;font-size:12px">Approved on
                                             <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                                         <?php endif ?>
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
 <center>
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
 </center>
 <?php $no++;
        endforeach;
    endif ?>

 <div class="modal fade" id="modal-xl">
     <div class="modal-dialog modal-xl">
         <?php echo form_open_multipart(
                'pemakai/prosestambahbbm?id=' . ($kend['idk']) . '',
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
             <?php form_close() ?>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>