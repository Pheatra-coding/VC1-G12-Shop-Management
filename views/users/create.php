<main id="main" class="main">
    <!-- User Creation Form -->
    <form action="/users/store" method="post" enctype="multipart/form-data">
        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="">

            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" placeholder="Enter email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback">
                        <?= htmlspecialchars($errors['email']) ?>
                    </div>
                <?php endif; ?>
            </div>
        
            <div class="mb-3 mt-3">
                <label for="role" class="form-label">Role:</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="" disabled <?= !isset($_POST['role']) ? 'selected' : '' ?>>Select Role</option>
                    <option value="admin" <?= (isset($_POST['role']) && $_POST['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= (isset($_POST['role']) && $_POST['role'] === 'user') ? 'selected' : '' ?>>User</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
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
        <a href="/users" class="btn btn-secondary">Cancel</a>
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