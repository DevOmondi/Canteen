<?php
require './server/db.php'; 


    // Handling the deletion process
    if (isset($_POST['delete']) && isset($_POST['delete_id'])) {
        $deleteId = mysqli_real_escape_string($conn, $_POST['delete_id']);
        $table = mysqli_real_escape_string($conn, $_POST['table']);
        
        // Deleting the selected product from the database
        $deleteQuery = "DELETE FROM $table WHERE id = '$deleteId'";
        
        if (mysqli_query($conn, $deleteQuery)) {
            // echo "<script>alert('Product deleted successfully.'); window.location.reload();</script>";
            echo "<script>
                        alert('Deleted successfully.');
                        window.location.href = 'index.php';
                    </script>";
        } else {
            echo "<script>alert('Error deleting product: " . mysqli_error($conn) . "');</script>";
        }
    }
?>