<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mt-4 mb-4">
    <?= view_cell('BackCell') ?>
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-3">
                <?= isset($products) ? 'Edit Product' : 'Add Product'; ?>
            </h4>
        </div>
        <div class="card-body">

            <form method="post"
                action="<?= isset($products) ? base_url('product/' . $products->id) : base_url('product'); ?>"
                id="formData" enctype="multipart/form-data" class="pristine-validate">
                <?php if (isset($products)) { ?>
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php } ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>"
                        name="name" value="<?= old('name', isset($products) ? $products->name : '') ?>"
                        data-pristine-required data-pristine-required-message="The name field is required."
                        data-pristine-minlength="3"
                        data-pristine-minlength-message="The name must be at least 3 characters long."
                        data-pristine-maxlength="255"
                        data-pristine-maxlength-message="The name cannot exceed 255 characters.">
                    <div class="invalid-feedback"><?= session('errors.name') ?? '' ?></div>

                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <input type="text" class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>"
                        name="description"
                        value="<?= old('description', isset($products) ? $products->description : '') ?>"
                        data-pristine-required data-pristine-required-message="The name field is required."
                        data-pristine-minlength="3"
                        data-pristine-minlength-message="The name must be at least 3 characters long."
                        data-pristine-maxlength="255"
                        data-pristine-maxlength-message="The name cannot exceed 255 characters.">
                    <div class="invalid-feedback"><?= session('errors.description') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="text" class="form-control <?= session('errors.price') ? 'is-invalid' : '' ?>"
                        name="price" value="<?= old('price', isset($products) ? $products->price : '') ?>"
                        data-pristine-required data-pristine-required-message="The Price field is required."
                        data-pristine-type="decimal" data-pristine-type-message="The Price must be a decimal number"
                        data-pristine-min="1" data-pristine-min-message="The price must be greater than 0.">
                    <div class="invalid-feedback"><?= session('errors.price') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" class="form-control <?= session('errors.stock') ? 'is-invalid' : '' ?>"
                        name="stock" value="<?= old('stock', isset($products) ? $products->stock : '') ?>"
                        data-pristine-required data-pristine-required-message="The Stock field is required."
                        data-pristine-type="integer" data-pristine-type-message="The Price must be a number"
                        data-pristine-min="0" data-pristine-min-message="The stock must be greater than or equal to 0.">
                    <div class="invalid-feedback"><?= session('errors.stock') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Categories:</label>
                    <select class="form-select <?= session('errors.category_id') ? 'is-invalid' : '' ?>"
                        name="category_id" data-pristine-required
                        data-pristine-required-message="The Categories field is required.">
                        <option value="" <?= old('category_id', isset($products) ? $products->category_id : '') ? 'disabled' : '' ?>>Select Categories</option>
                        <?php foreach ($categories as $item): ?>
                            <option value="<?= $item->id ?>" <?= old('category_id', isset($products) ? $products->category_id : '') == $item->name ? 'selected' : ''; ?>>
                                <?= $item->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= session('errors.category_id') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select class="form-select <?= session('errors.status') ? 'is-invalid' : '' ?>" name="status"
                        data-pristine-required data-pristine-required-message="The Status field is required.">
                        <option value="" <?= old('status', isset($products) ? $products->status : '') ? 'disabled' : '' ?>>Select Status</option>
                        <?php foreach ($activeornot as $item): ?>
                            <option value="<?= $item ?>" <?= old('status', isset($products) ? $products->status : '') == $item ? 'selected' : ''; ?>>
                                <?= $item ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= session('errors.status') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="is_new" class="form-label">Is New:</label>
                    <select class="form-select <?= session('errors.is_new') ? 'is-invalid' : '' ?>" name="is_new"
                        data-pristine-required data-pristine-required-message="The Is New field is required.">
                        <option value="" <?= old('is_new', isset($products) ? $products->is_new : '') ? 'disabled' : '' ?>>Select Is New</option>
                        <?php foreach ($trueorfalse as $item): ?>
                            <option value="<?= $item ?>" <?= old('is_new', isset($products) ? $products->is_new : '') == $item ? 'selected' : ''; ?>>
                                <?= $item ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= session('errors.is_new') ?? '' ?></div>
                </div>

                <div class="mb-3">
                    <label for="is_sale" class="form-label">Is Sale:</label>
                    <select class="form-select <?= session('errors.is_sale') ? 'is-invalid' : '' ?>" name="is_sale"
                        data-pristine-required data-pristine-required-message="The Is Sale field is required.">
                        <option value="" <?= old('is_sale', isset($products) ? $products->is_sale : '') ? 'disabled' : '' ?>>Select Is New</option>
                        <?php foreach ($trueorfalse as $item): ?>
                            <option value="<?= $item ?>" <?= old('is_sale', isset($products) ? $products->is_sale : '') == $item ? 'selected' : ''; ?>>
                                <?= $item ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= session('errors.is_sale') ?? '' ?></div>
                </div>

                <?php if (!isset($products)): ?>
                    <div class="form-group">
                        <label for="userfile" class="form-label">Choose Image (JPG, JPEG, PNG, GIF, WEBP - MAX 5MB)</label>
                        <input type="file" class="form-control mb-3" name="userfile" id="userfile" size="20" required
                            data-pristine-required-message="File must be uploaded.">
                        <div id="file-type-error" class="text-danger mt-2" style="display: none">
                            File must be an image (JPG, JPEG, PNG, GIF, WEBP)
                        </div>
                        <div id="file-size-error" class="text-danger mt-2" style="display: none">
                            File size must not exceed more than 5MB
                        </div>
                        <img id="image-preview" class="img-fluid mb-3" src="#" alt="Image Preview" style="display: none" />
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary"><?= isset($products) ? 'Update' : 'Simpan'; ?></button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    let pristine;
    window.onload = function () {
        let form = document.getElementById("formData");

        var pristine = new Pristine(form, {
            classTo: 'mb-3',
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorTextParent: 'mb-3',
            errorTextTag: 'div',
            errorTextClass: 'text-danger'
        });

        var fileInput = document.getElementById("userfile");
        var fileTypeError = document.getElementById("file-type-error");
        var fileSizeError = document.getElementById("file-size-error");
        var imagePreview = document.getElementById("image-preview");

        var maxSize = 5 * 1024 * 1024; // 5MB in bytes
        var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        var allowedExtensions = ['.jpg', '.jpeg', '.png', '.gif'];

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

        form.addEventListener('submit', function (e) {
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

    };
</script>

<?= $this->endSection() ?>