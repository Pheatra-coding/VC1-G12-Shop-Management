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
    
    /* NEW: Title and price row container */
    .title-price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    /* NEW: Adjust card title to work in flex row */
    .title-price-row .card-title {
        margin-bottom: 0;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-right: 10px;
    }
    
    /* NEW: Price container with icon */
    .price-container {
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }
    
    /* NEW: Stats row */
    .stats-row {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    /* NEW: Stat item */
    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    /* NEW: Small icon style */
    .stat-icon {
        width: 14px;
        height: 14px;
        color: #6c757d;
    }
    
    /* NEW: Small text style */
    .small-stat-text {
        font-size: 0.76rem;
        color: #6c757d;
        margin-bottom: 0;
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
                    <?php if (!empty($product['image']) && file_exists("uploads/" . $product['image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <div class="no-image">
                            <span>No Image</span>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="title-price-row">
                            <h6 class="card-title product-name"><?= htmlspecialchars($product['name']); ?></h6>
                            <div class="price-container">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28a745" viewBox="0 0 16 16" class="bi bi-tag">
                                    <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z"/>
                                    <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z"/>
                                </svg>
                                <p class="text-success fw-bold mb-0">$<?= number_format($product['price'], 2); ?></p>
                            </div>
                        </div>
                        <div class="stats-row">
                            <div class="stat-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="stat-icon bi bi-cart-check">
                                    <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                <p class="small-stat-text mb-0">Total Items Sold: <?= htmlspecialchars($product['total_sold']); ?></p>
                            </div>
                            <div class="stat-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="stat-icon bi bi-calendar-event">
                                    <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                </svg>
                                <p class="small-stat-text mb-0">Last Sale Date: <?= !empty($product['last_sale_date']) ? htmlspecialchars(date('M d, Y', strtotime($product['last_sale_date']))) : 'N/A'; ?></p>
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