<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Ensure images are circular and fit well */
        .user-img {
            width: 50px; /* Fixed width */
            height: 50px; /* Fixed height */
            object-fit: cover; /* Make sure the image is not stretched */
            border-radius: 50%; /* Make the image circular */
        }

        /* Make the Image column wider */
        th, td {
            vertical-align: middle; /* Ensure content is aligned properly */
        }

        .image-column {
            width: 80px; /* Increase the width of the Image column */
        }
    </style>
</head>
<body>

    <main id="main" class="main">
        <div class="container mt-4">
            <h1 class="mb-3">Employees Management</h1>

            <!-- Add Employee & Search Bar -->
            <div class="d-flex justify-content-between mb-3">
                <a href="/users/create" class="btn btn-primary">Add Employee</a>
               
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="employeeTable">
                    <thead class="table-light">
                        <tr>
                            <th class="image-column">Image</th> <!-- Adjusted column width -->
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Search Filter -->


</body>
</html>
