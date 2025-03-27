<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4">
    <?= view_cell('BackCell', ['backLink' => 'admin/users']) ?>
    <h2 class="mb-3 d-flex justify-content-center">User Reports</h2>

    <form action="<?= $baseUrl ?>" method="get" class="form-inline mb-3">

        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <h4>Preview :</h4>
            </div>

            <div class="col d-flex justify-content-end gap-2">
                <div class="col-md-3">
                    <div class="input-group">
                        <label class="input-group-text">Filter</label>
                        <select class="form-select <?= session('errors.group') ? 'is-invalid' : '' ?>" name="role"
                            id="role" required onchange="this.form.submit()">
                            <option value="">All Role</option>
                            <?php foreach ($groups as $group): ?>
                                <option value=" <?= $group->id ?>" <?= $params->role == $group->id ? 'selected' : '' ?>>
                                    <?= $group->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-secondary input-group-text">
                            Reset
                        </a>
                    </div>
                </div>
                <div class="col-md-2 px-0">
                    <a href="<?= base_url('admin/users/reports/pdf') . '?' . http_build_query([
                        'role' => $params->role,
                    ]) ?>" class="btn btn-success w-100" target="_blank">
                        <i class="bi bi-file-excel me-1"></i> Export Pdf
                    </a>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Username
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Role
                    </th>
                    <th>
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->full_name ?></td>
                        <td>
                            <?php
                            $groupModel = new \Myth\Auth\Models\GroupModel();
                            $groups = $groupModel->getGroupsForUser($user->id);
                            foreach ($groups as $group) {
                                echo '<span class="badge bg-info me-1">' . $group['name'] . '</span>';
                            }
                            ?>
                        </td>
                        <td><?= $user->status ?></td>
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