<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<h3 class="text-center"> <strong>Dashboard</strong></h3>

<h4> <strong>User Statistics</strong></h4>
<div class="mb-3">

    <div class="row">
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title bg-dark text-white p-2 rounded">
                        Total User
                    </h5>
                    <h3 class="card-text">
                        <?= $user_total ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title bg-dark text-white p-2 rounded">
                        Growth Percentage
                    </h5>
                    <h3 class="card-text">
                        <?= $user_growth ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title bg-dark text-white p-2 rounded">
                        New Users
                    </h5>
                    <div class="card-text">
                        <table class="table table-sm  table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_new as $item): ?>
                                    <tr>
                                        <td><?= $item->id ?></td>
                                        <td><?= $item->full_name ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title bg-dark text-white p-2 rounded">
                        Active Users
                    </h5>
                    <div class="card-text">
                        <table class="table table-sm table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_active as $item): ?>
                                    <tr>
                                        <td><?= $item->id ?></td>
                                        <td><?= $item->full_name ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <h4> <strong>Product Statistics</strong></h4>
    <div class="row">
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title bg-dark text-white p-2 rounded">
                        Total Products
                    </h5>
                    <h3 class="card-text">
                        <?= $product_total ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title bg-dark text-white p-2 rounded">
                        On Sale
                    </h5>
                    <div class="card-text">
                        <table class="table table-sm table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Name</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($product_onsale as $item): ?>
                                    <tr>
                                        <td><?= $item->name ?></td>
                                        <td><?= $item->stock ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title bg-dark text-white p-2 rounded">
                        Out of Stocks
                    </h5>
                    <div class="card-text">
                        <table class="table table-sm table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Name</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($product_outofstock as $item): ?>
                                    <tr>
                                        <td><?= $item->name ?></td>
                                        <td><?= $item->stock ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title bg-dark text-white p-2 rounded">
                        Active Products
                    </h5>
                    <div class="card-text">
                        <table class="table table-sm  table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($product_active as $item): ?>
                                    <tr>
                                        <td><?= $item->id ?></td>
                                        <td><?= $item->name ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>