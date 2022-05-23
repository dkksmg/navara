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
                         <h3 style="font-weight:bold;color:white;">Riwayat Pemakai</h3>
                     </div>
                     <div class="card-header">
                         <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                             data-target="#modal-xl">
                             Tambah Pemakai
                         </button>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%">
                             <thead>
                                 <tr>
                                     <th class="text-center">No</th>
                                     <th class="text-center" width="10%">Aksi</th>
                                     <th class="text-center">Nama Pemakai</th>
                                     <th class="text-center">NIP</th>
                                     <th class="text-center">Lokasi Unit</th>
                                     <th class="text-center">Status</th>
                                     <th class="text-center">Tanggal Awal</th>
                                     <th class="text-center">Tanggal Akhir</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php if ($rp != '') : ?>
                                 <?php $no = 1;
                                        foreach ($rp as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= $no ?></td>
                                     <td class="text-center">
                                         <?php if ($value['status'] == 'aktif') : ?>
                                         <a href="<?= site_url('home/nonaktifkanpemakai?id=' . $value['id_rp'] . '') ?>"
                                             class="btn btn-sm btn-secondary jedatombol"><i
                                                 class="fa-solid fa-octagon-xmark"
                                                 title="Nonaktifkan Pemakai <?= $value['name'] ?>"></i></a>
                                         <?php else : ?>
                                         <a href="<?= site_url('home/aktifkanpemakai?id=' . $value['id_rp'] . '') ?>"
                                             class="btn btn-sm btn-success jedatombol"><i
                                                 class="fa-solid fa-badge-check"
                                                 title="Aktifkan Pemakai <?= $value['name'] ?>"></i></a>
                                         <?php endif ?>
                                         <a onclick="editConfirm('<?= site_url('home/edit_pemakai?id=' . $value['id_rp'] . '') ?>')"
                                             href="#" class="btn btn-sm btn-warning jedatombol"><i class="fas fa-pen"
                                                 title="Edit Data Pemakai <?= $value['name'] ?>"></i></a>
                                     </td>
                                     <td class="text-center"><?= $value['name'] ?></td>
                                     <td class="text-center"><?= $value['nip_user'] ?></td>
                                     <td class="text-center"><?= $value['lokasi_unit'] ?></td>
                                     <td class="text-center"><?php if ($value['status'] == "tidak_aktif") : ?>
                                         Tidak Aktif
                                         <?php else : ?>
                                         Aktif
                                         <?php endif ?>
                                     </td>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_awal'])) ?></td>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_akhir'])) ?></td>
                                 </tr>
                                 <?php $no++;
                                        endforeach   ?>
                                 <?php endif ?>
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
         <form method="post" action="<?= site_url('home/prosestambahPemakai?id=' . $kend['idk'] . '') ?>"
             enctype="multipart/form-data">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title">Form Riwayat Pemakai</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Nama Pemakai</label>
                                 <select class="form-control" name="nama" required>
                                     <option value="">- Pilih Nama -</option>
                                     <?php foreach ($pemakai as $p) : ?>
                                     <option value="<?= $p['id'] ?>"><?= $p['name'] ?> - <?= $p['nip_user'] ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                         </div>
                         <!-- <div class="col-md-6">
                             <div class="form-group">
                                 <label>NIP / NIK</label>
                                 <input type="number" class="form-control" name="nip" required>
                             </div>
                         </div> -->
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Lokasi Unit</label>
                                 <select class="form-control" name="lokunit">
                                     <option readonly>-- Pilih Lokasi Unit --</option>
                                     <?php if ($lu != '') {
                                            foreach ($lu as $value) { ?>
                                     <option><?= $value['lokasi_unit'] ?></option>
                                     <?php }
                                        } ?>
                                 </select>
                             </div>
                         </div>
                     </div>
                     <!-- <div class="row">
                     </div> -->
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Tanggal Awal</label>
                                 <input type="text" class="form-control pilihtanggal" name="dari" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Tanggal Akhir</label>
                                 <input type="text" class="form-control pilihtanggal" name="sampai">
                                 <p style="color:red;">* kosongkan jika tanggal akhir belum ada</p>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer justify-content-between">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="sumbit" class="btn btn-primary">Simpan</button>
                 </div>
             </div>
         </form>
     </div>
     <!-- /.modal-content -->
 </div>
 <!-- /.modal-dialog -->
 </div>