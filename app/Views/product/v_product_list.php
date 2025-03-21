<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>
<?php use Config\Roles; ?>

<div class="container mt-4">
    <h2 class="mb-3">Produk List</h2>

    <a href="<?= base_url("product/new") ?>" class="btn btn-success mb-3">Add Products</a>
    <?php if(in_groups(Roles::ADMIN)):?>
    <a href="<?= base_url("api/json/product") ?>" class="btn btn-success mb-3">Get JSON Data</a>
    <?php endif?>

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
                    <select name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>" <?= ($params->category_id == $category->id) ? 'selected' : '' ?>>
                                <?= ucfirst($category->name) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>


            <div class="col-md-2">
                <div class="input-group ml-2">
                    <select name="price_range" class="form-select" onchange="this.form.submit()">
                        <option value="">All Price</option>
                        <option value="0-50000" <?= ($params->price_range == "0-50000") ? 'selected' : '' ?>>Rp 0 - Rp
                            49.999</option>
                        <option value="50000-100000" <?= ($params->price_range == "50000-100000") ? 'selected' : '' ?>>Rp
                            50.000 - Rp 99.999</option>
                        <option value="100000-500000" <?= ($params->price_range == "100000-500000") ? 'selected' : '' ?>>Rp
                            100.000 - Rp 499.999</option>
                        <option value="500000-1000000" <?= ($params->price_range == "500000-1000000") ? 'selected' : '' ?>>
                            Rp 500.000 - Rp 999.999</option>
                        <option value="1000000" <?= ($params->price_range == "1000000") ? 'selected' : '' ?>>> Rp
                            1.000.000</option>
                    </select>
                </div>
            </div>


            <div class="col-md-2">
                <div class="input-group ml-2">
                    <select name="perPage" class="form-select" onchange="this.form.submit()">
                        <option value="2" <?= ($params->perPage == 2) ? 'selected' : '' ?>>
                            2 per Page
                        </option>
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
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none" href="<?= $params->getSortUrl('name', $baseUrl) ?>">
                            Name <?= $params->isSortedBy('name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('description', $baseUrl) ?>">
                            Description <?= $params->isSortedBy('description') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none" href="<?= $params->getSortUrl('price', $baseUrl) ?>">
                            Price <?= $params->isSortedBy('price') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none" href="<?= $params->getSortUrl('stock', $baseUrl) ?>">
                            Stock <?= $params->isSortedBy('stock') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('category_name', $baseUrl) ?>">
                            Category <?= $params->isSortedBy('category_name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('status', $baseUrl) ?>">
                            Status <?= $params->isSortedBy('status') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('is_new', $baseUrl) ?>">
                            Is New <?= $params->isSortedBy('is_new') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('is_sale', $baseUrl) ?>">
                            Is Sale <?= $params->isSortedBy('is_sale') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>
                        <a class="text-white text-decoration-none"
                            href="<?= $params->getSortUrl('created_at', $baseUrl) ?>">
                            Created At <?= $params->isSortedBy('created_at') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '↕' ?>
                        </a>
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
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
                        <td>
                            <a href="<?= route_to("product_details", $product->id) ?>"
                                class="btn btn-info btn-sm">Detail</a>
                            <a href="/product/<?= $product->id; ?>/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/product/<?= $product->id; ?>" method="post" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure want to delete this product?');">
                                    Delete
                                </button>
                            </form>
                            <?php if(in_groups(Roles::ADMIN)):?>
                                <a href="/api/json/product/<?= $product->id; ?>" class="btn btn-info btn-sm">JSON By Id</a>
                            <?php endif?>
                            <a href="/product/<?= $product->id; ?>/image" class="btn btn-success btn-sm">Add Image</a>
                        </td>
                    </tr>
                <?php } ?>
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