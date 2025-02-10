<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-3"><?= isset($pesanan) ? 'Edit Pesanan' : 'Tambah Pesanan'; ?></h2>

    <form method="post" action="<?= isset($pesanan) ? '/pesanan/edit' : '/pesanan/add'; ?>" class="mb-3">
        <input type="hidden" name="id" value="<?= isset($pesanan) ? $pesanan->getId() : ''; ?>">

        <!-- Order ID -->
        <div class="mb-3">
            <label class="form-label">ID Pesanan:</label>
            <input type="text" class="form-control" value="<?= isset($pesanan) ? $pesanan->getId() : ''; ?>" name="id">
        </div>

        <!-- Product Selection -->
        <div class="mb-3">
            <label class="form-label">Pilih Produk:</label>
            <div class="input-group">
                <select id="produkSelect" class="form-select">
                    <?php foreach ($produk as $item): ?>
                        <option value="<?= $item->getId(); ?>" data-nama="<?= $item->getNama(); ?>"
                            data-harga="<?= $item->getHarga(); ?>">
                            <?= $item->getNama(); ?> - Rp <?= number_format($item->getHarga(), 0, ',', '.'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!isset($pesanan)) { ?>
                    <button type="button" class="btn btn-success" onclick="addProduct()">Tambah Produk</button>
                <?php } ?>
            </div>
        </div>

        <!-- Product List -->
        <h4 class="mt-3">Daftar Produk:</h4>
        <ul id="produkList" class="list-group mb-3">
            <?php if (isset($pesanan)): ?>
                <?php foreach ($pesanan->getProduct() as $product): ?>
                    <li class="list-group-item d-flex " id="product-<?= $product->getId(); ?>">
                        <?= $product->getProductName(); ?> - <span
                            id="qty-<?= $product->getId(); ?>"><?= $product->getQuantity(); ?></span>x
                        Rp <span
                            id="price-<?= $product->getId(); ?>"><?= number_format($product->getTotalPrice(), 0, ',', '.'); ?></span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <!-- Hidden Input for Products -->
        <input type="hidden" name="produk_ids" id="produkIds"
            value="<?= isset($pesanan) ? implode(',', array_map(fn($p) => "{$p->getId()}:{$p->getQuantity()}", $pesanan->getProduct())) : ''; ?>">

        <!-- Total Price -->
        <div class="mb-3">
            <label class="form-label">Total Harga:</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control" name="total" id="totalPrice" readonly
                    value="<?= isset($pesanan) ? number_format((int) $pesanan->getTotal(), 0, ',', '.') : '0'; ?>">
            </div>
        </div>


        <!-- Order Status -->
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

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary"><?= isset($pesanan) ? 'Update' : 'Simpan'; ?></button>
        <a href="/pesanan" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<!-- JavaScript to Manage Products -->
<script>
    let selectedProducts = <?= isset($pesanan) ? json_encode(array_map(fn($p) => [
        'id' => $p->getId(),
        'nama' => $p->getProductName(),
        'harga' => $p->getPrice(),
        'quantity' => $p->getQuantity()
    ], $pesanan->getProduct())) : '[]'; ?>;

    function addProduct() {
        const select = document.getElementById("produkSelect");
        const selectedOption = select.options[select.selectedIndex];

        const productId = selectedOption.value;
        const productName = selectedOption.getAttribute("data-nama");
        const productPrice = parseFloat(selectedOption.getAttribute("data-harga"));

        let existingProduct = selectedProducts.find(p => p.id === productId);

        if (existingProduct) {
            existingProduct.quantity++;
            document.getElementById(`qty-${productId}`).textContent = existingProduct.quantity;
            document.getElementById(`price-${productId}`).textContent = `${existingProduct.quantity * productPrice}`;
        } else {
            let newProduct = { id: productId, nama: productName, harga: productPrice, quantity: 1 };
            selectedProducts.push(newProduct);

            const listItem = document.createElement("li");
            listItem.classList.add("list-group-item", "d-flex");
            listItem.setAttribute("id", `product-${productId}`);
            listItem.innerHTML = `
                ${productName} - <span id="qty-${productId}">1</span>x 
                Rp <span id="price-${productId}">${productPrice}</span>
                <div>
                    <button onclick="updateQuantity('${productId}', 1)" class="btn btn-sm btn-primary ms-2">+</button>
                    <button onclick="updateQuantity('${productId}', -1)" class="btn btn-sm btn-warning">-</button>
                    <button onclick="removeProduct('${productId}')" class="btn btn-sm btn-danger">Hapus</button>
                </div>
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
        document.getElementById("totalPrice").value = `${totalHarga}`;
    }

    function updateHiddenInput() {
        document.getElementById("produkIds").value = selectedProducts.map(p => `${p.id}:${p.quantity}`).join(",");
    }
</script>

<?= $this->endSection() ?>