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
                <?= $this->load->view('admin/template/data_kend_layout', '', TRUE); ?>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color:#4a2f3a;">
                        <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                    </div>
                    <?= form_open('admin/proseseditpagu?id=' . $pagukend['id_ps'] . '&idkend=' . $pagukend['id_kend'], 'class="form-horizontal"') ?>
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
                                    <label>Total Anggaran Pagu <?= $pagukend['jenis_pagu'] ?></label>
                                    <input type="number" class="form-control" name="pagu" required
                                        placeholder="Masukkan Total Pagu <?= $pagukend['jenis_pagu'] ?>"
                                        value="<?= $pagukend['pagu_awal'] ?>">
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