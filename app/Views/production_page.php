<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<h1>Welcome to the E-Commerce Management System</h1>
<p>PRODUCTION MODE</p>


<form action="<?= 'login' ?>" method="post">
    <select name="role">
        <option value="user">Login as User</option>
        <option value="admin">Login as Admin</option>
    </select>
    <button type="submit">Login</button>
</form>

<?php if (isset($role)) { ?>
    <p>Role : <?= $role ?></p>
<?php } else { ?>
    <p>Not Login!</p>
<?php } ?>

<?= $this->endSection() ?>