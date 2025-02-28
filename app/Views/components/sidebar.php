<button class="menu-btn btn text-white" onclick="toggleSidebar()">
    ☰
</button>

<div class="sidebar" id="sidebar">
    <button class="menu-btn btn text-white" onclick="toggleSidebar()">
        ☰
    </button>
    <h4 class="text-light text-center">Academics</h4>
    <hr class="text-light">
    <nav>
        <a class="text-white" href="<?= base_url('/admin/user') ?>">User</a>
        <!-- <a class="text-white" href="<?= base_url('/admin/dashboard') ?>">Dashboard</a> -->
        <a href="<?= route_to("user_dashboard") ?>">Dashboard</a>
        <a class="text-white" href="<?= base_url('/admin/product') ?>">Product</a>
    </nav>
</div>

<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
    }
</script>