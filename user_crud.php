<?php
include 'db.php';
session_start();



// Create User
function createUser($name, $email, $phone, $address, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO Users (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $address, $hashed_password);
    $stmt->execute();
    $stmt->close();
    return true;
}

// Read User
function getUser($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user;
}

// Update User
function updateUser($user_id, $name, $email, $phone, $address, $password = null) {
    global $conn;
    if ($password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE Users SET name = ?, email = ?, phone = ?, address = ?, password = ? WHERE user_id = ?");
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $hashed_password, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE Users SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?");
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);
    }
    $stmt->execute();
    $stmt->close();
}

// Delete User
function deleteUser($user_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        if (createUser($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['password'])) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed!']);
        }
        exit();
    } elseif (isset($_POST['update'])) {
        if (!empty($_POST['password'])) {
            updateUser($_POST['user_id'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['password']);
        } else {
            updateUser($_POST['user_id'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address']);
        }
    } elseif (isset($_POST['delete'])) {
        deleteUser($_POST['user_id']);
    }
}

$response = ["status" => "error", "message" => "Invalid request"];
$user_id = $_SESSION['user_id'];



// Handle updating user details
if (isset($_POST['update1']) && $_POST['update1'] == '1') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);

    // Update user details in the database
    $stmt = $conn->prepare("UPDATE Users SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);

    if ($stmt->execute()) {
        $response = ["status" => "success", "message" => "User details updated successfully"];
    } else {
        $response = ["status" => "error", "message" => "Failed to update user details"];
    }
    $stmt->close();
    echo json_encode($response);
    exit();
}

// Handle updating user password
if (isset($_POST['password1']) && $_POST['password1'] == '1') {
    $current_password = $_POST['password'];
    $new_password = $_POST['Npassword'];
    $confirm_password = $_POST['Rpassword'];

    // Validate the new password
    if ($new_password !== $confirm_password) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match"]);
        exit();
    }

    // Check the current password
    $stmt = $conn->prepare("SELECT password FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current_password, $hashed_password)) {
        echo json_encode(["status" => "error", "message" => "Current password is incorrect"]);
        exit();
    }

    // Hash the new password and update it in the database
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE Users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_hashed_password, $user_id);

    if ($stmt->execute()) {
        $response = ["status" => "success", "message" => "Password updated successfully"];
    } else {
        $response = ["status" => "error", "message" => "Failed to update password"];
    }
    $stmt->close();
    echo json_encode($response);
    exit();
}

// Default response
echo json_encode($response);
?>
