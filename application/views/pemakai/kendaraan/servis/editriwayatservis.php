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
                                    <th>ID Aset</th>
                                    <th>:</th>
                                    <th><?= $servis['id_assets'] ?></th>
                                </tr>
                                <tr>
                                    <th>No. Polisi</th>
                                    <th>:</th>
                                    <th><?= $servis['no_polisi'] ?></th>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <th>:</th>
                                    <th><?= $servis['jenis'] ?></th>
                                </tr>
                                <tr>
                                    <th>Merk</th>
                                    <th>:</th>
                                    <th><?= strtoupper($servis['merk']) ?></th>
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
                                'pemakai/proseseditservis?id=' . $servis['id_rs'] . '',
                                'class="form-horizontal"'
                            );
                            echo form_hidden('id_kend', $servis['id_kendaraan']);
                            echo form_hidden('old_nota', $servis['foto_nota']);
                            echo form_hidden('old_servis', $servis['foto_servis']);
                            echo form_hidden('tipe', $servis['tipe']);
                            echo form_hidden('no_pol', $servis['no_polisi']);
                            ?>
                            <!-- <form method="post"
                                action="<?= site_url('pemakai/proseseditservis?id=' . $servis['id_rs'] . '') ?>"
                                enctype="multipart/form-data"> -->
                            <!-- <div class="modal-content"> -->
                            <div class="modal-header">
                                <!-- <h4 class="modal-title">Form Edit Riwayat Servis</h4> -->
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Service</label>
                                            <input type="text" class="form-control pilihtanggal" name="tgl" required
                                                value="<?php echo date('d-m-Y', strtotime($servis['tgl_servis'])) ?>"
                                                placeholder="Tanggal Service">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Bengkel Service</label>
                                            <input type="text" class="form-control" name="bengkel" required
                                                value="<?php echo $servis['lokasi'] ?>" placeholder="Nama Bengkel">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Keluhan</label>
                                            <input type="text" class="form-control" name="keluhan" required
                                                value="<?php echo $servis['keluhan'] ?>"
                                                placeholder="Keluhan Kendaraan">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Perbaikan</label>
                                            <input type="text" class="form-control" name="perbaikan" required
                                                value="<?php echo $servis['perbaikan'] ?>"
                                                placeholder="Perbaikan Kendaraan">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Biaya</label>
                                            <input type="number" class="form-control" name="biaya" required
                                                value="<?php echo $servis['total_biaya'] ?>" placeholder="Total Biaya">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Foto Nota</label>
                                            <input type="file" class="form-control" name="nota" accept="image/*"
                                                <?php if ($servis['foto_nota'] == null) : ?> required <?php endif ?>>
                                        </div>
                                        <div class="card" style="width: 18rem;">
                                            <div class="gallery">

                                                <img class="card-img-top"
                                                    src="<?= base_url('assets/upload/foto_nota/' . $servis['foto_nota']) ?>"
                                                    alt="Foto Servis">
                                            </div>
                                        </div>
                                        <div class="container-foto">
                                            <div class="popup">
                                                <i class="fas fa-times-circle" id="close"></i>
                                                <div class="imageShow">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Foto Service</label>
                                            <input type="file" class="form-control" name="foto" accept="image/*"
                                                <?php if ($servis['foto_servis'] == null) : ?> required <?php endif ?>>
                                        </div>
                                        <div class="card" style="width: 18rem;">
                                            <div class="gallery">
                                                <img class="card-img-top"
                                                    src="<?= base_url('assets/upload/foto_servis/' . $servis['foto_servis']) ?>"
                                                    alt="Foto Servis">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                </div>
                                <div class="modal-footer justify-content-end">
                                    <button type="sumbit" class="btn btn-primary">Simpan</button>
                                </div>
                                <!-- </form> -->
                                <?php form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
</div>