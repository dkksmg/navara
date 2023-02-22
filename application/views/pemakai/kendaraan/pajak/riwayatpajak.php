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
                 <th width="30%">ID Aset</th>
                 <th>:</th>
                 <th colspan="4"><?= $kend['id_assets'] ?></th>
               </tr>
               <tr>
                 <th>No. Polisi</th>
                 <th>:</th>
                 <th><?= strtoupper($kend['no_polisi']) ?></th>
               </tr>
               <tr>
                 <th>Jenis</th>
                 <th>:</th>
                 <th colspan="4"><?= strtoupper($kend['jenis']) ?></th>
               </tr>
               <tr>
                 <th>Merk</th>
                 <th>:</th>
                 <th><?= strtoupper($kend['merk']) ?></th>
               </tr>
               <tr>
                 <th>Tipe</th>
                 <th>:</th>
                 <th colspan="4"><?= strtoupper($kend['tipe']) ?></th>
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
                 <th colspan="4"><?= strtoupper($kend['jenis_bb']) ?></th>
               </tr>
               <tr>
                 <th>Pagu Kendaraan Tahun <?= date('Y') ?></th>
                 <th>:</th>
                 <th>Rp. <?= number_format($kend2['pagu_awal'], 2, ',', '.') ?></th>

                 <th>Pagu Kendaraan Tahun <?= date('Y')-1 ?></th>
                 <th>:</th>
                 <th>Rp. <?= number_format($kend3['pagu_awal'], 2, ',', '.') ?></th>
               </tr>
               <?php
                                $terpakai = $kend2['total_biaya_pajak'] + $kend2['total_biaya_servis'] + $kend2['total_biaya_bbm'];
                                $sisa = $kend2['pagu_awal'] - $terpakai;

                                $terpakai2 = $kend3['total_biaya_pajak'] + $kend3['total_biaya_servis'] + $kend3['total_biaya_bbm'];
                                $sisa2 = $kend3['pagu_awal'] - $terpakai3; ?>
               <tr>
                 <th>Pagu Terpakai</th>
                 <th>:</th>
                 <th>Rp. <?= number_format($terpakai, 2, ',', '.') ?></th>

                 <th>Pagu Terpakai</th>
                 <th>:</th>
                 <th>Rp. <?= number_format($terpakai2, 2, ',', '.') ?></th>
               </tr>
               <tr>
                 <th>Sisa Pagu</th>
                 <th>:</th>
                 <th>Rp. <?= number_format($sisa, 2, ',', '.') ?></th>

                 <th>Sisa Pagu</th>
                 <th>:</th>
                 <th>Rp. <?= number_format($sisa2, 2, ',', '.') ?></th>
               </tr>
             </table>
           </div>
         </div>
       </div>
       <?= $this->load->view('pemakai/template/menu_layout_pemakai', '', TRUE); ?>

       <div class="col-lg-12">
         <div class="card">
           <div class="card-header" style="background-color:#4a2f3a;">
             <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
           </div>
           <div class="card-header">
             <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-xl">
               Tambah Riwayat Pajak
             </button>
           </div>
           <div class="card-body">
             <table class="table table-bordered table-striped example" width="100%;">
               <thead>
                 <tr>
                   <th class="text-center">No</th>
                   <th class="text-center">Aksi</th>
                   <th class="text-center">Tanggal Pencatatan</th>
                   <th class="text-center">Tahun</th>
                   <th class="text-center">Total Pajak</th>
                   <th class="text-center">Status</th>
                 </tr>
               </thead>
               <tbody>
                 <?php $no = 1;
                                    if ($rp != '') {
                                        foreach ($rp as $value) { ?>
                 <tr>
                   <td class="text-center"><?= $no++; ?></td>
                   <td class="text-center">
                     <?php if ($value['status_pjk'] == 'Wait') : ?>
                     <a onclick="editConfirm('#')" href="#" class="btn btn-sm btn-warning jedatombol disabled"><i
                         class="fas fa-pen" title="Edit Riwayat Pajak <?= $kend['no_polisi'] ?>"></i></a>
                     <?php elseif ($value['status_pjk'] == 'Yes') : ?>
                     <a onclick="editConfirm('#')" href="#" class="btn btn-sm btn-warning jedatombol disabled"><i
                         class="fas fa-pen" title="Edit Riwayat Pajak <?= $kend['no_polisi'] ?>"></i></a>
                     <?php else : ?>
                     <a style="display: none" onclick="deleteConfirm('#')" href="#"
                       class="btn btn-sm btn-danger jedatombol disabled"><i class="fas fa-trash"
                         title="Hapus Riwayat Pajak <?= $kend['no_polisi'] ?>"></i></a>
                     <a onclick="editConfirm('<?= site_url('pemakai/editriwayatpajak?id=' . $value['id_pjk'] . '&idkend=' . ($value['id_kendaraan'])) ?>')"
                       href="#" class="btn btn-warning btn-sm jedatombol"
                       title="Edit Riwayat Pajak <?= $kend['no_polisi'] ?>"><i class="fas fa-pen"></i></a>
                     <?php endif ?>
                   </td>
                   <td class="text-center"><?= $value['tgl_pencatatan'] ?></td>
                   <!-- <td class="text-center"><?//= date('Y',strtotime($value['tgl_pencatatan'])) ?></td> -->
                   <td class="text-center"><?= $value['tahun'] ?></td>

                   <td class="text-center">
                     <?= "Rp. " . number_format($value['total_pajak'], 2, ',', '.'); ?>
                   </td>
                   <td class="text-center" width="20%">
                     <?php if ($value['status_pjk'] == 'Wait') : ?>
                     <p>Sedang Diverifikasi</p>
                     <?php elseif ($value['status_pjk'] == 'No') : ?>
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
     <form method="post" action="<?= site_url('pemakai/prosestambahpajak?id=' . $kend['idk'] . '') ?>"
       enctype="multipart/form-data">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Form Riwayat Pajak</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Tahun</label>
                 <?php
                                    $year_start  = 2000;
                                    $year_end = date('Y') + 20;
                                    $user_selected_year = date('Y');

                                    echo '<select id="year" required class="form-control" name="tahun_pajak">' . "\n";
                                    for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                        $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                        echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                    }
                                    echo '</select>' . "\n";
                                    ?>
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Total Pajak</label>
                 <input type="number" placeholder="Masukkan Total Pajak" class="form-control" name="total_pajak">
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