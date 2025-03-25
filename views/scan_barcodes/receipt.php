<main id="main" class="main">
    <style>
        .main {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 500px;
            margin: 20px auto;
            padding: 0;
        }
        .receipt-container {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        .receipt-header h1 {
            color: #2c3e50;
            margin: 0 0 8px 0;
            font-size: 24px;
            font-weight: 600;
        }
        .receipt-header p {
            color: #7f8c8d;
            margin: 0;
            font-size: 15px;
        }
        .ticket-info {
            margin-bottom: 20px;
        }
        .ticket-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }
        .ticket-details p {
            margin: 8px 0;
            font-size: 15px;
            color: #34495e;
        }
        .ticket-details strong {
            color: #2c3e50;
            font-weight: 600;
            display: inline-block;
            width: 70px;
        }
        .divider {
            border-top: 1px dashed #e0e0e0;
            margin: 20px 0;
        }
        .section-title {
            color: #2c3e50;
            font-size: 18px;
            margin: 0 0 15px 0;
            font-weight: 600;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .cart-table td {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            color: #34495e;
            font-size: 15px;
        }
        .cart-table tr:last-child td {
            border-bottom: none;
        }
        .total-row {
            font-weight: 600;
            color: #2c3e50 !important;
        }
        .qr-code {
            text-align: center;
            margin: 25px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .qr-code img {
            max-width: 180px;
            display: block;
            margin: 0 auto 10px auto;
        }
        .qr-code p {
            margin: 5px 0 0 0;
            color: #7f8c8d;
            font-size: 14px;
        }
        .btn-confirm {
            background-color: #27ae60;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.2s;
            margin-bottom: 10px;
        }
        .btn-confirm:hover {
            background-color: #2ecc71;
        }
        .btn-telegram {
            background-color: #0088cc;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-telegram:hover {
            background-color: #1a9ce0;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            color: #95a5a6;
            font-size: 13px;
        }
    </style>

    <div class="receipt-container">
        <div class="receipt-header">
            <h1>DINO SHOP</h1>
            <p>Order Receipt</p>
        </div>

        <div class="ticket-info">
            <div class="ticket-details">
                <p><strong>Shop:</strong> Dino Shop</p>
                <p><strong>Date:</strong> <?= date('D, d M Y') ?></p>
            </div>
        </div>

        <div class="divider"></div>

        <h3 class="section-title">Order Summary</h3>
        <table class="cart-table">
            <tbody>
                <?php foreach ($data['cart'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['quantity']) ?> × <?= htmlspecialchars($item['name']) ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>Subtotal</td>
                    <td>$<?= number_format($data['total'], 2) ?></td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>$0.00</td>
                </tr>
                <tr class="total-row">
                    <td>Total Amount</td>
                    <td>$<?= number_format($data['total'], 2) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="qr-code">
            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="Payment QR Code">
            <p>Scan to complete payment</p>
        </div>

        <form method="POST" action="/scan_barcodes/confirm">
            <button type="submit" class="btn-confirm">Confirm Payment</button>
        </form>

        <button class="btn-telegram" onclick="shareToTelegram()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
            </svg>
            Share to Telegram
        </button>

        <div class="receipt-footer">
            <p>Thank you for shopping with us!</p>
        </div>
    </div>

    <?php if (isset($data['clear_cart']) && $data['clear_cart']): ?>
        <script>
            localStorage.removeItem('cart'); // Clear cart immediately after rendering receipt
        </script>
    <?php endif; ?>

    <script>
        function shareToTelegram() {
            // Generate receipt text
            let receiptText = `*DINO SHOP - Order Receipt*\n\n`;
            receiptText += `*Shop:* Dino Shop\n`;
            receiptText += `*Date:* ${new Date().toLocaleDateString('en-US', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' })}\n\n`;
            receiptText += `*Order Summary:*\n`;
            
            // Add cart items
            <?php foreach ($data['cart'] as $item): ?>
                receiptText += `- ${<?= $item['quantity'] ?>} × ${<?= json_encode($item['name']) ?>}: $${<?= number_format($item['price'], 2) ?>}\n`;
            <?php endforeach; ?>
            
            receiptText += `\n*Subtotal:* $${<?= number_format($data['total'], 2) ?>}\n`;
            receiptText += `*Discount:* $0.00\n`;
            receiptText += `*Total Amount:* $${<?= number_format($data['total'], 2) ?>}\n\n`;
            receiptText += `Thank you for shopping with us!`;
            
            // Encode the text for URL
            const encodedText = encodeURIComponent(receiptText);
            
            // Open Telegram share link
            window.open(`https://t.me/share/url?url=${encodeURIComponent(window.location.href)}&text=${encodedText}`, '_blank');
        }
    </script>
</main>