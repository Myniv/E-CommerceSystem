<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>
<?= $title ?? '' ?>
<?= $this->endSection() ?>

<?= $this->section('admin_content') ?>

<?= $content ?? '' ?>

<?= $this->endSection() ?>