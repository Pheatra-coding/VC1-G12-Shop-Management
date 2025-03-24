<main id="main" class="main">
    <style>
        .main {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .receipt-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 100px;
            
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .cart-table th,
        .cart-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        /* .cart-table th {
            background-color: #f2f2f2;
        } */
        .btn-custom {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-custom:hover {
            background-color: #45a049;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .qr-code img {
            max-width: 200px;
        }
        .divider {
            border-top: 1px dashed #ccc;
            margin: 15px 0;
        }
        .ticket-info {
            margin-bottom: 20px;
        }
        .ticket-info h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .ticket-info p {
            margin: 5px 0;
            font-size: 16px;
        }
        .ticket-details {
            margin-top: 15px;
        }
        .ticket-number {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        
    </style>

    <div class="receipt-container">
        <div class="receipt-header">
            <h1>INVOICE</h1>
            <p>Please scan the QR code to pay</p>
        </div>

        <div class="ticket-info">
            <div class="ticket-details">
                <p><strong>Shop:</strong> Shop Management</p>
                <p><strong>Date:</strong> <?= date('D, d M Y') ?></p>
            </div>
        </div>

        <div class="divider"></div>

        <h2>Products</h2>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['cart'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?>x</td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" ><strong>Total Amount</strong></td>
                    <td>$<?= number_format($data['total'], 2) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="qr-code">
            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="Payment QR Code">
        </div>

        <div class="button-container">
            <form method="POST" action="/input_products/confirm">
                <button type="submit" class="btn-custom">Confirm Payment</button>
            </form>
        </div>
    </div>

    <?php if (isset($data['clear_cart']) && $data['clear_cart']): ?>
        <script>
            localStorage.removeItem('cart');
        </script>
    <?php endif; ?>
</main>