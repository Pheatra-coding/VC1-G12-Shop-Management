<?php session_start(); ?>

<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true): ?>
    <style>
        body {
            min-height: 100vh;
            /* Ensure body takes full viewport height */
            display: flex;
            justify-content: center;
            /* Center horizontally */
            background-color: #f5f5f5;
            /* Optional: light background for contrast */
            margin-top: 50px;

        }

        .main {
            width: 100%;
            max-width: 600px;
            /* Keep the max-width */
            padding: 20px;
            margin-top: 50px;
            /* Push it down a bit from the top */
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            /* Take full width of parent (.main) */
        }

        .form-container h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .main {
                padding: 10px;
                margin-top: 20px;
                /* Smaller margin on mobile */
            }

            .form-container {
                padding: 15px;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>

    <main id="main" class="main">
        <div class="form-container">
            <h1>Edit Category</h1>

            <?php if (isset($errors['general'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['general']); ?></div>
            <?php endif; ?>

            <form action="/categories/update/<?php echo htmlspecialchars($category['id']); ?>" method="POST">
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text"
                        id="category_name"
                        name="name"
                        value="<?php echo htmlspecialchars($category['category_name'] ?? ''); ?>"
                        required>
                    <?php if (isset($errors['category_name'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['category_name']); ?></div>
                    <?php endif; ?>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Update Category</button>
                    <a href="/categories" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php else:
    header('Location: /users/login');
    exit();
endif; ?>