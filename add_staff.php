<?php
 require './server/db.php'; 
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staffs'])) {
    // Retrieve and sanitize form inputs
    $name = mysqli_real_escape_string($conn, $_POST['staff-name']);
    $email = mysqli_real_escape_string($conn, $_POST['staff-email']);
    $role = mysqli_real_escape_string($conn, $_POST['staff-role']);

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        echo "<script>alert('Email already exists. Please use a different email.'); window.location.href = 'index.php';</script>";
    } else {
        // Insert data into the database
        $query = "INSERT INTO users (name, email, role) VALUES ('$name', '$email', '$role')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Staff member added successfully.'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
} else {
    echo "<script>alert('All fields are required.');</script>";
}

    
?>