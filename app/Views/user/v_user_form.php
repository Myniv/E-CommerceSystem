<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>


<div class="container mt-4 mb-4">
    <?= view_cell('BackCell') ?>
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-3">
                <?= isset($user) ? 'Edit User' : 'Add User'; ?>
            </h4>
        </div>
        <div class="card-body">
            <form <?php if (in_groups('Administrator')): ?>
                    action="<?= isset($user) ? base_url('admin/customer/update/' . $user->id) : base_url('admin/customer/create') ?>"
                <?php endif; ?> <?php if (in_groups('Customer')): ?>
                    action="<?= base_url('profile/edit') ?>"
                <?php endif; ?> 
                method="post" id="formData" novalidate>
                <?= csrf_field() ?>
                <?php if (isset($user)): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username"
                        class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                        value="<?= old('username', isset($user) ? $user->username : '') ?>" data-pristine-required
                        data-pristine-required-message="The username field is required." data-pristine-minlength="3"
                        data-pristine-minlength-message="The username must be at least 3 characters long."
                        data-pristine-maxlength="255"
                        data-pristine-maxlength-message="The username cannot exceed 255 characters." <?= isset($user) ? 'disabled' : '' ?>>
                    <div class="text-danger"><?= session('errors.username') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email"
                        class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                        value="<?= old('email', isset($user) ? $user->email : '') ?>" data-pristine-required
                        data-pristine-required-message="The email field is required."
                        data-pristine-type-message="Please enter a valid email address." data-pristine-maxlength="255"
                        data-pristine-maxlength-message="Email cannot exceed 255 characters." <?= isset($user) ? 'disabled' : '' ?>>
                    <div class="text-danger"><?= session('errors.email') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password"
                        class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>"
                        value="<?= old('password', isset($user) ? $user->password : '') ?>" <?= old('password', isset($user) ? $user->password : '') ? 'disabled' : '' ?> data-pristine-required
                        data-pristine-required-message="The password field is required." data-pristine-minlength="8"
                        data-pristine-minlength-message="The password must be at least 8 characters long."
                        data-pristine-maxlength="255"
                        data-pristine-maxlength-message="The password cannot exceed 255 characters.">
                    <div class="text-danger"><?= session('errors.password') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" name="full_name"
                        class="form-control <?= session('errors.full_name') ? 'is-invalid' : '' ?>"
                        value="<?= old('full_name', isset($user) ? $user->full_name : '') ?>" data-pristine-required
                        data-pristine-required-message="The full name field is required." data-pristine-minlength="3"
                        data-pristine-minlength-message="The full name must be at least 3 characters long."
                        data-pristine-maxlength="255"
                        data-pristine-maxlength-message="The full name cannot exceed 255 characters.">
                    <div class="text-danger"><?= session('errors.full_name') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>"
                        data-pristine-required data-pristine-required-message="The role field is required.">
                        >
                        <option value="" <?= old('role', isset($user) ? $user->role : '') ? 'disabled' : '' ?>
                            data-pristine-required data-pristine-required-message="The role field is required.">Select
                            Role</option>
                        <option value="Customer" <?= old('role', isset($user) ? $user->role : '') == 'Admin' ? 'selected' : '' ?>>Customer</option>
                    </select>
                    <div class="text-danger"><?= session('errors.role') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select <?= session('errors.status') ? 'is-invalid' : '' ?>"
                        data-pristine-required data-pristine-required-message="The status field is required.">
                        <option value="" <?= old('status', isset($user) ? $user->status : '') ? 'disabled' : '' ?>>Select
                            Status</option>
                        <option value="Active" <?= old('status', isset($user) ? $user->status : '') == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= old('status', isset($user) ? $user->status : '') == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                    <div class="text-danger"><?= session('errors.status') ?? '' ?></div>
                </div>

                <button type="submit" class="btn btn-success">Save User</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let pristine;
    window.onload = function () {
        let form = document.getElementById("formData");

        var pristine = new Pristine(form, {
            classTo: 'mb-3',
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorTextParent: 'mb-3',
            errorTextTag: 'div',
            errorTextClass: 'text-danger'
        });


        form.addEventListener('submit', function (e) {
            var valid = pristine.validate();
            if (!valid) {
                e.preventDefault();
            }
        });

    };
</script>

<?= $this->endSection() ?>