 
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
              <div class="card-header"  style="background-color:#4a2f3a;">
                <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas</h3>
              </div>
              <div class="card-body">
                <table class="table table-striped">
                  <tr>
                    <th>ID ASSETS</th>
                    <th>:</th>
                    <th><?=$kend['id_assets']?></th>
                  </tr>
                  <tr>
                    <th>No. Polisi</th>
                    <th>:</th>
                    <th><?=$kend['no_polisi']?></th>
                  </tr>
                  <tr>
                    <th>Jenis</th>
                    <th>:</th>
                    <th><?=$kend['jenis']?></th>
                  </tr> 
                  <tr>
                    <th>Merk</th>
                    <th>:</th>
                    <th><?=$kend['merk']?></th>
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
              <div class="card-header" >
                <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#modal-xl">
                  Tambah Pemakai
                </button>
              </div>
              <div class="card-body">
                <table  class="table table-bordered table-striped example" width="100%"> 
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Aksi</th>
                      <th>Nama Pemakai</th>
                      <th>NIP</th>
                      <th>Lokasi Unit</th>
                      <th>Status</th>
                      <th>Tanggal Awal</th>
                      <th>Tanggal Akhir</th>
                  </thead>
                  <tbody>
                    <?php $no=1; if ($rp!='') { foreach ($rp as $value) { ?>
                        <tr>
                          <td><?=$no++;?></td>
                          <td>
                            <?php if ($value['status']=='aktif') { ?>
                             <a href="<?=site_url('home/nonaktifkanpemakai?id='.$value['id_rp'].'')?>" class="btn btn-sm btn-warning">Nonaktifkan</a>
                            <?php }else{ ?>
                              <a href="<?=site_url('home/aktifkanpemakai?id='.$value['id_rp'].'')?>" class="btn btn-sm btn-success">Aktifkan</a>
                            <?php } ?>
                            
                          </td>
                          <td><?=$value['nama_pemakai']?></td>
                          <td><?=$value['nip_pemakai']?></td>
                          <td><?=$value['lokasi_unit']?></td>
                          <td><?=$value['status']?></td>
                          <td><?=$value['tgl_awal']?></td>
                          <td><?=$value['tgl_akhir']?></td>
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

      <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <form method="post" action="<?=site_url('home/prosestambahPemakai?id='.$kend['idk'].'')?>" enctype="multipart/form-data">          
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
                          <input type="text" class="form-control" name="nama" required>
                      </div>
                    </div> 
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>NIP / NIK</label>
                          <input type="text" class="form-control" name="nip" required>
                      </div>
                    </div> 
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Lokasi Unit</label>
                          <select class="form-control" name="lokunit">
                            <option readonly>-- Pilih Lokias Unit --</option>
                            <?php if ($lu!='') { foreach ($lu as $value) { ?>
                              <option><?=$value['lokasi_unit']?></option>
                            <?php }} ?>
                          </select>
                      </div>
                    </div> 
                  </div>
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
                          <p>* kosongkan jika tanggal akhir belum ada</p>
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