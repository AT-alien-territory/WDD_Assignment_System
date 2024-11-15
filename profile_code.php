<?php
session_start();
require_once 'db.php'; // Include database connection file

// Set the directory where uploaded images will be saved
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
    $user_id = $_POST['user_id']; // User ID from form
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verify the file is an image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        echo json_encode(['status' => 'error', 'message' => 'The uploaded file is not a valid image.']);
        exit();
    }

    // Allow only certain file types
    $allowed_formats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_formats)) {
        echo json_encode(['status' => 'error', 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed.']);
        exit();
    }

    // Move the file to the target directory
    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
        // Update the user's image path in the database
        $stmt = $conn->prepare("UPDATE Users SET image = ? WHERE user_id = ?");
        $stmt->bind_param("si", $target_file, $user_id);

        if ($stmt->execute()) {
            // Redirect to profile page or display success message
            $_SESSION['profile_picture'] = $target_file; // Update session if needed
            echo json_encode(['status' => 'success', 'message' => 'Profile picture uploaded successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database update failed: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error uploading your file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No file was uploaded or an error occurred with the upload.']);
}

$conn->close();
?>
