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
            display: flex;
            align-items: center;
        }
        
        .form-control {
            height: 50px;
            font-size: 1.1rem;
            border: 1px solid #e0e0e0;
            border-right: none;
            padding-left: 15px;
            flex: 1;
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
            display: none; /* Hidden by default */
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
            transition: background-color 0.3sjustice;
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
            
            .form-control, .btn-custom {
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
        <h1>Input Product Sale</h1>
        <a href="/scan_barcodes/barcode" class="btn btn-primary mt-3 mb-2 text-white outline-none">
            <i class="fas fa-arrow-left me-2"></i> Scan Barcode
        </a>
    </div>

    <div class="scanner-container">
        <div class="scanner-header">
            <h4><i class="fas fa-barcode me-2"></i>Product Selector</h4>
        </div>
        
        <form method="POST" action="/input_products/scan">
            <div class="input-group">
                <input type="text" class="form-control" name="product_name" list="product-list" 
                       placeholder="Search for a product" required>
                <datalist id="product-list">
                    <?php foreach ($data['products'] as $product): ?>
                        <option value="<?= htmlspecialchars($product['name']) ?>" data-id="<?= $product['id'] ?>">
                    <?php endforeach; ?>
                </datalist>
                <input type="hidden" name="product_id" id="product-id">
                <input type="number" class="form-control" name="quantity" min="1" 
                       placeholder="Quantity" required>
                <button class="btn btn-custom btn-search" type="submit">
                    <i class="fas fa-plus me-2"></i>Add
                </button>
            </div>
        </form>

        <?php if (isset($data['message'])): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <?= htmlspecialchars($data['message']) ?>
            </div>
        <?php endif; ?>

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

        <form method="POST" action="/input_products/submit" id="submit-form">
            <input type="hidden" name="cart_data" id="cart-data">
            <button type="submit" class="btn btn-custom btn-submit">
                <i class="fas fa-check-circle me-2"></i> Submit Order
            </button>
        </form>
    </div>

    <script>
        let cart = <?php echo isset($data['reset']) && $data['reset'] ? '{}' : 'JSON.parse(localStorage.getItem("cart")) || {}'; ?>;

        function updateCartTable() {
            const tbody = document.querySelector('#cart-table tbody');
            const tfoot = document.querySelector('#cart-table tfoot');
            const submitBtn = document.querySelector('.btn-submit');
            tbody.innerHTML = '';
            let totalPrice = 0;

            if (Object.keys(cart).length === 0) {
                tbody.innerHTML = '<tr><td colspan="5">No products selected yet.</td></tr>';
                tfoot.innerHTML = '';
                submitBtn.style.display = 'none';
            } else {
                submitBtn.style.display = 'block';
                for (let productId in cart) {
                    const item = cart[productId];
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="updateQuantity('${productId}', -1)">-</button>
                                <span>${item.quantity}</span>
                                <button class="quantity-btn" onclick="updateQuantity('${productId}', 1)">+</button>
                            </div>
                        </td>
                        <td>$${(item.price * item.quantity).toFixed(2)}</td>
                        <td>
                            <button class="remove-btn" onclick="removeProduct('${productId}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                    totalPrice += item.price * item.quantity;
                }
                tfoot.innerHTML = `
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td colspan="2"><strong>$${totalPrice.toFixed(2)}</strong></td>
                    </tr>
                `;
            }
            document.getElementById('cart-data').value = JSON.stringify(cart);
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function updateQuantity(productId, change) {
            if (cart[productId]) {
                cart[productId].quantity += change;
                if (cart[productId].quantity <= 0) {
                    delete cart[productId];
                }
                updateCartTable();
            }
        }

        function removeProduct(productId) {
            if (cart[productId]) {
                delete cart[productId];
                updateCartTable();
            }
        }

        const productInput = document.querySelector('input[name="product_name"]');
        const productIdInput = document.getElementById('product-id');
        productInput.addEventListener('input', function() {
            const selectedOption = Array.from(document.querySelectorAll('#product-list option'))
                .find(option => option.value === this.value);
            if (selectedOption) {
                productIdInput.value = selectedOption.getAttribute('data-id');
            } else {
                productIdInput.value = '';
            }
        });

        <?php if (isset($data['productInfo'])): ?>
            const productId = '<?= $data['productInfo']['id'] ?>';
            if (cart[productId]) {
                cart[productId].quantity += <?= $data['quantity'] ?>;
            } else {
                cart[productId] = {
                    product_id: <?= $data['productInfo']['id'] ?>,
                    name: '<?= htmlspecialchars($data['productInfo']['name']) ?>',
                    price: <?= $data['productInfo']['price'] ?>,
                    quantity: <?= $data['quantity'] ?>
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
    </script>
</main>