<?php session_start(); ?> 
<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true): ?>
<style>

    .small-icon {
    font-size: 14px; /* Small icon size */
    color: #aaa; /* Light gray color for inactive icons */
    transition: color 0.2s ease;
}

</style>

<main id="main" class="main">
    <!-- header products -->
    <div class="pagetitle">
        <h1>Products Management</h1>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <a href="/products/create" class="btn btn-primary"> <i class="fas fa-plus"></i> Add Product</a>
        <div class="input-group w-50">
            <input
                type="text"
                id="searchInput"
                class="form-control"
                placeholder="Search product..."
                onkeyup="searchTable()">
            <button class="btn btn-secondary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="productTable" class="table" style="vertical-align: middle;">
            <thead>
                    <tr>
                        <th>Product Image</th>
                        <th onclick="sortTable(2)">
                            <div class="header-content">Product Name <i id="sortIconName" class="fas fa-arrow-up small-icon" ></i> <!-- Single arrow icon --></div>
                        </th>
                        <th onclick="sortTable(3)">
                            <div class="header-content">Expiration Date <i id="sortIconEndDate" class="fas fa-arrow-up small-icon"></i> <!-- Single arrow icon --></div>
                        </th>
                        <th onclick="sortTable(4)">
                            <div class="header-content">Barcode Number <i id="sortIconBarcode" class="fas fa-arrow-up small-icon"></i> <!-- Single arrow icon --></div>
                        </th>
                        <th onclick="sortTable(5)">
                            <div class="header-content">Unit Price <i id="sortIconPrice" class="fas fa-arrow-up small-icon"></i> <!-- Single arrow icon --></div>
                        </th>
                        <th onclick="sortTable(6)">
                            <div class="header-content">Stock Quantity <i id="sortIconQuantity" class="fas fa-arrow-up small-icon"></i> <!-- Single arrow icon --></div>
                        </th>
                        <th>Actions</th>
                    </tr>

            </thead>
            <tbody id="tableBody">
                <?php if (!empty($products) && is_array($products)) : ?>
                    <?php
                    // Pagination logic
                    $items_per_page = 7; // Number of items per page
                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL
                    $offset = ($current_page - 1) * $items_per_page; // Calculate offset
                    $total_products = count($products); // Total number of products
                    $total_pages = ceil($total_products / $items_per_page); // Total pages
                    $paginated_products = array_slice($products, $offset, $items_per_page); // Slice products for current page
                    ?>
                    <?php foreach ($paginated_products as $product) : ?>
                        <tr>
                            <td>
                                <?php if (!empty($product['image']) && $product['image'] !== "No Image") : ?>
                                    <img
                                        src="/uploads/<?php echo htmlspecialchars($product['image']); ?>"
                                        alt="Product Image"
                                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                <?php else : ?>
                                    <p style="margin-bottom:-3px;">No Image</p>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['end_date']); ?></td>
                            <td><?php echo htmlspecialchars($product['barcode']); ?></td>
                            <td>$<?php echo number_format((float)$product['price'], 2, '.', ''); ?></td>
                            <td><?php echo htmlspecialchars($product['quantity']); ?></td>
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
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small"
                                                href="/products/edit/<?= $product['id'] ?>" style="font-size: 0.8rem;">
                                                <i class="bi bi-pencil-square text-primary" style="font-size: 0.8rem;"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <?php
                                        if (isset($_SESSION['user_name']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small text-danger"
                                                    href="/products/delete/<?= $product['id'] ?>" style="font-size: 0.8rem;">
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
                        <td colspan="7">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div id="noResultsMessage" style="display: none; text-align: center;">
            <p>No results found.</p>
        </div>
    </div>
    <!-- Pagination Links -->
    <?php if (!empty($products) && $total_pages > 1) : ?>
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


<!-- Function for search name products -->
<script>
    function searchTable() {
        let input = document.getElementById("searchInput").value.toLowerCase().trim();
        let table = document.getElementById("productTable");
        let rows = table.getElementsByTagName("tr");
        let noResultsMessage = document.getElementById("noResultsMessage");
        let found = false;

        noResultsMessage.style.display = "none";

        for (let i = 1; i < rows.length; i++) {
            let columns = rows[i].getElementsByTagName("td");
            let match = false;

            for (let j = 1; j < columns.length - 1; j++) {
                let cellText = columns[j].innerText.toLowerCase().trim();

                // Normalize price values (remove '$' and compare as number)
                if (columns[j].innerText.includes('$')) {
                    cellText = parseFloat(columns[j].innerText.replace('$', '')).toFixed(2);
                }
                console.log("Searching for:", input, "in", cellText);

                if (cellText.includes(input)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? "" : "none";
            if (match) {
                found = true;
            }
        }

        if (!found) {
            noResultsMessage.style.display = "block";
        }
    }
    let sortDirection = {};

    function sortTable(columnIndex) {
    const table = document.getElementById("productTable");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));
    const sortIcon = document.getElementById(`sortIcon${getColumnName(columnIndex)}`);

    sortDirection[columnIndex] = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
    sortIcon.className = `fas fa-arrow-${sortDirection[columnIndex] === 'asc' ? 'up' : 'down'} small-icon`;

    rows.sort((a, b) => {
        const cellA = a.querySelector(`td:nth-child(${columnIndex})`).innerText.trim();
        const cellB = b.querySelector(`td:nth-child(${columnIndex})`).innerText.trim();

        if (columnIndex === 3) return (sortDirection[columnIndex] === 'asc' ? new Date(cellA) - new Date(cellB) : new Date(cellB) - new Date(cellA));
        if (columnIndex === 5) return (sortDirection[columnIndex] === 'asc' ? parseFloat(cellA.replace('$', '')) - parseFloat(cellB.replace('$', '')) : parseFloat(cellB.replace('$', '')) - parseFloat(cellA.replace('$', '')));
        if (columnIndex === 6) return (sortDirection[columnIndex] === 'asc' ? parseQuantity(cellA) - parseQuantity(cellB) : parseQuantity(cellB) - parseQuantity(cellA));
        return sortDirection[columnIndex] === 'asc' ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
    });

    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
    }

    const parseQuantity = (value) => parseInt(value.trim(), 10) || NaN;

    const getColumnName = (columnIndex) => ({
    2: 'Name', 3: 'EndDate', 4: 'Barcode', 5: 'Price', 6: 'Quantity'
    })[columnIndex] || '';

</script>

<?php else:
    $this->redirect('/users/login');
endif;
?>