<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password, name ,email,phone , image_url FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $username ,$email , $phone,$image );
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['profile_picture'] = $image;
        
        echo json_encode(['status' => 'success', 'message' => 'Login successful!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    }
    exit();
}
?>