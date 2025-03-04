<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4">
    <h2 class="mb-3">Produk List</h2>

    <a href="<?= base_url("admin/product/new") ?>" class="btn btn-success mb-3">Tambah Produk</a>
    <a href="<?= base_url("api/json/product") ?>" class="btn btn-success mb-3">Get JSON Data</a>


    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Is New</th>
                    <th>Is Sale</th>
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
        <div class="d-flex justify-content-center">
            <?= $pager->links('products', 'custom_pager') ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>