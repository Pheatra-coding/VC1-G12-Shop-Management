<main id="main" class="main">
    <style>
        .main {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 0;
        }
        .receipt-container {
            margin: auto;
            width: 40%;
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
        .btn-download {
            background-color: #007bff;
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
            margin-top: 10px;
        }
        .btn-download:hover {
            background-color:rgb(25, 116, 214);
        }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            color: #95a5a6;
            font-size: 13px;
        }
    </style>

    <div class="receipt-container" id="receipt">
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
            <img src="/views/assets/img/DinoQR.png" alt="Payment QR Code">
            <p>Scan to complete payment</p>
        </div>

        <form method="POST" action="/scan_barcodes/confirm" id="confirm-form">
            <button type="submit" class="btn-confirm">Confirm Payment</button>
        </form>

        <button class="btn-download" onclick="downloadReceipt()" id="download-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
            </svg>
            Download Receipt
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

    <!-- Add html2canvas library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        async function downloadReceipt() {
            try {
                // Get the elements to hide
                const confirmForm = document.getElementById('confirm-form');
                const downloadBtn = document.getElementById('download-btn');

                // Temporarily hide the buttons
                confirmForm.style.display = 'none';
                downloadBtn.style.display = 'none';

                // Capture the receipt as an image
                const element = document.getElementById('receipt');
                const canvas = await html2canvas(element, {
                    scale: 2, // Increase resolution
                    useCORS: true, // Allow cross-origin images
                    backgroundColor: '#ffffff' // Ensure white background
                });

                // Show the buttons again
                confirmForm.style.display = 'block';
                downloadBtn.style.display = 'flex';

                // Create download link
                const image = canvas.toDataURL('image/png');
                const link = document.createElement('a');
                link.download = 'dino-shop-receipt.png';
                link.href = image;
                link.click();
                
            } catch (error) {
                // Ensure buttons are shown even if there's an error
                const confirmForm = document.getElementById('confirm-form');
                const downloadBtn = document.getElementById('download-btn');
                confirmForm.style.display = 'block';
                downloadBtn.style.display = 'flex';

                console.error('Error generating receipt image:', error);
                alert('Failed to generate receipt image. Please try again.');
            }
        }
    </script>
</main>