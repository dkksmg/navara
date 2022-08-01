<div class="content-container">

    <div class="container">
        <div class="row">
            <div class="col-sm-auto">
                <img class="logodisp" src="<?php echo base_url() ?>assets/logo/pemkot.png" type="image/png" width="auto"
                    height="auto" />
            </div>
            <div class="col-md-8 ml-5">
                <p class="header">
                    <b class="pemkot">PEMERINTAH KOTA SEMARANG
                    </b><br>
                    <b class="dinas">DINAS KESEHATAN</b><br>
                    <b class="alamat">Jl. Pandanaran No. 79 Telp.(024)8415269 - 8318070 Fax.(024) 8318771 Kode Pos :
                        50241
                        SEMARANG</b>
                </p>
            </div>
        </div>
    </div>
    <hr class="hr-satu">
    <hr class="hr-dua">
    <p class="title"><u><b>PENGAJUAN SERVIS KENDARAAN DINAS</b></u></p>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8" id="inner">
                    <p style="text-align:left;font-size:14px;">Yth. Bengkel <b><?= $pengajuan['bengkel_tujuan'] ?></b>
                        <br><br>di tempat
                    </p>

                    <p>Bersama dengan surat ini kami ajukan untuk melakukan servis kendaraan Dinas Kesehatan Kota
                        Semarang dengan data dibawah
                        ini :
                    </p>
                    <h5><strong>Data Kendaraan</strong></h5>
                    <br>
                    <table class="table table-striped table-bordered" border="1">
                        <tr>
                            <th width="30%">ID Aset</th>
                            <th>:</th>
                            <td><?= $kend['id_assets'] ?></td>
                        </tr>
                        <tr>
                            <th>No. Polisi</th>
                            <th>:</th>
                            <td><?= strtoupper($kend['no_polisi']) ?></td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <th>:</th>
                            <td><?= strtoupper($kend['jenis']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk</th>
                            <th>:</th>
                            <td><?= strtoupper($kend['merk']) ?></td>
                        </tr>
                        <tr>
                            <th>Tipe</th>
                            <th>:</th>
                            <td><?= strtoupper($kend['tipe']) ?></td>
                        </tr>
                        <tr>
                            <th>CC</th>
                            <th>:</th>
                            <td><?php if ($kend['besar_cc'] == '') :  ?> -
                                <?php else : ?>
                                <?= ($kend['besar_cc']) ?> CC
                                <?php endif ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Kilometer Kendaraan</th>
                            <th>:</th>
                            <td><?= ($pengajuan['km_service']) ?></td>
                        </tr>
                        <tr>
                            <th>Bahan Bakar</th>
                            <th>:</th>
                            <td><?= strtoupper($kend['jenis_bb']) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-8" id="inner">
                    <br>
                    <table class="table table-striped table-bordered" border="1">
                        <tr>
                            <th width="30%">Nama Pengguna Kendaraan</th>
                            <th>:</th>
                            <td><?= $pengajuan['name'] . ' (' . $pengajuan['nip_user'] . ')' ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan Servis</th>
                            <th>:</th>
                            <?php
                            $tanggal = date('d', strtotime($pengajuan['tgl_pengajuan']));
                            $nama_bulan = date('F', strtotime($pengajuan['tgl_pengajuan']));
                            $bulan = nama_bulan($nama_bulan);
                            $tahun = date('Y', strtotime($pengajuan['tgl_pengajuan']));
                            ?>
                            <td><?= $tanggal . ' ' . $bulan . ' ' . $tahun ?></td>
                        </tr>
                        <tr>
                            <th>Status Pengajuan Servis</th>
                            <th>:</th>
                            <td><?php if ($pengajuan['status_pengajuan'] == 'Yes') : ?>Disetujui<?php endif ?></td>
                        </tr>
                        <tr>
                            <th>Bengkel Tujuan</th>
                            <th>:</th>
                            <td><?= $pengajuan['bengkel_tujuan'] ?></td>
                        </tr>
                        <tr>
                            <th>Keluhan</th>
                            <th>:</th>
                            <td>
                                <?php if ($pengajuan['keluhan'] == '') : ?> -
                                <?php else : ?><?= $pengajuan['keluhan'] ?><?php endif ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Servis</th>
                            <th>:</th>
                            <td>
                                <?php if ($pengajuan['service'] == '') : ?> -
                                <?php else : ?><?= $pengajuan['service'] ?><?php endif ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Tambahan</th>
                            <th>:</th>
                            <td>
                                <?php if ($pengajuan['lain_lain'] == '') : ?> -
                                <?php else : ?><?= $pengajuan['lain_lain'] ?><?php endif ?>
                            </td>
                        </tr>
                    </table>
                    <table class="mt-3" border="0" width="100%">
                        <thead>
                            <tr>
                                <th width="40%" class="text-center">
                                    Pengelola Sarana dan Prasarana
                                </th>
                                <th></th>
                                <th></th>
                                <th width="40%" class="text-center">Pengguna</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr height="120px">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <?php if ($pengajuan['id_admin'] == 1) : ?>
                                    <?= $admin['name']; ?>
                                    <?php else : ?>
                                    Vian
                                    <?php endif; ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><?= $pengajuan['name'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>