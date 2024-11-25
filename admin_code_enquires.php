<?php
include 'db.php';

$query = "SELECT * FROM enquiries ORDER BY event_date DESC";
$result = mysqli_query($conn, $query);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(['error' => mysqli_error($conn)]);
}


?>


