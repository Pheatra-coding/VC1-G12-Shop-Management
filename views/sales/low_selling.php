<main id="main" class="main">
    <style>
        .card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background-color: #ffffff;
            height: 400px;
            width: 100%;
            max-width: 300px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            position: relative;
            margin: 0 auto;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            display: none; /* Hide the header since name and price are moved */
        }
        .price-header {
            color: #1e40af;
            font-size: 1.15rem;
            font-weight: 600;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .card:hover .price-header {
            transform: translateY(-2px);
            background: #dbeafe;
        }
        .card-img-top {
            width: 100%;
            height: 220px;
            object-fit: contain;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            background: transparent;
            padding: 1rem;
        }
        .card:hover .card-img-top {
            transform: scale(1.02);
            filter: brightness(1.03);
        }
        .card-body {
            padding: 1rem 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
        }
        .content-center {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            gap: 0.5rem;
        }
        .name-price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.5rem;
        }
        .card-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0;
            line-height: 1.3;
            text-transform: capitalize;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            transition: color 0.3s ease;
            flex: 1; /* Allows it to take available space */
        }
        .card:hover .card-title {
            color: #1e40af;
        }
        .text-muted {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 500;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            /* Removed transition for hover */
        }
        .text-muted i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
            color: #dc2626;
            /* Removed transition for hover */
        }
        .text-muted:nth-child(2) i { /* Adjusted for new order: date is now 2nd */
            color: #16a34a;
        }
        /* Removed .card:hover .text-muted and .card:hover .text-muted i */
        .no-image {
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 220px;
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 500;
            border-radius: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }
    </style>

    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Low Selling Products</h1>
    </div>

    <!-- Search Box -->
    <div class="d-flex justify-content-end mb-3">
        <div class="input-group w-50">
            <input type="text" id="searchInput" class="form-control" placeholder="Search low selling products..." onkeyup="searchTable()">
            <button class="btn btn-secondary" aria-label="Search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="productGrid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col product-item">
                    <div class="card border-0 shadow-sm">
                        <?php if (!empty($product['image']) && file_exists("views/uploads/" . $product['image'])): ?>
                            <img src="/views/uploads/<?= htmlspecialchars($product['image']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            <div class="no-image"><span>No Image</span></div>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="content-center">
                                <div class="name-price-row">
                                    <h6 class="card-title product-name"><?= htmlspecialchars($product['name']); ?></h6>
                                    <div class="price-header">
                                        <i class="bi bi-currency-dollar me-1"></i>
                                        <?= number_format($product['price'], 2); ?>
                                    </div>
                                </div>
                                <p class="text-muted">
                                    <i class="bi bi-box-seam"></i>
                                    Stock: <?= htmlspecialchars($product['quantity']); ?>
                                </p>
                                <p class="text-muted">
                                    <i class="bi bi-calendar-event"></i>
                                    <?= htmlspecialchars(date('M d, Y', strtotime($product['updated_at']))); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center mt-4">
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    No low-selling products available at the moment.
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- JavaScript for Search Functionality -->
<script>
    function searchTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const productItems = document.querySelectorAll('.product-item');
        let hasResults = false;

        productItems.forEach(item => {
            const productName = item.querySelector('.product-name').innerText.toLowerCase();
            item.style.display = productName.includes(input) ? '' : 'none';
            if (productName.includes(input)) hasResults = true;
        });

        const noProductsMessage = document.getElementById('noProductsMessage');
        if (noProductsMessage) {
            noProductsMessage.style.display = hasResults ? 'none' : 'block';
        }
    }
</script>

<!-- External Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" integrity="sha384-tC78DdvCZzRZTUXbAtzS39FerrDGGXxs8P4r9X2d1dW39S80G2pzb4G" crossorigin="anonymous">