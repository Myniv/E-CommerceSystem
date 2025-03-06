<div class="container mt-4">
    <h2 class="mb-3">Product Catalog</h2>
    <form action="{baseUrl}" method="get" class="form-inline mb-3">
        <div class="row g-2">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="{search}" placeholder="Search...">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <select name="category_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Category</option>
                    {categories}
                    <option value="{id}" {selected}>{name}</option>
                    {/categories}
                </select>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <select name="price_range" class="form-select" onchange="this.form.submit()">
                    <option value="">All Price</option>
                    {priceRangeOptions}
                    <option value="{value}" {selected}>{label}</option>
                    {/priceRangeOptions}
                </select>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <select name="perPage" class="form-select" onchange="this.form.submit()">
                    {perPageOptions}
                    <option value="{value}" {!selected!}>{value} per Page</option>
                    {/perPageOptions}
                </select>
            </div>

            <div class="col-6 col-md-4 col-lg-3 d-flex flex-wrap gap-2">
                {sorting}
                <a class="btn btn-dark text-white" href="{href}">
                    {name} {is_sorted}
                </a>
                {/sorting}
                <a href="{reset}" class="btn btn-secondary ">Reset</a>
            </div>
        </div>

        <input type="hidden" name="sort" value="{sort}">
        <input type="hidden" name="order" value="{order}">
    </form>


    <div class="row">
        {products}
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{image_path}" class="card-img-top img-fluid" alt="{name}"
                    style="width: 100%; height: 200px; object-fit: cover; display: block;">
                <div class="card-body">
                    <h5 class="card-title">{name}</h5>

                    <div class="row">
                        <div class="col-6">
                            <p class="card-text"><strong>Price:</strong> {priceFormat}</p>
                            <p class="card-text"><strong>Stock:</strong> {stock}</p>
                            <p class="card-text"><strong>{!stok_message!}</strong></p>
                        </div>
                        <div class="col-6">
                            <p class="card-text"><strong>Created:</strong> {created_atFormat}</p>
                            <p class="card-text mb-0"><strong>Category:</strong> {category_name}</p>
                            <div class="row align-items-left text-left">
                                <div class="col-md-4">
                                    <p class="card-text"><strong>{!is_sale_message!}</strong></p>
                                </div>
                                <div class="col-md-4">
                                    <p class="card-text"><strong>{!is_new_message!}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {/products}
    </div>
    {!pager!}
</div>