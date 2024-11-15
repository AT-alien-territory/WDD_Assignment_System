<?php
session_start();
include 'db.php';

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if a file is uploaded
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
    $fileName = $_FILES['profile_picture']['name'];
    $fileSize = $_FILES['profile_picture']['size'];
    $fileType = $_FILES['profile_picture']['type'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    // Allowed file extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
        exit();
    }

    // Generate a unique file name to prevent overwriting
    $newFileName = uniqid() . '.' . $fileExtension;

    // Destination folder for uploaded files
    $uploadFileDir = 'uploads/profile_pictures/';
    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0777, true); // Create the directory if it doesn't exist
    }

    $destPath = $uploadFileDir . $newFileName;

    // Move the uploaded file to the destination folder
    if (move_uploaded_file($fileTmpPath, $destPath)) {
        // Update the user's profile picture in the database
        $sql = "UPDATE users SET image_url = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
            exit();
        }
        $stmt->bind_param('si', $destPath, $user_id);
        echo  $stmt->error;    
        if ($stmt->execute()) {
            // Update the session variable
            $_SESSION['profile_picture'] = $destPath;

            echo json_encode(['status' => 'success', 'message' => 'Profile picture updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update the database.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload the file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded or there was an error with the upload.']);
}

$conn->close();
?>
