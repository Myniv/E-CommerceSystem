<body>
    <header
        class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <h1 class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"
                    onclick="window.location.href='<?= route_to('user_dashboard') ?>'" style="cursor: pointer;">
                    E-Commerce
                </h1>
                <nav class="nav">
                    <?php if (logged_in()): ?>
                        <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/') ?>">Home</a>
                        <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/about-us') ?>">About Us</a>
                        <a class="btn btn-primary nav-link text-white me-2"
                            href="<?= base_url('/dashboard') ?>">Dashboard</a>
                        <a class="btn btn-primary nav-link text-white me-2"
                            href="<?= base_url('/product/catalog') ?>">Catalog</a>
                        <?php if (in_groups('Administrator')): ?>
                            <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/admin/users') ?>">User</a>
                            <a class="btn btn-primary nav-link text-white me-2"
                                href="<?= base_url('/admin/user') ?>">Customer</a>
                            <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/product') ?>">Product</a>
                        <?php endif; ?>
                        <?php if (in_groups('Product Manager')): ?>
                            <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/product') ?>">Product</a>
                        <?php endif; ?>
                        <?php if (in_groups('Customer')): ?>
                            <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/pesanan') ?>">Pesanan</a>
                            <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/profile') ?>">Profile</a>
                        <?php endif; ?>
                        <a class="btn btn-danger nav-link text-white me-2" href="<?= base_url('/logout') ?>">Logout</a>
                    <?php else: ?>
                        <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/') ?>">Home</a>
                        <a class="btn btn-success nav-link text-white me-2" href="<?= base_url('/login') ?>">Login</a>
                        <a class="btn btn-warning nav-link text-white me-2" href="<?= base_url('/register') ?>">Register</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>
    <style>
        .bg-navy {
            background-color: rgb(0, 72, 144) !important;
        }

        .nav-link.active {
            /* highlight */
            background-color: rgb(0, 98, 255) !important;

            /* text color*/
            color: white !important;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let currentPath = window.location.pathname; // Get the current URL path

            document.querySelectorAll('.nav-link').forEach(link => {
                let linkPath = new URL(link.href).pathname; // Get the path of the link
                if (linkPath === currentPath) {
                    link.classList.add('active'); // Add active class if it matches
                }
            });
        });
    </script>
    <main>