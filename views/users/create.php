<main id="main" class="main">
    <!-- User Creation Form -->
    <form action="/users/store" method="post" enctype="multipart/form-data">
        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="">

        <!-- Profile Image Upload at the Top -->
        <div class="mb-4 text-center">
            <label for="profile_image" class="form-label fw-bold">Profile Image</label>
            <div class="custom-file-upload">
                <!-- Image Preview -->
                <div class="image-preview-container">
                    <img id="image_preview" src="#" alt="Image Preview" class="img-fluid d-none rounded-circle" style="width: 160px; height: 160px; object-fit: cover; border: 2px solid #ddd;">
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

        <!-- Name and Email in one line -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" placeholder="Enter email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback">
                        <?= htmlspecialchars($errors['email']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Role and Password in one line -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="role" class="form-label">Role:</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="" disabled <?= !isset($_POST['role']) ? 'selected' : '' ?>>Select Role</option>
                    <option value="admin" <?= (isset($_POST['role']) && $_POST['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= (isset($_POST['role']) && $_POST['role'] === 'user') ? 'selected' : '' ?>>User</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
            </div>
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="mb-3">
            <a href="/users" class="btn btn-secondary" style="margin-left: 12px;"> <i class="fas fa-arrow-left me-2"></i> Back to Users</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Save User</button>
        </div>
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
</main>