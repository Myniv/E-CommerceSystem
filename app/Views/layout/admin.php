<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<?php if (logged_in()): ?>
    <?php if (in_groups('Administrator')): ?>
        <?= $this->include('components/sidebar') ?>
    <?php endif; ?>
<?php endif; ?>
<?= $this->renderSection('admin_content') ?>

<?= $this->endSection() ?>