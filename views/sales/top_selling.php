<main id="main" class="main">
    <style>
        /* Card Container */
        .card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background-color: #ffffff;
            height: 350px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            position: relative;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        }

        /* Card Image */
        .card-img-top {
            transition: all 0.3s ease;
            border-radius: 0;
            width: 100%;
            height: 180px;
            object-fit: contain;
            background: transparent;
            padding: 1rem;
        }

        .card:hover .card-img-top {
            transform: scale(1.02);
            filter: brightness(1.03);
        }

        /* Card Body */
        .card-body {
            padding: 1rem 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
        }

        /* Product Name */
        .card-title {
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #111827;
            line-height: 1.3;
            text-transform: capitalize;
            text-align: center; /* Center align the title */
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            transition: color 0.3s ease;
        }

        .card:hover .card-title {
            color: #1e40af;
        }

        /* Price */
        .price-container {
            text-align: center; /* Center align the price */
            margin-bottom: 1rem; /* Added space below price */
        }

        .text-success {
            font-weight: 600;
            color: #1e40af;
            font-size: 1.15rem;
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            transition: transform 0.3s ease, background 0.3s ease;
            display: inline-block; /* Allows transform to work properly */
        }

        .card:hover .text-success {
            transform: translateY(-2px);
        }

        /* Stats row */
        .stats-row {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
            justify-content: space-between;
            flex-grow: 1;
        }

        /* Stat item */
        .stat-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        /* Small icon style */
        .stat-icon {
            font-size: 1.1rem;
            color: #6b7280;
            margin-right: 0.5rem;
        }

        /* Adjust icon colors */
        .stat-item:nth-child(1) .stat-icon {
            color: #16a34a;
        }
        .stat-item:nth-child(2) .stat-icon {
            color: #dc2626;
        }

        /* Small text style */
        .small-stat-text {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0;
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
        }

        /* No Image Placeholder */
        .no-image {
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 180px;
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 500;
            border-radius: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
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
                        <?php if (!empty($product['image']) && file_exists("views/uploads/" . $product['image'])): ?>
                            <img src="/views/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            <div class="no-image">
                                <span>No Image</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title product-name"><?= htmlspecialchars($product['name']); ?></h6>
                            <div class="price-container">
                                <p class="text-success fw-bold mb-0">$<?= number_format($product['price'], 2); ?></p>
                            </div>
                            <div class="stats-row">
                                <div class="stat-item">
                                    <i class="stat-icon bi bi-box-seam"></i>
                                    <p class="small-stat-text mb-0">Quantity: <?= htmlspecialchars($product['total_sold']); ?></p>
                                </div>
                                <div class="stat-item">
                                    <i class="stat-icon bi bi-calendar-event"></i>
                                    <p class="small-stat-text mb-0"><?= !empty($product['last_sale_date']) ? htmlspecialchars(date('M d, Y', strtotime($product['last_sale_date']))) : 'N/A'; ?></p>
                                </div>
                            </div>
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