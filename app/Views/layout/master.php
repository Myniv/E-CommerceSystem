<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<div class="d-flex flex-column min-vh-100">
    <?= $this->include('layout/header') ?>
    <div class="flex-grow-1">
        <div class="container mt-4">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <?= $this->include('layout/footer') ?>
</div>