 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <!-- <h1 class="m-0"> Data  Kendaraan Dinas <small>NAVARA</small></h1> -->
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
                                 <th>ID Aset</th>
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
                             Tambah Pengajuan Servis
                         </button>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%;">
                             <thead>
                                 <tr>
                                     <th class="text-center">No</th>
                                     <th class="text-center">Aksi</th>
                                     <th class="text-center">Tanggal Pengajuan</th>
                                     <th class="text-center">Bengkel Tujuan</th>
                                     <th class="text-center">Keluhan</th>
                                     <th class="text-center">Servis</th>
                                     <th class="text-center">Lain-Lain</th>
                                     <th class="text-center">Status Pengajuan</th>
                                     <th class="text-center">Update By</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if ($rp != '') {
                                        foreach ($rp as $value) { ?>
                                 <tr>
                                     <td class="text-center"><?= $no++; ?></td>
                                     <td class="text-center">
                                         <a onclick="deleteConfirm('<?= site_url('home/deletepengajuanservis?id=' . $value['id_pengajuan'] . '') ?>')"
                                             href="#" class="btn btn-sm btn-danger jedatombol"
                                             title="Delete Pengajuan Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fas fa-trash"></i></a>
                                         <a onclick="editConfirm('<?= site_url('home/editpengajuanservis?id=' . $value['id_pengajuan'] . '') ?>')"
                                             href="#" class="btn btn-sm btn-warning jedatombol"
                                             title="Edit Pengajuan Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fas fa-pencil"></i></a>
                                         <a onclick="cetakConfirm('<?= site_url('home/cetakpengajuanservis?id=' . $value['id_pengajuan'] . '') ?>')"
                                             href="#"
                                             class="btn btn-sm btn-primary jedatombol <?php if ($value['status_pengajuan'] == 'Wait' || $value['status_pengajuan'] == 'No') : ?> disabled <?php endif; ?>"
                                             title="Cetak Pengajuan Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa-solid fa-print"></i></a>
                                         <?php if ($value['status_pengajuan'] == 'No' || $value['status_pengajuan'] == 'Wait') : ?>
                                         <a href="#"
                                             onclick="approveConfirm('<?= site_url('home/approve_pengajuan?id=' . $value['id_pengajuan'] . '') ?>')"
                                             class="btn btn-sm btn-success jedatombol"
                                             title="Setujui Pengajuan Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                                             <i class="fa-solid fa-badge-check"></i></a>
                                         <a href="#"
                                             onclick="waitConfirm('<?= site_url('home/wait_pengajuan?id=' . $value['id_pengajuan'] . '') ?>')"
                                             class="btn btn-sm btn-dark jedatombol <?php if ($value['status_pengajuan'] == 'Wait') : ?> disabled <?php endif; ?>"
                                             title="Set Wait Pengajuan Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                                             <i class="fa-solid fa-circle-pause"></i></a>
                                         <?php else : ?>
                                         <a href="#"
                                             onclick="rejectConfirm('<?= site_url('home/reject_pengajuan?id=' . $value['id_pengajuan'] . '') ?>')"
                                             class="btn btn-sm btn-danger jedatombol"
                                             title="Tolak Pengajuan Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                                                 class="fa-solid fa-circle-xmark"></i></a>
                                         <a href="#"
                                             onclick="waitConfirm('<?= site_url('home/wait_pengajuan?id=' . $value['id_pengajuan'] . '') ?>')"
                                             class="btn btn-sm btn-dark jedatombol"
                                             title="Set Wait Pengajuan Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                                             <i class="fa-solid fa-circle-pause"></i></a>
                                         <?php endif; ?>
                                     </td>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pengajuan'])) ?>
                                     </td>
                                     <td class="text-center"><?= $value['bengkel_tujuan'] ?></td>
                                     <td class="text-center"><?php if ($value['keluhan'] == '') : ?> -
                                         <?php else : ?><?= $value['keluhan'] ?><?php endif ?></td>
                                     <td class="text-center"><?php if ($value['service'] == '') : ?> -
                                         <?php else : ?><?= $value['service'] ?><?php endif ?></td>
                                     <td class="text-center"><?php if ($value['lain_lain'] == '') : ?> -
                                         <?php else : ?><?= $value['lain_lain'] ?><?php endif ?>
                                     </td>
                                     <td class="text-center">
                                         <?php if ($value['status_pengajuan'] == 'No') : ?>
                                         Ditolak oleh <?= $value['name'] ?><br><i
                                             style="color:red;font-size:12px">Pemakai dapat melakukan
                                             pengajuan ulang</i>
                                         <?php elseif ($value['status_pengajuan'] == 'Yes') : ?>
                                         Disetujui oleh <?= $value['name'] ?>
                                         <?php else : ?>
                                         Perlu dicek <br><i style="color:red"
                                             class="fa-solid fa-triangle-exclamation"></i>
                                         <?php endif; ?>
                                     </td>
                                     <td class="text-center"><?php if ($value['name'] == '') : ?> -
                                         <?php else : ?><?= $value['name'] ?><?php endif; ?>
                                     </td>
                                 </tr>
                                 <?php }
                                    } ?>
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

 <div class="modal fade" id="modal-xl">
     <div class="modal-dialog modal-xl">
         <form method="post" action="<?= site_url('home/prosestambahpengajuanservis?id=' . $kend['idk'] . '') ?>"
             enctype="multipart/form-data">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title">Form Pengajuan Servis</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Nama Bengkel</label>
                                 <input type="text" placeholder="Masukkan Bengkel Tujuan" class="form-control"
                                     name="nama_bengkel">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Keluhan</label>
                                 <textarea type="text" placeholder="Masukkan Keluhan Kendaraan Yang Anda Gunakan"
                                     class="form-control" name="keluhan_kendaraan"></textarea>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Servis</label>
                                 <textarea type="text" placeholder="Masukkan Servis Kendaraan yang diinginkan"
                                     class="form-control" name="servis_kendaraan"></textarea>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Lain - Lain</label>
                                 <textarea type="text" placeholder="" class="form-control"
                                     name="lain_lain_kendaraan"></textarea>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer justify-content-between">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="sumbit" class="btn btn-primary">Simpan</button>

                 </div>
         </form>
     </div>
     <!-- /.modal-content -->
 </div>
 <!-- /.modal-dialog -->
 </div>