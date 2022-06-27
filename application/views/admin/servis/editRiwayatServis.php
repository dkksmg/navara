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
                    <?= $this->load->view('admin/template/data_kend_layout', '', TRUE); ?>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="background-color:#4a2f3a;">
                            <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart(
                                'home/proseseditservis?id=' . $servis['id_rs'] . '',
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
                                            <textarea class="form-control" name="keluhan" required
                                                placeholder="Keluhan Kendaraan"><?php echo htmlspecialchars($servis['keluhan']) ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Perbaikan</label>
                                            <textarea class="form-control" name="perbaikan" required
                                                placeholder="perbaikan Kendaraan"><?php echo htmlspecialchars($servis['perbaikan']) ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Lain Lain</label>
                                            <textarea class="form-control" name="lain_lain"
                                                placeholder="Tambahan/Lain-Lain"><?php echo htmlspecialchars($servis['lain_lain']) ?></textarea>
                                        </div>
                                    </div>
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
                                            <h5 class="card-title text-center mt-3 mb-3">Foto Nota</h5>
                                            <div class="gallery">

                                                <img class="card-img-top"
                                                    src="<?= base_url('assets//upload/foto_nota/' . $servis['foto_nota']) ?>"
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
                                            <h5 class="card-title text-center mt-3 mb-3">Foto Servis</h5>
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