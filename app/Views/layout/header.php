<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'My Website') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <header>
        <h1>Welcome to My Website</h1>
        <nav>
            <a href="<?= base_url('/') ?>">Home</a>
            <a href="<?= base_url('/products') ?>">Products</a>
            <a href="<?= base_url('/contact') ?>">Contact</a>
        </nav>
    </header>
    <main>
