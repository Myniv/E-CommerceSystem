<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>
<?php use Config\Roles; ?>

<div class="container mt-4">
    <?= view_cell('BackCell') ?>
    <h2 class="mb-3 d-flex justify-content-center">User Reports</h2>

    <div class="d-flex justify-content-center">
        <a href="<?= base_url('admin/users/reports/pdf') ?>" class="btn btn-success" target="_blank">
            <i class="bi bi-file-excel me-1"></i> Export PDF
        </a>
    </div>
</div>

<?= $this->endSection() ?>