<!DOCTYPE html>
<html lang="en">

<head>
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
            position: absolute;
            left: 10px;
            top: 10px;
            font-size: 24px;
            cursor: pointer;
            background: none;
            border: none;
            color: #343a40;
        }
    </style>
</head>

<body>

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

</body>

</html>