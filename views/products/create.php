<main id="main" class="main">
    <!-- Products Creation Form -->
    <form action="/products/store" method="post" enctype="multipart/form-data">
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
                        src="#" 
                        alt="Image Preview" 
                        class="img-fluid d-none rounded-circle" 
                        style="width: 160px; height: 160px; object-fit: cover; border: 2px solid #ddd;"
                    >
                    <!-- Close Button -->
                    <button 
                        type="button" 
                        id="close_preview" 
                        class="position-absolute top-0 end-0 d-none bg-white rounded-circle border-0 shadow-sm" 
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

        <!-- Submit and Cancel Buttons -->
        <div class="mb-3">
            <a href="/products" class="btn btn-secondary" style="margin-right: 8px;"><i class="fas fa-arrow-left me-2"></i> Back</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Save</button>
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