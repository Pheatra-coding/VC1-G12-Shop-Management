<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Management</title>
      <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
</head>
<style>
        /* Ensure images are circular and fit well */
        .user-img {
            width: 50px; /* Fixed width */
            height: 50px; /* Fixed height */
            object-fit: cover; /* Make sure the image is not stretched */
            border-radius: 50%; /* Make the image circular */
        }
        

        a {
            text-decoration: none;
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
        <div class="">
            <h1 class="mb-3" style="font-size:28px;">Employees Management</h1>

            <!-- Add Employee & Search Bar -->
            <div class="d-flex justify-content-between mb-3">
                <a href="/users/create" class="btn btn-primary">Add Employee</a>
                <div class="input-group w-50">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search employee..." onkeyup="searchTable()">
                    <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="employeeTable" class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php if (!empty($users) && is_array($users)) : ?>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <!-- Display User Image -->
                                    <td>
                                        <img src="<?= !empty($user['image']) ? 'uploads/' . htmlspecialchars($user['image']) : 'https://pheaktra-student.site/assets/img/PF.jpg'; ?>" 
                                        alt="User Image" class="img-fluid user-img" 
                                        style="width: 50px; height: 50px; border-radius: 50%;">
                                    </td>
                                    <!-- Display Username -->
                                    <td><?= htmlspecialchars($user['name']) ?></td>

                                    <!-- Display Email -->
                                    <td><?= htmlspecialchars($user['email']) ?></td>

                                    <!-- Display Role -->
                                    <td><?= htmlspecialchars($user['role']) ?></td>

                                    <!-- Actions Column -->
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/users/edit/<?= $user['id'] ?>">Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="/users/delete/<?= $user['id'] ?>">Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- No Results Message (Initially Hidden) -->
                <div id="noResultsMessage" style="display:none; text-align: center;">
                    <p>No results found.</p>
                </div>

            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Search Filter -->
    <script>
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("employeeTable");
            let rows = table.getElementsByTagName("tr");
            let noResultsMessage = document.getElementById("noResultsMessage");
            let found = false;

            // Hide the no results message initially
            noResultsMessage.style.display = "none";

            for (let i = 1; i < rows.length; i++) { 
                let columns = rows[i].getElementsByTagName("td");
                let match = false;

                for (let j = 1; j < columns.length - 1; j++) { 
                    if (columns[j].innerText.toLowerCase().includes(input)) {
                        match = true;
                        break;
                    }
                }
                rows[i].style.display = match ? "" : "none";

                if (match) {
                    found = true;
                }
            }

            // If no results match, show the "No results found" message
            if (!found) {
                noResultsMessage.style.display = "block";
            }
        }
    </script>

</body>
</html>
