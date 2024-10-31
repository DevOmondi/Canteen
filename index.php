<?php require './server/db.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-image: url('slide2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .sidebar {
            width: 250px;
            background-color: #2C3E50;
            color: white;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }

        .sidebar img {
            display: block;
            margin: 0 auto;
            width: 150px;
            height: auto;
            border-radius: 50%;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
        }

        .sidebar a {
            padding: 15px;
            text-decoration: none;
            color: white;
            font-size: 18px;
            display: block;
            border-bottom: 1px solid #34495E;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #1ABC9C;
        }

        .sidebar a.active {
            background-color: #1ABC9C;
        }

        .content {
            flex: 1;
            background-color: #728a90;
            padding: 20px;
            overflow-y: auto;
        }

        .content h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        /* Additional styles for form elements */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .button {
            padding: 10px 15px;
            background-color: #1ABC9C;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #16a085;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #1ABC9C;
            margin: 10px 0;
        }

        .stat-detail {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .stats-container .card {
            text-align: center;
            transition: transform 0.2s;
        }

        .stats-container .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <!-- Sidebar with tabs -->
    <div class="sidebar">
        <img src="./assets/logo_2.png" alt="Logo">
        <h2>Admin Dashboard</h2>
        <a href="#" class="active" onclick="showSection('dashboard', event)">Dashboard</a>
        <a href="#" onclick="showSection('manage-staff', event)">Manage Staff</a>
        <a href="#" onclick="showSection('manage-products', event)">Manage Products</a>
        <a href="#" onclick="showSection('order-history', event)">Order History</a>
        <a href="#" onclick="showSection('pre-orders', event)">Pre-Orders</a>
        <a href="#" onclick="showSection('reports', event)">Reports</a>
        <a href="#" onclick="logout()">Logout</a>
    </div>

    <!-- Main content -->
    <div class="content">
        <!-- Dashboard section -->
        <!-- <div id="dashboard" class="content-section active">
            <h1>Welcome, Admin</h1>
            <div class="card">
                <h3>Total Staff</h3>
            </div>
            <div class="card">
                <h3>Total Products</h3>
            </div>
            <div class="card">
                <h3>Total Pre-Orders</h3>
            </div>
            <div class="card">
                <h3>Recent Activities</h3>
            </div>
        </div> -->
        <!-- Dashboard section -->
        <div id="dashboard" class="content-section active">
            <h1>Welcome, Admin</h1>
            <div class="stats-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div class="card">
                    <h3>Total Staff</h3>
                    <p class="stat-number" id="total-staff">Loading...</p>
                </div>
                <div class="card">
                    <h3>Products</h3>
                    <p class="stat-number" id="total-products">Loading...</p>
                    <div class="stat-detail">
                        <p>In Stock: <span id="in-stock">Loading...</span></p>
                        <p>Out of Stock: <span id="out-of-stock">Loading...</span></p>
                    </div>
                </div>
                <div class="card">
                    <h3>Orders</h3>
                    <p class="stat-number" id="total-orders">Loading...</p>
                    <p class="stat-detail">Pre-Orders: <span id="total-preorders">Loading...</span></p>
                </div>
            </div>
        </div>

        <!-- Manage Staff section -->
        <div id="manage-staff" class="content-section">
            <h1>Manage Staff</h1>
            <div class="card">
                <h3>Staff List</h3>
            </div>
            <div class="card">
                <h3>Add New Staff</h3>
                <form>
                    <div class="form-group">
                        <label for="staff-name">Name:</label>
                        <input type="text" id="staff-name" name="staff-name">
                    </div>
                    <div class="form-group">
                        <label for="staff-email">Email:</label>
                        <input type="email" id="staff-email" name="staff-email">
                    </div>
                    <div class="form-group">
                        <label for="staff-role">Role:</label>
                        <select id="staff-role" name="staff-role">
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <button type="submit" class="button">Add Staff</button>
                </form>
            </div>
        </div>

        <!-- Manage Products section -->
        <div id="manage-products" class="content-section">
            <h1>Manage Products</h1>
            <div class="card">
                <h3>Product List</h3>
            </div>
            <div class="card">
                <h3>Add New Product</h3>
                <form>
                    <div class="form-group">
                        <label for="product-name">Name:</label>
                        <input type="text" id="product-name" name="product-name">
                    </div>
                    <div class="form-group">
                        <label for="product-price">Price:</label>
                        <input type="number" id="product-price" name="product-price">
                    </div>
                    <button type="submit" class="button">Add Product</button>
                </form>
                <h2>Current Products</h2>
                <table border="1">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </table>


            </div>

        </div>

        <!-- Order History section -->
        <div id="order-history" class="content-section">
            <h1>Order History</h1>
            <div class="card">
                <h3>All Orders</h3>
            </div>
        </div>

        <!-- Pre-Orders section -->
        <div id="pre-orders" class="content-section">
            <h1>Pre-Orders</h1>
            <div class="card">
                <h3>Pending Pre-Orders</h3>
            </div>
        </div>

        <!-- Reports section -->
        <div id="reports" class="content-section">
            <h1>Reports</h1>
            <div class="card">
                <h3>Sales Reports</h3>
                <p>Generate sales and order reports for the canteen.</p>
                <button class="button">Generate Report</button>
            </div>
        </div>
    </div>

    <script>
        function updateDashboardStats() {
            fetch('./server/get_stats.php')
                .then(response => response.json())
                .then(data => {
                    // Update staff stats
                    document.getElementById('total-staff').textContent = data.total_staff;

                    // Update product stats
                    document.getElementById('total-products').textContent = data.products.total_products;
                    document.getElementById('in-stock').textContent = data.products.in_stock;
                    document.getElementById('out-of-stock').textContent = data.products.out_of_stock;

                    // Update order stats
                    document.getElementById('total-orders').textContent = data.orders.total_orders;
                    document.getElementById('total-preorders').textContent = data.orders.total_preorders;
                })
                .catch(error => console.error('Error fetching stats:', error));
        }

        // Call updateDashboardStats when the page loads
        document.addEventListener('DOMContentLoaded', updateDashboardStats);

        function showSection(sectionId, event) {
            event.preventDefault(); // Prevent the default link behavior

            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Remove active class from all links
            const links = document.querySelectorAll('.sidebar a');
            links.forEach(link => {
                link.classList.remove('active');
            });

            // Show the selected sections
            document.getElementById(sectionId).classList.add('active');
            event.currentTarget.classList.add('active'); // Set the clicked link as active
        }

        if (sectionId === 'dashboard') {
            updateDashboardStats();
        }

        function logout() {
            alert("Logging out..."); // Implement actual logout logic as needed
        }
    </script>
</body>

</html>