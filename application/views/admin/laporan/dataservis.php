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
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-header">
                         <form>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Tahun</label>
                                         <?php
                                            $year_start  = 2000;
                                            $year_end = date('Y') + 10;
                                            $user_selected_year = date('Y');

                                            echo '<select id="year" required class="form-control" name="tahun" required>' . "\n";
                                            for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                                $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                                echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                            }
                                            echo '</select>' . "\n";
                                            ?>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-3">
                                     <button class="btn btn-sm btn-info">Cari</button>
                                 </div>
                             </div>
                         </form>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%">
                             <thead>
                                 <tr>
                                     <th class="text-center">No</th>
                                     <th class="text-center">Jenis Kendaraan</th>
                                     <th class="text-center">Merk</th>
                                     <th class="text-center">No Polisi</th>
                                     <th class="text-center">Pemakai</th>
                                     <th class="text-center">Pagu</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if (isset($rekap) && $rekap != '') {
                                        foreach ($rekap as $key => $value) { ?>
                                 <tr>
                                     <td class="text-center"><?= $no++; ?></td>
                                     <td class="text-center"><?= strtoupper($value['jenis']) ?></td>
                                     <td class="text-center"><?= strtoupper($value['merk']) ?></td>
                                     <td class="text-center"><?= strtoupper($value['no_polisi']) ?></td>
                                     <td class="text-center"><?php if ($value['name'] == null) : ?> -
                                         <?php else : ?><?= $value['name'] ?><?php endif ?></td>
                                     <td class="text-center">Rp.
                                         <?= number_format((float)$value['pagu_awal'], 2, ',', '.')  ?>
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