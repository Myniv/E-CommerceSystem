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
                            <?= $item->getNama(); ?> - Rp <?= $item->getHarga() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!isset($pesanan)): ?>
                    <button type="button" class="btn btn-success" onclick="addProduct()">Tambah Produk</button>
                <?php endif; ?>
            </div>
        </div>

        <h4 class="mt-3">Daftar Produk:</h4>
        <ul id="produkList" class="list-group mb-3"></ul>

        <?php if (isset($pesanan)): ?>
            <?php foreach ($pesanan->getProduct() as $product): ?>
                <li>
                    <?= "{$product['nama']} ({$product['quantity']}x) - Rp {$product['harga']}<br>"; ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>

        <input type="hidden" name="produk_ids" id="produkIds"
            value="<?= isset($pesanan) ? implode(',', array_map(fn($p) => "{$p['id']}:{$p['quantity']}", $pesanan->getProduct())) : ''; ?>">

        <div class="mb-3">
            <label class="form-label">Total:</label>
            <input type="text" class="form-control" name="total" required readonly
                value="<?= isset($pesanan) ? $pesanan->getTotal() : ''; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Status:</label>
            <select class="form-select" name="status" required>
                <?php
                $statuses = ['Pending', 'Completed', 'Cancelled'];
                $currentStatus = isset($pesanan) ? $pesanan->getStatus() : '';

                foreach ($statuses as $status):
                    ?>
                    <option value="<?= $status ?>" <?= ($status == $currentStatus) ? 'selected' : '' ?>>
                        <?= $status ?>
                    </option>
                <?php endforeach; ?>
            </select>
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

        // Check if product already exists
        let existingProduct = selectedProducts.find(p => p.id === productId);

        if (existingProduct) {
            existingProduct.quantity++;
            document.getElementById(`qty-${productId}`).textContent = existingProduct.quantity;
            document.getElementById(`price-${productId}`).textContent = `Rp ${existingProduct.quantity * productPrice}`;
        } else {
            let newProduct = { id: productId, nama: productName, harga: productPrice, quantity: 1 };
            selectedProducts.push(newProduct);

            const listItem = document.createElement("li");
            listItem.setAttribute("id", `product-${productId}`);
            listItem.innerHTML = `
                ${productName} - <span id="qty-${productId}">1</span>x 
                <span id="price-${productId}">Rp ${productPrice}</span>
                <button onclick="updateQuantity('${productId}', 1)" class="btn btn-sm btn-primary">+</button>
                <button onclick="updateQuantity('${productId}', -1)" class="btn btn-sm btn-warning">-</button>
                <button onclick="removeProduct('${productId}')" class="btn btn-sm btn-danger">Hapus</button>
            `;

            document.getElementById("produkList").appendChild(listItem);
        }

        updateTotalPrice();
        updateHiddenInput();
    }

    function updateQuantity(productId, change) {
        let product = selectedProducts.find(p => p.id === productId);
        if (!product) return;

        product.quantity += change;

        if (product.quantity <= 0) {
            removeProduct(productId);
        } else {
            document.getElementById(`qty-${productId}`).textContent = product.quantity;
            document.getElementById(`price-${productId}`).textContent = `Rp ${product.quantity * product.harga}`;
        }

        updateTotalPrice();
        updateHiddenInput();
    }

    function removeProduct(productId) {
        selectedProducts = selectedProducts.filter(p => p.id !== productId);
        document.getElementById(`product-${productId}`).remove();
        updateTotalPrice();
        updateHiddenInput();
    }

    function updateTotalPrice() {
        let totalHarga = selectedProducts.reduce((total, product) => total + (product.harga * product.quantity), 0);
        document.querySelector('input[name="total"]').value = totalHarga;
    }

    function updateHiddenInput() {
        document.getElementById("produkIds").value = selectedProducts.map(p => `${p.id}:${p.quantity}`).join(",");
    }
</script>

<?= $this->endSection() ?>