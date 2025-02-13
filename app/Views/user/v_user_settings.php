<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Settings</h2>

                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong>
                            <?= $user->getName(); ?>
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