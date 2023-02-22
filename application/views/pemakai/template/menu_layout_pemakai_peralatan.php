<div class="col-lg-12">
  <div class="card">
    <div class="card-header" style="background-color:#4a2f3a;">
      <h3 style="font-weight:bold;color:white;">Menu Peralatan</h3>
    </div>
    <div class="card-body">
      <!-- <div class="table-responsive"> -->
        <table class="table table-hover">
          <!-- <tbody> -->
            <tr>
              <td style="width: 10%">
                <a <?php if ($alat['pagu_awal'] == 0 or $alat['pagu_awal'] == null) : ?> disabled style="background-color: #555555"
              <?php else : ?>href="<?= site_url('pemakai/riwayatservisperalatan?id=' . $alat['id'] . '') ?>" <?php endif ?>
               class="btn btn-primary jedatombol"
               title="Riwayat Service <?= strtoupper($alat->merk) ?>">Riwayat Servis</a>
              </td>
              <td style="width: 50%">
                <a <?php if ($alat['pagu_awal'] == 0 or $alat['pagu_awal'] == null) : ?> disabled style="background-color: #555555" 
                <?php else : ?>href="<?= site_url('pemakai/pengajuan_servis_peralatan?id=' . $alat['id'] . '') ?>" <?php endif ?>
                class="btn btn-success jedatombol"
                title="Pengajuan Servis <?= strtoupper($alat->merk) ?>">Pengajuan Servis</a>
              </td>
            </tr>
          <!-- </tbody> -->
        </table>
      <!-- </div> -->

    </div>
  </div>

</div>