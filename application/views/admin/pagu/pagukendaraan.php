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
                            <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                        </div>
                        <div class="card-header">
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                data-target="#modal-xl">
                                Tambah Pagu Anggaran Pemeliharaan
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped example" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Aksi</th>
                                        <th class="text-center">Jenis Pagu</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Pagu</th>
                                        <th class="text-center">Terpakai</th>
                                        <th class="text-center">Sisa</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($pemeliharaan as $row) :
                                        if ($row->jenis_pagu == 'Pemeliharaan') :
                                            $terpakai = "Rp. " . number_format($row->total_biaya_servis, 2, ',', '.');
                                            $sisapemeliharaan = "Rp. " . number_format($row->pagu_awal - $row->total_biaya_servis, 2, ',', '.');
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no ?></td>
                                        <td class="text-center">
                                            <a onclick="deleteConfirm('<?= site_url('admin/hapuspagu?id=' . $row->id_ps . '') ?>')"
                                                href="#" class="btn btn-sm btn-danger jedatombol"><i
                                                    class="fas fa-trash"></i></a>
                                            <a onclick="editConfirm('<?= site_url('admin/editpagu?id=' . $row->id_ps . '') ?>')"
                                                href="#" class="btn btn-sm btn-warning jedatombol"
                                                title="Edit Pagu <?= $kend['no_polisi'] ?>"><i
                                                    class="fas fa-pencil"></i></a>
                                        </td>
                                        <td class="text-center"><?= $row->jenis_pagu ?></td>
                                        <td class="text-center"><?= $row->tahun ?></td>
                                        <td class="text-center">Rp. <?= number_format($row->pagu_awal, 2, ',', '.'); ?>
                                        </td>
                                        <td class="text-center"><?= $terpakai ?></td>
                                        <td class="text-center"><?= $sisapemeliharaan ?></td>
                                    </tr>
                                    <?php $no++;
                                        endif;
                                    endforeach;
                                    ?>
                                    <?php
                                    $num = $no;
                                    foreach ($bbm as $row) :
                                        if ($row->jenis_pagu == 'BBM') :
                                            $terpakai = "Rp. " . number_format($row->total_biaya_bbm, 2, ',', '.');
                                            $sisabbm = "Rp. " . number_format($row->pagu_awal - $row->total_biaya_bbm, 2, ',', '.');
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $num ?></td>
                                        <td class="text-center">
                                            <a onclick="deleteConfirm('<?= site_url('admin/hapuspagu?id=' . $row->id_ps . '') ?>')"
                                                href="#" class="btn btn-sm btn-danger jedatombol"><i
                                                    class="fas fa-trash"></i></a>
                                            <a onclick="editConfirm('<?= site_url('admin/editpagu?id=' . $row->id_ps . '') ?>')"
                                                href="#" class="btn btn-sm btn-warning jedatombol"
                                                title="Edit Pagu <?= $kend['no_polisi'] ?>"><i
                                                    class="fas fa-pencil"></i></a>
                                        </td>
                                        <td class="text-center"><?= $row->jenis_pagu ?></td>
                                        <td class="text-center"><?= $row->tahun ?></td>
                                        <td class="text-center">Rp. <?= number_format($row->pagu_awal, 2, ',', '.'); ?>
                                        </td>
                                        <td class="text-center"><?= $terpakai ?></td>
                                        <td class="text-center"><?= $sisabbm ?></td>
                                    </tr>
                                    <?php $num++;
                                        endif;
                                    endforeach;
                                    ?>
                                    <?php
                                    $nom = $num;
                                    foreach ($pajak as $row) :
                                        if ($row->jenis_pagu == 'Pajak Kendaraan') :
                                            $terpakai = "Rp. " . number_format($row->total_biaya_pajak, 2, ',', '.');
                                            $sisapajak = "Rp. " . number_format($row->pagu_awal - $row->total_biaya_pajak, 2, ',', '.');
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $nom ?></td>
                                        <td class="text-center">
                                            <a onclick="deleteConfirm('<?= site_url('admin/hapuspagu?id=' . $row->id_ps . '') ?>')"
                                                href="#" class="btn btn-sm btn-danger jedatombol"><i
                                                    class="fas fa-trash"></i></a>
                                            <a onclick="editConfirm('<?= site_url('admin/editpagu?id=' . $row->id_ps . '') ?>')"
                                                href="#" class="btn btn-sm btn-warning jedatombol"
                                                title="Edit Pagu <?= $kend['no_polisi'] ?>"><i
                                                    class="fas fa-pencil"></i></a>
                                        </td>
                                        <td class="text-center"><?= $row->jenis_pagu ?></td>
                                        <td class="text-center"><?= $row->tahun ?></td>
                                        <td class="text-center">Rp. <?= number_format($row->pagu_awal, 2, ',', '.'); ?>
                                        </td>
                                        <td class="text-center"><?= $terpakai ?></td>
                                        <td class="text-center"><?= $sisapajak ?></td>
                                    </tr>
                                    <?php $nom++;
                                        endif;
                                    endforeach;
                                    ?>
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

                                    echo '<select id="year" required class="form-control" name="tahun[]">' . "\n";
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Pagu</label>
                                    <input type="text" class="form-control" value="Pemeliharaan" disabled readonly>
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
                                    <input type="text" class="form-control" value="BBM" disabled readonly>
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
                                    <input type="text" class="form-control" value="Pajak Kendaraan" disabled readonly>
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