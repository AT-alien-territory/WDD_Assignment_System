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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 80%;
            margin: 20px auto;
        }
    </style>
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
            <li><a href="admin_enquiries.php"><i class='bx bx-envelope'></i> Enquiries</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="topbar">
            <div class="user-info">
                <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
            </div>
            <a href="logout_code.php"><i class='bx bx-log-out'></i> Logout</a>
        </div>
        <div class="chart-container">
            <h2 style="text-align: center;">Enquiries Submitted by Date</h2>
            <canvas id="enquiryChart"></canvas>
        </div>
    </div>

    <script>
        // Fetch data from the backend API
        fetch('get_enquiries.php') // Use the correct endpoint
            .then(response => response.json())
            .then(data => {
                // Extract labels (dates) and data (counts) for the chart
                const labels = data.map(item => item.date);
                const counts = data.map(item => item.count);

                // Create the chart
                const ctx = document.getElementById('enquiryChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // Chart type
                    data: {
                        labels: labels, // X-axis labels (dates)
                        datasets: [{
                            label: 'Number of Enquiries', // Chart label
                            data: counts, // Y-axis data (counts)
                            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Bar color
                            borderColor: 'rgba(54, 162, 235, 1)', // Bar border color
                            borderWidth: 1 // Border width
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: (tooltipItem) => `Enquiries: ${tooltipItem.raw}`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true // Start Y-axis at 0
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching enquiry data:', error));
    </script>
</body>
</html>
