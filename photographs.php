<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

include 'db.php';

// Fetch all photographs
$photographs = [];
if ($conn) {
    $result = $conn->query("SELECT * FROM Photographs");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $photographs[] = $row;
        }
    }
} else {
    echo "Database connection failed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photographs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.1/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>.image-container {
    display: flex;
    flex-wrap: wrap;
    gap: 16px; /* Space between each image box */
    justify-content: center; /* Centers the images */
}

.image-box {
    width: 400px;
    height: 400px;
    overflow: hidden;
    border-radius: 8px; /* Optional: rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: shadow effect */
}

.image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures image covers the box */
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .image-box {
        width: 100%; /* Full width on smaller screens */
        height: auto; /* Let height adjust to image ratio */
    }
}
/*base code*/
.animated {
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}
.animated.infinite {
  -webkit-animation-iteration-count: infinite;
  animation-iteration-count: infinite;
}
.animated.hinge {
  -webkit-animation-duration: 2s;
  animation-duration: 2s;
}
/*the animation definition*/
@-webkit-keyframes hinge {
  0% {
    -webkit-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out
  }
  20%,
  60% {
    -webkit-transform: rotate3d(0, 0, 1, 80deg);
    transform: rotate3d(0, 0, 1, 80deg);
    -webkit-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out
  }
  40%,
  80% {
    -webkit-transform: rotate3d(0, 0, 1, 60deg);
    transform: rotate3d(0, 0, 1, 60deg);
    -webkit-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out;
    opacity: 1
  }
  100% {
    -webkit-transform: translate3d(0, 700px, 0);
    transform: translate3d(0, 700px, 0);
    opacity: 0
  }
}
@keyframes hinge {
  0% {
    -webkit-transform-origin: top left;
    -ms-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out
  }
  20%,
  60% {
    -webkit-transform: rotate3d(0, 0, 1, 80deg);
    -ms-transform: rotate3d(0, 0, 1, 80deg);
    transform: rotate3d(0, 0, 1, 80deg);
    -webkit-transform-origin: top left;
    -ms-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out
  }
  40%,
  80% {
    -webkit-transform: rotate3d(0, 0, 1, 60deg);
    -ms-transform: rotate3d(0, 0, 1, 60deg);
    transform: rotate3d(0, 0, 1, 60deg);
    -webkit-transform-origin: top left;
    -ms-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out;
    opacity: 1
  }
  100% {
    -webkit-transform: translate3d(0, 700px, 0);
    -ms-transform: translate3d(0, 700px, 0);
    transform: translate3d(0, 700px, 0);
    opacity: 0
  }
}
.hinge {
  -webkit-animation-name: hinge;
  animation-name: hinge
}

</style>

</head>
<body>
<div class="sidebar bg-dark text-white p-3">
    <div class="sidebar-header">
        <h3>My Dashboard</h3>
    </div>
    <ul class="sidebar-menu list-unstyled">
        <li><a href="dashboard.php" class="text-white"><i class='bx bx-home'></i> Home</a></li>
        <li><a href="#" class="text-white"><i class='bx bx-user'></i> Profile</a></li>
        <li><a href="#" class="text-white"><i class='bx bx-photo-album'></i> Galleries</a></li>
        <li><a href="photographs.php" class="text-white active"><i class='bx bx-image'></i> Photographs</a></li>
        <li><a href="#" class="text-white"><i class='bx bx-envelope'></i> Enquiries</a></li>
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
        <h1>Photographs</h1>
        <div class="photographs-section">
            <!-- Upload Form -->
            <form id="uploadForm" action="photograph_crud.php" method="POST" enctype="multipart/form-data" class="mb-4">
                <input type="hidden" name="create" value="1">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control-file" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" name="category" id="category" class="form-control" placeholder="Category" required>
                </div>
                <div class="form-group">
                    <label for="upload_date">Upload Date</label>
                    <input type="date" name="upload_date" id="upload_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>

            <!-- Display Photographs -->
            <div class="row">
                <?php if (!empty($photographs)): ?>
                    <?php foreach ($photographs as $photo): ?>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                            <div class="image-container">
    <div class="image-box">
        <img src="<?php echo htmlspecialchars($photo['image_url']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>">
    </div>
</div>

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($photo['title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($photo['description']); ?></p>
                                    <button class="btn btn-danger delete-btn" data-id="<?php echo $photo['photo_id']; ?>">Delete</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No photographs found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle form submission
        $('#uploadForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: 'photograph_crud.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire('Success', 'Photograph uploaded successfully!', 'success').then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire('Error', 'There was an error uploading the photograph.', 'error');
                }
            });
        });

        // Handle delete button click
        $('.delete-btn').on('click', function() {
            var photoId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'photograph_crud.php',
                        type: 'POST',
                        data: { delete: true, photo_id: photoId },
                        success: function(response) {

                            Swal.fire('Deleted!', 'Your photograph has been deleted.', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'There was an error deleting the photograph.', 'error');
                        }
                    });
                }
            });
        });
    });
    // Tip: avoid this ton of code using AniJS ;)

var element = $('#square');

// when mouseover execute the animation
element.mouseover(function(){
  
  // the animation starts
  element.toggleClass('hinge animated');
  
  // do something when animation ends
  element.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(e){
   
   // trick to execute the animation again
    $(e.target).removeClass('hinge animated');
  
  });
  
});

</script>
<script src="https://cdn.rawgit.com/anijs/anijs/0.1.0/dist/anijs-min.js"></script>

</body>
</html>