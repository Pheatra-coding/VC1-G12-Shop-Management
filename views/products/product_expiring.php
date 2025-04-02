<main id="main" class="main">
    <link rel="stylesheet" href="styles.css">

    <div class="pagetitle">
        <h1>Expiring Inventory</h1>
    </div>

    <!-- Search Box -->
    <div class="d-flex justify-content-end mb-3 search-container">
        <div class="input-group search-wrapper">
            <input type="text" id="searchInput" class="form-control" placeholder="Search expiring products..." onkeyup="searchTable()">
            <button class="btn btn-secondary" aria-label="Search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <div class="product-grid" id="productGrid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-item">
                    <div class="card product-card expired-card">
                        <div class="expired-banner">EXPIRED</div>
                        <?php if (!empty($product['image']) && file_exists("views/uploads/" . $product['image'])): ?>
                            <img src="/views/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top faded-image" alt="<?= htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            <div class="no-image faded-image">
                                <span>No Image</span>
                            </div>
                        <?php endif; ?>
                        <div class="product-name-row">
                            <h6 class="card-title product-name expired-text"> <?= htmlspecialchars($product['name']); ?> </h6>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-products text-center mt-4">
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
    }
</script>

<style>
    .main {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .search-container {
        padding: 0 15px;
    }

    .search-wrapper {
        width: 100%;
        max-width: 500px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        padding: 0 15px;
    }

    .product-item {
        width: 100%;
    }

    .expired-card {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 300px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .expired-banner {
        position: absolute;
        top: 10px;
        left: -10px;
        background: red;
        color: white;
        font-weight: bold;
        padding: 5px 15px;
        transform: rotate(-20deg);
        font-size: clamp(12px, 2vw, 14px);
        z-index: 2;
    }

    .card-img-top, .no-image {
        width: 100%;
        height: 70%;
        object-fit: cover;
        max-height: 200px;
    }

    .no-image {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
    }

    .product-name-row {
        padding: 10px 0;
        height: 30%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .expired-text {
        color: red;
        text-align: center;
        margin: 0;
        font-size: clamp(14px, 2.5vw, 16px);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .no-products {
        grid-column: 1 / -1;
    }

    /* Media Queries for additional responsiveness */
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .expired-card {
            height: 250px;
        }
    }

    @media (max-width: 480px) {
        .product-grid {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
        }

        .expired-card {
            height: 200px;
            padding: 10px;
        }

        .search-wrapper {
            max-width: 100%;
        }
    }
</style>