<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
<?= $title ?? 'E-Commerce' ?>
<?= $this->endSection() ?>

<?= $this->section('admin_content') ?>

<?= $content ?? '' ?>

<?= $this->endSection() ?>