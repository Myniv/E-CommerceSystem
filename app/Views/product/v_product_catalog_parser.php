<div class="container mt-4">
    <h2 class="mb-3">Product Catalog</h2>

    <form method="get" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search product...">
            </div>
            <div class="col-md-4">
                <select name="kategori" class="form-select">
                    <option value="All" >All Categories</option>
                    <option value="Food">Food</option>
                    <option value="Clothes">Clothes</option>
                    <option value="Electronics">Electronics</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
            </div>
        </div>
    </form>

    <div class="row">
        {products}
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{image}" class="card-img-top" alt="{nama}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{nama}</h5>

                    <!-- Row for Price & Stock -->
                    <div class="row">
                        <div class="col-6">
                            <p class="card-text"><strong>Price:</strong> Rp {harga}</p>
                            <p class="card-text"><strong>Stock:</strong> {stok}</p>
                            <p class="card-text"><strong>{!stok_message!}</strong></p>
                            <p class="card-text"><strong>{!badge_message!}</strong></p>
                        </div>
                        <div class="col-6">
                            <p class="card-text"><strong>Status:</strong> {!status!}</p>
                            <p class="card-text"><strong>Category:</strong></p>
                            <ul class="list-unstyled m-0 p-0">
                                {kategori_list}
                                <li>{nama_kategori}</li>
                                {/kategori_list}
                            </ul>
                        </div>
                    </div>

                    <!-- Row for Status & Category -->
                    <div class="row">

                    </div>

                    <!-- Row for Stock Message & Badge Message -->
                    <div class="row">

                    </div>

                </div>
            </div>
        </div>
        {/products}
    </div>
</div>