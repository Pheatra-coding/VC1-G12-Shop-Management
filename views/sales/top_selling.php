<main id="main" class="main">
    <!-- header top selling -->
    <div class="pagetitle">
        <h1>Top Selling Products</h1>
    </div>

    <!-- Search Box -->
    <div class="d-flex justify-content-end mb-3 ">
        <div class="input-group w-50">
            <input
                type="text"
                id="searchInput"
                class="form-control"
                placeholder="Search top selling product..."
                onkeyup="searchTable()">
            <button class="btn btn-secondary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row row-cols-1 row-cols-md-4 g-4" id="productGrid">
        <?php if (empty($products)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    No top-selling products.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col product-item">
                    <div class="card h-60 border-0 shadow-sm">
                        <?php if (!empty($product['image']) && file_exists("uploads/" . $product['image'])): ?>
                            <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top p-3" alt="<?= $product['name']; ?>">
                        <?php else: ?>
                            <div class="text-center p-3">
                                <div class="bg-light p-5 d-flex align-items-center justify-content-center">
                                    <span class="text-muted">No Image</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h6 class="card-title product-name"><?= $product['name']; ?></h6>
                            <p class="text-success fw-bold">$<?= number_format($product['price'], 2); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<!-- JavaScript for Search -->
<script>
    function searchTable() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let productItems = document.querySelectorAll('.product-item');

        productItems.forEach(item => {
            let productName = item.querySelector('.product-name').innerText.toLowerCase();
            
            // Show or hide products based on search input
            if (productName.includes(input)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
