<?php session_start(); ?>
<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true): ?>
    <style>
        .small-icon {
            font-size: 14px;
            color: #aaa;
            transition: color 0.2s ease;
        }

        .category-container {
            margin-bottom: 20px;
        }

        .products-list {
            display: none;
            margin-top: 10px;
        }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Categories List</h1>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <a href="/categories/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Category
            </a>
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
            <table id="categoryTable" class="table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories) && is_array($categories)) : ?>
                        <?php foreach ($categories as $category) : ?>
                            <tr class="category-container">
                                <td>
                                    <button class="btn btn-secondary" onclick="toggleProducts(<?php echo $category['id']; ?>)">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </button>
                                    <div id="products-<?php echo $category['id']; ?>" class="products-list">
                                        <ul>
                                            <?php if (!empty($category['products'])) : ?>
                                                <?php foreach ($category['products'] as $product) : ?>
                                                    <li><?php echo htmlspecialchars($product['category_name']); ?> - $<?php echo number_format($product['price'], 2); ?></li>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <li><em>No products available</em></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
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
                                                    href="/categories/edit/<?= $category['id'] ?>" style="font-size: 0.8rem;">
                                                    <i class="bi bi-pencil-square text-primary" style="font-size: 0.8rem;"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <?php
                                            if (isset($_SESSION['user_name']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small text-danger"
                                                        href="/categories/delete/<?= $category['id'] ?>" style="font-size: 0.8rem;">
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
                            <td colspan="2">No categories found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function toggleProducts(categoryId) {
            let productList = document.getElementById("products-" + categoryId);
            if (productList.style.display === "none" || productList.style.display === "") {
                productList.style.display = "block";
            } else {
                productList.style.display = "none";
            }
        }
    </script>

<?php else:
    $this->redirect('/users/login');
endif; ?>
<script>
    function searchTable() {
        let input = document.getElementById("searchInput").value.toLowerCase().trim();
        let table = document.getElementById("categoryTable"); // Corrected table ID
        let rows = table.getElementsByTagName("tr");
        let noResultsMessage = document.getElementById("noResultsMessage");
        let found = false;

        if (!noResultsMessage) {
            noResultsMessage = document.createElement("p");
            noResultsMessage.id = "noResultsMessage";
            noResultsMessage.innerText = "No matching categories found.";
            noResultsMessage.style.color = "red";
            noResultsMessage.style.display = "none";
            table.parentNode.appendChild(noResultsMessage); // Append after table
        }

        noResultsMessage.style.display = "none";

        for (let i = 1; i < rows.length; i++) {
            let columns = rows[i].getElementsByTagName("td");
            let match = false;

            for (let j = 0; j < columns.length; j++) { // Changed from j=1 to j=0
                let cellText = columns[j].innerText.toLowerCase().trim();

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
</script>