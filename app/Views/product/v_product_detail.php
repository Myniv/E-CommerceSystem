<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?= view_cell('BackCell') ?>
            <div class="card shadow-lg">
                <div class="card-header bg-black text-white text-center">
                    <h4>Detail Produk</h4>
                </div>
                <div class="card-body">
                    <img src="<?= isset($products->image_path) ? base_url($products->image_path) : base_url("products/search-image.svg") ?>"
                        class="card-img-top" alt="<?= isset($products->name) ? $products->name : "Product" ?>">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>ID:</strong> <?= $products->id ?></li>
                        <li class="list-group-item"><strong>Nama:</strong> <?= $products->name ?></li>
                        <li class="list-group-item"><strong>Stok:</strong> <?= $products->stock ?></li>
                        <li class="list-group-item">
                            <strong>Price:</strong> <?= $products->getFormattedPrice() ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Category:</strong> <?= $products->category_name ?>
                        </li>
                        <li class="list-group-item"><strong>Status:</strong> <?= $products->status ?></li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive">
                <a href="/product/<?= $products->id ?>/image" class="btn btn-success btn-sm">Add Image</a>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <?php foreach ($product_images as $image): ?>
                            <tr>
                                <td>
                                    <img src="<?= base_url($image->image_path) ?>" class="card-img-top"
                                        alt="<?= isset($products->name) ? $products->name : "Product" ?>">
                                </td>
                                <td>
                                    <a href="/product/<?= $image->id; ?>/image/edit" class="btn btn-primary btn-sm">Edit
                                        Image</a>
                                    <form action="/product/<?= $image->id ?>/image/delete" method="post" class="d-inline">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure want to delete this Image?');">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>