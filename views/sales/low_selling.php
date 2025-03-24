<main id="main" class="main">
<!-- CSS (Card Styles) -->
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
        height: 350px;
        display: flex;
        flex-direction: column;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .card-img-top {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .no-image {
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 180px;
        font-size: 0.76rem;
        color: #6c757d;
    }
      .text-muted {
        font-size: 0.76rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
</style>

<!-- Page Title -->
<div class="pagetitle">
    <h1>Low Selling Products</h1>
</div>

<!-- Search Box -->
<div class="d-flex justify-content-end mb-3">
    <div class="input-group w-50">
        <input type="text" id="searchInput" class="form-control" placeholder="Search low selling product..." onkeyup="searchTable()">
        <button class="btn btn-secondary"><i class="fas fa-search"></i></button>
    </div>
</div>

<!-- Products Grid -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="productGrid">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="col product-item">
                <div class="card border-0 shadow-sm">
                    <?php if (!empty($product['image']) && file_exists("uploads/" . $product['image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <div class="no-image"><span>No Image</span></div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h6 class="card-title product-name"><?= htmlspecialchars($product['name']); ?></h6>
                        <p class="text-success fw-bold mb-2">$<?= number_format($product['price'], 2); ?></p>
                        <p class="text-muted mb-1">Stock Quantity: <?= htmlspecialchars($product['quantity']); ?></p>
                        <p class="text-muted mb-0">Last Updated: <?= htmlspecialchars(date('M d, Y', strtotime($product['updated_at']))); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center mt-4">
            <div class="alert alert-warning" role="alert">No low-selling products available at the moment.</div>
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
            item.style.display = productName.includes(input) ? '' : 'none';
            if (productName.includes(input)) hasResults = true;
        });

        let noProductsMessage = document.getElementById('noProductsMessage');
        if (noProductsMessage) {
            noProductsMessage.style.display = hasResults ? 'none' : 'block';
        }
    }
</script>
