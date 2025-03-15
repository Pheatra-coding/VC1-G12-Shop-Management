<main id="main" class="main">
    <!-- Product Creation Form -->
    <form action="/products/update/<?= $product['id'] ?>" method="post" enctype="multipart/form-data">
        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="">

        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="endDate" class="form-label">End Date:</label>
            <input type="date" class="form-control" id="endDate" name="end_date" value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : htmlspecialchars($product['end_date']); ?>" required>
        </div>
    
        <div class="mb-3">
            <label for="barcode" class="form-label">Barcode:</label>
            <input type="text" class="form-control <?= isset($errors['barcode']) ? 'is-invalid' : '' ?>" id="barcode" name="barcode" value="<?php echo isset($_POST['barcode']) ? htmlspecialchars($_POST['barcode']) : htmlspecialchars($product['barcode']); ?>" required>
            <?php if (isset($errors['barcode'])): ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['barcode']) ?>
                </div>
            <?php endif; ?>
        </div>

    
        <div class="mb-3">
            <label for="price" class="form-label">Price($):</label>
            <input type="number" step="0.01" class="form-control <?= isset($errors['general']) ? 'is-invalid' : '' ?>" id="price" name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : htmlspecialchars($product['price']); ?>" min="0" required>
            <?php if (isset($errors['general'])): ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['general']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity:</label>
            <input type="number" class="form-control <?= isset($errors['general']) ? 'is-invalid' : '' ?>" id="quantity" name="quantity" value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : htmlspecialchars($product['quantity']); ?>" min="0" required>
            <?php if (isset($errors['general'])): ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['general']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="profile_image" class="form-label">Product Image:</label>
            <input type="file" class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>" id="profile_image" name="image" accept="image/*" onchange="previewImage(event)">
            <?php if (isset($errors['image'])): ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['image']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-3">
            <img 
                id="image_preview"
                src="<?= $product['image'] ? '/uploads/' . htmlspecialchars($product['image']) : '#' ?>" 
                alt="Product Image"
                class="img-fluid"
                style="
                    width: 160px; 
                    height: 160px; 
                    border-radius: 10px; 
                    display: <?= $product['image'] ? 'block' : 'none' ?>; 
                    margin-top: 10px; 
                    object-fit: cover;"
            >
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="/products" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</main>

<!-- JavaScript for image preview -->
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('image_preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<!-- JavaScript for enforcing positive numbers -->
<script>
    document.getElementById('price').addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
    });

    document.getElementById('quantity').addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
    });
</script>