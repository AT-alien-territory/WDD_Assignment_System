<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.1/css/boxicons.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>My Dashboard</h3>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class='bx bx-home'></i> Home</a></li>
            <li><a href="profile.php"><i class='bx bx-user'></i> Profile</a></li>
            <li><a href="#"><i class='bx bx-photo-album'></i> Galleries</a></li>
            <li><a href="photographs.php"><i class='bx bx-image'></i> Photographs</a></li>
            <li><a href="#"><i class='bx bx-envelope'></i> Enquiries</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="topbar">
            <div class="user-info">
                <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
            </div>
            <a href="logout_code.php"><i class='bx bx-log-out'></i> Logout</a>
        </div>
        <div class="content">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <div class="photographs-section">
                
            <canvas id="myChart" width="400" height="400"></canvas>

                <!-- Add your photographs content here -->
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Get the canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Create a chart
    var myChart = new Chart(ctx, {
        type: 'bar', // Chart type: 'line', 'bar', 'radar', etc.
        data: {
            labels: ['January', 'February', 'March', 'April'], // X-axis labels
            datasets: [{
                label: 'Monthly Sales', // Chart label
                data: [12, 19, 3, 5], // Data points
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>