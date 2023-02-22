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
                <?= $this->load->view('admin/template/data_peralatan_layout', '', TRUE); ?>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color:#4a2f3a;">
                        <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                    </div>
                    <?= form_open('admin/proseseditpaguperalatan?id_ps=' . $pagu_alat['id_ps'] . '&id_alat=' . $pagu_alat['id_alat'], 'class="form-horizontal"') ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select id="year" required class="form-control" name="tahun" disabled readonly>
                                        <option value="<?= $pagu_alat['tahun'] ?>" selected><?= $pagu_alat['tahun'] ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Total Anggaran Pagu <?= $pagu_alat['jenis_pagu'] ?></label>
                                    <input type="number" class="form-control" name="pagu" required
                                        placeholder="Masukkan Total Pagu <?= $pagu_alat['jenis_pagu'] ?>"
                                        value="<?= $pagu_alat['pagu_awal'] ?>">
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