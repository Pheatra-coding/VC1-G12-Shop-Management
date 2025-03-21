<?php session_start(); ?>
<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true && isset($user) && $user['status'] === 'Active'): ?>
    <main id="main" class="main d-flex justify-content-center bg-light">
        <div class="card shadow-lg position-relative rounded-3" style="max-width: 80%; width: 90%;">
            <div class="position-absolute top-0 start-0 end-0 bg-gradient-primary rounded-top" style="height: 80px;"></div>
            <div class="card-body pt-5">
                <!-- Profile Picture, Name, and Role with Background Color -->
                <div style="background-color: #e9ecef; padding: 20px; border-radius: 10px; display: flex; align-items: flex-start; margin-bottom: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <!-- Profile Picture with Box Shadow -->
                    <div style="margin-right: 20px;">
                        <img src="/uploads/<?= htmlspecialchars($user['image']) ?>" alt="Profile" class="rounded-circle border-4 border-white" style="width: 120px; height: 120px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                    </div>
                    <!-- Name and Role -->
                    <div>
                        <h2 class="fw-bold mb-1" style="color: #2c3e50;"><?= htmlspecialchars($user['name']) ?></h2>
                        <h3 class="text-muted" style="color: #7f8c8d;"><?= htmlspecialchars($user['role']) ?></h3>
                    </div>
                </div>

                <!-- My Profile Heading -->
                <div style="margin-bottom: 30px;">
                    <h1 style="color: #34495e; font-size: 2rem; font-weight: bold;">My Profile</h1>
                </div>

                <!-- Profile Details with Icons and Gaps -->
                <div class="row g-4">
                    <div class="col-12 d-flex align-items-center border-bottom pb-3" style="border-color: #ecf0f1;">
                        <div class="col-4 fw-semibold" style="color: #34495e;"><i class="bi bi-person-fill me-2"></i>Full Name:</div>
                        <div class="col-8" style="color: #2c3e50;"><?= htmlspecialchars($user['name']) ?></div>
                    </div>
                    <div class="col-12 d-flex align-items-center border-bottom pb-3" style="border-color: #ecf0f1;">
                        <div class="col-4 fw-semibold" style="color: #34495e;"><i class="bi bi-person-badge-fill me-2"></i>Role:</div>
                        <div class="col-8" style="color: #2c3e50;"><?= htmlspecialchars($user['role']) ?></div>
                    </div>
                    <div class="col-12 d-flex align-items-center pb-3">
                        <div class="col-4 fw-semibold" style="color: #34495e;"><i class="bi bi-envelope-fill me-2"></i>Email:</div>
                        <div class="col-8" style="color: #2c3e50;"><?= htmlspecialchars($user['email']) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let dropdownBtn = document.querySelector(".dropdown-toggle");
                let dropdownMenu = document.querySelector(".dropdown-menu.profile");

                // Prevent Bootstrap from repositioning dropdown
                dropdownBtn.removeAttribute("data-bs-toggle");

                // Toggle dropdown when clicking profile picture
                dropdownBtn.addEventListener("click", function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    // Keep dropdown in place and toggle visibility
                    let isVisible = dropdownMenu.classList.contains("show");
                    document.querySelectorAll(".dropdown-menu").forEach(menu => {
                        menu.classList.remove("show");
                        menu.style.display = "none";
                    });

                    if (!isVisible) {
                        dropdownMenu.classList.add("show");
                        dropdownMenu.style.display = "block";
                        dropdownMenu.style.top = dropdownBtn.offsetHeight + "px";
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener("click", function(event) {
                    if (!dropdownBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.remove("show");
                        dropdownMenu.style.display = "none";
                    }
                });
            });
        </script>
        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </main>
<?php else: ?>
    <?php $this->redirect('/users/login'); ?>
<?php endif; ?>