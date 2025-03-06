<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4">
    <h2 class="mb-3">User List</h2>

    <a href="/admin/user/create" class="btn btn-success mb-3">Tambah Pengguna</a>
    <a href="<?= base_url("api/json/user") ?>" class="btn btn-success mb-3">Get JSON Data</a>

    <form action="<?= $baseUrl ?>" method="get" class="form-inline mb-3">
        <div class="row mb-4">
            <div class="col-md-5">
                <div class="input-group mr-2">
                    <input type="text" class="form-control" name="search" value="<?= $params->search ?>"
                        placeholder="Search...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="input-group ml-2">
                    <select name="role" class="form-select" onchange="this.form.submit()">
                        <option value="">All Role</option>
                        <option value="Admin" <?= ($params->role == "Admin") ? 'selected' : '' ?>>Admin</option>
                        <option value="User" <?= ($params->role == "User") ? 'selected' : '' ?>>User</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="input-group ml-2">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="Active" <?= ($params->role == "Active") ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= ($params->role == "Inactive") ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="input-group ml-2">
                    <select name="perPage" class="form-select" onchange="this.form.submit()">
                        <option value="5" <?= ($params->perPage == 5) ? 'selected' : '' ?>>
                            5 per Page
                        </option>
                        <option value="10" <?= ($params->perPage == 10) ? 'selected' : '' ?>>
                            10 per Page
                        </option>
                        <option value="25" <?= ($params->perPage == 25) ? 'selected' : '' ?>>
                            25 per Page
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-md-1">
                <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-secondary ml-2">
                    Reset
                </a>
            </div>

            <input type="hidden" name="sort" value="<?= $params->sort; ?>">
            <input type="hidden" name="order" value="<?= $params->order; ?>">

        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>
                        <a class="text-white text-decoration-none" href="<?= $params->getSortUrl('id', $baseUrl) ?>">
                            ID <?= $params->isSortedBy('id') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('username', $baseUrl) ?>">
                            Username <?= $params->isSortedBy('username') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none" href="<?= $params->getSortUrl('email', $baseUrl) ?>">
                            Email <?= $params->isSortedBy('email') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('full_name', $baseUrl) ?>">
                            Name <?= $params->isSortedBy('full_name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none" href="<?= $params->getSortUrl('role', $baseUrl) ?>">
                            Role <?= $params->isSortedBy('role') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('status', $baseUrl) ?>">
                            Status <?= $params->isSortedBy('status') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('last_login', $baseUrl) ?>">
                            Last Login <?= $params->isSortedBy('last_login') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
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
                        <td><?= $user->getLastLogin() ?></td>
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
        <?= $pager->links('users', 'custom_pager') ?>
        <div class="text-center mt-2">
            <small>Show <?= count($users) ?> of <?= $total ?> total data (Page
                <?= $params->page ?>)</small>
        </div>
    </div>
</div>

<?= $this->endSection() ?>