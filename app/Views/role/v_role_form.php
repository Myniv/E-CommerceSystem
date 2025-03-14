<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4 mb-4">
    <?= view_cell('BackCell') ?>
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-3">
                <?= isset($role) ? 'Edit roles' : 'Add User'; ?>
            </h4>
        </div>
        <div class="card-body">
            <form
                action="<?= isset($role) ? base_url('admin/roles/update/' . $role->id) : base_url('admin/roles/create') ?>"
                method="post" id="formData" novalidate>
                <?= csrf_field() ?>
                <?php if (isset($user)): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name"
                        class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>"
                        value="<?= old('name', isset($role) ? $role->name : '') ?>">
                    <div class="text-danger"><?= session('errors.name') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description"
                        class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>"
                        value="<?= old('description', isset($role) ? $role->description : '') ?>">
                    <div class="text-danger"><?= session('errors.description') ?? '' ?></div>
                </div>

                <button type="submit" class="btn btn-success">Save Role</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>