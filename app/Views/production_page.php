<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<h1>Welcome to the E-Commerce Management System</h1>
<p>PRODUCTION MODE</p>

<?php if (isset($role)) { ?>
    <p>Role : <?= $role ?></p>
<?php } else { ?>
    <p>Not Login!</p>
<?php } ?>

<? if (isset($error)) { ?>
    <p><?= $error ?></p>
<? } ?>

<?= $this->endSection() ?>