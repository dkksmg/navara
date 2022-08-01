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
                        <?php echo
                        form_open_multipart(
                            'home/proseseditpengajuanservis?id=' . $rp['id_pengajuan'] . '&id_kend=' . $rp['id_kendaraan'],
                            'class="form-horizontal"'
                        );
                        ?>
                        <!-- <div class="modal-content"> -->
                        <div class="modal-header">
                            <!-- <h4 class="modal-title">Form Edit Riwayat Servis</h4> -->
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Bengkel</label>
                                        <input type="text" placeholder="Masukkan Bengkel Tujuan" class="form-control"
                                            name="nama_bengkel" value="<?php echo $rp['bengkel_tujuan'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kilometer Kendaraan</label>
                                        <input type="number" placeholder="Masukkan Kilometer Kendaraan"
                                            class="form-control" name="km_service"
                                            value="<?php echo $rp['km_service'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Keluhan</label>
                                        <textarea type="text" placeholder="Masukkan Keluhan Kendaraan Yang Anda Gunakan"
                                            class="form-control" name="keluhan_kendaraan"
                                            required><?php echo htmlspecialchars($rp['keluhan']) ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Servis</label>
                                        <textarea type="text" placeholder="Masukkan Servis Kendaraan yang diinginkan"
                                            class="form-control" name="servis_kendaraan"
                                            required><?php echo htmlspecialchars($rp['service']) ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lain - Lain</label>
                                        <textarea type="text" placeholder="" class="form-control"
                                            name="lain_lain_kendaraan"><?php echo htmlspecialchars($rp['lain_lain']) ?></textarea>
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