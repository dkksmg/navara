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
                                <th>ID Aset</th>
                                <th>:</th>
                                <th><?= $pagu['id_assets'] ?></th>
                            </tr>
                            <tr>
                                <th>No. Polisi</th>
                                <th>:</th>
                                <th><?= strtoupper($pagu['no_polisi']) ?></th>
                            </tr>
                            <tr>
                                <th>Jenis</th>
                                <th>:</th>
                                <th><?= strtoupper($pagu['jenis']) ?></th>
                            </tr>
                            <tr>
                                <th>Merk</th>
                                <th>:</th>
                                <th><?= strtoupper($pagu['merk']) ?></th>
                            </tr>
                            <tr>
                                <th>Tipe</th>
                                <th>:</th>
                                <th><?= strtoupper($pagu['tipe']) ?></th>
                            </tr>
                            <tr>
                                <th>CC</th>
                                <th>:</th>
                                <th><?php if ($pagu['besar_cc'] == '') :  ?> -
                                    <?php else : ?><?= strtoupper($pagu['besar_cc']) ?> CC <?php endif ?></th>
                            </tr>
                            <tr>
                                <th>Bahan Bakar</th>
                                <th>:</th>
                                <th><?= strtoupper($pagu['jenis_bb']) ?></th>
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
                    <?= form_open('admin/proseseditpagu?id=' . $pagu['id_ps'] . '&idkend=' . $pagu['id_kend'], 'class="form-horizontal"') ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <?php
                                    $year_start  = 2000;
                                    $year_end = date('Y') + 50;
                                    $user_selected_year = date('Y');
                                    echo '<select id="year" required class="form-control" name="tahun" disabled readonly>' . "\n";
                                    for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                        if ($pagu['tahun'] == null) :
                                            $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                        else :
                                            $selected = ($pagu['tahun'] == $i_year ? ' selected' : '');
                                        endif;
                                        echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                    }
                                    echo '</select>' . "\n";
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Total Anggaran Pagu <?= $pagu['jenis_pagu'] ?></label>
                                    <input type="number" class="form-control" name="pagu" required
                                        placeholder="Masukkan Total Pagu <?= $pagu['jenis_pagu'] ?>"
                                        value="<?= $pagu['pagu_awal'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="sumbit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>