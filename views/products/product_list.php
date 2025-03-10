
    <main id="main" class="main">
        <!-- header products -->
        <div class="pagetitle">
            <h1>Product Management</h1>
        </div>
            <div class="d-flex justify-content-between mb-3">
                <a href="/products/create" class="btn btn-primary">Add Product</a>
                <div class="input-group w-50">
                    <input 
                        type="text" 
                        id="searchInput" 
                        class="form-control" 
                        placeholder="Search product..." 
                        onkeyup="searchTable()"
                    >
                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="productTable" class="table" style="vertical-align: middle;">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>End Date</th>
                            <th>Barcode</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php if (!empty($products) && is_array($products)) : ?>
                            <?php foreach ($data['products'] as $product) : ?>
                                <tr>
                                    <td>
                                        <?php if ($product['image']) : ?>
                                            <img 
                                                src="/uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                                alt="Product Image" 
                                                style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover;"
                                            >
                                        <?php else : ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['end_date']); ?></td>
                                    <td><?php echo htmlspecialchars($product['barcode']); ?></td>
                                    <td>$<?php echo number_format((float)$product['price'], 2, '.', ''); ?></td>
                                    <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button 
                                                class="btn btn-action dropdown-toggle" 
                                                type="button" 
                                                id="actionsDropdown-<?php echo $product['id']; ?>" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false"
                                            >
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul 
                                                class="dropdown-menu dropdown-menu-action" 
                                                aria-labelledby="actionsDropdown-<?php echo $product['id']; ?>"
                                            >
                                                <li>
                                                    <a 
                                                        class="dropdown-item action-item" 
                                                        href="/products/edit/<?php echo $product['id']; ?>"
                                                    >
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a 
                                                        class="dropdown-item action-item" 
                                                        href="/products/delete/<?php echo $product['id']; ?>"
                                                    >
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
                                <td colspan="7">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div id="noResultsMessage" style="display: none; text-align: center;">
                    <p>No results found.</p>
                </div>
            </div>
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

    </script>