<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-3"><?= isset($products) ? 'Edit Produk' : 'Tambah Produk'; ?></h2>

            <form method="post"
                action="<?= isset($products) ? base_url('admin/product/' . $products->getId()) : base_url('admin/product'); ?>">
                <?php if (isset($products)) { ?>
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php } ?>

                <div class="mb-3">
                    <label class="form-label">Id:</label>
                    <input type="text" class="form-control" name="id"
                        value="<?= isset($products) ? $products->getId() : ''; ?>" <?= isset($products) ? 'readonly' : ''; ?>
                        required>
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
                    <div class="input-group">
                        <select id="categorySelect" class="form-select">
                            <option value="Food">Food</option>
                            <option value="Clothes">Clothes</option>
                            <option value="Electronics">Electronics</option>
                        </select>
                        <button type="button" class="btn btn-success" onclick="addCategory()">Tambah Kategori</button>
                    </div>
                </div>

                <h4 class="mt-3">Kategori Terpilih:</h4>
                <ul id="categoryList" class="list-group mb-3">
                    <?php
                    $selectedCategories = isset($products) ? $products->getKategori() : [];
                    foreach ($selectedCategories as $category): ?>
                        <li class="list-group-item d-flex justify-content-between" id="category-<?= $category ?>">
                            <?= $category ?>
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="removeCategory('<?= $category ?>')">Hapus</button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <input type="hidden" name="kategori" id="categoryInput"
                    value="<?= isset($products) ? implode(',', $selectedCategories) : ''; ?>">

                <div class="mb-3">
                    <label class="form-label">Status:</label>
                    <select class="form-control" name="status" required>
                        <option value="Active" <?= isset($products) && $products->getStatus() == 'Active' ? 'selected' : ''; ?>>
                            Active</option>
                        <option value="Inactive" <?= isset($products) && $products->getStatus() == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><?= isset($products) ? 'Update' : 'Simpan'; ?></button>
                <a href="<?= base_url('admin/product') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script>
    let selectedCategories = "<?= isset($products) ? implode(',', $selectedCategories) : ''; ?>".split(',').filter(Boolean);

    function addCategory() {
        const select = document.getElementById("categorySelect");
        const category = select.value;

        if (!selectedCategories.includes(category)) {
            selectedCategories.push(category);

            const listItem = document.createElement("li");
            listItem.classList.add("list-group-item", "d-flex", "justify-content-between");
            listItem.setAttribute("id", `category-${category}`);
            listItem.innerHTML = `
                ${category} 
                <button type="button" class="btn btn-danger btn-sm" onclick="removeCategory('${category}')">Hapus</button>
            `;

            document.getElementById("categoryList").appendChild(listItem);
            updateHiddenInput();
        }
    }

    function removeCategory(category) {
        selectedCategories = selectedCategories.filter(cat => cat !== category);
        document.getElementById(`category-${category}`).remove();
        updateHiddenInput();
    }

    function updateHiddenInput() {
        document.getElementById("categoryInput").value = selectedCategories.join(",");
    }
</script>

<?= $this->endSection() ?>