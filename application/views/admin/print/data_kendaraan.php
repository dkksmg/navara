 <!-- Main content -->
 <div class="content">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card" style="width: 100%;">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-body">
                         <table class="table table-striped">
                             <tr>
                                 <th width="20%">ID Aset</th>
                                 <th width="10%">:</th>
                                 <th><?= $kend['id_assets'] ?></th>
                             </tr>
                             <tr>
                                 <th width="20%">No. Polisi</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['no_polisi']) ?></th>
                             </tr>
                             <tr>
                                 <th width="20%">Jenis</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis']) ?></th>
                             </tr>
                             <tr>
                                 <th width="20%">Merk</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['merk']) ?></th>
                             </tr>
                             <tr>
                                 <th width="20%">No STNK</th>
                                 <th>:</th>
                                 <th>
                                     <?php if (empty($kend['no_stnk'])) : ?>
                                     <?= strtoupper($kend['no_stnk']) ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Data masih kosong. Harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= strtoupper($kend['no_stnk']) ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                             <tr>
                                 <th width="20%">No Mesin</th>
                                 <th>:</th>
                                 <th>
                                     <?php if (empty($kend['no_mesin'])) : ?>
                                     <?= strtoupper($kend['no_mesin']) ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Data masih kosong. Harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= strtoupper($kend['no_mesin']) ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                             <tr>
                                 <th width="20%">No Rangka</th>
                                 <th>:</th>
                                 <th>
                                     <?php if (empty($kend['no_rangka'])) : ?>
                                     <?= strtoupper($kend['no_rangka']) ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Data masih kosong. Harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= strtoupper($kend['no_rangka']) ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                             <tr>
                                 <th width="20%">Tahun</th>
                                 <th>:</th>
                                 <th>
                                     <?php if (empty($kend['tahun_perolehan'])) : ?>
                                     <?= $kend['tahun_perolehan'] ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Data masih kosong. Harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= $kend['tahun_perolehan']; ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                             <tr>
                                 <th width="20%">Bahan Bakar</th>
                                 <th>:</th>
                                 <th>
                                     <?php if (empty($kend['jenis_bb'])) : ?>
                                     <?= strtoupper($kend['jenis_bb']) ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Data masih kosong. Harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= strtoupper($kend['jenis_bb']) ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                             <tr>
                                 <th width="20%">CC</th>
                                 <th>:</th>
                                 <th>
                                     <?php if (empty($kend['besar_cc'])) : ?>
                                     <?= $kend['besar_cc'] ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Data masih kosong. Harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= $kend['besar_cc'] ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                             <tr>
                                 <th width="20%">Masa Berlaku STNK</th>
                                 <th>:</th>
                                 <th>
                                     <?php if ($kend['masa_berlaku_stnk'] == '1970-01-01') : ?>
                                     <?= date('d-m-Y', strtotime($kend['masa_berlaku_stnk'])) ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Masa Berlaku STNK harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= date('d-m-Y', strtotime($kend['masa_berlaku_stnk'])) ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                             <tr>
                                 <th width="20%">Pemakai Sekarang</th>
                                 <th>:</th>
                                 <th>
                                     <?php if (empty($kend['nama_pemakai'])) : ?>
                                     <?= strtoupper($kend['nama_pemakai']) ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Data masih kosong. Harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= strtoupper($kend['nama_pemakai']) ?>
                                     <?php if (!empty($kend['nip_pemakai'])) : ?>
                                     (<?= $kend['nip_pemakai'] ?>)
                                     <?php endif; ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                             <tr>
                                 <th width="20%">Lokasi Unit Kendaraan</th>
                                 <th>:</th>
                                 <th>
                                     <?php if (empty($kend['lokasi_unit'])) : ?>
                                     <?= strtoupper($kend['lokasi_unit']) ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Data masih kosong. Harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= strtoupper($kend['lokasi_unit']) ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                             <tr>
                                 <th width="20%">Durasi Penggunaan</th>
                                 <th>:</th>
                                 <th>
                                     <?php if ($kend['tgl_awal'] == '1970-01-01' && $kend['tgl_akhir'] == '1970-01-01' || $kend['tgl_awal'] == '' && $kend['tgl_akhir'] == '') : ?>
                                     <?= date('d-m-Y', strtotime($kend['tgl_awal'])) ?> sampai
                                     <?= date('d-m-Y', strtotime($kend['tgl_akhir'])) ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Tanggal penggunaan awal &
                                         akhir harap segera di perbarui
                                     </span>
                                     <?php elseif ($kend['tgl_akhir'] == '1970-01-01') : ?>
                                     <?= date('d-m-Y', strtotime($kend['tgl_awal'])) ?> sampai
                                     <?= date('d-m-Y', strtotime($kend['tgl_akhir'])) ?>
                                     <span
                                         style="font-size:12px;font-style:italic;color:red; font-family:Arial;align-items:right">
                                         Tanggal penggunaan
                                         akhir harap segera di perbarui
                                     </span>
                                     <?php else : ?>
                                     <?= date('d-m-Y', strtotime($kend['tgl_awal'])) ?> sampai
                                     <?= date('d-m-Y', strtotime($kend['tgl_akhir'])) ?>
                                     <?php endif; ?>
                                 </th>
                             </tr>
                         </table>
                     </div>
                 </div>
             </div>
             <!-- <div class="col-lg-12">
                 <div class="card" style="width: 100%;">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Pagu Tahunan Kendaraan Dinas</h3>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped">
                             <thead>
                                 <tr>
                                     <th class="text-center">Tahun</th>
                                     <th class="text-center">Jenis Pagu</th>
                                     <th class="text-center">Total Awal</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if ($pajak != '') :
                                        foreach ($pajak as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pencatatan'])); ?>
                                     </td>
                                     <td class="text-center"><?= $value['tahun'] ?></td>
                                     <td class="text-center">Rp.
                                         <?= number_format($value['total_pajak'], 2, ',', '.'); ?>
                                     </td>
                                 </tr>
                                 <?php
                                        endforeach;
                                    endif ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div> -->
             <div class="col-lg-12">
                 <div class="card" style="width: 100%;">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Riwayat Pajak Kendaraan Dinas</h3>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped">
                             <thead>
                                 <tr>
                                     <th class="text-center">Tanggal Pencatatan</th>
                                     <th class="text-center">Tahun Pajak</th>
                                     <th class="text-center">Total Pajak</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if ($pajak != '') :
                                        foreach ($pajak as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pencatatan'])); ?>
                                     </td>
                                     <td class="text-center"><?= $value['tahun'] ?></td>
                                     <td class="text-center">Rp.
                                         <?= number_format($value['total_pajak'], 2, ',', '.'); ?>
                                     </td>
                                 </tr>
                                 <?php
                                        endforeach;
                                    endif ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-12">
                 <div class="card" style="width: 100%;">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Riwayat BBM Kendaraan Dinas</h3>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped">
                             <thead>
                                 <tr>
                                     <th class="text-center">Tanggal Pencatatan</th>
                                     <th class="text-center">Total BBM</th>
                                     <th class="text-center">Struk BBM</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if ($bbm != '') :
                                        foreach ($bbm as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pencatatan'])); ?>
                                     </td>
                                     <td class="text-center">Rp. <?= number_format($value['total_bbm'], 2, ',', '.'); ?>
                                     </td>
                                     <td class="text-center"><img width="30%" height="auto"
                                             src="<?= base_url('assets/upload/struk_bbm/' . $value['struk_bbm'] . '') ?>">
                                     </td>
                                 </tr>
                                 <?php
                                        endforeach;
                                    endif ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-12">
                 <div class="card" style="width: 100%;">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Riwayat Kondisi Kendaraan Dinas</h3>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped">
                             <thead>
                                 <tr>
                                     <th class="text-center">Tanggal Pencatatan</th>
                                     <th class="text-center">Kondisi</th>
                                     <th class="text-center">Foto Tampak Depan</th>
                                     <th class="text-center">Foto Tampak Kanan</th>
                                     <th class="text-center">Foto Tampak Kiri</th>
                                     <th class="text-center">Foto Tampak Belakang</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if ($kondisi != '') :
                                        foreach ($kondisi as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pencatatan'])); ?>
                                     </td>
                                     <td class="text-center"><?= $value['kondisi'] ?></td>
                                     <td class="text-center"><img width="70%" height="auto"
                                             src="<?= base_url('assets/upload/file_kendaraan/depan/' . $value['foto_tampak_depan'] . '') ?>">
                                     </td>
                                     <td class="text-center"><img width="70%" height="auto"
                                             src="<?= base_url('assets/upload/file_kendaraan/kanan/' . $value['foto_tampak_kanan'] . '') ?>">
                                     </td>
                                     <td class="text-center"><img width="70%" height="auto"
                                             src="<?= base_url('assets/upload/file_kendaraan/kiri/' . $value['foto_tampak_kiri'] . '') ?>">
                                     </td>
                                     <td class="text-center"><img width="70%" height="auto"
                                             src="<?= base_url('assets/upload/file_kendaraan/belakang/' . $value['foto_tampak_belakang'] . '') ?>">
                                     </td>
                                 </tr>
                                 <?php
                                        endforeach;
                                    endif ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-12">
                 <div class="card" style="width: 100%;">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Riwayat Servis Kendaraan Dinas</h3>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped">
                             <thead>
                                 <tr>
                                     <th class="text-center">Tanggal Servis</th>
                                     <th class="text-center">Bengkel</th>
                                     <th class="text-center">Keluhan</th>
                                     <th class="text-center">Perbaikan</th>
                                     <th class="text-center" width="10%">Total Biaya Servis</th>
                                     <th class="text-center">Foto Nota</th>
                                     <th class="text-center">Foto Servis</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if ($servis != '') :
                                        foreach ($servis as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_servis'])); ?>
                                     </td>
                                     <td class="text-center"><?= $value['lokasi'] ?></td>
                                     <td class="text-center"><?= $value['keluhan'] ?></td>
                                     <td class="text-center"><?= $value['perbaikan'] ?></td>
                                     <td class="text-center">Rp.
                                         <?= number_format($value['total_biaya'], 2, ',', '.'); ?></td>
                                     <td class="text-center"><img width="100%" height="auto"
                                             src="<?= base_url('assets/upload/foto_nota/' . $value['foto_nota'] . '') ?>">
                                     </td>
                                     <td class="text-center"><img width="100%" height="auto"
                                             src="<?= base_url('assets/upload/foto_servis/' . $value['foto_servis'] . '') ?>">
                                     </td>

                                 </tr>
                                 <?php
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



 </div>