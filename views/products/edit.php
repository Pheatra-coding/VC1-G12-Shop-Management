<?php session_start(); ?> 
<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true): ?>

<main id="main" class="main">
    <!-- Product Update Form -->
    <form action="/products/update/<?= $product['id'] ?>" method="post" enctype="multipart/form-data">
        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="">

        <!-- Product Image Upload at the Top -->
        <div class="mb-4 text-center">
            <label for="profile_image" class="form-label fw-bold">Product Image</label>
            <div class="custom-file-upload">
                <!-- Image Preview -->
                <div class="image-preview-container">
                    <img 
                        id="image_preview" 
                        src="<?= $product['image'] ? '/views/uploads/' . htmlspecialchars($product['image']) : '#' ?>" 
                        alt="Product Image" 
                        class="img-fluid <?= $product['image'] ? 'rounded-circle' : 'd-none' ?>" 
                        style="width: 160px; height: 160px; object-fit: cover; border: 2px solid #ddd;"
                    >
                    <!-- Close Button -->
                    <button 
                        type="button" 
                        id="close_preview" 
                        class="position-absolute top-0 end-0 <?= $product['image'] ? '' : 'd-none' ?> bg-white rounded-circle border-0 shadow-sm" 
                        style="transform: translate(50%, -50%); padding: 5px 8px; cursor: pointer;" 
                        onclick="closeImagePreview()"
                        aria-label="Remove image"
                    >
                        <i class="fas fa-times" style="color: red; font-size: 1rem;"></i>
                    </button>
                </div>
                <!-- File Upload Label -->
                <label for="profile_image" class="file-upload-label mt-3">
                    <i class="fas fa-cloud-upload-alt me-2"></i> Choose Image
                </label>
                <!-- File Input -->
                <input type="file" class="form-control d-none" id="profile_image" name="image" accept="image/*" onchange="previewImage(event)">
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <!-- Product Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : htmlspecialchars($product['name']); ?>" required>
                </div>
                
                <!-- Purchase Price -->
                <div class="mb-3">
                    <label for="purchase_price" class="form-label">Purchase Price ($):</label>
                    <input type="number" step="0.01" class="form-control" id="purchase_price" name="purchase_price" value="<?php echo isset($_POST['purchase_price']) ? htmlspecialchars($_POST['purchase_price']) : htmlspecialchars($product['purchase_price']); ?>" min="0">
                </div>
                
                <!-- Stock Quantity -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Stock Quantity:</label>
                    <input type="number" class="form-control <?= isset($errors['general']) ? 'is-invalid' : '' ?>" id="quantity" name="quantity" value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : htmlspecialchars($product['quantity']); ?>" min="0" required>
                    <?php if (isset($errors['general'])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['general']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="col-md-6">
                <!-- Barcode -->
                <div class="mb-3">
                    <label for="barcode" class="form-label">Barcode Number:</label>
                    <input type="text" class="form-control <?= isset($errors['barcode']) ? 'is-invalid' : '' ?>" id="barcode" name="barcode" value="<?php echo isset($_POST['barcode']) ? htmlspecialchars($_POST['barcode']) : htmlspecialchars($product['barcode']); ?>" required>
                    <?php if (isset($errors['barcode'])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['barcode']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Selling Price -->
                <div class="mb-3">
                    <label for="price" class="form-label">Selling Price ($):</label>
                    <input type="number" step="0.01" class="form-control <?= isset($errors['general']) ? 'is-invalid' : '' ?>" id="price" name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : htmlspecialchars($product['price']); ?>" min="0" required>
                    <?php if (isset($errors['general'])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['general']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Expiration Date -->
                <div class="mb-3">
                    <label for="endDate" class="form-label">Expiration Date:</label>
                    <input type="date" class="form-control" id="endDate" name="end_date" value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : htmlspecialchars($product['end_date']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category:</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        <?php
                        $productModel = new ProductModel();
                        $categories = $productModel->getCategories();
                        foreach ($categories as $category) {
                            echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            
        </div>
         
        <!-- Submit and Cancel Buttons -->
        <div class="mb-3">
            <a href="/products" class="btn btn-secondary" style="margin-right: 8px;"><i class="fas fa-arrow-left me-2"></i> Back</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Update</button>
        </div>
    </form>
</main>

<!-- JavaScript for image preview -->
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('image_preview');
        const closeButton = document.getElementById('close_preview');

        // Set the image source and make it visible
        preview.src = reader.result;
        preview.classList.remove('d-none');

        // Make the close button visible
        closeButton.classList.remove('d-none');
    }
    reader.readAsDataURL(event.target.files[0]);
}

function closeImagePreview() {
    const preview = document.getElementById('image_preview');
    const closeButton = document.getElementById('close_preview');
    const fileInput = document.getElementById('profile_image');

    // Hide the image preview and close button
    preview.src = '#';
    preview.classList.add('d-none');
    closeButton.classList.add('d-none');

    // Clear the file input
    fileInput.value = '';
}

// Enforce positive numbers
document.getElementById('price').addEventListener('input', function() {
    if (this.value < 0) this.value = 0;
});

document.getElementById('purchase_price').addEventListener('input', function() {
    if (this.value < 0) this.value = 0;
});

document.getElementById('quantity').addEventListener('input', function() {
    if (this.value < 0) this.value = 0;
});
</script>

<!-- CSS for custom file upload -->
<style>
.custom-file-upload {
    border: 2px dashed #ccc;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.custom-file-upload:hover {
    background-color: #f9f9f9;
}

.file-upload-label {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.file-upload-label:hover {
    background-color: #0056b3;
}

.file-upload-label i {
    margin-right: 8px;
}

.image-preview-container {
    position: relative;
    margin-bottom: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.rounded-circle {
    border-radius: 50% !important;
}
</style>

<?php else:
    $this->redirect('/users/login');
endif;
?>