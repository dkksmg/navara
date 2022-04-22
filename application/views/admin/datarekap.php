 
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
                <form>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Periode</label>
                          <input type="text" class="form-control pilihtanggal" name="dari" value="<?=isset($dari)?date('d-m-Y',strtotime($dari)):date('d-m-Y');?>" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>S/D</label>
                          <input type="text" class="form-control pilihtanggal" name="sampai" value="<?=isset($sampai)?date('d-m-Y',strtotime($sampai)):date('d-m-Y');?>" required>
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
                <table  class="table table-bordered table-striped example" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Total Kendaraan</th>
                      <th>Kondisi Baik</th>
                      <th>Kondisi Rusak Ringan</th>
                      <th>Kondisi Rusak Sedang</th>
                      <th>Kondisi Rusak Berat</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; if (isset($rekap)&&$rekap!='') { foreach ($rekap as $key => $value) { ?>
                      <tr>
                        <td><?=$no++;?></td>
                        <td><?=$value['jml']?></td>
                        <td><?=$value['baik']?></td>
                        <td><?=$value['ringan']?></td>
                        <td><?=$value['sedang']?></td>
                        <td><?=$value['berat']?></td>
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

