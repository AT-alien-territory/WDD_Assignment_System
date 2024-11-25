<?php
// Start the session
session_start();

// Include the database connection file
include 'db.php';

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the form data and sanitize it
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Optional: Capture user ID if logged in

    // Validate input data
    if (empty($event_type) || empty($event_date) || empty($location) || empty($message)) {
        // Return an error response if fields are empty
        echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
    } else {
        // Insert the enquiry data into the database
        $query = "INSERT INTO enquiries (event_type, event_date, location, message) 
                  VALUES ('$event_type', '$event_date', '$location', '$message')";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            // Return a success response
            echo json_encode(['status' => 'success', 'message' => 'Your enquiry has been submitted successfully!']);
        } else {
            // Return an error response if insertion fails
            echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . mysqli_error($conn)]);
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch data for analysis
    $query = "SELECT event_type, COUNT(*) AS count FROM enquiries GROUP BY event_type";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        // Return data as JSON
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Database Error: ' . mysqli_error($conn)]);
    }
} else {
    // Return an error response if the request is invalid
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

exit();
?>
