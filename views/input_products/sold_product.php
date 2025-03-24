<style>
    /* Styling the entire form container */
    .form-group {
        margin-bottom: 1.5rem;
    }

    /* Button Styling */
    form .btn {
        background-color: #007bff;
        color: white;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 40px;
    }

    .form-group {
        width: 50%;
    }

    .pagination {
        display: flex;
        justify-content: center;
    }

    #quantity {
        border: 1px solid #007bff !important;

    }

    /* Ensure Select2 Dropdown Has the Same Border as the Quantity Input */
    .select2-container--default .select2-selection--single {
        border: 1px solid #007bff !important;
        /* Match the quantity input border */
        border-radius: 10px;
        /* Optional: Match the border rounding */
        height: 38px !important;
        /* Adjust height */
        padding: 8px;
        background-color: white;
    }

    /* Ensure Focused State Matches */
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:hover {
        border-color: #007bff !important;
        /* Keep border color consistent */
        outline: none !important;
        /* Optional: Add glow effect */
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Input Product Sale</h1>
    </div>

    <!-- Product Selection and Quantity Update Form -->
    <form action="/input_products/processSale" method="post">
        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="">

        <div class="form-container ">
            <div class="form-group">
                <label for="productSelect" class="form-label">Select Product:</label>
                <select class="form-control select2" id="productSelect" name="product_id" required>
                    <option></option>
                    <?php if (!empty($products)): ?>
                        <?php
                        $categories = array();
                        foreach ($products as $product) {
                            $categories[$product['category']][] = $product;
                        }
                        foreach ($categories as $category => $category_products): ?>
                            <optgroup label="<?php echo htmlspecialchars($category); ?>">
                                <?php foreach ($category_products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option disabled>No products available</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" step="1" required>
            </div>

        </div>
        <button type="submit" class="btn">Submit</button>
    </form>

    <div class="pagetitle mt-4 d-flex justify-content-between">
        <h1>Products Sale</h1>
        <div class="d-flex" style="width: 50%;"> <!-- Parent container set to 100% width -->
            <div class="input-group" style="width: 100%;"> <!-- Input group set to 100% of its container -->
                <input type="text" id="searchInput" class="form-control" placeholder="Search product..."
                    onkeyup="searchTable()"> <!-- Increase font size for better visibility -->
                <button class="btn btn-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="table-responsive mt-4">
        <table id="productTable" class="table" style="vertical-align: middle;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Sale Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if (!empty($sales)): ?>
                    <?php
                    // Pagination logic
                    $items_per_page = 4;
                    $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $items_per_page;
                    $total_sales = count($sales);
                    $total_pages = ceil($total_sales / $items_per_page);
                    $paginated_sales = array_slice($sales, $offset, $items_per_page);
                    ?>

                    <?php foreach ($paginated_sales as $sale): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sale['name']); ?></td>
                            <td><?php echo (int) $sale['quantity']; ?></td>
                            <td><?php echo "$" . htmlspecialchars($sale['total_price']); ?></td>
                            <td><?php echo htmlspecialchars($sale['sale_date']); ?></td>
                            <td class="text-center align-middle" style="width: 50px;">
                                <div class="dropdown">
                                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown" aria-expanded="false"
                                        style="cursor: pointer; font-size: 1.2rem; display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; transition: background 0.3s;"
                                        onmouseover="this.style.background='#f1f1f1'"
                                        onmouseout="this.style.background='transparent'">
                                    </i>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-2 border-0 p-1"
                                        style="min-width: 100px; margin-right: 30px;">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small"
                                                href="/input_products/edit/<?= $sale['id'] ?>" style="font-size: 0.8rem;">
                                                <i class="bi bi-pencil-square text-primary" style="font-size: 0.8rem;"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small text-danger"
                                                href="/input_products/delete<?= $sale['id'] ?>" style="font-size: 0.8rem;">
                                                <i class="bi bi-trash3" style="font-size: 0.8rem;"></i>
                                                Delete
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No products sold yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Component -->
    <?php if (!empty($sales) && $total_pages > 1): ?>
        <div class="pagination">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                        <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">

<script>
    $(document).ready(function () {
        $('#productSelect').select2({
            placeholder: "",
            allowClear: true,
            tags: false,
            width: '100%',
            minimumResultsForSearch: 3
        });
    });

    function searchTable() {
        let input = document.getElementById("searchInput").value.toLowerCase().trim();
        let table = document.getElementById("productTable");
        let rows = table.getElementsByTagName("tr");
        let found = false;

        for (let i = 1; i < rows.length; i++) {
            let columns = rows[i].getElementsByTagName("td");
            let match = false;

            for (let j = 0; j < columns.length; j++) {
                let cellText = columns[j].innerText.toLowerCase().trim();

                if (cellText.includes(input)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? "" : "none";
            if (match) found = true;
        }

        if (!found) {
            if (!document.getElementById("noResultsMessage")) {
                let row = document.createElement("tr");
                row.id = "noResultsMessage";
                row.innerHTML = `<td colspan="6" class="text-center text-danger">No results found.</td>`;
                table.appendChild(row);
            }
        } else {
            let messageRow = document.getElementById("noResultsMessage");
            if (messageRow) messageRow.remove();
        }
    }
</script>