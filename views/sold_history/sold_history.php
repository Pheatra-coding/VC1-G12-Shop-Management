<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_name']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'):
    $items_per_page = 8;
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $items_per_page;
    $total_transactions = count($transactions);
    $total_pages = ceil($total_transactions / $items_per_page);
    $paginated_transactions = array_slice($transactions, $offset, $items_per_page);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Sold History</h1>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <div class="input-group w-50">
            <input type="text" id="searchInput" class="form-control" placeholder="Search sold products..." onkeyup="searchTable()">
            <button class="btn btn-secondary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="soldTable" class="table" style="vertical-align: middle;">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Sale Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($paginated_transactions) && is_array($paginated_transactions)) : ?>
                    <?php foreach ($paginated_transactions as $transaction) : ?>
                        <tr class="product-item">
                            <td class="product-name"><?php echo htmlspecialchars($transaction['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['quantity']); ?></td>
                            <td>$<?php echo number_format((float)$transaction['total_price'], 2, '.', ''); ?></td>
                            <td><?php echo htmlspecialchars(date('d-M-Y', strtotime($transaction['sale_date']))); ?></td>
                            <td class="text-center align-middle" style="width: 50px;">
                                <div class="dropdown">
                                    <i class="bi bi-three-dots-vertical"
                                       data-bs-toggle="dropdown"
                                       aria-expanded="false"
                                       style="cursor: pointer; font-size: 1.2rem; display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; transition: background 0.3s;"
                                       onmouseover="this.style.background='#f1f1f1'"
                                       onmouseout="this.style.background='transparent'">
                                    </i>
                                    <ul class="dropdown-menu shadow-sm rounded-2 border-0 p-1">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small text-primary"
                                               href="#"
                                               onclick="viewReceipt(<?php echo isset($transaction['transaction_id']) ? $transaction['transaction_id'] : 0; ?>, '<?php echo addslashes(htmlspecialchars($transaction['product_name'])); ?>', <?php echo (int)$transaction['quantity']; ?>, <?php echo (float)$transaction['total_price']; ?>, '<?php echo addslashes(htmlspecialchars(date('D, d M Y', strtotime($transaction['sale_date'])))); ?>')">
                                                <i class="bi bi-eye"></i> View Receipt
                                            </a>
                                        </li>
                                        <?php if ($_SESSION['user_role'] === 'Admin'): ?>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-1 py-1 px-2 small text-danger"
                                                   href="/sold_history/delete/<?php echo $transaction['product_id']; ?>"
                                                   onclick="return confirmDelete(event, '<?php echo addslashes(htmlspecialchars($transaction['product_name'])); ?>')">
                                                    <i class="bi bi-trash3"></i> Delete
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No transactions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_pages > 1) : ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($current_page > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                    <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>

    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="receiptModalBody">
                    <!-- Receipt content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden container for printing -->
    <div id="printContainer" style="display: none;"></div>
</main>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Add html2canvas library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    function searchTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.product-item');
        let hasResults = false;

        rows.forEach(row => {
            const productName = row.querySelector('.product-name').innerText.toLowerCase();
            row.style.display = productName.includes(input) ? '' : 'none';
            if (productName.includes(input)) hasResults = true;
        });
    }

    function confirmDelete(event, productName) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete "${productName}". This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = event.target.href;
            }
        });
    }

    function viewReceipt(transactionId, productName, quantity, totalPrice, saleDate) {
        const receiptHTML = `
            <div class="receipt-container" id="receipt" style="width: 100%; box-shadow: none; padding: 0;">
                <div class="receipt-header">
                    <h1>DINO SHOP</h1>
                    <p>Order Receipt</p>
                </div>

                <div class="ticket-info">
                    <div class="ticket-details">
                        <p><strong>Shop:</strong> Dino Shop</p>
                        <p><strong>Date:</strong> ${saleDate}</p>
                    </div>
                </div>

                <div class="divider"></div>

                <h3 class="section-title">Order Summary</h3>
                <table class="cart-table">
                    <tbody>
                        <tr>
                            <td>${quantity} × ${productName}</td>
                            <td>$${totalPrice.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td>$${totalPrice.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td>$0.00</td>
                        </tr>
                        <tr class="total-row">
                            <td>Total Amount</td>
                            <td>$${totalPrice.toFixed(2)}</td>
                        </tr>
                    </tbody>
                </table>

                <button class="btn-print" onclick="printReceipt()">
                    <i class="bi bi-printer"></i> Print Receipt
                </button>

                <button class="btn-download" onclick="downloadReceipt()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                    </svg> Download Receipt
                </button>

                <div class="receipt-footer">
                    <p>Thank you for shopping with us!</p>
                </div>
            </div>
        `;

        document.getElementById('receiptModalBody').innerHTML = receiptHTML;
        const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        receiptModal.show();
    }

    function printReceipt() {
        const receiptElement = document.getElementById('receipt');
        if (!receiptElement) {
            console.error('Receipt element not found');
            return;
        }

        // Clone the receipt to avoid modal interference
        const printContainer = document.getElementById('printContainer');
        const receiptClone = receiptElement.cloneNode(true);

        // Hide buttons in the clone
        const printBtn = receiptClone.querySelector('.btn-print');
        const downloadBtn = receiptClone.querySelector('.btn-download');
        if (printBtn) printBtn.style.display = 'none';
        if (downloadBtn) downloadBtn.style.display = 'none';

        // Apply print-specific styles to the clone
        receiptClone.style.width = '100%';
        receiptClone.style.margin = '0';
        receiptClone.style.padding = '20px';
        receiptClone.style.boxShadow = 'none';
        receiptClone.style.borderRadius = '0';
        receiptClone.style.position = 'static'; // Ensure it behaves like a normal element

        // Append the clone to the hidden print container
        printContainer.innerHTML = '';
        printContainer.appendChild(receiptClone);

        // Ensure the DOM updates before printing
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                const originalOverflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';

                // Print the page
                window.print();

                // Restore original state
                document.body.style.overflow = originalOverflow;
                printContainer.innerHTML = ''; // Clear the print container
            });
        });
    }

    async function downloadReceipt() {
        try {
            const receiptElement = document.getElementById('receipt');
            if (!receiptElement) {
                console.error('Receipt element not found');
                return;
            }

            // Hide buttons temporarily
            const printBtn = receiptElement.querySelector('.btn-print');
            const downloadBtn = receiptElement.querySelector('.btn-download');
            if (printBtn) printBtn.style.display = 'none';
            if (downloadBtn) downloadBtn.style.display = 'none';

            // Clone the receipt for download
            const clone = receiptElement.cloneNode(true);
            clone.style.width = '100%';
            clone.style.margin = '0';
            clone.style.padding = '20px';
            clone.style.boxShadow = 'none';
            clone.style.borderRadius = '0';
            document.body.appendChild(clone);

            // Capture the clone as an image
            const canvas = await html2canvas(clone, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff',
                logging: false,
                removeContainer: true
            });

            // Remove the clone
            document.body.removeChild(clone);

            // Restore buttons
            if (printBtn) printBtn.style.display = 'block';
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
            const printBtn = document.getElementById('receipt')?.querySelector('.btn-print');
            const downloadBtn = document.getElementById('receipt')?.querySelector('.btn-download');
            if (printBtn) printBtn.style.display = 'block';
            if (downloadBtn) downloadBtn.style.display = 'flex';
        }
    }
