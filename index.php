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

    <section id="carouselExampleIndicators" class="carousel slide full-height" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://placehold.co/800x400" class="d-block w-100" alt="First slide">
            </div>
            <div class="carousel-item">
                <img src="https://placehold.co/800x400" class="d-block w-100" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img src="https://placehold.co/800x400" class="d-block w-100" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </section>

    <section id="portfolio" class="container">
        <h2 class="text-center">Portfolio</h2>
        <div class="row">
            <?php
            $limit = 1;
            include 'db.php';
            $result = $conn->query("SELECT * FROM Photographs");
            while ($row = $result->fetch_assoc()) {
                if ($limit < 5){
                    echo '<div class="col-md-3 portfolio-item">';
                    echo '<div class="image-container">';
                    echo '<div class="image-box">';
                    echo '<img class ="img-fluid img-thumbnail" src="' . $row['image_url'] . '" class="img-fluid" alt="' . $row['title'] . '" onerror="this.onerror=null;this.src=\'https://placehold.co/600x400\';">';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $limit = $limit +1;
                }
            
            }
            echo '<div class="seemore text-center w-100">';
            echo '<a  href="Gallery.php">See more</a>';
            echo '</div>';
            ?>
        </div>
    </section>

    <section id="about" class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">About</h2>
                <h2 class="text-center">John Doe</h2>
                <p class="text-center">John Doe is a professional photographer with over 10 years of experience in capturing stunning landscapes, portraits, and events. His work has been featured in numerous magazines and exhibitions worldwide. John is known for his unique ability to capture the essence of his subjects, creating timeless images that tell a story.</p>
                <p class="text-center">John holds a degree in Fine Arts from the University of Photography and has worked with top brands and clients. He is passionate about teaching and often conducts workshops and seminars to share his knowledge and skills with aspiring photographers.</p>
            </div>
            <div class="col-md-6">
                <img src="https://placehold.co/600x400" class="img-fluid" alt="About Image" onerror="this.onerror=null;this.src='https://placehold.co/600x400';">
            </div>
        </div>
        
    </section>

    
   <section id="gallery" class="container mt-5">
    <h2 class="text-center">Gallery</h2>
    <div class="row">
        <?php
        $limit = 1;
        $result = $conn->query("SELECT * FROM Photographs"); //img-fluid img-thumbnail
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($limit < 5){
                    echo '<div class="col-md-3 portfolio-item">';
                    echo '<div class="image-container">';
                    echo '<div class="image-box">';
                    echo '<img class ="img-fluid img-thumbnail" src="' . $row['image_url'] . '" class="img-fluid" alt="' . $row['title'] . '" onerror="this.onerror=null;this.src=\'https://placehold.co/600x400\';">';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $limit = $limit +1;
                }
                // echo '<h1>$limit</h1>';
                
                
            }
            echo '<div class="seemore text-center w-100">';
            echo '<a  href="Gallery.php">See more</a>';
            echo '</div>';
        } else {
            // Display placeholder images if no photographs are found
            for ($i = 0; $i < 8; $i++) {
                echo '<div class="col-lg-3 col-md-4 col-6 mb-4">';
                echo '<div class="d-block mb-4 h-100">';
                echo '<img class="img-fluid img-thumbnail" src="https://placehold.co/600x400" alt="Placeholder Image">';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</section>


    <section id="contact" class="container mt-5">
        <h2 class="text-center">Contact</h2>
        <form action="send_email.php" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </section>

    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Photographer Portfolio</h5>
                    <p>
                        Capturing moments from today... Creating memories for a lifetime.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#portfolio" class="text-dark">Portfolio</a>
                        </li>
                        <li>
                            <a href="#about" class="text-dark">About</a>
                        </li>
                        <li>
                            <a href="#contact" class="text-dark">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Follow Me</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#" class="text-dark">Facebook</a>
                        </li>
                        <li>
                            <a href="#" class="text-dark">Instagram</a>
                        </li>
                        <li>
                            <a href="#" class="text-dark">Twitter</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3 bg-dark text-white">
            © 2023 Photographer Portfolio. All rights reserved.
        </div>
    </footer>
<header>
    <!-- <h1>Welcome to Malcolm Lismore's Photography</h1>
</header>

<main>
    <p>Feel free to browse our portfolio, check pricing, or contact us for your photography needs.</p>
    <p>The chat bot in the bottom-right corner is here to assist you!</p>
</main>

<footer>
    <p>&copy; 2024 Malcolm Lismore. All rights reserved.</p>
</footer> -->



<!--Start of Tawk.to Script-->
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
<!--End of Tawk.to Script-->
    <!-- <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/YOUR_PROPERTY_ID/DEFAULT';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script> -->


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>