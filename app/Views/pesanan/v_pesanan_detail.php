<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-black text-white text-center">
                    <h4>Detail Produk</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>ID:</strong> <?= $pesanan->getId() ?></li>
                        <div class="list-group-item">
                            <li class="list-group"><strong>Produk:</strong>
                                <?php foreach ($pesanan->getProduct() as $product) { ?>
                                <li class="ms-4">
                                    <?= "{$product->getProductName()} ({$product->getQuantity()}x) - Rp {$product->getTotalPrice()}<br>"; ?>
                                </li>
                            <?php } ?>
                            </li>
                        </div>
                        <li class="list-group-item">
                            <strong>Harga:</strong> Rp <?= $pesanan->getTotal() ?>
                        </li>
                        <li class="list-group-item"><strong>Status:</strong> <?= $pesanan->getStatus() ?></li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="/pesanan" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>