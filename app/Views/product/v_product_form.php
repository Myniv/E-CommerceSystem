<h2><?= isset($products) ? 'Edit Produk' : 'Tambah Produk'; ?></h2>

<form method="post" action="<?= isset($products) ? '/product/edit' : '/product/add'; ?>">
    <input type="hidden" name="nim" value="<?= isset($products) ? $products->getId() : ''; ?>">

    <label>Id:</label>
    <input type="text" name="id" value="<?= isset($products) ? $products->getId() : ''; ?>" <?= isset($products) ? 'readonly' : ''; ?> required><br>

    <label>Nama:</label>
    <input type="text" name="nama" value="<?= isset($products) ? $products->getNama() : ''; ?>" required><br>

    <label>Harga:</label>
    <input type="number" name="harga" value="<?= isset($products) ? $products->getHarga() : ''; ?>" required><br>

    <label>Stok:</label>
    <input type="number" name="stok" value="<?= isset($products) ? $products->getStok() : ''; ?>" required><br>

    <label>kategori:</label>
    <input type="text" name="kategori" value="<?= isset($products) ? $products->getKategori() : ''; ?>" required><br>

    <button type="submit"><?= isset($products) ? 'Update' : 'Simpan'; ?></button>
</form>

<a href="/products">Kembali</a>