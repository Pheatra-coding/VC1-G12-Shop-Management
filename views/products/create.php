<?php session_start(); ?> 
<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true): ?>

<main id="main" class="main">
    <form action="/products/store" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="">

        <!-- Image Upload -->
        <div class="mb-4 text-center">
            <label for="profile_image" class="form-label fw-bold">Product Image</label>
            <div class="custom-file-upload">
                <div class="image-preview-container">
                    <img 
                        id="image_preview" 
                        src="#" 
                        alt="Image Preview" 
                        class="img-fluid d-none rounded-circle" 
                        style="width: 160px; height: 160px; object-fit: cover; border: 2px solid #ddd;"
                    >
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
                <label for="profile_image" class="file-upload-label mt-3">
                    <i class="fas fa-cloud-upload-alt me-2"></i> Choose Image
                </label>
                <input type="file" class="form-control d-none" id="profile_image" name="image" accept="image/*" onchange="previewImage(event)">
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
                </div>
                
                <div class="mb-3">
                    <label for="purchase_price" class="form-label">Purchase Price ($):</label>
                    <input type="number" class="form-control" id="purchase_price" name="purchase_price" min="0.01" step="0.01" placeholder="0.00">
                </div>
                
                <div class="mb-3">
                    <label for="quantity" class="form-label">Stock Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" step="1" placeholder="0" required>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="barcode" class="form-label">Barcode Number:</label>
                    <input type="text" class="form-control" id="barcode" placeholder="Enter barcode" name="barcode" required>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Selling Price ($):</label>
                    <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01" placeholder="0.00" required>
                </div>
                
                <div class="mb-3">
                    <label for="endDate" class="form-label">Expiration Date</label>
                    <input type="date" class="form-control" id="endDate" name="end_date" required>
                </div>
            </div>
        </div>

        <!-- Form Buttons -->
        <div class="mb-3">
            <a href="/products" class="btn btn-secondary" style="margin-right: 8px;">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Save
            </button>
        </div>
    </form>
</main>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('image_preview');
        const closeButton = document.getElementById('close_preview');
        preview.src = reader.result;
        preview.classList.remove('d-none');
        closeButton.classList.remove('d-none');
    }
    reader.readAsDataURL(event.target.files[0]);
}

function closeImagePreview() {
    const preview = document.getElementById('image_preview');
    const closeButton = document.getElementById('close_preview');
    const fileInput = document.getElementById('profile_image');
    preview.src = '#';
    preview.classList.add('d-none');
    closeButton.classList.add('d-none');
    fileInput.value = '';
}
</script>

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