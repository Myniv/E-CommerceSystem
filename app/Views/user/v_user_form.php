<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

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
                        value="<?= isset($user) ? $user->getId() : ''; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama:</label>
                    <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                        name="name" value="<?= isset($user) ? $user->getName() : ''; ?>" required>
                    <?php if (isset($errors['name'])): ?>
                        <div class="invalid-feedback"> <?= esc($errors['name']) ?> </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username:</label>
                    <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                        name="username" value="<?= isset($user) ? $user->getUsername() : ''; ?>" required>
                    <?php if (isset($errors['username'])): ?>
                        <div class="invalid-feedback"> <?= esc($errors['username']) ?> </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon:</label>
                    <input type="number" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                        name="phone" value="<?= isset($user) ? $user->getPhone() : ''; ?>" required>
                    <?php if (isset($errors['phone'])): ?>
                        <div class="invalid-feedback"> <?= esc($errors['phone']) ?> </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                        name="email" value="<?= isset($user) ? $user->getEmail() : ''; ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"> <?= esc($errors['email']) ?> </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat:</label>
                    <textarea class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>" name="address"
                        required><?= isset($user) ? $user->getAddress() : ''; ?></textarea>
                    <?php if (isset($errors['address'])): ?>
                        <div class="invalid-feedback"> <?= esc($errors['address']) ?> </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin:</label>
                    <select class="form-select <?= isset($errors['sex']) ? 'is-invalid' : '' ?>" name="sex" required>
                        <option value="male" <?= isset($user) && $user->getSex() == 'Male' ? 'selected' : ''; ?>>Laki-laki
                        </option>
                        <option value="female" <?= isset($user) && $user->getSex() == 'Female' ? 'selected' : ''; ?>>
                            Perempuan</option>
                    </select>
                    <?php if (isset($errors['sex'])): ?>
                        <div class="invalid-feedback"> <?= esc($errors['sex']) ?> </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role:</label>
                    <select class="form-select <?= isset($errors['role']) ? 'is-invalid' : '' ?>" name="role" required>
                        <option value="admin" <?= isset($user) && $user->getRole() == 'Admin' ? 'selected' : ''; ?>>Admin
                        </option>
                        <option value="user" <?= isset($user) && $user->getRole() == 'User' ? 'selected' : ''; ?>>User
                        </option>
                    </select>
                    <?php if (isset($errors['role'])): ?>
                        <div class="invalid-feedback"> <?= esc($errors['role']) ?> </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary"><?= isset($user) ? 'Update' : 'Simpan'; ?></button>
                <a href="/admin/user" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>