<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_name']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'):

    // Fetch all deleted users into an array
    $deletedUsers = $deletedUsers->fetchAll(PDO::FETCH_ASSOC); // Convert PDOStatement to an array

    // Pagination logic
    $items_per_page = 8; // Number of items per page
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL
    $offset = ($current_page - 1) * $items_per_page; // Calculate offset
    $total_users = count($deletedUsers); // Total number of users (now works because $deletedUsers is an array)
    $total_pages = ceil($total_users / $items_per_page); // Total pages
    $paginated_users = array_slice($deletedUsers, $offset, $items_per_page); // Slice users for current page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
 body {
            background-color: #f6f9ff;
        }

        .table {
            background-color: white;
            overflow: hidden;
        }

        a {
            text-decoration: none;
        }

        .image-column {
            width: 80px;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
        }

        .badge-deleted {
            background-color: #dc3545;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .dropdown-menu {
            min-width: 100px;
        }

        .dropdown-item {
            font-size: 0.8rem;
        }

        .bi-three-dots-vertical {
            cursor: pointer;
            font-size: 1.2rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .bi-three-dots-vertical:hover {
            background: #f1f1f1;
        }

        .bulk-actions {
            margin-bottom: 10px;
        }

        .bulk-actions button {
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .pagetitle h1 {
                font-size: 1.5rem;
            }

            .bulk-actions button {
                font-size: 0.8rem;
                padding: 5px 10px;
            }

            .input-group {
                width: 100% !important;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .table th, .table td {
                font-size: 0.9rem;
            }

            .dropdown-menu {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <main id="main" class="main">
        <!-- Header -->
        <div class="pagetitle">
            <h1>Deleted Users</h1>
        </div>

        <!-- Search Bar -->
        <div class="d-flex justify-content-between mb-3 flex-wrap">
             <!-- Bulk Actions -->
            <div class="bulk-actions">
                <button class="btn btn-primary btn-sm" style="margin-bottom: -14px;" onclick="restoreSelected()">Restore</button>
                <button class="btn btn-danger btn-sm" style="margin-bottom: -14px;" onclick="deleteSelected()">Delete Permanently</button>
            </div>

            <div class="input-group w-50">
                <input type="text" id="searchInput" class="form-control" placeholder="Search employee..." onkeyup="searchTable()">
                <button class="btn btn-secondary"><i class="fas fa-search"></i></button>
            </div>
        </div>

        <!-- Deleted Users Table -->
        <div class="table-responsive">
            <table id="deletedUsersTable" class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"></th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Deleted At</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (!empty($paginated_users) && is_array($paginated_users)) : ?>
                        <?php foreach ($paginated_users as $user) : ?>
                            <tr>
                                <td><input type="checkbox" class="user-checkbox" value="<?= $user['id'] ?>"></td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td><?= htmlspecialchars(date('d-M-Y', strtotime($user['deleted_at']))) ?></td>
                                <td>
                                    <span class="text-danger">Deleted</span>
                                </td>
                                <td class="text-center align-middle" style="width: 50px;">
                                    <div class="dropdown dropdown">
                                        <i class="bi bi-three-dots-vertical"
                                           data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                        </i>
                                        <ul class="dropdown-menu shadow-sm rounded-2 border-0 p-1">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small"
                                                    href="/users/restore/<?= $user['id'] ?>">
                                                        <i class="bi bi-arrow-counterclockwise text-primary"></i>
                                                        Restore
                                                </a>
                                            </li>

                                            <li>
                                                <form action="/users/permanently_delete/<?= $user['id'] ?>" method="POST" style="display:inline;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="page" value="<?= isset($_GET['page']) ? $_GET['page'] : 1 ?>"> <!-- Capture the current page -->
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small text-danger" style="border: none; background: none; padding: 0;">
                                                        <i class="bi bi-trash3"></i>
                                                        Delete Permanently
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="9" class="text-center">No deleted users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <?php if ($total_pages > 1) : ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                        <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>

        <!-- No Results Message (Initially Hidden) -->
        <div id="noResultsMessage" style="display:none; text-align: center;">
            <p>No results found.</p>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Checkboxes and Bulk Actions -->
    <script>
        // Toggle Select All Checkboxes
        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
        }

        // Restore Selected Users
        function restoreSelected() {
            const selectedIds = getSelectedUserIds(); // Get selected user IDs
            if (selectedIds.length > 0) {
                if (confirm('Are you sure you want to restore the selected users?')) {
                    // Make a POST request to restore selected users
                    fetch('/users/bulk_restore', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            'ids[]': selectedIds // Send IDs as an array
                        })
                    })
                    .then(response => response.json()) // Assuming the response is in JSON format
                    .then(data => {
                        if (data.success) {
                            alert('Users restored successfully!');
                            window.location.reload(); // Reload the page after restoring
                        } else {
                            alert('Failed to restore selected users.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while restoring users.');
                    });
                }
            } else {
                alert('Please select at least one user to restore.');
            }
        }

        // Delete Selected Users Permanently
        function deleteSelected() {
            const selectedIds = getSelectedUserIds();
            if (selectedIds.length > 0) {
                if (confirm('Are you sure you want to permanently delete the selected users?')) {
                    // Create a URL-encoded string of the selected IDs
                    const params = new URLSearchParams();
                    selectedIds.forEach(id => {
                        params.append('ids[]', id); // Send as an array
                    });

                    // Send the request with all selected IDs
                    fetch('/users/bulk_permanently_delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: params.toString() // Send IDs as a URL-encoded string
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.reload(); // Reload page after deletion
                        } else {
                            alert('Failed to delete selected users.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            } else {
                alert('Please select at least one user to delete.');
            }
        }

        // Get Selected User IDs
        function getSelectedUserIds() {
            const checkboxes = document.querySelectorAll('.user-checkbox:checked');
            const selectedIds = [];
            checkboxes.forEach(checkbox => {
                selectedIds.push(checkbox.value);
            });
            return selectedIds;
        }

        // Search Functionality
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("deletedUsersTable");
            let rows = table.getElementsByTagName("tr");
            let noResultsMessage = document.getElementById("noResultsMessage");
            let found = false;

            // Hide the no results message initially
            noResultsMessage.style.display = "none";

            for (let i = 1; i < rows.length; i++) {
                let columns = rows[i].getElementsByTagName("td");
                let match = false;

                for (let j = 2; j < columns.length - 1; j++) {
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

<?php else:
    header("Location: /users/login");
    exit;
endif;