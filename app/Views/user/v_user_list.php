<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4">
    <h2 class="mb-3">User List</h2>

    <a href="/admin/user/create" class="btn btn-success mb-3">Tambah Pengguna</a>
    <a href="<?= base_url("api/json/user") ?>" class="btn btn-success mb-3">Get JSON Data</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <!-- <th>Password</th> -->
                    <th>Name</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->email ?></td>
                        <!-- <td><?= $user->password ?></td> -->
                        <td><?= $user->full_name ?></td>
                        <td><?= $user->role ?></td>
                        <td><?= $user->status ?></td>
                        <td><?= $user->last_login ?></td>
                        <td>
                            <a href="/admin/user/profile-parser/<?= $user->id ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="/admin/user/update/<?= $user->id ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/user/delete/<?= $user->id ?>" method="post" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure want to delete this user?');">
                                    Delete
                                </button>
                            </form>
                            <!-- <a href="/admin/user/role/<?= $user->username ?>" class="btn btn-info btn-sm">Role</a>
                            <a href="/admin/user/settings/<?= $user->full_name ?>" class="btn btn-info btn-sm">Settings</a> -->
                            <a href="/api/json/user/<?= $user->id ?>" class="btn btn-info btn-sm">JSON By Id</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>