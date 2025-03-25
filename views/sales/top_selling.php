<main id="main" class="main">

<!-- CSS (Focused on Card Internals) -->
<style>
    /* Card Container */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
        height: 350px; /* Medium height for the card */
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Card Image */
    .card-img-top {
        transition: transform 0.3s ease;
        border-radius: 10px 10px 0 0;
        width: 100%;
        height: 180px; /* Adjusted height for medium-sized cards */
        object-fit: cover; /* Ensure images cover the area */
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    /* Card Body */
    .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1; /* Allow body to grow and fill remaining space */
    }

    /* Product Name */
    .card-title {
        font-size: 1.20rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #333; /* Darker text for better readability */
    }

    /* Price */
    .text-success {
        font-weight: 700;
        color: #28a745;
        margin-bottom: 0.5rem;
    }

    /* Quantity and Date */
    .text-muted {
        font-size: 0.76rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    /* No Image Placeholder */
    .no-image {
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 180px; /* Match image height */
        font-size: 1rem;
        color: #6c757d;
    }
</style>

<!-- Header -->
<div class="pagetitle">
    <h1>Top Selling Products</h1>
</div>

<!-- Search Box -->
<div class="d-flex justify-content-end mb-3">
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
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="productGrid">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="col product-item">
                <div class="card border-0 shadow-sm product-card">
                    <?php if (!empty($product['image']) && file_exists("/views/uploads/" . $product['image'])): ?>
                        <img src="/views/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <div class="no-image">
                            <span>No Image</span>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h6 class="card-title product-name mb-1"><?= htmlspecialchars($product['name']); ?></h6>
                        <p class="text-success fw-bold mb-2">$<?= number_format($product['price'], 2); ?></p>
                        <p class="text-muted mb-1">Total Items Sold: <?= htmlspecialchars($product['total_sold']); ?></p>
                        <p class="text-muted mb-0">Last Sale Date: <?= !empty($product['last_sale_date']) ? htmlspecialchars(date('M d, Y', strtotime($product['last_sale_date']))) : 'N/A'; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- No Products Message -->
        <div class="col-12 text-center mt-4">
            <div class="alert alert-warning" role="alert">
                No top-selling products available at the moment.
            </div>
        </div>
    <?php endif; ?>
</div>
</main>

<!-- JavaScript for Search -->
<script>
    function searchTable() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let productItems = document.querySelectorAll('.product-item');

        let hasResults = false;

        productItems.forEach(item => {
            let productName = item.querySelector('.product-name').innerText.toLowerCase();
            
            // Show or hide products based on search input
            if (productName.includes(input)) {
                item.style.display = '';
                hasResults = true;
            } else {
                item.style.display = 'none';
            }
        });

        // Show or hide the no products message based on search results
        let noProductsMessage = document.getElementById('noProductsMessage');
        if (noProductsMessage) {
            noProductsMessage.style.display = hasResults ? 'none' : 'block';
        }
    }
</script>