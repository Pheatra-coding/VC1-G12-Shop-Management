<main id="main" class="main">
    <style>
        /* General container styling */
        .main {
           
            margin: 0 auto;
            padding: 20px;
            font-family: 'Arial', sans-serif;
        }

        .pagetitle h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 10px;
        }

        .pagetitle + p {
            color: #666;
            margin-bottom: 20px;
        }

        /* Scanner container */
        .scanner-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .scanner-container h4 {
            font-size: 1.25rem;
            color: #444;
            margin-bottom: 15px;
        }

        /* Input group */
        .input-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .form-control {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.3);
        }

        /* Add button */
        .btn-search {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-search:hover {
            background-color: #0056b3;
        }

        /* Cart table */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .cart-table th,
        .cart-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .cart-table th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .cart-table td {
            color: #555;
        }

        .cart-table tbody tr:hover {
            background-color: #f5f5f5;
            transition: background-color 0.2s;
        }

        .cart-table tfoot td {
            font-weight: bold;
            color: #333;
            background-color: #f8f9fa;
        }

        /* Submit button */
        .btn-submit {
            background-color: #28a745;
            color: white;
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        /* Alert */
        .alert-info {
            background-color: #e7f1ff;
            color: #31708f;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .input-group {
                flex-direction: column;
            }
            .form-control,
            .btn-search {
                width: 100%;
            }
        }
    </style>

    <div class="pagetitle">
        <h1>Input Product Sale</h1>
    </div>
    <p>Select products to add them to the cart</p>

    <div class="scanner-container mt-4">
        <h4>Product Selector</h4>
        <form method="POST" action="/input_products/scan">
            <div class="input-group">
                <input type="text" class="form-control" name="product_name" list="product-list" placeholder="Search for a product" required>
                <datalist id="product-list">
                    <?php foreach ($data['products'] as $product): ?>
                        <option value="<?= htmlspecialchars($product['name']) ?>" data-id="<?= $product['id'] ?>">
                    <?php endforeach; ?>
                </datalist>
                <input type="hidden" name="product_id" id="product-id">
                <input type="number" class="form-control" name="quantity" min="1" placeholder="Quantity" required>
                <button class="btn btn-custom btn-search" type="submit">
                    <i class="fas fa-plus"></i> Add
                </button>
            </div>
        </form>

        <?php if (isset($data['message'])): ?>
            <div class="alert alert-info mt-4">
                <?= htmlspecialchars($data['message']) ?>
            </div>
        <?php endif; ?>

        <div id="cart-table-container">
            <table class="cart-table" id="cart-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
        </div>

        <form method="POST" action="/input_products/submit" id="submit-form">
            <input type="hidden" name="cart_data" id="cart-data">
            <button type="submit" class="btn btn-custom btn-submit">Submit Order</button>
        </form>
    </div>

    <script>
        let cart = <?php echo isset($data['reset']) && $data['reset'] ? '{}': 'JSON.parse(localStorage.getItem("cart")) || {}'; ?>;

        function updateCartTable() {
            const tbody = document.querySelector('#cart-table tbody');
            const tfoot = document.querySelector('#cart-table tfoot');
            tbody.innerHTML = '';
            let totalPrice = 0;

            if (Object.keys(cart).length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">No products selected yet.</td></tr>';
                tfoot.innerHTML = '';
            } else {
                for (let productId in cart) {
                    const item = cart[productId];
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>$${item.price}</td>
                        <td>${item.quantity}</td>
                        <td>$${(item.price * item.quantity).toFixed(2)}</td>
                    `;
                    tbody.appendChild(row);
                    totalPrice += item.price * item.quantity;
                }
                tfoot.innerHTML = `
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total Price:</strong></td>
                        <td><strong>$${totalPrice.toFixed(2)}</strong></td>
                    </tr>
                `;
            }
            document.getElementById('cart-data').value = JSON.stringify(cart);
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