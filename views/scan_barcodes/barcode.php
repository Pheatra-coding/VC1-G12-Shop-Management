<main id="main" class="main">
    <style>
        .scanner-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            margin-left: auto;
            margin-right: auto;
        }
        
        .scanner-header {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #eaeaea;
            text-align: center;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            overflow: hidden;
        }
        
        #barcodeInput {
            height: 50px;
            font-size: 1.1rem;
            border: 1px solid #e0e0e0;
            border-right: none;
            padding-left: 15px;
        }
        
        .btn-custom {
            border-radius: 0;
            height: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-search {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 0 25px;
        }
        
        .btn-search:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
        }
        
        .btn-submit {
            background-color: #007bff;
            color: white;
            padding: 12px 0;
            font-size: 1.1rem;
            border: none;
            border-radius: 6px;
            margin-top: 2rem;
            width: 100%;
            transition: all 0.3s ease;
            display: none;
        }
        
        .btn-submit:hover {
            background-color: #0069d9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(39, 73, 174, 0.3);
        }
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: table; /* Changed from none to always show table */
        }
        
        .cart-table th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .cart-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }
        
        .cart-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .cart-table tfoot td {
            font-weight: 600;
            background-color: #f8f9fa;
            border-top: 2px solid #e0e0e0;
        }
        
        .alert-info {
            background-color: #e3f2fd;
            color: #1976d2;
            border-left: 4px solid #1976d2;
            padding: 15px;
            border-radius: 4px;
            margin: 1.5rem 0;
            display: none;
        }
        
        .cart-section {
            display: block; /* Changed from none to always show */
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .quantity-btn {
            background-color: #e0e0e0;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        
        .quantity-btn:hover {
            background-color: #d0d0d0;
        }
        
        .remove-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        
        .remove-btn:hover {
            background-color: #e04343;
        }
        
        .nav-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .nav-btn:hover {
            background-color: #218838;
            transform: translateY(-1px);
        }
        
        @media (max-width: 768px) {
            .scanner-container {
                padding: 1.5rem;
            }
            
            #barcodeInput, .btn-custom {
                height: 45px;
                font-size: 1rem;
            }
            
            .cart-table {
                font-size: 0.9rem;
            }
            
            .cart-table th, .cart-table td {
                padding: 8px 10px;
            }
        }
    </style>

    <div class="pagetitle">
        <h1>Barcode Scanner</h1>
        <a href="/input_products/sold_product" class="btn btn-primary mt-3 mb-2 text-white outline-none">
            <i class="fas fa-arrow-right me-2"></i> Input Products
        </a>
    </div>

    <div class="scanner-container">
        <div class="scanner-header">
            <h4><i class="fas fa-barcode me-2"></i>Scan Product</h4>
        </div>
        
        <form method="POST" action="/scan_barcodes/scan" class="mb-4">
            <div class="input-group">
                <input type="text" id="barcodeInput" class="form-control" 
                       name="barcode" placeholder="Scan or enter barcode number" 
                       autofocus autocomplete="off">
                <button class="btn btn-custom btn-search text-white" type="submit">
                    <i class="fas fa-search me-2"></i>Scan
                </button>
            </div>
        </form>

        <?php if (isset($message)): ?>
            <div class="alert alert-info" id="message-alert">
                <i class="fas fa-info-circle me-2"></i>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="cart-section" id="cart-section">
            <div class="table-responsive">
                <table class="cart-table" id="cart-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>

            <form method="POST" action="/scan_barcodes/submit" id="submit-form">
                <input type="hidden" name="cart_data" id="cart-data">
                <button type="submit" class="btn btn-custom btn-submit text-white">
                    <i class="fas fa-check-circle me-2"></i> Submit Order
                </button>
            </form>
        </div>
    </div>

    <script>
        let cart = <?php echo isset($data['reset']) && $data['reset'] ? '{}': 'JSON.parse(localStorage.getItem("cart")) || {}'; ?>;
        
        function showCartSection(show) {
            const submitBtn = document.querySelector('.btn-submit');
            submitBtn.style.display = show ? 'block' : 'none';
        }
        
        function showMessageAlert(show) {
            const alert = document.getElementById('message-alert');
            if (alert) {
                alert.style.display = show ? 'block' : 'none';
            }
        }

        function updateCartTable() {
            const tbody = document.querySelector('#cart-table tbody');
            const tfoot = document.querySelector('#cart-table tfoot');
            tbody.innerHTML = '';
            let totalPrice = 0;

            if (Object.keys(cart).length === 0) {
                showCartSection(false);
                showMessageAlert(false);
                tbody.innerHTML = '<tr><td colspan="5">No products selected yet.</td></tr>';
            } else {
                showCartSection(true);
                showMessageAlert(true);
                
                for (let barcode in cart) {
                    const item = cart[barcode];
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="updateQuantity('${barcode}', -1)">-</button>
                                <span>${item.quantity}</span>
                                <button class="quantity-btn" onclick="updateQuantity('${barcode}', 1)">+</button>
                            </div>
                        </td>
                        <td>$${(item.price * item.quantity).toFixed(2)}</td>
                        <td>
                            <button class="remove-btn" onclick="removeItem('${barcode}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                    totalPrice += item.price * item.quantity;
                }
                tfoot.innerHTML = `
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                        <td><strong>$${totalPrice.toFixed(2)}</strong></td>
                    </tr>
                `;
            }
            document.getElementById('cart-data').value = JSON.stringify(cart);
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function updateQuantity(barcode, change) {
            if (cart[barcode]) {
                cart[barcode].quantity += change;
                if (cart[barcode].quantity <= 0) {
                    delete cart[barcode];
                }
                updateCartTable();
            }
        }

        function removeItem(barcode) {
            if (cart[barcode]) {
                delete cart[barcode];
                updateCartTable();
            }
        }

        <?php if (isset($productInfo)): ?>
            const barcode = '<?= htmlspecialchars($productInfo['barcode']) ?>';
            if (cart[barcode]) {
                cart[barcode].quantity += 1;
            } else {
                cart[barcode] = {
                    product_id: <?= $productInfo['id'] ?>,
                    name: '<?= htmlspecialchars($productInfo['name']) ?>',
                    price: <?= $productInfo['price'] ?>,
                    quantity: 1
                };
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartTable();
        <?php else: ?>
            <?php if (isset($data['reset']) && $data['reset']): ?>
                localStorage.removeItem('cart');
                cart = {};
            <?php endif; ?>
            updateCartTable();
        <?php endif; ?>

        document.getElementById('submit-form').onsubmit = function() {
            localStorage.setItem('cart', JSON.stringify(cart));
            setTimeout(() => {
                localStorage.removeItem('cart');
            }, 1000);
        };

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('barcodeInput').focus();
        });
    </script>
</main>