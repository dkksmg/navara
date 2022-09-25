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
                      $year_start  = 2020;
                      $year_end = date('Y') + 5;
                      $user_selected_year = date('Y');

                      echo '<select id="year" required class="form-control" name="tahun" required>' . "\n";
                      for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                        $selected = (($user_selected_year == set_value('tahun') || $user_selected_year == $i_year) ? 'selected' : '');
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
             <br>
             <div class="row">
               <div class="col-md-3">
                 <?php
                  $tahun = $this->input->get('tahun');
                  if (isset($rekap) && $rekap != '') : ?>
                 <a href="<?= site_url('laporan/export_excel?tahun=' . $tahun) ?>" class="btn btn-sm btn-warning"><i
                     class="fa-solid fa-file-excel"></i>
                   Export
                   Excel</a>

                 <?php endif; ?>
               </div>
             </div>
           </div>
           <div class="card-body">
             <div class="table-responsive">
               <table class="table table-bordered table-striped example" width="100%">
                 <thead>
                   <tr>
                     <th class="text-center" rowspan="2">No</th>
                     <th class="text-center" rowspan="2">Jenis Kendaraan</th>
                     <th class="text-center" rowspan="2">Merk</th>
                     <th class="text-center" rowspan="2">Tipe</th>
                     <th class="text-center" rowspan="2">No Polisi</th>
                     <th class="text-center" rowspan="2" width="25%">Pemakai</th>
                     <th class="text-center" rowspan="2" width="15%">Pagu</th>
                     <th class="text-center" colspan="5">Januari</th>
                     <th class="text-center" colspan="5">Februari</th>
                     <th class="text-center" colspan="5">Maret</th>
                     <th class="text-center" colspan="5">April</th>
                     <th class="text-center" colspan="5">Mei</th>
                     <th class="text-center" colspan="5">Juni</th>
                     <th class="text-center" colspan="5">Juli</th>
                     <th class="text-center" colspan="5">Agustus</th>
                     <th class="text-center" colspan="5">September</th>
                     <th class="text-center" colspan="5">Oktober</th>
                     <th class="text-center" colspan="5">November</th>
                     <th class="text-center" colspan="5">Desember</th>
                     <th class="text-center" rowspan="2">Sisa</th>
                   </tr>
                   <tr>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                     <th class="text-center">Sparepart</th>
                     <th class="text-center">Oli</th>
                     <th class="text-center">Service</th>
                     <th class="text-center">BBM</th>
                     <th class="text-center">Pajak</th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php $no = 1;
                    if (isset($rekap) && $rekap != '') : ?>
                   <?php
                      for ($i = 0; $i < sizeof($rekap); $i++) : ?>
                   <tr>
                     <td class="text-center"><?= $no++; ?></td>
                     <?php
                          $k = 0;
                          $totalpagu = 0;
                          foreach ($rekap[$i] as $j) :
                            if ($k == 5) {
                              $totalpagu += $j;
                              $j = "Rp. " . number_format((float)$j, 2, ',', '.');
                            }
                            $k++;
                          ?>
                     <td class="text-center"><?= $j ?></td>
                     <?php endforeach ?>
                     <?php
                          foreach ($januari[$i] as $jan) :
                            $totalpagu -= $jan;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$jan, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($februari[$i] as $feb) :
                            $totalpagu -= $feb;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$feb, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($maret[$i] as $mar) :
                            $totalpagu -= $mar;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$mar, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($april[$i] as $apr) :
                            $totalpagu -= $apr;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$apr, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($mei[$i] as $may) :
                            $totalpagu -= $may; ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$may, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($juni[$i] as $jun) :
                            $totalpagu -= $jun;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$jun, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($juli[$i] as $jul) :
                            $totalpagu -= $jul;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$jul, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($agustus[$i] as $ags) :
                            $totalpagu -= $ags;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$ags, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($september[$i] as $sept) :
                            $totalpagu -= $sept;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$sept, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($oktober[$i] as $okt) :
                            $totalpagu -= $okt;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$okt, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($november[$i] as $nov) :
                            $totalpagu -= $nov;
                          ?>
                     <td class="text-center"> <?= "Rp. " . number_format((float)$nov, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <?php foreach ($desember[$i] as $des) :
                            $totalpagu -= $des;
                          ?>
                     <td class="text-center"><?= "Rp. " . number_format((float)$des, 2, ',', '.'); ?>
                     </td>
                     <?php endforeach ?>
                     <td class="text-center"><?= "Rp. " . number_format((float)$totalpagu, 2, ',', '.'); ?></td>
                   </tr>
                   <?php endfor ?>
                   <?php endif; ?>

                 </tbody>
               </table>
             </div>
           </div>
         </div>
       </div>
     </div>
     <!-- /.row -->
   </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->