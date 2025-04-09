<?php session_start(); ?>
<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true): ?>

    <main id="main" class="main">
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
        /* General Styles */
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

            /* Grid Styles */
            .product-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, 220px);
                /* Fixed width for each card */
                gap: 20px;
                padding: 0 15px;
                max-width: 1200px;
                /* Limits the overall grid width */
               
            }

            /* Card Styles */
            .expired-card {
                position: relative;
                overflow: hidden;
                width: 220px;
                /* Fixed width to match the grid column */
                height: 300px;
                padding: 15px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                margin: 0 auto;
                /* Centers the card within the product-item */
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

            .card-img-top,
            .no-image {
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

            /* Product Name Styles */
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
                    grid-template-columns: repeat(auto-fit, 180px);
                    /* Fixed width for medium screens */
                    gap: 15px;
                }

                .expired-card {
                    width: 180px;
                    /* Match the grid column width */
                    height: 250px;
                }

                .card-img-top,
                .no-image {
                    max-height: 160px;
                    /* Adjust image height for smaller cards */
                }

                .expired-text {
                    font-size: clamp(12px, 2vw, 14px);
                    /* Slightly smaller text */
                }
            }

            @media (max-width: 480px) {
                .product-grid {
                    grid-template-columns: repeat(auto-fit, 140px);
                    /* Fixed width for small screens */
                    gap: 10px;
                }

                .expired-card {
                    width: 140px;
                    /* Match the grid column width */
                    height: 200px;
                    padding: 10px;
                }

                .card-img-top,
                .no-image {
                    max-height: 120px;
                    /* Adjust image height for smaller cards */
                }

                .expired-text {
                    font-size: clamp(10px, 1.5vw, 12px);
                    /* Smaller text for small screens */
                }

                .search-wrapper {
                    max-width: 100%;
                }

                .expired-banner {
                    font-size: clamp(10px, 1.5vw, 12px);
                    /* Smaller banner text */
                    padding: 3px 10px;
                    /* Adjust padding for smaller banner */
                }
            }
        
    </style>

<?php else:
    $this->redirect('/users/login');
endif;
?>