<!DOCTYPE html>
<html lang="en">
<?php use Config\Roles; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.css') ?>" type="text/css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url('js/bootstrap.js') ?>"><</script>
    <script src="<?= base_url('js/pristine/dist/pristine.js') ?>" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title><?= $this->renderSection('title') ?? 'E-Commerce' ?></title>

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
            <?php if (logged_in()): ?>
                <?php if (in_groups(Roles::ADMIN)): ?>
                    <?= $this->include('components/sidebar') ?>
                <?php endif; ?>
            <?php endif; ?>
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <?= $this->include('components/footer') ?>
    <?= $this->renderSection('scripts') ?>
</div>