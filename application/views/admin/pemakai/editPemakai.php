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