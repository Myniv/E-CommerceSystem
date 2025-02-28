<?= $this->extend('layout/master') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4 mb-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-3">
                <?= isset($user) ? 'Edit User' : 'Add User'; ?>
            </h4>
        </div>
        <div class="card-body">
            <form
                action="<?= isset($user) ? base_url('admin/user/update/' . $user->id) : base_url('admin/user/create') ?>"
                method="post">
                <?= csrf_field() ?>
                <?php if (isset($user)): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username"
                        class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                        value="<?= old('username', isset($user) ? $user->username : '') ?>">
                    <div class="invalid-feedback"><?= session('errors.username') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email"
                        class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                        value="<?= old('email', isset($user) ? $user->email : '') ?>">
                    <div class="invalid-feedback"><?= session('errors.email') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password"
                        class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" <?= isset($user) ? 'disabled' : '' ?>>
                    <div class="invalid-feedback"><?= session('errors.password') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" name="full_name"
                        class="form-control <?= session('errors.full_name') ? 'is-invalid' : '' ?>"
                        value="<?= old('full_name', isset($user) ? $user->full_name : '') ?>">
                    <div class="invalid-feedback"><?= session('errors.full_name') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>">
                        <option value="Admin" <?= old('role', isset($user) ? $user->role : '') == 'Admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="User" <?= old('role', isset($user) ? $user->role : '') == 'User' ? 'selected' : '' ?>>User</option>
                    </select>
                    <div class="invalid-feedback"><?= session('errors.role') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select <?= session('errors.status') ? 'is-invalid' : '' ?>">
                        <option value="Active" <?= old('status', isset($user) ? $user->status : '') == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= old('status', isset($user) ? $user->status : '') == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                    <div class="invalid-feedback"><?= session('errors.status') ?? '' ?></div>
                </div>

                <button type="submit" class="btn btn-success">Save User</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>