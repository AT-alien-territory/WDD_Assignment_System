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
    <title>Admin Enquiries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.1/css/boxicons.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="layout.css">
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
<div class="container my-5">
    
        <h2>Admin Enquiries</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Type</th>
                    <th>Event Date</th>
                    <th>Location</th>
                    <th>Message</th>
                    <!-- <th>Reply</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="enquiryTableBody">
                <!-- Enquiries will be dynamically loaded here -->
            </tbody>
        </table>
    </div>
        </div>
        </div>
    

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply to Enquiry</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="replyForm">
                    <div class="modal-body">
                        <input type="hidden" id="enquiryId" name="enquiry_id">
                        <div class="form-group">
                            <label for="replyMessage">Reply</label>
                            <textarea id="replyMessage" name="reply_message" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fetch and display enquiries
        function fetchEnquiries() {
            $.ajax({
                url: 'admin_code_enquires.php',
                type: 'GET',
                success: function(response) {
                    const enquiries = JSON.parse(response);
                    let rows = '';
                    enquiries.forEach(enquiry => {
                        rows += `
                            <tr>
                                <td>${enquiry.enquiry_id}</td>
                                <td>${enquiry.event_type}</td>
                                <td>${enquiry.event_date}</td>
                                <td>${enquiry.location}</td>
                                <td>${enquiry.message}</td>
                                <td>${enquiry.Reply || 'No reply yet'}</td>
                                <td>
                                    <button class="btn btn-primary reply-btn" data-id="${enquiry.enquiry_id}">Reply</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#enquiryTableBody').html(rows);

                    // Add click event for Reply buttons
                    $('.reply-btn').on('click', function() {
                        const id = $(this).data('id');
                        $('#enquiryId').val(id);
                        $('#replyModal').modal('show');
                    });
                }
            });
        }

        // Handle reply form submission
        $('#replyForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'send_reply.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const result = JSON.parse(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: result.message,
                        confirmButtonText: 'OK',
                    });
                    alert(result.message);
                    $('#replyModal').modal('hide');
                    fetchEnquiries();
                }
            });
        });

        // Initial fetch
        fetchEnquiries();
    </script>
</body>
</html>
