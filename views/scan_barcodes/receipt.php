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
        
        /* Print-specific styles */
        @media print {
            body, html {
                width: 100%;
                height: auto;
                margin: 0;
                padding: 0;
                background: white;
            }
            
            body * {
                visibility: hidden;
            }
            
            #receipt, #receipt * {
                visibility: visible;
            }
            
            #receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 20px;
                box-shadow: none;
                border-radius: 0;
            }
            
            .receipt-container {
                width: 100% !important;
                margin: 0 !important;
                padding: 20px !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                page-break-after: always;
            }
            
            .btn-confirm, .btn-download {
                display: none !important;
            }
            
            @page {
                size: auto;
                margin: 0mm;
            }
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

        <form method="POST" action="/scan_barcodes/confirm" id="confirm-form" onsubmit="printReceiptAndSubmit(event)">
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
       // Function to handle automatic printing when confirming payment
    function printReceiptAndSubmit(event) {
        event.preventDefault(); // Prevent form submission temporarily
        
        // Get the elements to hide for printing
        const confirmForm = document.getElementById('confirm-form');
        const downloadBtn = document.getElementById('download-btn');
        
        // Temporarily hide buttons for printing
        confirmForm.style.display = 'none';
        downloadBtn.style.display = 'none';
        
        // Print the receipt
        window.print();
        
        // Short delay to ensure print dialog opens before submitting form
        setTimeout(function() {
            // Show buttons again
            confirmForm.style.display = 'block';
            downloadBtn.style.display = 'flex';
            
            // Submit the form to complete the payment confirmation
            document.getElementById('confirm-form').submit();
        }, 500);
    }

    async function downloadReceipt() {
        try {
            const receiptElement = document.getElementById('receipt');
            if (!receiptElement) {
                console.error('Receipt element not found');
                return;
            }

            // Hide buttons temporarily
            const confirmForm = document.getElementById('confirm-form');
            const downloadBtn = document.getElementById('download-btn');
            if (confirmForm) confirmForm.style.display = 'none';
            if (downloadBtn) downloadBtn.style.display = 'none';

            // Clone the receipt for download
            const clone = receiptElement.cloneNode(true);

            // Set portrait dimensions (600px width, 800px height)
            clone.style.width = '600px'; // Fixed width
            clone.style.height = '800px'; // Fixed height for portrait
            clone.style.margin = '0';
            clone.style.padding = '20px';
            clone.style.boxShadow = 'none';
            clone.style.borderRadius = '0';
            clone.style.boxSizing = 'border-box'; // Ensure padding is included in dimensions
            clone.style.overflow = 'hidden'; // Prevent content from overflowing
            clone.style.backgroundColor = '#ffffff'; // Ensure white background

            // Ensure the content scales to fit the portrait dimensions
            clone.style.display = 'flex';
            clone.style.flexDirection = 'column';
            clone.style.justifyContent = 'space-between';

            // Append the clone to the body temporarily
            document.body.appendChild(clone);

            // Capture the clone as an image with html2canvas
            const canvas = await html2canvas(clone, {
                scale: 2, // Higher resolution for better quality
                useCORS: true,
                backgroundColor: '#ffffff',
                logging: false,
                removeContainer: true,
                width: 600, // Match the clone's width
                height: 800 // Match the clone's height
            });

            // Remove the clone from the DOM
            document.body.removeChild(clone);

            // Restore buttons
            if (confirmForm) confirmForm.style.display = 'block';
            if (downloadBtn) downloadBtn.style.display = 'flex';

            // Create download link
            const image = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.download = 'dino-shop-receipt-' + new Date().toISOString().slice(0, 10) + '.png';
            link.href = image;
            link.click();
        } catch (error) {
            console.error('Error generating receipt image:', error);
            alert('Failed to generate receipt image. Please try again.');
            const confirmForm = document.getElementById('confirm-form');
            const downloadBtn = document.getElementById('download-btn');
            if (confirmForm) confirmForm.style.display = 'block';
            if (downloadBtn) downloadBtn.style.display = 'flex';
        }
    }
    </script>
</main>