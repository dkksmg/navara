<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1><?= $title ?></h1> -->
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="col-md-10">
                <div class="card-info">
                    <div class="card-body">
                        <?php echo form_open(
                            'admin/prosesedituser?id=' . $user['id'] . '',
                            'class="form-horizontal"'
                        );
                        ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><?= $title ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama User</label>
                                            <input type="text" class="form-control" name="nama_user"
                                                value="<?= $user['name'] ?>" placeholder="Masukkan Nama User" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>NIP</label>
                                            <input type="number" class="form-control" name="nip_user"
                                                value="<?= $user['nip_user'] ?>"
                                                placeholder="Kosongkan Jika Role Tidak Pemakai Kendaraan" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <?php
                                            $role = array('' => '- Pilih -', 'Superadmin' => 'Superadmin', 'Admin' => 'Admin Wilayah', 'Pemakai' => 'Pemakai Kendaraan');
                                            echo form_dropdown(
                                                'role_user',
                                                $role,
                                                $user['role'],
                                                form_error('role') == true ? "class='form-control is-invalid' required" : "class='form-control' required"
                                            ); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" name="username"
                                                value="<?= $user['username'] ?>" placeholder="Masukkan Username"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Masukkan Password">
                                            <p style="color:red;">* kosongkan jika tidak ingin update password</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Lokasi Kerja</label>
                                            <select class="form-control" name="lokasi_kerja" required>
                                                <option readonly>-- Pilih Lokasi Kerja --</option>
                                                <?php if ($lu != '') : ?>
                                                <?php foreach ($lu as $value) : ?>
                                                <option <?php if ($user['wilayah'] == $value['lokasi_unit']) : ?>
                                                    selected <?php endif ?>>
                                                    <?= $value['lokasi_unit'] ?></option>
                                                <?php endforeach;
                                                endif; ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <?php
                                            $status = array('' => '- Pilih -', 'Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif');
                                            echo form_dropdown(
                                                'status_user',
                                                $status,
                                                $user['status'],
                                                form_error('status') == true ? "class='form-control is-invalid' required" : "class='form-control' required"
                                            ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="sumbit" class="btn btn-primary">Update</button>
                            </div>
                            <!-- </form> -->
                            <?php form_close() ?>
                        </div>
                    </div>

                </div>
            </div>

    </section>
</div>