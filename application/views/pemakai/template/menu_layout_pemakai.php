<div class="col-lg-12">
  <div class="card">
    <div class="card-header" style="background-color:#4a2f3a;">
      <h3 style="font-weight:bold;color:white;">Menu Kendaraan</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <tbody>
            <tr>
              <td>
                <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                  <?php else : ?>href="<?= site_url('pemakai/riwayatkondisi?id=' . $kend['idk'] . '') ?>" <?php endif ?>
                  class="btn btn-primary jedatombol"
                  title="Riwayat Kondisi <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                  Kondisi</a>
              </td>
              <td>
                <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                  <?php else : ?> href="<?= site_url('pemakai/riwayatbbm?id=' . $kend['idk'] . '') ?>" <?php endif; ?>
                  class="btn btn-secondary jedatombol"
                  title="Riwayat BBM <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                  BBM</a>
              </td>
              <td>
                <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                  <?php else : ?> href="<?= site_url('pemakai/riwayatpajak?id=' . $kend['idk'] . '') ?>" <?php endif ?>
                  class="btn btn-danger jedatombol"
                  title="Riwayat Pajak <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                  Pajak</a>
              </td>
              <td>
                <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                  <?php else : ?> href="<?= site_url('pemakai/riwayatservis?id=' . $kend['idk'] . '') ?>"
                  <?php endif; ?> class="btn btn-warning jedatombol"
                  title="Riwayat Servis <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                  Servis</a>
              </td>
              <td>
                <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                  <?php else : ?> href="<?= site_url('pemakai/pengajuanservis?id=' . $kend['idk']) ?>" <?php endif; ?>
                  class="btn btn-success jedatombol"
                  title="Pengajuan Servis <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Pengajuan
                  Servis</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>

</div>