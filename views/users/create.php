<main id="main" class="main">
    <div class="container">
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
                <div class="mt-3">
                    <img id="image_preview" src="#" alt="Image Preview" class="img-fluid d-none" style="width: 160px; height: 160px; border-radius: 10px; display: block; margin-top: 10px;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/users" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const preview = document.getElementById('image_preview');
                preview.src = reader.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</main>