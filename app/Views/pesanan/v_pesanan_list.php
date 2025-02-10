<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-3">Pesanan List</h2>
    <a href="/pesanan/create" class="btn btn-success mb-3">Tambah Pesanan</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pesanan as $item) { ?>
                    <tr>
                        <td><?= $item->getId(); ?></td>
                        <td>
                            <?php foreach ($item->getProduct() as $product) { ?>
                                <?= "{$product->getProductName()} ({$product->getQuantity()}x) - Rp {$product->getTotalPrice()}<br>"; ?>
                            <?php } ?>
                        </td>
                        <td>Rp <?= $item->getTotal() ?></td>
                        <td>
                            <span>
                                <?= $item->getStatus(); ?>
                            </span>
                        </td>
                        <td>
                            <a href="/pesanan/detail/<?= $item->getId(); ?>" class="btn btn-primary btn-sm">Detail</a>
                            <a href="/pesanan/edit/<?= $item->getId(); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/pesanan/delete/<?= $item->getId(); ?>" method="post" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>