<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title><?= $this->renderSection('title') ?></title>

    <style>
        .sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            height: 100%;
            width: 250px;
            background: #343a40;
            padding-top: 20px;
            transition: left 0.3s ease-in-out;
            z-index: 1000;
        }

        .sidebar a {
            color: white;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .sidebar.active {
            left: 0;
        }

        .menu-btn {
            position: fixed;
            left: 10px;
            top: 10px;
            font-size: 24px;
            cursor: pointer;
            background: none;
            border: none;
            color: #343a40;
            z-index: 1100;
        }

        .content {
            margin-left: 20px;
            transition: margin-left 0.3s;
        }

        .sidebar.active+.content {
            margin-left: 250px;
        }
    </style>

</head>
<div class="d-flex flex-column min-vh-100">
    <?= $this->include('components/header') ?>
    <div class="d-flex flex-grow-1">
        <div class="container mt-4">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <?= $this->include('components/footer') ?>
</div>