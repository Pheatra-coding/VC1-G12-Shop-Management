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
            animation: fadeInUp 0.5s ease forwards;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.25rem;
            position: relative;
            z-index: 1;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-bottom: 1px solid #d1d5db;
        }

        .price-header {
            color: #1e3a8a;
            font-size: 1.15rem;
            font-weight: 600;
            text-align: center;
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            transition: transform 0.3s ease, background 0.3s ease;
            background: #ffffff;
        }

        .card:hover .price-header {
            transform: translateY(-2px);
            background: #e0e7ff;
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
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.05));
        }

        .card:hover .card-img-top {
            transform: scale(1.02);
            filter: brightness(1.03) drop-shadow(0 6px 12px rgba(0, 0, 0, 0.08));
        }

        .card-body {
            padding: 1rem 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
            background: linear-gradient(to top, #f8fafc, #ffffff);
        }

        .content-center {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            gap: 0.5rem;
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0;
            line-height: 1.3;
            text-transform: capitalize;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            background: rgba(241, 245, 249, 0.7);
        }

        .text-muted {
            font-size: 0.9rem;
            color: #4b5563;
            margin-bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 500;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            background: #f1f5f9;
        }

        .text-muted i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
            color: #b91c1c;
        }

        .text-muted:nth-child(2) i {
            color: #15803d;
        }

        .no-image {
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 220px;
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
            border-radius: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            transition: background 0.3s ease;
        }

        .no-image:hover {
            background: #cbd5e1;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Page Title Style from Image */
        .pagetitle h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #003087;
            /* Dark blue from image */
            margin-bottom: 1rem;
        }

        /* Search Bar Style from Image */
        .input-group {
            width: 100%;
            max-width: 400px;
            /* Matches the width in the image */
        }

        .input-group .form-control {
            border: 1px solid #d1d5db;
            /* Light gray border */
            border-radius: 0.25rem 0 0 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            color: #6b7280;
            /* Placeholder text color */
        }

        .input-group .form-control::placeholder {
            color: #6b7280;
        }

        .input-group .btn-secondary {
            background: #6b7280;
            /* Gray button background */
            border: 1px solid #6b7280;
            border-radius: 0 0.25rem 0.25rem 0;
            padding: 0.5rem 1rem;
        }

        .input-group .btn-secondary i {
            color: #ffffff;
            /* White icon */
        }
    </style>

    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Low Selling Products</h1>
    </div>

    <!-- Search Box -->
    <div class="d-flex justify-content-end mb-3">
        <div class="input-group w-50">
            <input
                type="text"
                id="searchInput"
                class="form-control"
                placeholder="Search low selling product..."
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
                    <div class="card border-0 shadow-sm">
                        <div class="card-header">
                            <h6 class="card-title product-name"><?= htmlspecialchars($product['name']); ?></h6>
                            <div class="price-header">
                                <i class="bi bi-currency-dollar me-1"></i>
                                <?= number_format($product['price'], 2); ?>
                            </div>
                        </div>
                        <?php if (!empty($product['image']) && file_exists("uploads/" . $product['image'])): ?>
                            <img src="/uploads/<?= htmlspecialchars($product['image']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            <div class="no-image"><span>No Image</span></div>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="content-center">
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
    /**
     * Filters product cards based on search input
     * @returns {void}
     */
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