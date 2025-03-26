<?php session_start(); ?>
<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true): ?>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .pagetitle {
            margin-bottom: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .table {
            margin-top: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .alert-info {
            background-color:rgba(198, 65, 65, 0.9);
            border-color: #dee2e6;
            color:rgb(255, 255, 255);
            margin-top: 12px;
        }
                a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Low Stock Products</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Low Stock Overview</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                There are <strong><?php echo $lowStockCount; ?></strong> products with low stock.
                            </div>

                            <hr>

                            <?php if (!empty($products)): ?>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                                <td><?php echo $product['quantity']; ?></td>
                                                <td><?php echo htmlspecialchars($product['price']); ?> USD</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="text-center">No low stock products found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</main><!-- End #main -->


</body>
</html>

<?php else: ?>
    <?php $this->redirect('/users/login'); ?>
<?php endif; ?>