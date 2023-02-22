<div class="card">
  <div class="card-header" style="background-color:#4a2f3a;">
    <h3 style="font-weight:bold;color:white;">Menu Peralatan</h3>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <tbody>
          <tr>
            <td class="text-center">
              <a href="<?=site_url('home/riwayat_pemakai_peralatan?id=' . $alat['id']) ?>" class="btn btn-sm btn-success jedatombol" title="Riwayat Pemakai <?= $alat['merk'] ?>"><i class="fa fa-users"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('admin/pagu_peralatan?id=' . $alat['id'] . '') ?>" class="btn btn-sm btn-dark jedatombol"
                title="Pagu Tahunan Peralatan <?= $alat['merk'] ?>"><i
                  class="fa fa-wallet"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('home/riwayat_servis_peralatan?id=' . $alat['id']) ?>"
                class="btn btn-sm btn-primary jedatombol"
                title="Riwayat Service <?= $alat['merk'] ?>"><i
                  class="fa fa-tools"></i></a>
            </td>
            <td class="text-center">
              <a href="<?= site_url('home/pengajuan_servis_peralatan?id=' . $alat['id'] . '') ?>"
                class="btn btn-sm btn-info jedatombol"
                title="Pengajuan Servis Peralatan <?= $alat['merk'] ?>"><i
                  class="fa-solid fa-ballot"></i></a>
            </td>
            <td class="text-center">
              <a onclick="editConfirm('<?= site_url('home/edit_peralatan?id=' . $alat['id'] . '') ?>')" href="#"
                class="btn btn-sm btn-warning jedatombol"
                title="Edit Data Peralatan <?= $alat['merk'] ?>"><i
                  class="fa fa-pen"></i></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>