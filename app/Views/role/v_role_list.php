<?= $this->extend('layout/master'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <h2 class="mb-3">Role List</h2>

    <div class="mb-3">
        <a href="<?= base_url('admin/roles/create'); ?>" class="btn btn-success">Add New User</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($roles as $role): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $role->name; ?></td>
                        <td><?= $role->description; ?></td>
                        <td>
                            <a href="<?= base_url('admin/roles/update/' . $role->id); ?>"
                                class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/roles/delete/' . $role->id); ?>" method="post"
                                class="d-inline" onsubmit="return confirm('Are you sure want to delete this role?')">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($roles)): ?>
                    <tr>
                        <td colspan="6" class="text-center">No Users Data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>