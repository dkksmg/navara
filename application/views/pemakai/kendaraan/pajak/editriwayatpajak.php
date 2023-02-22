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
                                    <th width="30%">ID Aset</th>
                                    <th>:</th>
                                    <th colspan="4"><?= $value['id_assets'] ?></th>
                                </tr>
                                <tr>
                                    <th>No. Polisi</th>
                                    <th>:</th>
                                    <th><?= strtoupper($kend['no_polisi']) ?></th>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <th>:</th>
                                    <th colspan="4"><?= strtoupper($kend['jenis']) ?></th>
                                </tr>
                                <tr>
                                    <th>Merk</th>
                                    <th>:</th>
                                    <th><?= strtoupper($kend['merk']) ?></th>
                                </tr>
                                <tr>
                                    <th>Tipe</th>
                                    <th>:</th>
                                    <th colspan="4"><?= strtoupper($kend['tipe']) ?></th>
                                </tr>
                                <tr>
                                    <th>CC</th>
                                    <th>:</th>
                                    <th><?php if ($kend['besar_cc'] == '') :  ?> -
                                        <?php else : ?><?= strtoupper($kend['besar_cc']) ?> CC <?php endif ?></th>
                                </tr>
                                <tr>
                                    <th>Bahan Bakar</th>
                                    <th>:</th>
                                    <th colspan="4"><?= strtoupper($kend['jenis_bb']) ?></th>
                                </tr>
                                <tr>
                                    <th>Pagu Kendaraan Tahun <?= date('Y') ?></th>
                                    <th>:</th>
                                    <th>Rp. <?= number_format($kend['pagu_awal'], 2, ',', '.') ?></th>

                                    <th>Pagu Kendaraan Tahun <?= date('Y')-1 ?></th>
                                    <th>:</th>
                                    <th>Rp. <?= number_format($kend2['pagu_awal'], 2, ',', '.') ?></th>
                                </tr>
                                <?php
                                $terpakai = $kend['total_biaya_pajak'] + $kend['total_biaya_servis'] + $kend['total_biaya_bbm'];
                                $sisa = $kend['pagu_awal'] - $terpakai;

                                $terpakai2 = $kend2['total_biaya_pajak'] + $kend2['total_biaya_servis'] + $kend2['total_biaya_bbm'];
                                $sisa2 = $kend2['pagu_awal'] - $terpakai2;
                                 ?>
                                <tr>
                                    <th>Pagu Terpakai</th>
                                    <th>:</th>
                                    <th>Rp. <?= number_format($terpakai, 2, ',', '.') ?></th>

                                    <th>Pagu Terpakai</th>
                                    <th>:</th>
                                    <th>Rp. <?= number_format($terpakai2, 2, ',', '.') ?></th>
                                </tr>
                                <tr>
                                    <th>Sisa Pagu</th>
                                    <th>:</th>
                                    <th>Rp. <?= number_format($sisa, 2, ',', '.') ?></th>

                                    <th>Sisa Pagu</th>
                                    <th>:</th>
                                    <th>Rp. <?= number_format($sisa2, 2, ',', '.') ?></th>
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
                                'pemakai/proseseditpajak?id=' . $value['id_pjk'] . '',
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
                                            <select class="form-control" name="tahun_pajak" readonly required>
                                                <option value="<?=$value['tahun']?>"><?=$value['tahun']?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Pajak</label>
                                            <input type="number" class="form-control" placeholder="Masukkan Total Pajak"
                                                value="<?= $value['total_pajak'] ?>" name="total_pajak">
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
        </div>

    </section>
</div>