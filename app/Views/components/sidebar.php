<button class="menu-btn btn text-white" onclick="toggleSidebar()">
    ☰
</button>

<div class="sidebar" id="sidebar">
    <button class="menu-btn btn text-white" onclick="toggleSidebar()">
        ☰
    </button>
    <h4 class="text-light text-center">Management</h4>
    <hr class="text-light">
    <nav>
        <?php if (in_groups('Administrator')): ?>
            <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/admin/users') ?>">User</a>
            <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/admin/customer') ?>">Customer</a>
            <a class="btn btn-primary nav-link text-white me-2" href="<?= base_url('/product') ?>">Product</a>
        <?php endif; ?>
    </nav>
</div>

<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
    }
</script>