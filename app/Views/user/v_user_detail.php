<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Detail Profil</h2>

                    <ul class="list-group">
                        <li class="list-group-item"><strong>ID:</strong> <?= $user->getId(); ?></li>
                        <li class="list-group-item"><strong>Nama:</strong> <?= $user->getName(); ?></li>
                        <li class="list-group-item"><strong>Username:</strong> <?= $user->getUsername(); ?></li>
                        <li class="list-group-item"><strong>Telepon:</strong> <?= $user->getPhone(); ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?= $user->getEmail(); ?></li>
                        <li class="list-group-item"><strong>Alamat:</strong> <?= $user->getAddress(); ?></li>
                        <li class="list-group-item"><strong>Jenis Kelamin:</strong>
                            <?= $user->getSex() == 'male' ? 'Laki-laki' : 'Perempuan'; ?>
                        </li>
                        <li class="list-group-item"><strong>Role:</strong>
                            <?= $user->getRole(); ?>
                        </li>
                    </ul>

                    <div class="text-center mt-4">
                        <a href="/admin/user" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>