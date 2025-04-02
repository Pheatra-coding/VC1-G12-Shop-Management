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
                            <td>
                                <a href="/categories/edit/<?php echo $category['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="/categories/delete/<?php echo $category['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
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
