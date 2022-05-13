<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mt-3 mb-3">
                <div class="col-sm-6">
                    <!-- <h1><?= $title ?></h1> -->
                </div>
            </div>
        </div>
    </div>

    <section class="content">
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
                                    <th><?= $value['id_assets'] ?></th>
                                </tr>
                                <tr>
                                    <th>No. Polisi</th>
                                    <th>:</th>
                                    <th><?= $value['no_polisi'] ?></th>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <th>:</th>
                                    <th><?= $value['jenis'] ?></th>
                                </tr>
                                <tr>
                                    <th>Merk</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['merk']) ?></th>
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
                        <div class="card-body">
                            <?php echo form_open_multipart(
                                'home/proseseditpajak?id=' . $value['id_pjk'] . '',
                                'class="form-horizontal"'
                            );
                            echo form_hidden('id_kend', $value['id_kendaraan']);
                            ?>
                            <!-- <div class="modal-content"> -->
                            <div class="modal-header">
                                <!-- <h4 class="modal-title">Form Edit Riwayat Servis</h4> -->
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <?php
                                            $year_start  = 2000;
                                            $year_end = date('Y');
                                            $user_selected_year = date('Y');

                                            echo '<select id="year" required class="form-control" name="tahun_pajak" disabled readonly>' . "\n";
                                            for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                                if ($value['tahun'] == null) :
                                                    $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                                else :
                                                    $selected = ($value['tahun'] == $i_year ? ' selected' : '');
                                                endif;
                                                echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                            }
                                            echo '</select>' . "\n";
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Pajak</label>
                                            <input type="text" id="rupiah" class="form-control"
                                                placeholder="Masukkan Total Pajak" value="<?= $value['total_pajak'] ?>"
                                                name="total_pajak">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-end">
                                <button type="sumbit" class="btn btn-primary">Simpan</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
</div>