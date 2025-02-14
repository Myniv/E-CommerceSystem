<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-3">Produk List</h2>

    <a href="<?= base_url("api/product/new") ?>" class="btn btn-success mb-3">Tambah Produk</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td><?= $product->getId(); ?></td>
                        <td><?= $product->getNama(); ?></td>
                        <td>Rp <?= $product->getHarga() ?></td>
                        <td><?= $product->getStok(); ?></td>
                        <td><?= $product->getKategori(); ?></td>
                        <td>
                            <!-- <a href="/product/detail/<?= $product->getId(); ?>" class="btn btn-info btn-sm">Detail</a> -->
                            <a href="<?= route_to("product_details", $product->getId()) ?>"
                                class="btn btn-info btn-sm">Detail</a>
                            <a href="/api/product/<?= $product->getId(); ?>/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/api/product/<?= $product->getId(); ?>" method="post" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
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