<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <!-- <h1 class="m-0"> Data  Kendaraan Dinas <small>NAVARA</small></h1> -->
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <?= $this->load->view('admin/template/data_kend_layout', '', TRUE); ?>
        <?= $this->load->view('admin/template/menu_layout_admin', '', TRUE); ?>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header" style="background-color:#4a2f3a;">
            <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
          </div>
          <div class="card-header">
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-xl">
              Tambah Pagu Anggaran Pemeliharaan
            </button>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped example" width="100%">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Aksi</th>
                  <th class="text-center">Tahun</th>
                  <th class="text-center">Pagu</th>
              </thead>
              <tbody>
                <?php
                                $no = 1;
                                if (isset($paguall)) :
                                    foreach ($paguall as $row) :
                                ?>
                <tr>
                  <td class="text-center"><?= $no ?></td>
                  <td class="text-center">
                    <a onclick="deleteConfirm('<?= site_url('admin/hapuspagu?id=' . $row['id_ps'] . '&idkend=' . $row['id_kend']) ?>')"
                      href="#" class="btn btn-sm btn-danger jedatombol"><i class="fas fa-trash"></i></a>
                    <a onclick="editConfirm('<?= site_url('admin/editpagu?id=' . $row['id_ps'] . '&idkend=' . $row['id_kend']) ?>')"
                      href="#" class="btn btn-sm btn-warning jedatombol" title="Edit Pagu <?= $kend['no_polisi'] ?>"><i
                        class="fas fa-pencil"></i></a>
                  </td>
                  <td class="text-center"><?= $row['tahun'] ?></td>
                  <td class="text-center">Rp. <?= number_format($row['pagu_awal'], 2, ',', '.'); ?>
                  </td>
                </tr>
                <?php
                                        $no++;
                                    endforeach;
                                endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Main content -->
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header" style="background-color:#4a2f3a;">
            <h3 style="font-weight:bold;color:white;"><?= $title_cek ?></h3>
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
            <table class="table table-bordered table-striped example" width="100%">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Tahun</th>
                  <th class="text-center">Pagu</th>
                  <th class="text-center">Terpakai</th>
                  <th class="text-center">Sisa</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                                if (isset($rekap)) :
                                    foreach ($rekap as $key => $value) :
                                        $terpakai = $value['total_biaya_pajak'] + $value['total_biaya_servis'] + $value['total_biaya_bbm'];
                                        $sisa = $value['pagu_awal'] - $terpakai;
                                ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td class="text-center"><?= $value['tahun'] ?></td>
                  <td class="text-center">Rp. <?= number_format($value['pagu_awal'], 2, ',', '.'); ?>
                  </td>
                  <td class="text-center">Rp. <?= number_format($terpakai, 2, ',', '.'); ?></td>
                  <td class="text-center">Rp. <?= number_format($sisa, 2, ',', '.'); ?></td>
                </tr>
                <?php endforeach;
                                endif; ?>

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
    <form method="post" action="<?= site_url('admin/prosestambahpagu?id=' . $kend['idk'] . '') ?>"
      enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Pagu Kendaraan Dinas</h4>
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
                                $year_end = date('Y') + 50;
                                $user_selected_year = date('Y');
                                echo '<select id="year" required class="form-control" name="tahun">' . "\n";
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
                <label>Anggaran Pagu</label>
                <input type="number" class="form-control" name="pagu" placeholder="Masukkan Anggaran Pagu Kendaraan"
                  required>
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
</div>
</div>