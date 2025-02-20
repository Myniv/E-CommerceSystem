<div class="container mt-4">
    <h2 class="mb-3">Product Catalog</h2>
    <div class="row">
        {products}
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{image}" class="card-img-top" alt="{nama}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{nama}</h5>
                    <p class="card-text"><strong>Price:</strong> Rp {harga}</p>
                    <p class="card-text"><strong>Stock:</strong> {stok}</p>
                    <p class="card-text"><strong>Category:</strong> {kategori}</p>
                </div>
            </div>
        </div>
        {/products}
    </div>
</div>