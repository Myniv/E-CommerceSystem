<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-3">User List</h2>

    <a href="/admin/user/create" class="btn btn-success mb-3">Tambah Pengguna</a>
    <a href="<?= base_url("api/json/user") ?>" class="btn btn-success mb-3">Get JSON Data</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?= $user->getId(); ?></td>
                        <td><?= $user->getName(); ?></td>
                        <td><?= $user->getUsername(); ?></td>
                        <td><?= $user->getPhone(); ?></td>
                        <td><?= $user->getEmail(); ?></td>
                        <td><?= $user->getAddress(); ?></td>
                        <td><?= $user->getSex(); ?></td>
                        <td><?= $user->getRole(); ?></td>
                        <td>
                            <a href="/admin/user/profile-parser/<?= $user->getId(); ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="/admin/user/update/<?= $user->getId(); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/user/delete/<?= $user->getId(); ?>" method="post" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    Hapus
                                </button>
                            </form>
                            <a href="/admin/user/role/<?= $user->getUsername(); ?>" class="btn btn-info btn-sm">Role</a>
                            <a href="/admin/user/settings/<?= $user->getName(); ?>" class="btn btn-info btn-sm">Settings</a>
                            <a href="/api/json/user/<?= $user->getId(); ?>" class="btn btn-info btn-sm">JSON By Id</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>