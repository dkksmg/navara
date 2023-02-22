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
                <?= $this->load->view('admin/template/data_peralatan_layout', '', TRUE); ?>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color:#4a2f3a;">
                        <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                    </div>
                    <div class="card-body">
                        <?php echo
                        form_open_multipart(
                            'home/proseseditpengajuanservisperalatan?id=' . $rp['id_pengajuan'] . '&id_alat=' . $rp['id_alat'],
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
                                <label>Tanggal Pengajuan</label>
                                 <input type="text" class="form-control pilihtanggal" name="dari" value="<?=isset($rp)? date("d-m-Y", strtotime($rp['tgl_pengajuan'])) : ""; ?>"required>
                              </div>
                             </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tempat Servis</label>
                                        <input type="text" placeholder="Masukkan Tempat Servis" class="form-control"
                                            name="tempat_servis" value="<?= $rp['tempat_servis'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Keluhan</label>
                                        <textarea type="text" placeholder="Masukkan Keluhan Peralatan Yang Anda Gunakan"
                                            class="form-control" name="keluhan_peralatan"
                                            required><?php echo htmlspecialchars($rp['keluhan']) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Servis</label>
                                        <textarea type="text" placeholder="Masukkan Servis Peralatan yang diinginkan"
                                            class="form-control" name="servis_peralatan"
                                            required><?php echo htmlspecialchars($rp['servis']) ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lain - Lain</label>
                                        <textarea type="text" placeholder="" class="form-control"
                                            name="lain_lain_peralatan"><?php echo htmlspecialchars($rp['lain_lain']) ?></textarea>
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