<main id="main" class="main">
    <!-- Products Creation Form -->
    <form action="/products/store" method="post" enctype="multipart/form-data">
        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="">

        <!-- Name and Barcode in one line -->
        <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Product Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
            </div>
            <div class="col-md-6">
                <label for="barcode" class="form-label">Barcode Number:</label>
                <input type="text" class="form-control <?= isset($errors['barcode']) ? 'is-invalid' : '' ?>" id="barcode" placeholder="Enter barcode" name="barcode" value="<?= isset($_POST['barcode']) ? htmlspecialchars($_POST['barcode']) : '' ?>" required>
                <?php if (isset($errors['barcode'])): ?>
                    <div class="invalid-feedback">
                        <?= htmlspecialchars($errors['barcode']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Price and Quantity in one line -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="price" class="form-label">Unit Price ($):</label>
                <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01" value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>" required>
            </div>
            <div class="col-md-6">
                <label for="quantity" class="form-label">Stock Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" step="1" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>" required>
            </div>
        </div>

        <!-- End Date -->
        <div class="mb-3">
            <label for="endDate" class="form-label">Expiration Date</label>
            <input type="date" class="form-control" id="endDate" name="end_date" value="<?= isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : '' ?>" required>
        </div>

        <!-- Profile Image Upload -->
        <div class="mb-3">
            <label for="profile_image" class="form-label">Product Image:</label>
            <input type="file" class="form-control" id="profile_image" name="image" accept="image/*" onchange="previewImage(event)">
            <div class="mt-3 position-relative" style="width: 160px;">
                <img 
                    id="image_preview" 
                    src="#" 
                    alt="Image Preview" 
                    class="img-fluid d-none" 
                    style="width: 160px; height: 160px; border-radius: 10px; margin-top: 10px; object-fit: cover;"
                >
                <!-- Close Button (No Background, Gray "X") -->
                <button 
                    type="button" 
                    id="close_preview" 
                    class="position-absolute top-0 end-0 d-none" 
                    style="transform: translate(150%, -20%); background: none; border: none; padding: 0; cursor: pointer;" 
                    onclick="closeImagePreview()"
                    aria-label="Remove image"
                >
                    <i class="fas fa-times" style="color: red; font-size: 1.2rem;"></i>
                </button>
            </div>
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Save Product</button>
            <a href="/products" class="btn btn-secondary" style="margin-left: 12px;"><i class="fas fa-arrow-left me-2"></i> Back to Products</a>
        </div>
    </form>
</main>

<!-- JavaScript for image preview -->
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
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
</script>