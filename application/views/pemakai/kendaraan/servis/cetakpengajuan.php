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

                    <p>Bersama dengan surat ini kami ajukan untuk melakukan servis kendaraan dinas dengan data dibawah
                        ini :
                    </p>
                    <br>
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
                            <th><?php if ($kend['besar_cc'] == '') :  ?> -
                                <?php else : ?><?= strtoupper($kend['besar_cc']) ?> CC <?php endif ?></th>
                        </tr>
                        <tr>
                            <th>Bahan Bakar</th>
                            <th>:</th>
                            <td><?= strtoupper($kend['jenis_bb']) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-8" id="inner">
                    <!-- <h5><strong>Summary Data</strong></h5> -->
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
                            <td><?= date('d-m-Y', strtotime($pengajuan['tgl_pengajuan'])) ?></td>
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
                    <table border="0" width="100%">
                        <thead>
                            <td width="500px"></td>
                            <td width="50px"></td>
                            <td width="50px"></td>
                            <td width="50px"></td>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-right"><b>Tanda Tangan Pengguna</b></td>
                            </tr>
                            <tr height="200px">
                                <td class="text-right" colspan="5"><?= $pengajuan['name'] ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>