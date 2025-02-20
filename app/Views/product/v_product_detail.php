<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-black text-white text-center">
                    <h4>Detail Produk</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>ID:</strong> <?= $products->getId() ?></li>
                        <li class="list-group-item"><strong>Nama:</strong> <?= $products->getNama() ?></li>
                        <li class="list-group-item"><strong>Stok:</strong> <?= $products->getStok() ?></li>
                        <li class="list-group-item">
                            <strong>Harga:</strong> Rp <?= number_format($products->getHarga(), 0, ',', '.') ?>
                        </li>
                        <li class="list-group-item"><strong>Kategori:</strong> <?= $products->getKategori() ?></li>
                        <li class="list-group-item"><strong>Status:</strong> <?= $products->getStatus() ?></li>
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