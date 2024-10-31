<?php require './server/db.php'; ?>

<!DOCTYPE html>
<html lang="en">


<head>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
   
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
            <?php
                // Assuming $conn is your database connection
                // Counts for Total Staff, Products, Orders, and Pre-Orders

                // Total Staff
                $totalStaffQuery = "SELECT COUNT(*) AS total_staff FROM staff";
                $totalStaffResult = mysqli_query($conn, $totalStaffQuery);
                $totalStaff = mysqli_fetch_assoc($totalStaffResult)['total_staff'];

                // Total Products
                $totalProductsQuery = "SELECT COUNT(*) AS total_products FROM products";
                $totalProductsResult = mysqli_query($conn, $totalProductsQuery);
                $totalProducts = mysqli_fetch_assoc($totalProductsResult)['total_products'];

                // Products In Stock
                $inStockQuery = "SELECT COUNT(*) AS in_stock FROM products WHERE quantity_in_stock > 0";
                $inStockResult = mysqli_query($conn, $inStockQuery);
                $inStock = mysqli_fetch_assoc($inStockResult)['in_stock'];

                // Products Out of Stock
                $outOfStockQuery = "SELECT COUNT(*) AS out_of_stock FROM products WHERE quantity_in_stock = 0";
                $outOfStockResult = mysqli_query($conn, $outOfStockQuery);
                $outOfStock = mysqli_fetch_assoc($outOfStockResult)['out_of_stock'];

                // Total Orders
                $totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM orders";
                $totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
                $totalOrders = mysqli_fetch_assoc($totalOrdersResult)['total_orders'];

                // Total Pre-Orders
                $totalPreordersQuery = "SELECT COUNT(*) AS total_preorders FROM orders WHERE status = 'pre-order'";
                $totalPreordersResult = mysqli_query($conn, $totalPreordersQuery);
                $totalPreorders = mysqli_fetch_assoc($totalPreordersResult)['total_preorders'];
            ?>

            <div class="stats-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div class="card">
                    <h3>Total Staff</h3>
                    <p class="stat-number" id="total-staff"><?= $totalStaff ?></p>
                </div>
                <div class="card">
                    <h3>Products</h3>
                    <p class="stat-number" id="total-products"><?= $totalProducts ?></p>
                    <div class="stat-detail">
                        <p>In Stock: <span id="in-stock"><?= $inStock ?></span></p>
                        <p>Out of Stock: <span id="out-of-stock"><?= $outOfStock ?></span></p>
                    </div>
                </div>
                <div class="card">
                    <h3>Orders</h3>
                    <p class="stat-number" id="total-orders"><?= $totalOrders ?></p>
                    <p class="stat-detail">Pre-Orders: <span id="total-preorders"><?= $totalPreorders ?></span></p>
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
                <?php
                    // Assuming $conn is your database connection
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staffs'])) {
                        // Retrieve and sanitize form inputs
                        $name = mysqli_real_escape_string($conn, $_POST['staff-name']);
                        $email = mysqli_real_escape_string($conn, $_POST['staff-email']);
                        $role = mysqli_real_escape_string($conn, $_POST['staff-role']);

                        // Basic validation
                        if (!empty($name) && !empty($email) && !empty($role)) {
                            // Insert data into the database
                            $query = "INSERT INTO users (name, email, 	role) VALUES ('$name', '$email', '$role')";
                            
                            if (mysqli_query($conn, $query)) {
                                echo "<script>alert('Staff member added successfully.');</script>";
                            } else {
                                echo "<p>Error: " . mysqli_error($conn) . "</p>";
                            }
                        } else {
                            echo "<p>All fields are required.</p>";
                        }
                    }
                ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="staff-name">Name:</label>
                        <input type="text" id="staff-name" name="staff-name" required>
                    </div>
                    <div class="form-group">
                        <label for="staff-email">Email:</label>
                        <input type="email" id="staff-email" name="staff-email" required>
                    </div>
                    <div class="form-group">
                        <label for="staff-role">Role:</label>
                        <select id="staff-role" name="staff-role" required>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <button type="submit" name="staffs" class="button">Add Staff</button>
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
                

                <form method="POST" action="add_products.php">
                    <div class="form-group">
                        <label for="product-name">Name:</label>
                        <input type="text" id="product-name" name="product-name" required>
                    </div>
                    <div class="form-group">
                        <label for="product-price">Price:</label>
                        <input type="number" id="product-price" name="product-price" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity_in_stock">Quantity:</label>
                        <input type="number" id="quantity_in_stock" name="quantity_in_stock" min='0' required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="button" name="add_product">Add Product</button>
                </form>

                <h2>Current Products</h2>
                <?php
                // Assuming $conn is your database connection
                $query = "SELECT id, name, price, quantity_in_stock, created_at FROM products";
                $result = mysqli_query($conn, $query);
                ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity in Stock</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $row['id'] . "</th>";
                                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['quantity_in_stock']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                    echo "<td>";
                                    echo "<form method='POST' action='delete.php' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this product?\");'>";
                                    echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                                    echo "<input type='hidden' name='table' value='products'>";
                                    echo "<button type='submit' name='delete' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i> Delete</button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No products available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


            </div>

        </div>

        <!-- Order History section -->
        <div id="order-history" class="content-section">
            <h1>Order History</h1>
            <div class="card">
                <h3>All Orders</h3>

                <?php
// Assuming $conn is your database connection
$query = "SELECT id, user_id, order_type, status, total_amount, pickup_datetime, created_at, updated_at FROM orders";
$result = mysqli_query($conn, $query);
?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">User ID</th>
                <th scope="col">Order Type</th>
                <th scope="col">Status</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Pickup Date & Time</th>
                <th scope="col">Created At</th>
                <th scope="col">Updated At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $row['id'] . "</th>";
                    echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['order_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['pickup_datetime']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['updated_at']) . "</td>";
                    echo "<td>";
                    echo "<form method='POST' action='delete.php' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this order?\");'>";
                    echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                    echo "<input type='hidden' name='table' value='orders'>";
                    echo "<button type='submit' name='delete' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i> Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center'>No orders available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>



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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>