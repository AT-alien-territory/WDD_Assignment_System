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
  <h2>Enquiry</h2>
  </div>
<div class="container my-5">
        <h2 class="text-center">Submit Your Event Enquiry</h2>
        <form action="submit_enquiry.php" method="POST">
            <div class="mb-3">
                <label for="event_type" class="form-label">Event Type</label>
                <input type="text" class="form-control" id="event_type" name="event_type" required>
            </div>
            <div class="mb-3">
                <label for="event_date" class="form-label">Event Date</label>
                <input type="date" class="form-control" id="event_date" name="event_date" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Event Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Enquiry</button>
        </form>
    </div>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
