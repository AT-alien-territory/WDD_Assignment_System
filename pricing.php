<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photographer Portfolio</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .portfolio-item {
            margin-bottom: 30px;
        }
        .carousel-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .full-height {
            height: calc(100vh - 56px); /* Adjust 56px if your navbar height is different */
        }
     .image-container {
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
.page-image{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 300px;
    background-image: url(https://placehold.co/100x400);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

    </style>
</head>
<body>
    <?php
    session_start();
    include 'db.php';
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Photographer</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Gallery.php">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Enquiries.php">Enquir</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pricing.php">price</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout_code.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
  <div class="page-image">
  <h2>Pricing</h2>
  </div>
    <!-- Pricing Section -->
    <div class="container my-5">
        <h2 class="text-center mb-5">Photography Packages</h2>
        <div class="row">
            <!-- Basic Package -->
            <div class="col-md-4">
                <div class="card pricing-card">
                    <div class="card-header">
                        Basic Package
                    </div>
                    <div class="card-body">
                        <p class="price">$500</p>
                        <ul>
                            <li>Up to 4 hours of shooting</li>
                            <li>50 edited photos</li>
                            <li>Online gallery access</li>
                        </ul>
                        <a href="enquiries.php" class="btn btn-primary">Inquire Now</a>
                    </div>
                </div>
            </div>

            <!-- Premium Package -->
            <div class="col-md-4">
                <div class="card pricing-card">
                    <div class="card-header">
                        Premium Package
                    </div>
                    <div class="card-body">
                        <p class="price">$900</p>
                        <ul>
                            <li>Up to 8 hours of shooting</li>
                            <li>150 edited photos</li>
                            <li>Video highlights</li>
                            <li>Online gallery + USB drive</li>
                        </ul>
                        <a href="enquiries.php" class="btn btn-primary">Inquire Now</a>
                    </div>
                </div>
            </div>

            <!-- Ultimate Package -->
            <div class="col-md-4">
                <div class="card pricing-card">
                    <div class="card-header">
                        Ultimate Package
                    </div>
                    <div class="card-body">
                        <p class="price">$1500</p>
                        <ul>
                            <li>Full-day coverage (12 hours)</li>
                            <li>Unlimited edited photos</li>
                            <li>Video highlights + Full video</li>
                            <li>Private photo book + Online gallery</li>
                        </ul>
                        <a href="enquiries.php" class="btn btn-primary">Inquire Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2024 Malcolm Lismore Photography. All Rights Reserved.</p>
    </footer>
    <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/67383e424304e3196ae378b5/1icpr6d9n';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-qJ7z2tFZ9Gog5AO+zDl5eP0m08Wgnn5GFE7XU1G6z6cHoX58xSHGvdEB89xxI1Y0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0Z1E5S5R5S1vkp6mBf8j9iNK6B57g1H98z4ya4PvT+ebJr57" crossorigin="anonymous"></script>
</body>

</html>
