<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<?php isset($errors) ?: $errors = []; ?>
<?php foreach ($errors as $error): ?>
    <li><?= esc($error) ?></li>
<?php endforeach ?>
<?= view_cell('BackCell') ?>
<div class="container mt-4 mb-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-3">
                <?= isset($productsImage) ? 'Edit Product Image' : 'Add Product Image'; ?>
            </h4>
        </div>
        <div class="card-body">
            <form method="post"
                action="<?= isset($productsImage) ? base_url('product/' . $productsImage->id . '/image/edit') : base_url('product/' . $productId . '/image') ?>"
                id="formData" enctype="multipart/form-data" class="pristine-validate">
                <?php if (isset($productsImage)) { ?>
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php } ?>

                <?php if (isset($productsImage)): ?>
                    <div class="form-group">
                        <label for="is_primary" class="form-label">Is Primary</label>
                        <input class="form-check-input" type="checkbox" name="is_primary" id="is_primary" value="true"
                            <?= (isset($products_image) && $products_image->is_primary) ? 'checked' : ''; ?>>
                    </div>
                <?php endif; ?>

                <label for="userfile" class="form-label">Choose Image (JPG, JPEG, PNG, GIF - MAX 5MB)</label>
                <input class="form-control mb-3" type="file" name="userfile" id="userfile" size="20" required
                    data-pristine-required="Silahkan Pilih file untuk diunggah">
                <div id="file-type-error" class="text-danger mt-2" style="display: none">
                    File must be an image (JPG, JPEG, PNG, GIF)
                </div>
                <div id="file-size-error" class="text-danger mt-2" style="display: none">
                    File size must not exceed more than 5MB
                </div>
                <img id="image-preview" class="img-fluid mb-3" src="#" alt="Image Preview" style="display: none" />
        </div>
        <input class="btn btn-primary" type="submit" value="upload">
        </form>
    </div>
</div>
</div>


<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById("upload-form");
        var pristine = new Pristine(form);

        var fileInput = document.getElementById("userfile");
        var fileTypeError = document.getElementById("file-type-error");
        var fileSizeError = document.getElementById("file-size-error");
        var imagePreview = document.getElementById("image-preview");

        var maxSize = 5 * 1024 * 1024; // 5MB in bytes
        var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        var allowedExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp'];

        pristine.addValidator(fileInput, function (value) {
            fileTypeError.style.display = 'none';
            fileSizeError.style.display = 'none';
            imagePreview.style.display = 'none';

            if (fileInput.files.length === 0) {
                return true;
            }

            var file = fileInput.files[0];
            var validType = allowedTypes.includes(file.type);
            if (!validType) {
                var fileName = file.name.toLowerCase();
                validType = allowedExtensions.some(function (ext) {
                    return fileName.endsWith(ext);
                })
            }

            if (!validType) {
                fileTypeError.style.display = 'block';
                return false;
            }

            if (file.size > maxSize) {
                fileSizeError.style.display = 'block';
                return false;
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);

            return true;
        }, "validasi file gagal", 5, false);

        form.addEventListener("submit", function (e) {
            var valid = pristine.validate();
            if (!valid) {
                e.preventDefault();
            }
        });

        fileInput.addEventListener('change', function () {
            fileTypeError.style.display = 'none';
            fileSizeError.style.display = 'none';
            pristine.validate(fileInput);
        });

    });
</script>
<?= $this->endSection(); ?>