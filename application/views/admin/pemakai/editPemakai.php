<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
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
                                    <th><?= $value['id_assets'] ?></th>
                                </tr>
                                <tr>
                                    <th>No. Polisi</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['no_polisi']) ?></th>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['jenis']) ?></th>
                                </tr>
                                <tr>
                                    <th>Merk</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['merk']) ?></th>
                                </tr>
                                <tr>
                                    <th>Tipe</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['tipe']) ?></th>
                                </tr>
                                <tr>
                                    <th>CC</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['besar_cc']) ?> CC</th>
                                </tr>
                                <tr>
                                    <th>Bahan Bakar</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['jenis_bb']) ?></th>
                                </tr>
                                <tr>
                                    <th>Pagu Kendaraan Tahun <?= date('Y') ?></th>
                                    <th>:</th>
                                    <th>Rp. <?= isset($pagu) ? number_format($pagu['pagu_awal'], 2, ',', '.') : 0 ?>
                                    </th>
                                </tr>
                                <?php
                                if (isset($pagu)) {
                                    $terpakai = $pagu['total_biaya_pajak'] + $pagu['total_biaya_servis'] + $pagu['total_biaya_bbm'];
                                    $sisa = $pagu['pagu_awal'] - $terpakai;
                                }
                                ?>
                                <tr>
                                    <th>Pagu Terpakai</th>
                                    <th>:</th>
                                    <th>Rp. <?= isset($terpakai) ? number_format($terpakai, 2, ',', '.') : 0 ?></th>
                                </tr>
                                <tr>
                                    <th>Sisa Pagu</th>
                                    <th>:</th>
                                    <th>Rp. <?= isset($sisa) ? number_format($sisa, 2, ',', '.') : 0 ?></th>
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
                                'home/proseseditpemakai?id=' . $value['id_rp'] . '',
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
                                            <label>Nama Pemakai</label>
                                            <select class="form-control" name="nama" required>
                                                <option value="">- Pilih Nama -</option>
                                                <?php foreach ($pemakai as $p) : ?>
                                                <?php if ($value['id_user'] != $p['id']) : ?>
                                                <option value="<?= $p['id'] ?>"><?= $p['name'] ?> -
                                                    <?= $p['nip_user'] ?>
                                                </option>
                                                <?php else : ?>
                                                <option value="<?= $p['id'] ?>" selected><?= $p['name'] ?> -
                                                    <?= $p['nip_user'] ?>
                                                </option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>NIP / NIK</label>
                                            <input type="number" class="form-control" name="nip" required
                                                value="<?= $value['nip_pemakai'] ?>">
                                        </div>
                                    </div> -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Lokasi Unit</label>
                                            <select class="form-control" name="lokunit">
                                                <option readonly>-- Pilih Lokasi Unit --</option>
                                                <?php if ($lu != '') : ?>
                                                <?php foreach ($lu as $lokasi) : ?>
                                                <option <?php if ($value['lokasi_unit'] == $lokasi['lokasi_unit']) : ?>
                                                    selected="selected" <?php endif ?>><?= $lokasi['lokasi_unit'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Awal</label>
                                            <input type="text" class="form-control pilihtanggal" name="dari" required
                                                value="<?= date('d-m-Y', strtotime($value['tgl_awal'])) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Akhir</label>
                                            <input type="text" class="form-control pilihtanggal" name="sampai"
                                                value="<?= date('d-m-Y', strtotime($value['tgl_akhir'])) ?>">
                                            <p style="color:red;">* kosongkan jika tanggal akhir belum ada</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="sumbit" class="btn btn-primary">Simpan</button>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>

    </section>

</div>