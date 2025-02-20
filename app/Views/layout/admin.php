<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<?= $this->include('components/sidebar') ?>
<?= $this->renderSection('admin_content') ?>

<?= $this->endSection() ?>