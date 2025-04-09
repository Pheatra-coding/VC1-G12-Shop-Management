<?php session_start(); ?>
<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true): ?>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #6c757d;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
        }

        .category-container {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 12px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .category-container:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            cursor: pointer;
            border-bottom: 1px solid var(--medium-gray);
        }

        .category-title {
            font-weight: 600;
            color: var(--secondary-color);
            margin: 0;
            font-size: 1.1rem;
        }

        .products-list {
            padding: 0 16px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }

        .products-list.show {
            max-height: 500px;
            padding: 16px;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--medium-gray);
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-name {
            font-weight: 500;
            word-break: break-word;
        }

        .product-details {
            color: var(--dark-gray);
            font-size: 0.9rem;
            display: flex;
            gap: 15px;
        }

        .no-products {
            color: var(--dark-gray);
            font-style: italic;
            padding: 10px 0;
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--dark-gray);
            padding: 5px;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 8px 0;
        }

        .dropdown-item {
            padding: 8px 16px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown-item:hover {
            background-color: var(--light-gray);
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
        }

        .search-container {
            max-width: 400px;
            transition: all 0.3s ease;
        }

        .search-container.collapsed {
            max-width: 40px;
            overflow: hidden;
        }

        .search-container.collapsed .form-control,
        .search-container.collapsed .input-group-text {
            display: none;
        }

        .search-container.collapsed .btn {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            padding: 0;
        }

        .empty-state {
            text-align: center;
            color: var(--dark-gray);
            padding: 40px 20px;
        }

        .empty-state .bi-folder-x {
            font-size: 3rem;
            color: var(--medium-gray);
            margin-bottom: 15px;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .category-header {
                padding: 12px;
            }

            .category-title {
                font-size: 1rem;
            }

            .products-list.show {
                padding: 12px;
            }

            .product-item {
                flex-direction: column;
                gap: 4px;
            }

            .product-details {
                flex-direction: column;
                gap: 4px;
            }

            .search-container {
                width: auto;
                max-width: none;
            }

            .card-title {
                font-size: 1.2rem;
            }

            .breadcrumb {
                font-size: 0.9rem;
            }

            .btn-add-new {
                width: 40px;
                height: 40px;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .btn-add-new span {
                display: none;
            }

            .btn-add-new i {
                margin: 0;
            }

            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .d-flex.gap-2 {
                width: 100%;
                justify-content: space-between;
            }
        }

        /* Desktop styles */
        @media (min-width: 769px) {
            .btn-add-new i {
                margin-right: 8px;
            }

            .search-container.collapsed {
                max-width: 400px;
            }

            .search-container.collapsed .form-control,
            .search-container.collapsed .input-group-text {
                display: block;
            }

            .search-container.collapsed .btn {
                border-radius: 0 0.375rem 0.375rem 0;
                width: auto;
                height: auto;
                padding: 0.375rem 0.75rem;
            }
        }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Product Categories</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0">All Categories</h5>
                                <div class="d-flex gap-2">
                                    <div class="search-container collapsed" id="searchContainer">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                id="searchInput"
                                                class="form-control"
                                                placeholder="Search categories..."
                                                onkeyup="searchTable()">
                                            <button class="btn btn-secondary" onclick="toggleSearch()">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <a href="/categories/create" class="btn btn-primary btn-add-new">
                                        <i class="bi bi-plus-lg"></i><span>Add New</span>
                                    </a>
                                </div>
                            </div>

                            <div id="categoryList">
                                <?php if (!empty($categories) && is_array($categories)) : ?>
                                    <?php foreach ($categories as $category) : ?>
                                        <div class="category-container">
                                            <div class="category-header" onclick="toggleProducts(<?php echo $category['id']; ?>)">
                                                <div class="d-flex align-items-center gap-3">
                                                    <i class="bi bi-folder-fill text-primary"></i>
                                                    <h3 class="category-title"><?php echo htmlspecialchars($category['category_name']); ?></h3>
                                                    <span class="badge bg-light text-dark">
                                                        <?php echo !empty($category['products']) ? count($category['products']) : 0; ?> items
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="dropdown">
                                                        <button class="action-btn" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation()">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu " style="min-width: 100px;">
                                                            <li>
                                                                <a class="dropdown-item" href="/categories/edit/<?= $category['id'] ?>" style="font-size: 0.8rem;">
                                                                    <i class="bi bi-pencil-square text-primary me-2" style="font-size: 0.8rem;"></i>Edit
                                                                </a>
                                                            </li>
                                                            <?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                                                                <li>
                                                                    <a class="dropdown-item text-danger" href="/categories/delete/<?= $category['id'] ?>" style="font-size: 0.8rem;">
                                                                        <i class="bi bi-trash3 me-2" style="font-size: 0.8rem;"></i>Delete
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                    <button class="action-btn">
                                                        <i class="bi bi-chevron-down"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div id="products-<?php echo $category['id']; ?>" class="products-list">
                                                <?php if (!empty($category['products']) && is_array($category['products'])) : ?>
                                                    <?php foreach ($category['products'] as $product) : ?>
                                                        <div class="product-item">
                                                            <span class="product-name">
                                                                <?php echo htmlspecialchars($product['name']); ?>
                                                            </span>
                                                            <span class="product-details">
                                                                $<?php echo number_format($product['price'], 2); ?>
                                                                <span>Qty: <?php echo htmlspecialchars($product['quantity']); ?></span>
                                                            </span>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <div class="no-products">No products in this category</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="empty-state">
                                        <i class="bi bi-folder-x"></i>
                                        <h4>No Categories Found</h4>
                                        <p>Get started by adding your first category</p>
                                        <a href="/categories/create" class="btn btn-primary">
                                            <i class="bi bi-plus-lg"></i> Add Category
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function toggleProducts(categoryId) {
            const productList = document.getElementById(`products-${categoryId}`);
            const chevron = event.currentTarget.querySelector('.bi-chevron-down');

            productList.classList.toggle('show');
            chevron.classList.toggle('bi-chevron-down');
            chevron.classList.toggle('bi-chevron-up');
        }

        function searchTable() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const categories = document.querySelectorAll('.category-container');
            let hasResults = false;

            categories.forEach(category => {
                const categoryName = category.querySelector('.category-title').textContent.toLowerCase();
                const productItems = category.querySelectorAll('.product-name');
                let categoryMatch = categoryName.includes(input);
                let productMatch = false;

                // Check if any product in this category matches
                productItems.forEach(item => {
                    if (item.textContent.toLowerCase().includes(input)) {
                        productMatch = true;
                    }
                });

                if (categoryMatch || productMatch) {
                    category.style.display = '';
                    hasResults = true;

                    // Show products if there was a product match
                    const productsList = category.querySelector('.products-list');
                    if (productMatch) {
                        productsList.classList.add('show');
                        category.querySelector('.bi-chevron-down').classList.add('bi-chevron-up');
                        category.querySelector('.bi-chevron-down').classList.remove('bi-chevron-down');
                    }
                } else {
                    category.style.display = 'none';
                }
            });

            // Show empty state if no results
            const emptyState = document.querySelector('.empty-state');
            if (!hasResults && categories.length > 0) {
                if (!emptyState) {
                    const emptyHtml = `
                        <div class="empty-state">
                            <i class="bi bi-search"></i>
                            <h4>No matching results</h4>
                            <p>Try adjusting your search query</p>
                        </div>
                    `;
                    document.getElementById('categoryList').insertAdjacentHTML('beforeend', emptyHtml);
                } else if (emptyState.querySelector('h4').textContent !== 'No matching results') {
                    emptyState.innerHTML = `
                        <i class="bi bi-search"></i>
                        <h4>No matching results</h4>
                        <p>Try adjusting your search query</p>
                    `;
                }
            } else if (emptyState && emptyState.querySelector('h4').textContent === 'No matching results') {
                emptyState.remove();
            }
        }

        function toggleSearch() {
            const searchContainer = document.getElementById('searchContainer');
            const searchInput = document.getElementById('searchInput');
            
            // Only prevent default on mobile where we want the icon-only behavior
            if (window.innerWidth <= 768) {
                event.preventDefault();
                searchContainer.classList.toggle('collapsed');
                
                // Focus input when expanded
                if (!searchContainer.classList.contains('collapsed')) {
                    searchInput.focus();
                }
            }
        }

        // Close search when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const searchContainer = document.getElementById('searchContainer');
            const searchInput = document.getElementById('searchInput');
            
            if (window.innerWidth <= 768 && 
                !searchContainer.contains(event.target) && 
                !searchContainer.classList.contains('collapsed')) {
                searchContainer.classList.add('collapsed');
            }
        });
    </script>

<?php else:
    $this->redirect('/users/login');
endif; ?>