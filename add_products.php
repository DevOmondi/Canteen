<?php
 require './server/db.php'; 
    // Assuming $conn is your database connection
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
        // Retrieve and sanitize form inputs
        $productName = mysqli_real_escape_string($conn, $_POST['product-name']);
        $productPrice = mysqli_real_escape_string($conn, $_POST['product-price']);
        $quantityInStock = mysqli_real_escape_string($conn, $_POST['quantity_in_stock']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $currentTimestamp = date("Y-m-d H:i:s"); // Current date and time
        // Basic validation
        if (!empty($productName) && !empty($productPrice) && !empty($quantityInStock) && !empty($description)) {
            if($quantityInStock > 0){
                $status='in_stock';
            }else{
                $status='out_of_stock';
            }
            // Insert data into the database
            $query = "INSERT INTO products (name, price, quantity_in_stock, description, created_at, updated_at) 
                        VALUES ('$productName', '$productPrice', '$quantityInStock', '$description', '$currentTimestamp', '$currentTimestamp')";
            
            if (mysqli_query($conn, $query)) {
                echo "<script>
                        alert('Product added successfully.');
                        window.location.href = 'index.php';
                    </script>";
            
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('All fields are required.');</script>";
        }
    }
?>