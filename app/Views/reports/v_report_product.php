<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>
<?php use Config\Roles; ?>

<div class="container mt-4">
    <h2 class="mb-3 d-flex justify-content-center">Product Reports</h2>

    <form action="<?= $baseUrl ?>" method="get" class="form-inline mb-3">

        <div class="row d-flex justify-content-between align-items-center">
            <!-- Left Side (Preview) -->
            <div class="col-auto">
                <h4>Preview :</h4>
            </div>

            <!-- Right Side (Filters & Buttons) -->
            <div class="col d-flex justify-content-end gap-2">
                <div class="col-md-3">
                    <div class="input-group">
                        <select name="category_id" class="form-select" onchange="this.form.submit()">
                            <option value="">All Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>" <?= ($params->category_id == $category->id) ? 'selected' : '' ?>>
                                    <?= ucfirst($category->name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-secondary input-group-text">
                            Reset
                        </a>
                    </div>
                </div>
                <div class="col-md-2 px-0">
                    <a href="<?= base_url('product/reports/excel') . '?' . http_build_query([
                        'category_id' => $params->category_id,
                    ]) ?>" class="btn btn-success w-100" target="_blank">
                        <i class="bi bi-file-excel me-1"></i> Export PDF
                    </a>
                </div>
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
                    Name
                </th>
                <th>
                    Description
                </th>
                <th>
                    Price
                </th>
                <th>
                    Stock
                </th>
                <th>
                    Category
                </th>
                <th>
                    Status
                </th>
                <th>
                    Is New
                </th>
                <th>
                    Is Sale
                </th>
                <th>
                    Created At
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data yang ditemukan</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td><?= $product->id ?></td>
                        <td><?= $product->name ?></td>
                        <td><?= $product->description ?></td>
                        <td><?= $product->getFormattedPrice() ?></td>
                        <td><?= $product->stock ?></td>
                        <td><?= $product->category_name; ?></td>
                        <td><?= $product->status; ?></td>
                        <td><?= $product->is_new; ?></td>
                        <td><?= $product->is_sale; ?></td>
                        <td><?= $product->created_at->humanize(); ?></td>
                    </tr>
                <?php } ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?= $pager->links('products', 'custom_pager') ?>
    <div class="text-center mt-2">
        <small>Show <?= count($products) ?> of <?= $total ?> total data (Page
            <?= $params->page ?>)</small>
    </div>

</div>
</div>

<?= $this->endSection() ?>