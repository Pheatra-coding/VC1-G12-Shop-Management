<main id="main" class="main">
    <!-- 
        Professional and Interesting Card Display Style Using Bootstrap:
        - White background with deeper shadow (shadow)
        - Rounded corners (rounded-3)
        - Image at the top with object-fit-contain
        - Product name and price centered (text-center)
        - Total Items Sold and Last Sale Date left-aligned (text-start)
        - Reduced gaps between elements for a closer layout (mb-1, mb-2)
        - Smaller card size (w-100 with max-width)
        - Enhanced with Bootstrap classes, icons, and animations
        - No Add to Cart button
    -->
    <style>
        /* Minimal Custom CSS for Card Size, Hover Effect, and Animation */
        .card {
            max-width: 220px; /* Smaller width */
            height: 280px; /* Reduced height (no Add to Cart button) */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05); /* Slight scale on hover for interest */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Deeper shadow on hover */
        }

        .card-img-top {
            height: 140px; /* Smaller image height to fit reduced card height */
            object-fit: contain;
        }

        .no-image {
            height: 140px; /* Match smaller image height */
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
                    <div class="card border-0 shadow rounded-3 w-100 animate__animated animate__fadeInUp">
                        <?php if (!empty($product['image']) && file_exists("uploads/" . $product['image'])): ?>
                            <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top p-3 bg-white" alt="<?= htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            <div class="no-image bg-light d-flex align-items-center justify-content-center text-muted text-uppercase">
                                <span>No Image</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body p-2 d-flex flex-column">
                            <div class="text-center mb-1">
                                <h6 class="card-title product-name mb-1 fw-bold text-dark fs-5"><?= htmlspecialchars($product['name']); ?></h6>
                                <p class="text-success fw-bold mb-1 fs-6">$<?= number_format($product['price'], 2); ?></p>
                            </div>
                            <p class="text-muted mb-1 text-start fs-6">
                                <i class="bi bi-box-seam me-1 text-danger"></i>
                                Total Items Sold: <?= htmlspecialchars($product['total_sold']); ?>
                            </p>
                            <p class="text-muted mb-0 text-start fs-6">
                                <i class="bi bi-calendar-event me-1 text-success"></i>
                                Last Sale Date: <?= !empty($product['last_sale_date']) ? htmlspecialchars(date('M d, Y', strtotime($product['last_sale_date']))) : 'N/A'; ?>
                            </p>
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

<!-- External Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" integrity="sha384-tC78DdvCZzRZTUXbAtzS39FerrDGGXxs8P4r9X2d1dW39S80G2pzb4G" crossorigin="anonymous">
<!-- Animate.css for Fade-In Animation -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">