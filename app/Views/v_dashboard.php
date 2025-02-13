<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title bg-dark text-white p-2 rounded">
                    Total Products
                </h5>
                <h3 class="card-text">
                    <?= $product ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title bg-dark text-white p-2 rounded">
                    Total User
                </h5>
                <h3 class="card-text">
                    <?= $user ?>
                </h3>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>