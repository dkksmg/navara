<div class="card">
  <div class="card-header" style="background-color:#4a2f3a;">
    <h3 style="font-weight:bold;color:white;">Menu Kendaraan</h3>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <tbody>
          <tr>
            <td class="text-center"><a href="<?= site_url('home/riwayat_kondisi?id=' . $kend['idk'] . '') ?>"
                class="btn btn-sm btn-warning jedatombol"
                title="Riwayat Kondisi <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                  class="fa fa-motorcycle"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('home/riwayat_pemakai?id=' . $kend['idk'] . '') ?>"
                class="btn btn-sm btn-success jedatombol"
                title="Riwayat Pemakai <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                  class="fa fa-users"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('home/riwayat_servis?id=' . $kend['idk'] . '') ?>"
                class="btn btn-sm btn-primary jedatombol"
                title="Riwayat Service <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                  class="fa fa-tools"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('admin/pagu?id=' . $kend['idk'] . '') ?>" class="btn btn-sm btn-dark jedatombol"
                title="Pagu Tahunan Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                  class="fa fa-wallet"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('home/print_data_kendaraan?id=' . $kend['idk'] . '') ?>"
                class="btn btn-sm btn-dark jedatombol" target="_blank"
                title="Print Data Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                  class="fa fa-print"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('home/riwayat_bbm?id=' . ($kend['idk']) . '') ?>"
                class="btn btn-sm btn-primary jedatombol"
                title="Riwayat BBM <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                  class="fa fa-gas-pump"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('home/riwayat_pajak?id=' . $kend['idk'] . '') ?>"
                class="btn btn-sm btn-primary jedatombol"
                title="Riwayat Pajak Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                  class="fa fa-align-justify"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('home/pengajuan_servis?id=' . $kend['idk'] . '') ?>"
                class="btn btn-sm btn-info jedatombol"
                title="Pengajuan Servis Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                  class="fa-solid fa-ballot"></i></a>
            </td>
            <td class="text-center">
              <a onclick="editConfirm('<?= site_url('home/edit_kendaraan?id=' . $kend['idk'] . '') ?>')" href="#"
                class="btn btn-sm btn-warning jedatombol"
                title="Edit Data Kendaraan <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                  class="fa fa-pen"></i></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>