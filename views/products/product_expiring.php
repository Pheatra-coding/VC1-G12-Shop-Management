<main id="main" class="main">
    <style>
        .product-item {
            text-align: center;
        }
        .product-card {
            border-radius: 10px;
            padding: 10px;
            background: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .product-card img {
            max-height: 120px;
            object-fit: contain;
        }
        .expired-label {
            background: red;
            color: white;
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }
        .no-image {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 5px;
            color: #6c757d;
        }
    </style>

    <div class="pagetitle">
        <h1>Expirations</h1>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4" id="productGrid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col product-item">
                    <div class="card product-card position-relative">
                        <?php if (!empty($product['image']) && file_exists("uploads/" . $product['image'])): ?>
                            <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            <div class="no-image">
                                <span>No Image</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title product-name mb-1"> <?= htmlspecialchars($product['name']); ?> </h6>
                        </div>
                        <div class="expired-label">Expired</div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center mt-4">
                <div class="alert alert-warning" role="alert">
                    No expiring products available at the moment.
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
