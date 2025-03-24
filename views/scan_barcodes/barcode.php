<main id="main" class="main">
    <style>
        /* [Previous styles remain the same] */
        .btn-submit {
            background-color: #28a745;
            color: white;
            margin-top: 20px;
            width: 100%;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
    </style>

    <div class="pagetitle">
        <h1>Scan Barcode</h1>
    </div>
    <p>Scan products to add them to the cart</p>

    <div class="scanner-container mt-4">
        <h4>Barcode Scanner</h4>
        <form method="POST" action="/scan_barcodes/scan">
            <div class="input-group">
                <input type="text" id="barcodeInput" class="form-control" name="barcode" placeholder="Enter barcode" autofocus>
                <button class="btn btn-custom btn-search" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>

        <?php if (isset($message)): ?>
            <div class="alert alert-info mt-4">
                <?= htmlspecialchars($message) ?>
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

        <form method="POST" action="/scan_barcodes/submit" id="submit-form">
            <input type="hidden" name="cart_data" id="cart-data">
            <button type="submit" class="btn btn-custom btn-submit">Submit Order</button>
        </form>
    </div>

    <script>
        // Initialize cart - reset if coming from confirm
        let cart = <?php echo isset($data['reset']) && $data['reset'] ? '{}': 'JSON.parse(localStorage.getItem("cart")) || {}'; ?>;

        function updateCartTable() {
            const tbody = document.querySelector('#cart-table tbody');
            const tfoot = document.querySelector('#cart-table tfoot');
            tbody.innerHTML = '';
            let totalPrice = 0;

            if (Object.keys(cart).length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">No products scanned yet.</td></tr>';
                tfoot.innerHTML = '';
            } else {
                for (let barcode in cart) {
                    const item = cart[barcode];
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
            // Reset cart if coming from confirm
            <?php if (isset($data['reset']) && $data['reset']): ?>
                localStorage.removeItem('cart');
                cart = {};
            <?php endif; ?>
            updateCartTable();
        <?php endif; ?>

        // Clear cart after submit
        document.getElementById('submit-form').onsubmit = function() {
            localStorage.setItem('cart', JSON.stringify(cart)); // Save current state before submit
            setTimeout(() => {
                localStorage.removeItem('cart'); // Clear after submission
            }, 1000);
        };
    </script>
</main>