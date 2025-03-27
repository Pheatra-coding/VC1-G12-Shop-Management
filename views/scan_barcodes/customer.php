<main id="main" class="main">
    <style>
        .customer-container {
            max-width: 800px;
            margin: 2rem auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .customer-header {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            font-size: 1.1rem;
        }

        .cart-table th {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #e0e0e0;
        }

        .cart-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            color: #34495e;
        }

        .cart-table tfoot td {
            font-weight: 600;
            padding: 15px 12px;
            background-color: #f8f9fa;
            border-top: 2px solid #e0e0e0;
        }

        .payment-section {
            margin-top: 2rem;
            text-align: center;
        }

        .qr-code {
            margin: 1.5rem 0;
        }

        .qr-code img {
            max-width: 200px;
        }

        .pay-btn {
            background-color: #27ae60;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 300px;
        }

        .pay-btn:hover {
            background-color: #2ecc71;
            transform: translateY(-2px);
        }

        .empty-message {
            text-align: center;
            color: #7f8c8d;
            font-size: 1.2rem;
            padding: 2rem;
        }
    </style>

    <div class="customer-container">
        <div class="customer-header">
            <h2>Your Shopping Cart</h2>
            <p>Please review your items below</p>
        </div>

        <?php if (empty($data['cart'])): ?>
            <div class="empty-message">
                <p>No items scanned yet. Please wait while items are being added.</p>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['cart'] as $barcode => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total Amount</td>
                        <td>$<?= number_format($data['total'], 2) ?></td>
                    </tr>
                </tfoot>
            </table>

            <div class="payment-section">
                <div class="qr-code">
                    <img src="/views/assets/img/DinoQR.png" alt="Payment QR Code">
                    <p>Scan to pay with your mobile device</p>
                </div>
                <form method="POST" action="/scan_barcodes/confirm" id="pay-form">
                    <button type="submit" class="pay-btn">Confirm Payment</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Auto-refresh every 5 seconds to get latest cart updates
        setInterval(function() {
            fetch('/scan_barcodes/customer')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('.customer-container').innerHTML;
                    document.querySelector('.customer-container').innerHTML = newContent;
                })
                .catch(error => console.error('Error refreshing cart:', error));
        }, 5000);
    </script>
</main>