
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enquiry_id = intval($_POST['enquiry_id']);
    $reply_message = mysqli_real_escape_string($conn, $_POST['reply_message']);

    $query = "UPDATE enquiries SET reply = '$reply_message' WHERE enquiry_id = $enquiry_id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Reply sent successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>