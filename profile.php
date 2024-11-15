<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
isset($_SESSION['phone']) ;
$phone = $_SESSION['phone'];
$email = $_SESSION['email'];
$image = $_SESSION['profile_picture'];

$conn->close();
// $image = $_SESSION['image'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.1/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .profile-upload-container {
            width: 100%;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            display: flex;
            gap: 50px;
            align-items: center;
        }
        .profile-picture{
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background-image: url(<?php echo htmlspecialchars($image); ?>);
            display: inline-block;
            background-size: cover;
            background-position: center;
            margin-bottom: 10px;
            position: relative;
            cursor: pointer;
        }
        .upload-btn {
            background-color: #1877f2;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }
        .save-btn {
            background-color: #42b72a;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }
        .file-input {
            display: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>My Dashboard</h3>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#"><i class='bx bx-home'></i> Home</a></li>
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
            <div class="profile-upload-container">
                <form id="uploadForm" action="profile_code.php" method="POST" enctype="multipart/form-data">
                    <!-- Profile picture preview area -->
                    <div class="profile-picture" id="profilePreview" onclick="document.getElementById('fileInput').click();">
                    </div>
                    <!-- File input for uploading new picture -->
                    <input type="file" id="fileInput" name="profile_picture" class="file-input" accept="image/*" onchange="loadFile(event)">
                    
                    <!-- Hidden input to store user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                    <!-- Save button -->
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>

            <div class="content">
                <h1>Name: <?php echo htmlspecialchars($username); ?></h1>
                <h2>Email Address: <?php echo htmlspecialchars($email); ?></h2>
                <h2>Phone Number: <?php echo htmlspecialchars($phone); ?></h2>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <script>
        // JavaScript to handle profile picture preview
        function loadFile(event) {
            const profilePreview = document.getElementById('profilePreview');
            profilePreview.style.backgroundImage = `url(${URL.createObjectURL(event.target.files[0])})`;
        }

        // Form submission handler using AJAX
        $('#uploadForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Create a FormData object to handle the file upload
            var formData = new FormData(this);

            // Make AJAX request
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false, // Don't process the data
                contentType: false, // Don't set content type
                success: function(response) {
                    // Parse the response
                    var data = JSON.parse(response);

                    // Display SweetAlert based on response status
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while uploading the file.'
                    });
                }
            });
        });
    </script>
</body>
</html>
