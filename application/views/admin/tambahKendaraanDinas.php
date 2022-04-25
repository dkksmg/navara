 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0"> <?= $title ?> <small>NAVARA</small></h1>
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
                     <div class="card-header" style="background-color:#ff7970;">
                         <h3 style="font-weight:bold;"><?= $title ?> </h3>
                     </div>
                     <?php form_open('home/tambahKendaraanDinas', 'id="formpertanyaan"') ?>
                     <form method="post" id="formpertanyaan">
                         <div class="card-body">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>ID ASSETS</label>
                                         <input type="text" class="form-control" name="id_aset"
                                             value="<?= isset($kend) ? $kend['id_assets'] : id_aset() ?>" disabled
                                             readonly>
                                     </div>
                                 </div>
                                 <?php if (isset($kend)) { ?>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Nomor Polisi</label>
                                         <input type="text" class="form-control" name="nopol"
                                             value="<?= isset($kend) ? $kend['no_polisi'] : ""; ?>" required>
                                     </div>
                                 </div>
                                 <?php } else { ?>
                                 <div class="col-md-2">
                                     <div class="form-group">
                                         <label>Huruf Awal No. Polisi</label>
                                         <input type="text" class="form-control" name="nopolawaal" required
                                             placeholder="H">
                                     </div>
                                 </div>
                                 <div class="col-md-2">
                                     <div class="form-group">
                                         <label>Angka </label>
                                         <input type="text" class="form-control" name="nopolangka" required
                                             placeholder="1234">
                                     </div>
                                 </div>
                                 <div class="col-md-2">
                                     <div class="form-group">
                                         <label>Huruf Akhir No. Polisi</label>
                                         <input type="text" class="form-control" name="nopolakhir" required
                                             placeholder="HH">
                                     </div>
                                 </div>
                                 <?php } ?>

                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Merk</label>
                                         <input type="text" class="form-control" name="merk"
                                             value="<?= isset($kend) ? $kend['merk'] : ""; ?>" required>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Jenis</label>
                                         <select class="form-control" name="jeniskendaraan">
                                             <option
                                                 <?= isset($kend) && $kend['jenis'] == 'Sedan' ? "selected" : ""; ?>>
                                                 Sedan</option>
                                             <option <?= isset($kend) && $kend['jenis'] == 'SUV' ? "selected" : ""; ?>>
                                                 SUV</option>
                                             <option <?= isset($kend) && $kend['jenis'] == 'MPV' ? "selected" : ""; ?>>
                                                 MPV</option>
                                             <option
                                                 <?= isset($kend) && $kend['jenis'] == 'Ambulan' ? "selected" : ""; ?>>
                                                 Ambulan</option>
                                             <option
                                                 <?= isset($kend) && $kend['jenis'] == 'Sepeda Motor' ? "selected" : ""; ?>>
                                                 Sepeda Motor</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                         <label>Tipe (Avanza, Vario, Supra, Dll...)</label>
                                         <input type="text" class="form-control" name="tipe"
                                             value="<?= isset($kend) ? $kend['tipe'] : ""; ?>" required>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>No. STNK</label>
                                         <input type="text" class="form-control" name="nostnk"
                                             value="<?= isset($kend) ? $kend['no_stnk'] : ""; ?>">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Masa Berlaku STNK</label>
                                         <input type="text" class="form-control pilihtanggal" name="tgl_stnk"
                                             value="<?= isset($kend) ? date('d-m-Y', strtotime($kend['masa_berlaku_stnk'])) : ""; ?>">
                                     </div>
                                 </div>

                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>No. Mesin</label>
                                         <input type="text" class="form-control" name="nomesin"
                                             value="<?= isset($kend) ? $kend['no_mesin'] : ""; ?>">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>No. Rangka</label>
                                         <input type="text" class="form-control" name="norangka"
                                             value="<?= isset($kend) ? $kend['no_rangka'] : ""; ?>">
                                     </div>
                                 </div>

                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Jenis Bahan Bakar</label>
                                         <select class="form-control" name="jenisbb">
                                             <option
                                                 <?= isset($kend) && $kend['jenis_bb'] == 'Bensin' ? "selected" : ""; ?>>
                                                 Bensin</option>
                                             <option
                                                 <?= isset($kend) && $kend['jenis_bb'] == 'Solar' ? "selected" : ""; ?>>
                                                 Solar</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Besar CC</label>
                                         <input type="text" class="form-control" name="besarcc"
                                             value="<?= isset($kend) ? $kend['besar_cc'] : ""; ?>">
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                         <label>Tahun Motor</label>
                                         <input type="text" class="form-control" name="tahunperolehan"
                                             value="<?= isset($kend) ? $kend['tahun_perolehan'] : ""; ?>">
                                     </div>
                                 </div>
                             </div>

                         </div>
                         <div class="card-footer">
                             <button type="sumbit"
                                 class="btn btn-primary"><?= isset($kend) ? 'Edit' : 'Tambah'; ?></button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>

     </div>
     <!-- /.row -->
 </div><!-- /.container-fluid -->
 </div>