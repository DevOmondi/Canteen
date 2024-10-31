<?php
require './server/db.php';

function getDashboardStats($pdo) {
    $stats = [];
    
    // Get total staff
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as total_staff FROM staff");
        $stats['total_staff'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_staff'];
    } catch(PDOException $e) {
        $stats['total_staff'] = 0;
    }
    
    // Get product stats
    try {
        $stmt = $pdo->query("SELECT 
            COUNT(*) as total_products,
            SUM(CASE WHEN status = 'in_stock' THEN 1 ELSE 0 END) as in_stock,
            SUM(CASE WHEN status = 'out_of_stock' THEN 1 ELSE 0 END) as out_of_stock
            FROM products");
        $stats['products'] = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $stats['products'] = ['total_products' => 0, 'in_stock' => 0, 'out_of_stock' => 0];
    }
    
    // Get order stats
    try {
        $stmt = $pdo->query("SELECT 
            COUNT(*) as total_orders,
            SUM(CASE WHEN order_type = 'pre_order' THEN 1 ELSE 0 END) as total_preorders
            FROM orders");
        $stats['orders'] = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $stats['orders'] = ['total_orders' => 0, 'total_preorders' => 0];
    }
    
    return $stats;
}

// Return JSON response if this file is called directly
// if (basename($_SERVER['PHP_SELF']) == 'get_stats.php') {
//     header('Content-Type: application/json');
//     echo json_encode(getDashboardStats($pdo));
// }
?>