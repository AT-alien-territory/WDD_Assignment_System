<?php
// Include the database connection file
include 'db.php';

// Query to count inquiries grouped by date
$query = "SELECT DATE(event_date) as date, COUNT(*) as count FROM enquiries GROUP BY DATE(event_date)";
$result = mysqli_query($conn, $query);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row; // Add date and count to the array
    }
    // Return the data as JSON
    echo json_encode($data);
} else {
    // Handle errors
    echo json_encode(['error' => mysqli_error($conn)]);
}
exit();
?>
