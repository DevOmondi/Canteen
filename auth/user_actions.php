<?php

// Registration endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'register') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(['message' => 'User registered successfully']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Failed to register user']);
    }
    exit;
}

// Login endpoint  
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session or generate JWT token
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        http_response_code(200);
        echo json_encode(['message' => 'Login successful']);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid email or password']);
    }
    exit;
}
