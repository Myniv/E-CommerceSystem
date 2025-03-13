<body>
    <header
        class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <h1 class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"
                    onclick="window.location.href='<?= route_to('user_dashboard') ?>'" style="cursor: pointer;">
                    E-Commerce
                </h1>
                <nav>
                    <?php if (logged_in()): ?>
                        <a href="<?= base_url('/') ?>">Home</a>
                        <a href="<?= base_url('/about-us') ?>">About Us</a>
                        <a href="<?= route_to("user_dashboard") ?>">Dashboard</a>
                        <a href="<?= base_url('/pesanan') ?>">Pesanan</a>
                        <a href="<?= base_url('/product/catalog') ?>">Catalog</a>
                        <a class="btn btn-danger nav-link text-white me-2" href="<?= base_url('/logout') ?>">Logout</a>
                    <?php else: ?>
                        <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/') ?>">Home</a>
                        <a class="btn btn-success nav-link text-white me-2" href="<?= base_url('/login') ?>">Login</a>
                        <a class="btn btn-warning nav-link text-white me-2"
                            href="<?= base_url('/register') ?>">Register</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>
    <main>