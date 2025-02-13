<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-3"><?= isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna'; ?></h2>

            <form method="post"
                action="<?= isset($user) ? base_url('/admin/user/update/' . $user->getId()) : base_url('/admin/user/create') ?>">
                <?php if (isset($user)) { ?>
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php } ?>

                <div class="mb-3">
                    <label class="form-label">ID:</label>
                    <input type="number" class="form-control" name="id"
                        value="<?= isset($user) ? $user->getId() : ''; ?>" <?= isset($user) ? 'readonly' : ''; ?>
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama:</label>
                    <input type="text" class="form-control" name="name"
                        value="<?= isset($user) ? $user->getName() : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon:</label>
                    <input type="number" class="form-control" name="phone"
                        value="<?= isset($user) ? $user->getPhone() : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email"
                        value="<?= isset($user) ? $user->getEmail() : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat:</label>
                    <textarea class="form-control" name="address"
                        required><?= isset($user) ? $user->getAddress() : ''; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin:</label>
                    <select class="form-select" name="sex" required>
                        <option value="male" <?= isset($user) && $user->getSex() == 'Male' ? 'selected' : ''; ?>>Laki-laki
                        </option>
                        <option value="female" <?= isset($user) && $user->getSex() == 'Female' ? 'selected' : ''; ?>>
                            Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role:</label>
                    <select class="form-select" name="role" required>
                        <option value="admin" <?= isset($user) && $user->getRole() == 'Admin' ? 'selected' : ''; ?>>Admin
                        </option>
                        <option value="user" <?= isset($user) && $user->getRole() == 'User' ? 'selected' : ''; ?>>User
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><?= isset($user) ? 'Update' : 'Simpan'; ?></button>
                <a href="/admin/user" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>