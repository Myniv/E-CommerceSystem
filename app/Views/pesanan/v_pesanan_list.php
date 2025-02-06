<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<h2>Pesanan List</h2>
<a href="/pesanan/create">Tambah Mahasiswa</a>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Produk</th>
        <th>Total</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($pesanan as $item) { ?>
        <tr>
            <td><?= $item->getId(); ?></td>
            <td><?= $item->getProduct(); ?></td>
            <td><?= $item->getTotal(); ?></td>
            <td><?= $item->getStatus(); ?></td>
            <td>
                <button onclick="location.href='/pesanan/detail/<?= $item->getId(); ?>'">Detail</button>
                <button onclick="location.href='/pesanan/edit/<?= $item->getId(); ?>'">Edit</button>
                <form action="/pesanan/delete/<?= $item->getId(); ?>" method="post" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>
<?= $this->endSection() ?>