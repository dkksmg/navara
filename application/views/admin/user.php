 
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Data  User Navara <small>NAVARA</small></h1>
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
                <h3 style="font-weight:bold;color:white;">Data User Navara</h3>
              </div>
              
              <div class="card-body">
                <table  class="table table-bordered table-striped example" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th width="150px">Aksi</th>
                      <th>Username</th>
                      <th>Nama</th>
                      <th>Kode</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; if ($user!='') { foreach ($user as $usr) { ?>
                      <tr>
                        <td><?=$no++;?></td>
                        <td></td>
                        <td><?=$usr['username']?></td>
                        <td><?=$usr['name']?></td>
                        <td><?=$usr['kode']?></td>
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

