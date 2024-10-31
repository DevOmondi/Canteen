<?php
require '../server/database.php'; // Ensure this file correctly sets up $conn

// Query to get total staff count from staff table
$query = "SELECT COUNT(*) as total_staff FROM staff";
$result = mysqli_query($conn, $query);

// Fetch the result
$staff_count = 0; // Initialize with zero in case there's no result
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $staff_count = $row['total_staff'];
    mysqli_free_result($result);
}

// Close the database connection
mysqli_close($conn);

// Output the total staff count
echo $staff_count;
