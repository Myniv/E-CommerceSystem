<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-3"><?= isset($products) ? 'Edit Produk' : 'Tambah Produk'; ?></h2>

            <form method="post"
                action="<?= isset($products) ? base_url('api/product/' . $products->getId()) : base_url('api/product'); ?>">
                <?php if (isset($products)) { ?>
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php } ?>
                <div class="mb-3">
                    <label class="form-label">Id:</label>
                    <input type="text" class="form-control" name="id"
                        value="<?= isset($products) ? $products->getId() : ''; ?>" <?= isset($products) ? 'readonly' : ''; ?> required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama:</label>
                    <input type="text" class="form-control" name="nama"
                        value="<?= isset($products) ? $products->getNama() : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga:</label>
                    <input type="number" class="form-control" name="harga"
                        value="<?= isset($products) ? $products->getHarga() : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok:</label>
                    <input type="number" class="form-control" name="stok"
                        value="<?= isset($products) ? $products->getStok() : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori:</label>
                    <input type="text" class="form-control" name="kategori"
                        value="<?= isset($products) ? $products->getKategori() : ''; ?>" required>
                </div>

                <button type="submit" class="btn btn-primary"><?= isset($products) ? 'Update' : 'Simpan'; ?></button>
                <a href=<?= base_url('api/product') ?> class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>