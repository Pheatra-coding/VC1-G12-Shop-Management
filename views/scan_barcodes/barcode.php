<main id="main" class="main">
    <style>
        body {
            background-color: #f6f9ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .scanner-container {
            margin-top: 50px;
            padding: 30px;
            border: none;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .input-group {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .input-group .form-control {
            border: 2px solid #e9ecef;
            padding: 12px;
            font-size: 16px;
            flex: 0.5;
        }

        .input-group .btn {
            padding: 12px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-custom {
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-search {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-search:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        h1 {
            color: #343a40;
            font-weight: bold;
            margin-bottom: 20px;
        }

        h4 {
            color: #495057;
            margin-bottom: 15px;
        }

        p {
            color: #6c757d;
            font-size: 16px;
        }

        .fa-search {
            margin-right: 8px;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .cart-table th, .cart-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .cart-table th {
            background-color: #f2f2f2;
        }

        .btn-submit {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #218838;
        }
    </style>

    <div class="">
        <div class="pagetitle">
            <h1>Scan Barcode</h1>
        </div>
        <p>Scan products to add them to the cart and process sales.</p>

        <div class="scanner-container mt-4">
            <h4>Barcode Scanner</h4>
            <p>Scan a barcode or enter it manually to add products.</p>

            <!-- Form to submit the barcode -->
            <form method="POST" action="/scan_barcodes/scan">
                <div class="input-group">
                    <input type="text" id="barcodeInput" class="form-control" name="barcode" placeholder="Enter barcode" aria-label="Enter barcode" autofocus>
                    <button class="btn btn-custom btn-search" type="submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>

            <!-- Display message if available -->
            <?php if (isset($message)): ?>
                <div class="alert alert-info mt-4">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <!-- Display product information if available -->
            <?php if (isset($productInfo) && is_array($productInfo)): ?>
                <?php
                    session_start(); // Ensure session is started
                    // Initialize cart session if not already done
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }

                    // Check if the product is already in the cart
                    $barcode = htmlspecialchars($productInfo['barcode']);
                    if (isset($_SESSION['cart'][$barcode])) {
                        // If the product is already in the cart, increment the quantity
                        $_SESSION['cart'][$barcode]['quantity'] += 1;
                    } else {
                        // If it's a new product, add it to the cart
                        $_SESSION['cart'][$barcode] = [
                            'name' => $productInfo['name'],
                            'price' => $productInfo['price'],
                            'quantity' => 1
                        ];
                    }

                    // Update the total price for this product
                    $_SESSION['cart'][$barcode]['total_price'] = $_SESSION['cart'][$barcode]['price'] * $_SESSION['cart'][$barcode]['quantity'];

                    // Calculate the total price of all products in the cart
                    $totalPrice = 0;
                    foreach ($_SESSION['cart'] as $item) {
                        $totalPrice += $item['total_price'];
                    }
                ?>
            <?php endif; ?>

            <!-- Display the cart in a table -->
            <?php if (!empty($_SESSION['cart'])): ?>
                <form method="POST" action="">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $barcode => $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td>$<?= htmlspecialchars($item['price']) ?></td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right;"><strong>Total Price:</strong></td>
                                <td><strong>$<?= number_format($totalPrice, 2) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Submit button to process the sale -->
                    <button type="submit" class="btn-submit" name="submit_sale">Submit Sale</button>
                </form>
            <?php else: ?>
                <p>No products scanned yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php
    // Handle sale submission
    if (isset($_POST['submit_sale'])) {
        // Assuming you have a PDO instance $pdo already configured
        // Insert the products from the cart into the 'sales' table

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $query = "INSERT INTO sales (product_name, price, quantity, total_price, date) VALUES (:product_name, :price, :quantity, :total_price, NOW())";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    ':product_name' => $item['name'],
                    ':price' => $item['price'],
                    ':quantity' => $item['quantity'],
                    ':total_price' => $item['total_price']
                ]);
            }

            // After successfully processing the sale, clear the cart
            unset($_SESSION['cart']);

            // Optionally, redirect to a success page or show a success message
            header("Location: /sales_success.php");
            exit;
        } else {
            echo "<p>No products in the cart to submit.</p>";
        }
    }
    ?>
</main>
