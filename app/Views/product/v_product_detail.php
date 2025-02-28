<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-black text-white text-center">
                    <h4>Detail Produk</h4>
                </div>
                <div class="card-body">
                    <img src="<?= isset($products->image_path) ? base_url($products->image_path) : base_url("products/search-image.svg") ?>"
                        class="card-img-top" alt="<?= isset($products->name) ? $products->name : "Product" ?>"
                        style="height: 200px; object-fit: cover;">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>ID:</strong> <?= $products->id ?></li>
                        <li class="list-group-item"><strong>Nama:</strong> <?= $products->name ?></li>
                        <li class="list-group-item"><strong>Stok:</strong> <?= $products->stock ?></li>
                        <li class="list-group-item">
                            <strong>Price:</strong> <?= $products->getFormattedPrice() ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Category:</strong> <?= $products->category_name ?>
                        </li>
                        <li class="list-group-item"><strong>Status:</strong> <?= $products->status ?></li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="/admin/product" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>