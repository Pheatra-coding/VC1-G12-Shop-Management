<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_name']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'):
    // Pagination logic
    $items_per_page = 7; // Number of items per page
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL
    $offset = ($current_page - 1) * $items_per_page; // Calculate offset
    $total_users = count($users); // Total number of users
    $total_pages = ceil($total_users / $items_per_page); // Total pages
    $paginated_users = array_slice($users, $offset, $items_per_page); // Slice users for current page
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shop Management</title>
        <!-- Bootstrap 5 CSS -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </head>
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

        x .image-column {
            width: 80px;
        }

        .invalid-feedback {
            display: block;
            color: rgb(246, 112, 125);
        }

        .status-active {
            color: #027A48;
            background-color: #ECFDF3;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
        }

        .status-inactive {
            color: #F15046;
            background-color: #FFF2EA;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
        }

        .status-icon {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-active .status-icon {
            background-color: #027A48;
        }

        .status-inactive .status-icon {
            background-color: #F15046;
        }

        .small-icon {
            font-size: 14px;
            color: #aaa;
            transition: color 0.2s ease;
        }
    </style>

    </head>

    <body>

        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Employees Management</h1>
            </div>
            <!-- Add Employee & Search Bar -->
            <div class="d-flex justify-content-between mb-3">
                <a href="/users/create" class="btn btn-primary">Add Employee</a>
                <div class="input-group w-50">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search employee..." onkeyup="searchTable()">
                    <button class="btn btn-secondary"><i class="fas fa-search"></i></button>
                </div>
            </div>

            <table id="employeeTable" class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th onclick="sortTable(2)">
                            <div class="header-content">Username <i id="sortIconUsername" class="fas fa-arrow-up small-icon"></i></div>
                        </th>
                        <th onclick="sortTable(3)">
                            <div class="header-content">Email <i id="sortIconEmail" class="fas fa-arrow-up small-icon"></i></div>
                        </th>
                        <th onclick="sortTable(4)">
                            <div class="header-content">Role <i id="sortIconRole" class="fas fa-arrow-up small-icon"></i></div>
                        </th>
                        <th onclick="sortTable(5)">
                            <div class="header-content">Status <i id="sortIconStatus" class="fas fa-arrow-up small-icon"></i></div>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (!empty($paginated_users) && is_array($paginated_users)) : ?>
                        <?php foreach ($paginated_users as $user) : ?>
                            <tr>
                                <td>
                                    <img src="<?= !empty($user['image']) ? 'uploads/' . htmlspecialchars($user['image']) : 'https://cdn-icons-png.flaticon.com/512/8847/8847419.png'; ?>"
                                        alt="User Image" class="img-fluid user-img"
                                        style="width: 40px; height: 40px; border-radius: 50%;">
                                </td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td>
                                    <span class="<?= htmlspecialchars($user['status']) == 'Active' ? 'status-active' : 'status-inactive'; ?>">
                                        <span class="status-icon"></span> <!-- Circle icon -->
                                        <?= htmlspecialchars($user['status']) == 'Active' ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td class="text-center align-middle" style="width: 50px;">
                                    <div class="dropdown">
                                        <i class="bi bi-three-dots-vertical"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="cursor: pointer; font-size: 1.2rem; display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; transition: background 0.3s;"
                                            onmouseover="this.style.background='#f1f1f1'"
                                            onmouseout="this.style.background='transparent'">
                                        </i>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-2 border-0 p-1" style="min-width: 100px; margin-right: 30px;">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small"
                                                    href="/users/edit/<?= $user['id'] ?>" style="font-size: 0.8rem;">
                                                    <i class="bi bi-pencil-square text-primary" style="font-size: 0.8rem;"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small text-danger"
                                                    href="/users/delete/<?= $user['id'] ?>" style="font-size: 0.8rem;">
                                                    <i class="bi bi-trash3" style="font-size: 0.8rem;"></i>
                                                    Delete
                                                </a>
                                            </li>
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

            let sortDirection = {};

            function sortTable(columnIndex) {
                const table = document.getElementById("employeeTable");
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.querySelectorAll("tr"));
                const columnName = getColumnName(columnIndex);
                const sortIcon = document.getElementById(`sortIcon${columnName}`);

                // Toggle sorting direction
                sortDirection[columnIndex] = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
                sortIcon.className = `fas fa-arrow-${sortDirection[columnIndex] === 'asc' ? 'up' : 'down'} small-icon`;

                rows.sort((a, b) => {
                    const cellA = a.querySelector(`td:nth-child(${columnIndex})`)?.innerText.trim();
                    const cellB = b.querySelector(`td:nth-child(${columnIndex})`)?.innerText.trim();

                    if (!cellA || !cellB) return 0; // Prevent sorting errors

                    // Default: Text sorting (case-insensitive)
                    return sortDirection[columnIndex] === 'asc' ?
                        cellA.localeCompare(cellB, undefined, {
                            sensitivity: 'base'
                        }) :
                        cellB.localeCompare(cellA, undefined, {
                            sensitivity: 'base'
                        });
                });

                // Append sorted rows back to table
                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));
            }

            // Map correct column names to match header icon IDs
            function getColumnName(columnIndex) {
                return {
                    2: 'Username',
                    3: 'Email',
                    4: 'Role',
                    5: 'Status'
                } [columnIndex] || '';
            }
        </script>

    </body>

    </html>

<?php else:
    $this->redirect('/users/login');
endif;
?>