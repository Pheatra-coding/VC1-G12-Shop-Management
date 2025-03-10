<?php
if (!isset($user)) {
    echo "User not found.";
    exit;
}
// Set default image if no image is found
$imageUrl = !empty($user['image']) ? htmlspecialchars($user['image']) : 'path/to/default/image.jpg'; // Provide a valid path to a default image
?>

<main id="main" class="main">
    <div class="container">
        <!-- User Edit Form -->
        <form action="/users/update/<?php echo htmlspecialchars($user['id']); ?>" method="post" enctype="multipart/form-data">
            <!-- CSRF Protection -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="role" class="form-label">Role:</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="" disabled>Select Role</option>
                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password (leave blank to keep current)" name="password">
            </div>

            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image:</label>
                <input type="file" class="form-control" id="profile_image" name="image" accept="image/*" onchange="previewImage(event)">
                <div class="mt-3">
                    <img id="image_preview" src="<?php echo $imageUrl; ?>" alt="Current Image" class="img-fluid" style="width: 160px; height: 160px; border-radius: 10px; display: block; margin-top: 10px;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/users" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('image_preview');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</main>