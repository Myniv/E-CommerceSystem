<h2><?= isset($pesanan) ? 'Edit Pesanan' : 'Tambah Pesanan'; ?></h2>

<form method="post" action="<?= isset($pesanan) ? '/pesanan/edit' : '/pesanan/add'; ?>">
    <input type="hidden" name="nim" value="<?= isset($pesanan) ? $pesanan->getId() : ''; ?>">

    <label>Id:</label>
    <input type="text" name="id" value="<?= isset($pesanan) ? $pesanan->getId() : ''; ?>" <?= isset($pesanan) ? 'readonly' : ''; ?> required><br>

    <label>Produk:</label>
    <select id="produkSelect">
        <?php foreach ($produk as $item): ?>
            <option value="<?= $item->getId(); ?>" data-nama="<?= $item->getNama(); ?>"
                data-harga="<?= $item->getHarga(); ?>">
                <?= $item->getNama(); ?> - <?= $item->getHarga(); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="button" onclick="addProduct()">Tambah Produk</button>

    <h3>Daftar Produk:</h3>
    <ul id="produkList"></ul>

    <!-- Hidden input to store selected product IDs -->
    <input type="hidden" name="produk_ids" id="produkIds" value="">

    <label>Total:</label>
    <input type="text" name="total" required><br>

    <label>Status:</label>
    <input type="text" name="status" required><br>

    <button type="submit"><?= isset($pesanan) ? 'Update' : 'Simpan'; ?></button>
</form>

<a href="/pesanan">Kembali</a>

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