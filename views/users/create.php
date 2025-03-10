<main id="main" class="main">
<div class="container">
    <!-- User Creation Form -->
    <form action="/users/store" method="post" enctype="multipart/form-data">
        <!-- CSRF Protection -->
           <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name"   value="<?= $_SESSION['old_name'] ?? '' ?>" required>
        </div>

        <div class="mb-3 mt-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"  value="<?= $_SESSION['old_email'] ?? '' ?>"  required>
            <?php if (isset($_SESSION['email_error'])): ?>
                <div class="invalid-feedback">
                    <?= $_SESSION['email_error']; ?>
                </div>
                <?php unset($_SESSION['email_error']); ?>
            <?php endif; ?>
        </div>
    
        <div class="mb-3 mt-3">
            <label for="role" class="form-label">Role:</label>
            <select name="role" id="role" class="form-control" required>
                <option value="" disabled selected>Select Role</option>
                <option value="admin" <?= ($_SESSION['old_role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= ($_SESSION['old_role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
            </select>
            <?php if (isset($_SESSION['role_error'])): ?>
                <div class="invalid-feedback d-block">
                    <?= $_SESSION['role_error']; ?>
                </div>
                <?php unset($_SESSION['role_error']); ?>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" <?= isset($_SESSION['password_error']) ? 'is-invalid' : '' ?> id="pwd" placeholder="Enter password" name="password" required>
            <?php if (isset($_SESSION['password_error'])): ?>
                <div class="invalid-feedback">
                    <?= $_SESSION['password_error']; ?>
                </div>
                <?php unset($_SESSION['password_error']); ?>
            <?php endif; ?>
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
