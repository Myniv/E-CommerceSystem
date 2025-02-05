<h2>Produk List</h2>
<a href="/product/create">Tambah Mahasiswa</a>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Kategori</th>
        <th>Action</th>
    </tr>
    <?php foreach ($products as $product) { ?>
        <tr>
            <td><?= $product->getId(); ?></td>
            <td><?= $product->getNama(); ?></td>
            <td><?= $product->getHarga(); ?></td>
            <td><?= $product->getStok(); ?></td>
            <td><?= $product->getKategori(); ?></td>
            <td>
                <button onclick="location.href='/product/detail/<?= $product->getId(); ?>'">Detail</button>
                <button onclick="location.href='/product/edit/<?= $product->getId(); ?>'">Edit</button>
                <form action="/product/delete/<?= $product->getId(); ?>" method="post" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>