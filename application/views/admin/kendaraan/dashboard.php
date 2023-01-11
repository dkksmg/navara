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
<<<<<<< HEAD
   <div class="container">
     <div class="row">
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-success">
           <div class="inner">
             <h3><?= $totalkendaraan ?></h3>
             <p>Total Kendaraan (Mobil, Ambulance, Sepeda Motor)</p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
=======
     <div class="container">
         <div class="row">
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-info">
                     <div class="inner">
                         <h3><?= $totalkendaraan ?></h3>
                         <p>Total Kendaraan</p>
                     </div>
                     <div class="icon">
                         <i class="ion ion-bag"></i>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-info">
                     <div class="inner">
                         <h3><?= $totalspm ?></h3>
                         <p>Total Kendaraan <b>Sepeda Motor</b></p>
                     </div>
                     <div class="icon">
                         <i class="ion ion-bag"></i>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-info">
                     <div class="inner">
                         <h3><?= $totalabm ?></h3>

                         <p>Total Kendaraan <b>Ambulance</b></p>
                     </div>
                     <div class="icon">
                         <i class="ion ion-bag"></i>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-info">
                     <div class="inner">
                         <h3><?= $totalmbl ?></h3>

                         <p>Total Kendaraan <b>Mobil</b></p>
                     </div>
                     <div class="icon">
                         <i class="ion ion-bag"></i>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-warning">
                     <div class="inner">
                         <h3><?= $totalpmkkend ?></h3>
                         <p>Total Kendaraan Dinas Terpakai <?php if ($this->session->userdata('role') == 'Admin') : ?>di
                             Wilayah Anda<?php endif; ?></p>
                     </div>
                     <div class="icon">
                         <i class="ion ion-bag"></i>
                     </div>
                 </div>
             </div>
             <?php if ($this->session->userdata('role') == 'Superadmin') : ?>
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-secondary">
                     <div class="inner">
                         <h3><?= $totalpemakai ?></h3>

                         <p>Total User <b>Pemakai Kendaraan</b></p>
                     </div>
                     <div class="icon">
                         <i class="ion ion-bag"></i>
                     </div>
                 </div>
             </div>
             <?php endif ?>
>>>>>>> 316cdd9c350e7cdeffa7b00461fea08d732b474c
         </div>
       </div>
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-info">
           <div class="inner">
             <h3><?= $totalspm ?></h3>
             <p>Total <b>Sepeda Motor</b></p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
         </div>
       </div>
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-info">
           <div class="inner">
             <h3><?= $totalabm ?></h3>
             <p>Total <b>Ambulance</b></p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
         </div>
       </div>
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-info">
           <div class="inner">
             <h3><?= $totalabmkl ?></h3>
             <p>Total <b>Ambulance Keliling</b></p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
         </div>
       </div>
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-info">
           <div class="inner">
             <h3><?= $totalabmhbt ?></h3>
             <p>Total <b>Ambulance Hebat</b></p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
         </div>
       </div>
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-info">
           <div class="inner">
             <h3><?= $totalabmsg ?></h3>
             <p>Total <b>Ambulance Siaga</b></p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
         </div>
       </div>
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-info">
           <div class="inner">
             <h3><?= $totalmbl ?></h3>
             <p>Total <b>Mobil</b></p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
         </div>
       </div>
       <?php if ($this->session->userdata('role') == 'Superadmin') : ?>
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-secondary">
           <div class="inner">
             <h3><?= $totalpemakai ?></h3>

             <p>Total Akun <b>Pemakai Kendaraan</b></p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
         </div>
       </div>
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-warning">
           <div class="inner">
             <h3><?= $totalpmkkend ?></h3>
             <p>Kendaraan Dinas <b>Terpakai</b> <?php if ($this->session->userdata('role') == 'Admin') : ?>di
               Wilayah Anda<?php endif; ?></p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
         </div>
       </div>
       <div class="col-lg-3 col-6">
         <!-- small box -->
         <div class="small-box bg-warning">
           <div class="inner">
             <h3><?= $totalkendaraan - $totalpmkkend ?></h3>
             <p>Kendaraan Dinas <b>Tidak Terpakai</b></p>
           </div>
           <div class="icon">
             <i class="ion ion-bag"></i>
           </div>
         </div>
       </div>

       <?php endif ?>
     </div>
     <div class="row">
     </div>
     <!-- /.row -->
   </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->