</script>

<style>
    /* Receipt Styles */
    .receipt-container {
        margin: auto;
        width: 100%;
        background-color: white;
        border-radius: 12px;
        padding: 15px;
        box-sizing: border-box;
    }
    .receipt-header {
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    .receipt-header h1 {
        color: #2c3e50;
        margin: 0 0 8px 0;
        font-size: 22px;
        font-weight: 600;
    }
    .receipt-header p {
        color: #7f8c8d;
        margin: 0;
        font-size: 14px;
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
        margin: 6px 0;
        font-size: 14px;
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
        font-size: 16px;
        margin: 0 0 15px 0;
        font-weight: 600;
    }
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .cart-table td {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
        color: #34495e;
        font-size: 14px;
    }
    .cart-table tr:last-child td {
        border-bottom: none;
    }
    .total-row {
        font-weight: 600;
        color: #2c3e50 !important;
    }
    .receipt-footer {
        text-align: center;
        margin-top: 15px;
        color: #95a5a6;
        font-size: 13px;
    }

    /* Button Styles */
    .btn-print {
        background-color: #26ad5f;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        width: 100%;
        transition: background-color 0.2s;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-print:hover {
        background-color: #2ecc71;
    }
    .btn-download {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        width: 100%;
        transition: background-color 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 5px;
        margin-bottom: 10px;
    }
    .btn-download:hover {
        background-color: #0069d9;
    }

    /* Print-specific styles */
    @media print {
        body, html {
            margin: 0;
            padding: 0;
            background: white;
            overflow: visible !important;
        }

        body * {
            visibility: hidden;
        }

        #printContainer, #printContainer * {
            visibility: visible;
        }

        #printContainer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
            box-shadow: none;
            border-radius: 0;
            display: block !important;
        }

        #printContainer .receipt-container {
            width: 100%;
            margin: 0;
            padding: 20px;
            box-shadow: none;
            border-radius: 0;
        }

        .btn-print, .btn-download {
            display: none !important;
        }

        @page {
            size: auto;
            margin: 10mm;
        }
    }
</style>

<?php else:
    header("Location: /users/login");
    exit;
endif; ?>