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
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        }
        .product-card img {
            max-height: 120px;
            object-fit: contain;
            transition: transform 0.3s ease-in-out;
        }
        .product-card:hover img {
            transform: scale(1.05);
        }
        .expired-label {
            background: red;
            color: white;
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
            display: inline-block;
            margin-left: 8px;
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
        .product-name-row {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            gap: 8px;
        }
        .card-title.product-name {
            margin-right: 8px;
            transition: color 0.3s ease-in-out;
        }
        .product-card:hover .card-title.product-name {
            color: #1e40af;
        }
    </style>

    <div class="pagetitle">
        <h1>Expiring Inventory</h1>
    </div>

     <!-- Search Box -->
     <div class="d-flex justify-content-end mb-3">
        <div class="input-group w-50">
            <input type="text" id="searchInput" class="form-control" placeholder="Search expiring products..." onkeyup="searchTable()">
            <button class="btn btn-secondary" aria-label="Search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4" id="productGrid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col product-item">
                    <div class="card product-card">
                        <?php if (!empty($product['image']) && file_exists("views/uploads/" . $product['image'])): ?>
                            <img src="/views/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            <div class="no-image">
                                <span>No Image</span>
                            </div>
                        <?php endif; ?>
                        <div class="product-name-row">
                            <h6 class="card-title product-name"><?= htmlspecialchars($product['name']); ?></h6>
                            <div class="expired-label">Expired</div>
                        </div>
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