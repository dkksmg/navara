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
                                 <th>ID ASSETS</th>
                                 <th>:</th>
                                 <th><?= $kend['id_assets'] ?></th>
                             </tr>
                             <tr>
                                 <th>No. Polisi</th>
                                 <th>:</th>
                                 <th><?= $kend['no_polisi'] ?></th>
                             </tr>
                             <tr>
                                 <th>Jenis</th>
                                 <th>:</th>
                                 <th><?= $kend['jenis'] ?></th>
                             </tr>
                             <tr>
                                 <th>Merk</th>
                                 <th>:</th>
                                 <th><?= $kend['merk'] ?></th>
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
                         <form>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Periode Bulan :</label>
                                         <?php
                                            $options = array(
                                                '' => '- Pilih -',
                                                '1' => 'Januari',
                                                '2' => 'Februari',
                                                '3' => 'Maret',
                                                '4' => 'April',
                                                '5' => 'Mei',
                                                '6' => 'Juni',
                                                '7' => 'Juli',
                                                '8' => 'Agustus',
                                                '9' => 'September',
                                                '10' => 'Oktober',
                                                '11' => 'November',
                                                '12' => 'Desember',
                                            );
                                            echo form_dropdown(
                                                'bulan_pilihan',
                                                $options,
                                                set_value($this->input->get('bulan_pilihan')),
                                                "class='form-control' required"
                                            ); ?>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Tahun : </label>
                                         <?php
                                            $year_start  = 2000;
                                            $year_end = date('Y') + 20;
                                            $user_selected_year = date('Y');

                                            echo '<select id="year" required class="form-control" name="tahun_pilihan">' . "\n";
                                            for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                                $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                                echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                            }
                                            echo '</select>' . "\n";
                                            ?>
                                     </div>
                                 </div>
                                 <?php echo form_hidden('id', $kend['idk']) ?>
                             </div>
                             <div class="row">
                                 <div class="col-md-3">
                                     <button class="btn btn-sm btn-info">Cari</button>
                                 </div>
                             </div>
                         </form>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%" height="auto">
                             <thead>
                                 <tr>
                                     <th class="text-center">No</th>
                                     <th class="text-center">Tgl Service</th>
                                     <th class="text-center">Bengkel Service</th>
                                     <th class="text-center">Keluhan</th>
                                     <th class="text-center">Perbaikan</th>
                                     <th class="text-center" width="10%">Total Biaya</th>
                                     <th class="text-center">Foto Service</th>
                                     <th class="text-center">Foto Nota</th>
                                 </tr>
                             </thead>
                             <tbody>

                                 <?php
                                    if (isset($rs) && $rs != '') :
                                        $no = 1;
                                        foreach ($rs as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= $no; ?></td>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_servis'])) ?></td>
                                     <td class="text-center"><?= $value['lokasi'] ?></td>
                                     <td><?= $value['keluhan'] ?></td>
                                     <td><?= $value['perbaikan'] ?></td>
                                     <td class="text-left">
                                         <?= $value['total_biaya']; ?></td>
                                     <td class="text-center">
                                         <img width="40%"
                                             src="<?= base_url('assets/upload/foto_servis/' . $value['foto_servis'] . '') ?>"
                                             data-toggle="modal" data-target="#servisModal<?php echo $no ?>">
                                     </td>
                                     <td class="text-center"><img width="40%"
                                             src="<?= base_url('assets/upload/foto_nota/' . $value['foto_nota'] . '') ?>"
                                             data-toggle="modal" data-target="#notaModal<?php echo $no ?>">
                                     </td>
                                 </tr>
                                 <?php $no++;
                                        endforeach;
                                    endif
                                    ?>
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

 <!-- Modal Foto Servis & Nota -->
 <?php
    if (isset($rs) && $rs != '') :
        $no = 1;
        foreach ($rs as $value) : ?>
 <center>
     <div class="modal fade" id="notaModal<?php echo $no ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
                 </div>
                 <div class="modal-body">
                     <center>
                         <img src="<?= base_url('assets/upload/foto_nota/' . $value['foto_nota'] . '') ?>"
                             alt="Foto Servis" class="img-responsive" width="70%" height="auto">
                     </center>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>
     <div class="modal fade" id="servisModal<?php echo $no ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
                 </div>
                 <div class="modal-body">
                     <center>
                         <img src="<?= base_url('assets/upload/foto_servis/' . $value['foto_servis'] . '') ?>"
                             alt="Foto Nota" class="img-responsive" width="70%" height="auto">
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