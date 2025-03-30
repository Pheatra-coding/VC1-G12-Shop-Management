<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_name']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'):
    $items_per_page = 8;
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $items_per_page;
    $total_transactions = count($transactions);
    $total_pages = ceil($total_transactions / $items_per_page);
    $paginated_transactions = array_slice($transactions, $offset, $items_per_page);
?>
    <style>
        body {
            background-color: #f6f9ff;
        }

        .table {
            background-color: white;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .pagetitle h1 {
                font-size: 1.5rem;
            }

            .table th,
            .table td {
                font-size: 0.9rem;
            }
        }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Sold History</h1>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <div class="input-group w-50">
                <input type="text" id="searchInput" class="form-control" placeholder="Search sold products..." onkeyup="searchTable()">
                <button class="btn btn-secondary" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Sale Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($paginated_transactions) && is_array($paginated_transactions)) : ?>
                        <?php foreach ($paginated_transactions as $transaction) : ?>
                            <tr class="product-item">
                                <td class="product-name"><?= htmlspecialchars($transaction['product_name']) ?></td>
                                <td><?= htmlspecialchars($transaction['quantity']) ?></td>
                                <td><?= htmlspecialchars($transaction['total_price']) ?></td>
                                <td><?= htmlspecialchars(date('d-M-Y', strtotime($transaction['sale_date']))) ?></td>
                                <td class="text-center align-middle" style="width: 50px;">
                                    <div class="dropdown dropdown">
                                        <i class="bi bi-three-dots-vertical"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="cursor: pointer; font-size: 1.2rem; display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; transition: background 0.3s;"
                                            onmouseover="this.style.background='#f1f1f1'"
                                            onmouseout="this.style.background='transparent'">
                                        </i>
                                        <ul class="dropdown-menu shadow-sm rounded-2 border-0 p-1" style="min-width: 100px;">
                                            <!-- <li>
                                                <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small"
                                                    href="/products/edit/<?= $product['id'] ?>" style="font-size: 0.8rem;">
                                                    <i class="bi bi-pencil-square text-primary" style="font-size: 0.8rem;"></i>
                                                    Edit
                                                </a>
                                            </li> -->
                                            <?php
                                            if (isset($_SESSION['user_name']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small text-danger"
                                                    href="/sold_history/delete/<?= $transaction['product_id'] ?>"
                                                    onclick="return confirmDelete(event, '<?= htmlspecialchars($transaction['product_name']) ?>')"
                                                    style="font-size: 0.8rem;">
                                                    <i class="bi bi-trash3" style="font-size: 0.8rem;"></i>
                                                    Delete
                                                </a>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center">No transactions found.</td>
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
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function searchTable() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.product-item');
            let hasResults = false;

            rows.forEach(row => {
                const productName = row.querySelector('.product-name').innerText.toLowerCase();
                row.style.display = productName.includes(input) ? '' : 'none';
                if (productName.includes(input)) hasResults = true;
            });

            const noProductsMessage = document.getElementById('noProductsMessage');
            if (noProductsMessage) {
                noProductsMessage.style.display = hasResults ? 'none' : 'block';
            }
        }
    </script>
    <script>
        function confirmDelete(event, productName) {
            event.preventDefault(); // Prevent the default link action

            // Show SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete "${productName}". This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, navigate to the delete link
                    window.location.href = event.target.href;
                }
            });
        }
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php else:
    header("Location: /users/login");
    exit;
endif; ?>