<div class="container mt-4">
    <h2 class="mb-3">Produk List</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {products}
                <tr>
                    <td>{id}</td>
                    <td>{nama}</td>
                    <td>Rp {harga}</td>
                    <td>{stok}</td>
                    <td>{kategori}</td>
                    <td>
                    </td>
                </tr>
                {/products}
            </tbody>
        </table>
    </div>
</div>