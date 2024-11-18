<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// $username = $_SESSION['username'];
$user_id = $_SESSION ['user_id'];
// if (!isset($_POST['phone'])) {
//     header("Location: login.php");
// }
// isset($_SESSION['phone']) ;

// if(!isset($_SESSION['address'])){
//     header("Location : login.php");
// }

//    
$stmt = $conn->prepare("SELECT   name ,email,phone , address,image_url FROM Users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result(  $username ,$email , $phone , $address,$image );
    $stmt->fetch();
    $stmt->close();


// if (!isset($_SESSION['address'])) {
//     header("Location: login.php");
//     // exit();
// }
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
        .shared-container {
    width: 50%;
    background: #fff;
    padding: 20px;
    box-shadow: 2px 3px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center;
    gap: 50px;
    /* align-items: center; */
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    /* justify-content: center; */
}

/* Hover effect for shared styles */
.shared-container:hover {
    box-shadow: 2px 3px 20px rgba(0, 0, 0, 0.3);
    transform: scale(1.02);
}
        
.profile-picture {
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
    transition: opacity 0.3s ease;
}

.profile-picture:hover {
    opacity: 0.8;
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
            width: 300px;
        }
        .file-input {
            display: none;
        }
        .content{
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            gap: 20px;
        }
        .update-userdetails>.update-details> form>.form-group>label {
            text-align: left;
            /* background-color: #42b72a; */
            font-weight: 600;


        }
        .update-userdetails>.update-details> form>.form-group{
            /* background-color: aqua; */
            text-align: left;

        }
        .update-userdetails>.update-details> form>.form-group>input{
           width: 500px;


        }
        .update-userdetails>.update-details> form>button{
           width: 500px;
        
        }
        
        .password-updated-container>form>.form-group{
           
            text-align: left;
            font-weight: 600;
            font-size: larger;

        }
        .password-updated-container
        {
            height: 500px;
            width:98%;
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
                <span>Welcome, <?php echo htmlspecialchars($image); ?></span>
            </div>
            <a href="logout_code.php"><i class='bx bx-log-out'></i> Logout</a>
        </div>
        <div class="content">
            <div class="profile-upload-container shared-container d-flex justify-content-center align-ithem-center">
                <form id="uploadForm" action="profile_code.php" method="POST" enctype="multipart/form-data">
                    <!-- Profile picture preview area -->
                    <div class="profile-picture" id="profilePreview" onclick="document.getElementById('fileInput').click();">
                    </div>
                    <!-- File input for uploading new picture -->
                    <input type="file" id="fileInput" name="profile_picture" class="file-input" accept="image/*" onchange="loadFile(event)">
                    
                    <!-- Hidden input to store user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <div class="content d-flex flex-column gap-3 text-start ">
                <h2>Name: <?php echo htmlspecialchars($username); ?></h2>
                <h3>Email Address: <?php echo htmlspecialchars($email); ?></h3>
                <h4>Phone Number: <?php echo htmlspecialchars($phone); ?></h4>
                <h4>Address: <?php echo htmlspecialchars($address); ?></h4>

            </div>
                    <!-- Save button -->
                    <button type="submit" class="save-btn">Save</button>
                </form>
                
            </div>
            <div class="update-userdetails   shared-container ">
            <h3 class="mt-4">Update User Details</h3>
              <div class="update-details w-100 h-100 d-flex align-items-center justify-content-center  flex-column ">
                
              <form id="updatedDetails" method="POST" action="user_crud.php" class="d-flex  flex-column gap-4 ">

<input type="hidden" name="update1" value="1">
<div class="form-group">
    <label for="name">Full Name</label>
    <input type="text" class="form-control" value="<?php echo htmlspecialchars($username); ?>" id="name" name="name" required>
</div>
<div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" id="email" name="email" required>
</div>
<div class="form-group ">
    <label for="phone">Phone Number</label>
    <input type="text" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" id="phone" name="phone">
</div>
<div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control"  id="address" name="address"><?php echo htmlspecialchars($address); ?></textarea>
            </div>

<button type="submit" class="btn btn-primary btn-block">Update it</button>


</form>
              </div>  
        
            </div>
            


            
        </div>
        <center>
        <div class="password-updated-container  border shared-container ">
            <h3>Update Password</h3>
        <form id="updatedPassword" method="POST" action="user_crud.php" class="d-flex flex-column gap-5">
            <input type="hidden" name="password1" value="1">
            <div class="form-group">
                <label for="password">Current Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="Npassword">New Password</label>
                <input type="password" class="form-control" id="Npassword" name="Npassword" required>
            </div>
            <div class="form-group">
                <label for="Rpassword">Re-enter password</label>
                <input type="password" class="form-control" id="Rpassword" name="Rpassword" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
            </div>
            </center>

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
            e.preventDefault(); 
            var formData = new FormData(this);
            // alert("hi");
            $.ajax({
                
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false, // Don't process the data
                contentType: false, // Don't set content type
                success: function(response) {
                    // Parse the response
                    var data = JSON.parse(response);
                    // alert(response);

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
        $(document).ready(function() {
            $('#updatedDetails').on('submit', function(e) {
                e.preventDefault();
                // alert("hi");
                $.ajax({
                    type: 'POST',
                    url: 'user_crud.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'profile.php';
                                    
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    }
                });
            });
        });
        
        $(document).ready(function() {
            $('#updatedPassword').on('submit', function(e) {
                e.preventDefault();
                // alert("hi");
                $.ajax({
                    type: 'POST',
                    url: 'user_crud.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'profile.php';
                                    
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
