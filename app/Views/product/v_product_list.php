<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4">
    <h2 class="mb-3">Produk List</h2>

    <a href="<?= base_url("admin/product/new") ?>" class="btn btn-success mb-3">Tambah Produk</a>
    <a href="<?= base_url("api/json/product") ?>" class="btn btn-success mb-3">Get JSON Data</a>

    <form action="<?= $baseUrl ?>" method="get" class="form-inline mb-3">
        <div class="row mb-4">
            <div class="col-md-6">
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
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">All Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>" <?= ($params->filters['category_id'] == $category->id) ? 'selected' : '' ?>>
                                <?= ucfirst($category->name) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>


            <div class="col-md-2">
                <div class="input-group ml-2">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <?php foreach ($statuss as $status): ?>
                            <option value="<?= $status ?>" <?= ($params->filters['status'] == $status) ? 'selected' : '' ?>>
                                <?= ucfirst($status) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="input-group ml-2">
                    <select name="perPage" class="form-control" onchange="this.form.submit()">
                        <option value="10" <?= ($params->perPage == 10) ? 'selected' : '' ?>>
                            10 per halaman
                        </option>
                        <option value="25" <?= ($params->perPage == 25) ? 'selected' : '' ?>>
                            25 per halaman
                        </option>
                        <option value="50" <?= ($params->perPage == 50) ? 'selected' : '' ?>>
                            50 per halaman
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-md-1">
                <a href="<?= $params->getResetUrl($baseUrl) ?>" class="btn btn-secondary ml-2">
                    Reset
                </a>
            </div>

        </div>
    </form>


    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>
                        <a href="<?= $params->getSortUrl('id', $baseUrl) ?>">
                            ID <?= $params->isSortedBy('id') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th><a href="<?= $params->getSortUrl('name', $baseUrl) ?>">
                            Name <?= $params->isSortedBy('name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('description', $baseUrl) ?>">
                            Description <?= $params->isSortedBy('description') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('price', $baseUrl) ?>">
                            Price <?= $params->isSortedBy('price') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('stock', $baseUrl) ?>">
                            Stock <?= $params->isSortedBy('stock') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('category_name', $baseUrl) ?>">
                            Category <?= $params->isSortedBy('category_name') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('status', $baseUrl) ?>">
                            Status <?= $params->isSortedBy('status') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('is_new', $baseUrl) ?>">
                            Is New <?= $params->isSortedBy('is_new') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $params->getSortUrl('is_sale', $baseUrl) ?>">
                            Is Sale <?= $params->isSortedBy('is_sale') ? ($params->getSortDirection() == 'asc' ?
                                '↑' : '↓') : '' ?>
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
                        <td>
                            <!-- <a href="/product/detail/<?= $product->id; ?>" class="btn btn-info btn-sm">Detail</a> -->
                            <a href="<?= route_to("product_details", $product->id) ?>"
                                class="btn btn-info btn-sm">Detail</a>
                            <a href="/admin/product/<?= $product->id; ?>/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/product/<?= $product->id; ?>" method="post" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    Hapus
                                </button>
                            </form>
                            <a href="/api/json/product/<?= $product->id; ?>" class="btn btn-info btn-sm">JSON By Id</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?= $pager->links('products', 'custom_pager') ?>
        <div class="text-center mt-2">
            <small>Menampilkan <?= count($products) ?> dari <?= $total ?> total data (Halaman
                <?= $params->page_products ?>)</small>
        </div>

    </div>
</div>

<?= $this->endSection() ?>