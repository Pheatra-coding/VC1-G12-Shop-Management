<main id="main" class="main">
    <style>
        /* Base Styles */
        .main {
            overflow-y: auto;
            height: 100vh;
            padding: 20px 0;
        }

        .customer-container {
            margin: 15px auto;
            max-width: 800px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: auto;
            display: flex;
            flex-direction: column;
            width: 95%;
        }

        .customer-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px dashed #e0e0e0;
            position: sticky;
            top: 0;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            z-index: 10;
        }

        .customer-header h1 {
            color: #2c3e50;
            margin: 0 0 8px 0;
            font-size: clamp(24px, 5vw, 32px);
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .customer-header p {
            color: #6c757d;
            margin: 0;
            font-size: clamp(14px, 3vw, 16px);
            font-style: italic;
        }

        /* Table Styles - Responsive */
        .customer-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin: 15px 0;
            display: none;
        }

        .customer-table th {
            background-color: #3498db;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: clamp(12px, 2.5vw, 14px);
            letter-spacing: 0.3px;
            position: sticky;
            top: 90px; /* Header height + padding */
            z-index: 5;
        }

        .customer-table th:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            padding-left: 12px;
        }

        .customer-table th:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            padding-right: 12px;
        }

        .customer-table td {
            padding: 12px 8px;
            background-color: white;
            border-bottom: 1px solid #f0f0f0;
            color: #34495e;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
            font-size: clamp(13px, 3vw, 15px);
        }

        .customer-table td:first-child {
            padding-left: 12px;
        }

        .customer-table td:last-child {
            padding-right: 12px;
        }

        .customer-table tbody tr {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .customer-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Total Section */
        .total-section {
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: none;
            position: sticky;
            bottom: 0;
            background: white;
            z-index: 5;
        }

        .total-section p {
            margin: 8px 0;
            font-size: clamp(16px, 4vw, 18px);
            color: #2c3e50;
            display: flex;
            justify-content: space-between;
        }

        .total-section .grand-total {
            font-size: clamp(20px, 5vw, 26px);
            font-weight: 700;
            color: #27ae60;
            border-top: 1px solid #e0e0e0;
            padding-top: 12px;
            margin-top: 12px;
        }

        /* Payment Section */
        .payment-section {
            margin-top: 25px;
            padding: 15px;
            background-color: #fff;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: none;
        }

        .payment-section h3 {
            color: #2c3e50;
            font-size: clamp(18px, 4vw, 20px);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .payment-section img {
            max-width: min(200px, 60vw);
            margin: 12px auto;
            display: block;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px;
            background: white;
        }

        .payment-instruction {
            color: #6c757d;
            font-size: clamp(13px, 3vw, 14px);
            margin-top: 12px;
            line-height: 1.5;
        }

        /* Welcome Container */
        .welcome-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #2c3e50;
            padding: 15px;
            min-height: 60vh;
        }

        .welcome-container h2 {
            font-size: clamp(22px, 5vw, 28px);
            margin-bottom: 15px;
            color: #27ae60;
            animation: fadeIn 1.5s ease-in-out;
        }

        .cart-icon {
            width: clamp(80px, 20vw, 100px);
            height: clamp(80px, 20vw, 100px);
            position: relative;
            margin-bottom: 20px;
        }

        .cart-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%233498db" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>') no-repeat center;
            background-size: 70%;
            animation: bounce 2s infinite ease-in-out;
        }

        .welcome-container p {
            font-size: clamp(15px, 4vw, 18px);
            margin: 8px 0;
            max-width: 500px;
            line-height: 1.6;
        }

        /* Animations */
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Mobile-specific adjustments */
        @media (max-width: 480px) {
            .customer-container {
                padding: 15px;
                border-radius: 12px;
            }

            .customer-table th, 
            .customer-table td {
                padding: 10px 6px;
            }

            .customer-table th:first-child,
            .customer-table td:first-child {
                padding-left: 8px;
            }

            .customer-table th:last-child,
            .customer-table td:last-child {
                padding-right: 8px;
            }

            .total-section,
            .payment-section {
                padding: 12px;
            }

            .welcome-container {
                padding: 10px;
            }

            .customer-header {
                top: -20px; /* Adjust for mobile viewport */
                padding-top: 20px;
            }

            .customer-table th {
                top: 70px; /* Adjusted sticky position for mobile */
            }
        }

        /* Very small devices (e.g., iPhone 5/SE) */
        @media (max-width: 320px) {
            .customer-header h1 {
                font-size: 20px;
            }

            .customer-header p {
                font-size: 13px;
            }

            .customer-table th {
                font-size: 11px;
                padding: 8px 4px;
            }

            .customer-table td {
                font-size: 12px;
                padding: 8px 4px;
            }

            .welcome-container h2 {
                font-size: 18px;
            }

            .welcome-container p {
                font-size: 14px;
            }
        }

        /* Landscape orientation adjustments */
        @media (max-height: 500px) and (orientation: landscape) {
            .customer-container {
                min-height: auto;
            }

            .cart-icon {
                width: 60px;
                height: 60px;
                margin-bottom: 10px;
            }

            .welcome-container {
                min-height: 40vh;
            }

            .welcome-container h2 {
                margin-bottom: 8px;
                font-size: 18px;
            }

            .welcome-container p {
                font-size: 14px;
                margin: 5px 0;
            }
        }
    </style>

    <div class="customer-container">
        <div class="customer-header">
            <h1>Your Shopping Cart</h1>
            <p>MENG HOUT Shop - Making Shopping Fun and Easy!</p>
        </div>

        <div class="welcome-container" id="welcome-container">
            <div class="cart-icon"></div>
            <h2>Welcome to MENG HOUT Shop!</h2>
            <p>Your items will appear here as they're scanned.</p>
            <p>Relax and watch your shopping list grow!</p>
        </div>

        <div class="table-responsive-wrapper">
            <table class="customer-table" id="customer-cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="customer-cart-body"></tbody>
            </table>
        </div>

        <div class="total-section" id="customer-total-section">
            <p>Subtotal: <span id="customer-subtotal">$0.00</span></p>
            <p class="grand-total">Total: <span id="customer-grand-total">$0.00</span></p>
        </div>

        <div class="payment-section" id="payment-section">
            <h3>Time to Pay!</h3>
            <img src="/views/assets/img/DinoQR.png" alt="Payment QR Code" id="qr-code">
            <div class="payment-instruction">
                <p>Scan this QR code with your favorite payment app</p>
                <p>Let the cashier know when you're done!</p>
            </div>
        </div>
    </div>

    <script>
        function updateCustomerView() {
            const cart = JSON.parse(localStorage.getItem('cart') || '{}');
            const tbody = document.getElementById('customer-cart-body');
            const subtotalSpan = document.getElementById('customer-subtotal');
            const grandTotalSpan = document.getElementById('customer-grand-total');
            const paymentSection = document.getElementById('payment-section');
            const table = document.getElementById('customer-cart-table');
            const totalSection = document.getElementById('customer-total-section');
            const welcomeContainer = document.getElementById('welcome-container');
            
            tbody.innerHTML = '';
            let subtotal = 0;

            if (Object.keys(cart).length === 0) {
                welcomeContainer.style.display = 'flex';
                table.style.display = 'none';
                totalSection.style.display = 'none';
                paymentSection.style.display = 'none';
            } else {
                welcomeContainer.style.display = 'none';
                table.style.display = 'table';
                totalSection.style.display = 'block';
                paymentSection.style.display = 'block';

                for (let barcode in cart) {
                    const item = cart[barcode];
                    const row = document.createElement('tr');
                    const itemTotal = item.price * item.quantity;
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>${item.quantity}</td>
                        <td>$${itemTotal.toFixed(2)}</td>
                    `;
                    tbody.appendChild(row);
                    subtotal += itemTotal;
                }
            }

            subtotalSpan.textContent = `$${subtotal.toFixed(2)}`;
            grandTotalSpan.textContent = `$${subtotal.toFixed(2)}`;
        }

        // Initial setup
        updateCustomerView();

        // Listen for storage changes
        window.addEventListener('storage', function(e) {
            if (e.key === 'cart') {
                updateCustomerView();
            }
        });

        // Poll for changes (reduced frequency for mobile devices)
        const pollInterval = window.matchMedia("(max-width: 768px)").matches ? 2000 : 1000;
        setInterval(updateCustomerView, pollInterval);

        // Handle orientation changes
        window.addEventListener('orientationchange', function() {
            setTimeout(updateCustomerView, 300);
        });

        // Handle resize events with debounce
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                updateCustomerView();
            }, 250);
        });
    </script>
</main>