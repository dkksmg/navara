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
                            <h3 style="font-weight:bold;color:white;">Pagu Anggaran Pemeliharaan</h3>
                        </div>
                        <div class="card-header">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-xl">
                                Tambah Pagu Anggaran Pemeliharaan
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped example" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Jenis Pagu</th>
                                        <th>Tahun</th>
                                        <th>Pagu</th>
                                        <th>Terpakai</th>
                                        <th>Sisa</th>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                    if ($pagu != '') {
                      foreach ($pagu as $pg) {
                        if ($pg['jenis_pagu'] == 'BBM') {
                          $terpakai = "Rp " . number_format($pg['tb'], 2, ',', '.');
                          $sisabbm = "Rp " . number_format($pg['pagu_awal'] - $pg['tb'], 2, ',', '.');
                        } elseif ($pg['jenis_pagu'] == 'Pemeliharaan') {
                          $sisabbm = "";
                          $terpakai = "";
                        } else {
                          $sisabbm = "";
                          $terpakai = "";
                        } ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td></td>
                                        <td><?= $pg['jenis_pagu'] ?></td>
                                        <td><?= $pg['tahun'] ?></td>
                                        <td>Rp <?= number_format($pg['pagu_awal'], 2, ',', '.'); ?></td>
                                        <td><?= $terpakai ?></td>
                                        <td><?= $sisabbm ?></td>
                                    </tr>
                                    <?php }
                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
            <form method="post" action="<?= site_url('admin/prosestambahpagu?id=' . $kend['idk'] . '') ?>"
                enctype="multipart/form-data">
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
                                    <label>Tahun</label>
                                    <select class="form-control" name="tahun">
                                        <?php
                      $tahun = date('Y');
                      $before = $tahun - 5;
                      $after = $tahun + 5;
                      for ($i = $before; $i < $after; $i++) {
                        echo "<option>" . $i . "</option>";
                      } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Pagu</label>
                                    <input type="text" class="form-control" value="Pemeliharaan" readonly>
                                    <input type="hidden" name="jenis[]" value="Pemeliharaan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pagu</label>
                                    <input type="number" class="form-control" name="pagu[]" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Pagu</label>
                                    <input type="text" class="form-control" value="BBM" readonly>
                                    <input type="hidden" name="jenis[]" value="BBM">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pagu</label>
                                    <input type="number" class="form-control" name="pagu[]" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Pagu</label>
                                    <input type="text" class="form-control" value="Pajak Kendaraan" readonly>
                                    <input type="hidden" name="jenis[]" value="Pajak Kendaraan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pagu</label>
                                    <input type="number" class="form-control" name="pagu[]" required>
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