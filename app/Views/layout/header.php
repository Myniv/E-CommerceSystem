<body>
    <header
        class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <title>E-Commerce</title>
                <h1 class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"
                    onclick="window.location.href='<?= route_to('user_dashboard') ?>'" style="cursor: pointer;">
                    E-Commerce
                </h1>
                <nav>
                    <a href="<?= base_url('/') ?>">Home</a>
                    <a href="<?= base_url('/admin/show') ?>">Show</a>
                    <a href="<?= base_url('/about-us') ?>">About Us</a>
                    <a href="<?= route_to("user_dashboard") ?>">Dashboard</a>
                    <!-- <a href="<?= base_url('/api/product') ?>">Products</a> -->
                    <a href="<?= base_url('/api/product') ?>">Products</a>
                    <a href="<?= base_url('/admin/user') ?>">User</a>
                    <a href="<?= base_url('/api/pesanan') ?>">Pesanan</a>
                </nav>
            </div>
        </div>
    </header>
    <main>