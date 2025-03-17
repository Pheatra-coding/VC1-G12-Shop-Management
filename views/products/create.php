<main id="main" class="main">
    <!-- Products Creation Form -->
    <form action="/products/store" method="post" enctype="multipart/form-data">
        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="">

        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="endDate" class="form-label">End Date:</label>
            <input type="date" class="form-control" id="endDate" name="end_date" value="<?= isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : '' ?>" required>
        </div>
    
        <div class="mb-3 mt-3">
            <label for="barcode" class="form-label">Barcode:</label>
            <input type="text" class="form-control <?= isset($errors['barcode']) ? 'is-invalid' : '' ?>" id="barcode" placeholder="Enter barcode" name="barcode" value="<?= isset($_POST['barcode']) ? htmlspecialchars($_POST['barcode']) : '' ?>" required>
            <?php if (isset($errors['barcode'])): ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['barcode']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price($):</label>
            <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01" value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" min="1" step="1" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>" required>
        </div>

        <div class="mb-3">
        <label for="profile_image" class="form-label">Profile Image:</label>
        <input type="file" class="form-control" id="profile_image" name="image" accept="image/*" onchange="previewImage(event)">
        <div class="mt-3 position-relative" style="width: 160px;">
            <img id="image_preview" src="#" alt="Image Preview" class="img-fluid d-none" style="width: 160px; height: 160px; border-radius: 10px; display: block; margin-top: 10px;">
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

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/products" class="btn btn-secondary">Cancel</a>
    </form>

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
</main>