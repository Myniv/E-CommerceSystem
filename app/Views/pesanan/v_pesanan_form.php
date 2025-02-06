<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-3"><?= isset($pesanan) ? 'Edit Pesanan' : 'Tambah Pesanan'; ?></h2>

    <form method="post" action="<?= isset($pesanan) ? '/pesanan/edit' : '/pesanan/add'; ?>" class="mb-3">
        <input type="hidden" name="nim" value="<?= isset($pesanan) ? $pesanan->getId() : ''; ?>">

        <div class="mb-3">
            <label class="form-label">Id:</label>
            <input type="text" class="form-control" name="id" value="<?= isset($pesanan) ? $pesanan->getId() : ''; ?>"
                <?= isset($pesanan) ? 'readonly' : ''; ?> required>
        </div>

        <div class="mb-3">
            <label class="form-label">Produk:</label>
            <div class="input-group">
                <select id="produkSelect" class="form-select">
                    <?php foreach ($produk as $item): ?>
                        <option value="<?= $item->getId(); ?>" data-nama="<?= $item->getNama(); ?>"
                            data-harga="<?= $item->getHarga(); ?>">
                            <?= $item->getNama(); ?> - Rp <?= number_format($item->getHarga(), 2); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="btn btn-success" onclick="addProduct()">Tambah Produk</button>
            </div>
        </div>

        <h4 class="mt-3">Daftar Produk:</h4>
        <ul id="produkList" class="list-group mb-3"></ul>

        <input type="hidden" name="produk_ids" id="produkIds" value="">

        <div class="mb-3">
            <label class="form-label">Total:</label>
            <input type="text" class="form-control" name="total" required readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Status:</label>
            <input type="text" class="form-control" name="status" required>
        </div>

        <button type="submit" class="btn btn-primary"><?= isset($pesanan) ? 'Update' : 'Simpan'; ?></button>
        <a href="/pesanan" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<script>
    let selectedProducts = [];

    function addProduct() {
        const select = document.getElementById("produkSelect");
        const selectedOption = select.options[select.selectedIndex];
        const productId = selectedOption.value;
        const productName = selectedOption.getAttribute("data-nama");
        const productPrice = parseFloat(selectedOption.getAttribute("data-harga"));

        selectedProducts.push({ id: productId, harga: productPrice });

        const listItem = document.createElement("li");
        listItem.textContent = `${productName} - Rp ${productPrice}`;
        document.getElementById("produkList").appendChild(listItem);

        updateTotalPrice();

        document.getElementById("produkIds").value = selectedProducts.map(p => p.id).join(",");
    }

    function updateTotalPrice() {
        let totalHarga = selectedProducts.reduce((total, product) => total + product.harga, 0);
        document.querySelector('input[name="total"]').value = totalHarga;
    }
</script>

<?= $this->endSection() ?>