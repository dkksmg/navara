 
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Data  Kendaraan Dinas <small>NAVARA</small></h1>
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
              <div class="card-header">
                <a href="<?=site_url('home/tambahKendaraanDinas')?>" class="btn btn-sm btn-success">Tambah Kendaraan</a>
              </div>
              <div class="card-body">
                <table  class="table table-bordered table-striped example">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th width="150px">Aksi</th>
                      <th>ID ASSETS</th>
                      <th>No. Polisi</th>
                      <th>Jenis</th>                      
                      <th>Merk</th>
                      <th>Tipe</th>
                      <th>No. STNK</th>
                      <th>Masa Berlaku STNK</th>
                      <th>No. Mesin</th>
                      <th>No. Rangka</th>
                      <th>Tahun Motor</th>
                      <th>Jenis Bahan Bakar</th>
                      <th>Besar CC</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; if ($kendaraan!='') { foreach ($kendaraan as $kend) { ?>
                      <tr>
                        <td><?=$no++;?></td>
                        <td>
                          <a href="<?=site_url('home/riwayat_kondisi?id='.$kend['idk'].'')?>" class="btn btn-sm btn-warning jedatombol" title="Riwayat Kondisi"><i class="fa fa-motorcycle"></i></a>
                          <a href="<?=site_url('home/riwayat_pemakai?id='.$kend['idk'].'')?>" class="btn btn-sm btn-success jedatombol" title="Riwayat Pemakai"><i class="fa fa-users"></i></a>
                          <a href="<?=site_url('home/riwayat_servis?id='.$kend['idk'].'')?>" class="btn btn-sm btn-primary jedatombol" title="Riwayat Service"><i class="fa fa-tools"></i></a>
                          <a href="<?=site_url('home/riwayat_bbm?id='.$kend['idk'].'')?>" class="btn btn-sm btn-primary jedatombol" title="Riwayat BBM"><i class="fa fa-gas-pump"></i></a>
                          <a href="<?=site_url('home/riwayat_pajak?id='.$kend['idk'].'')?>" class="btn btn-sm btn-primary jedatombol" title="Riwayat Pajak"><i class="fa fa-align-justify"></i></a>
                          <?php if ($this->session->userdata('logged_in_admin')==TRUE) { ?>
                            <a href="<?=site_url('admin/pagu?id='.$kend['idk'].'')?>" class="btn btn-sm btn-dark jedatombol" title="Pagu Tahunan"><i class="fa fa-wallet"></i></a>
                            <a href="<?=site_url('home/edit_kendaraan?id='.$kend['idk'].'')?>" class="btn btn-sm btn-dark jedatombol" title="Edit Data Kendaraan"><i class="fa fa-pen"></i></a>                       
                          <?php } ?>
                          
                        </td>
                        <td><?=$kend['id_assets']?></td>
                        <td><?=$kend['no_polisi']?></td>
                        <td><?=$kend['jenis']?></td>                        
                        <td><?=$kend['merk']?></td>
                        <td><?=$kend['tipe']?></td>
                        <td><?=$kend['no_stnk']?></td>
                        <td><?=$kend['masa_berlaku_stnk']?></td>                        
                        <td><?=$kend['no_mesin']?></td>
                        <td><?=$kend['no_rangka']?></td>
                        <td><?=$kend['tahun_perolehan']?></td>
                        <td><?=$kend['jenis_bb']?></td>
                        <td><?=$kend['besar_cc']?></td>
                      </tr>
                    <?php }} ?>
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

