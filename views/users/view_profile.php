<?php
// Securely validate user session and status
if (isset($_SESSION['users']) && $_SESSION['users'] === true && isset($user) && $user['status'] === 'Active'):
?>
    <main id="main" class="main d-flex justify-content-center bg-light" style="min-height: 100vh; padding: 40px 0; background: #f1f5f9;">
        <div class="card shadow-lg position-relative rounded-3" style="max-width: 80%; width: 90%; transition: transform 0.3s ease; background: #fff;">
            <!-- Header Gradient Overlay with Subtle Animation -->
            <div class="position-absolute top-0 start-0 end-0 rounded-top" style="height: 100px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); box-shadow: 0 2px 10px rgba(30, 58, 138, 0.3);"></div>
            
            <div class="card-body pt-5" style="position: relative; z-index: 1;">
                <!-- Profile Header Container with Hover Effect -->
                <div style="background: linear-gradient(145deg, #f1f5f9, #ffffff); padding: 25px; border-radius: 15px; display: flex; align-items: center; margin-bottom: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s ease;">
                    <!-- Profile Avatar with Interactive Border -->
                    <div style="margin-right: 25px; position: relative;">
                        <img src="/uploads/<?= htmlspecialchars($user['image'] ?? 'default.jpg', ENT_QUOTES, 'UTF-8') ?>" 
                             alt="User Profile Avatar" 
                             class="rounded-circle border-4 border-white" 
                             style="width: 130px; height: 130px; object-fit: cover; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease;">
                        <div style="position: absolute; top: -5px; right: -5px; width: 25px; height: 25px; background: #10b981; border-radius: 50%; border: 2px solid white;"></div> <!-- Online Indicator -->
                    </div>
                    <!-- User Identification with Bold Styling -->
                    <div style="flex-grow: 1;">
                        <h2 class="fw-bold mb-1" style="color: #1f2937; font-size: 2rem; letter-spacing: 0.5px;"><?= htmlspecialchars($user['name'] ?? 'Unnamed User', ENT_QUOTES, 'UTF-8') ?></h2>
                        <h3 class="text-muted" style="color: #6b7280; font-size: 1.25rem; font-style: italic;"><?= htmlspecialchars($user['role'] ?? 'No Role', ENT_QUOTES, 'UTF-8') ?></h3>
                    </div>
                </div>

                <!-- Profile Section Title with Underline Effect -->
                <div style="margin-bottom: 35px; text-align: center;">
                    <h1 style="color: #1e3a8a; font-size: 2.5rem; font-weight: bold; position: relative; display: inline-block; padding-bottom: 10px;">
                        My Profile
                        <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 50%; height: 3px; background: linear-gradient(to right, #10b981, transparent);"></span>
                    </h1>
                </div>

                <!-- Profile Information Grid with Card-like Rows -->
                <div class="row g-4">
                    <div class="col-12 d-flex align-items-center border-bottom pb-3" style="background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); transition: transform 0.2s ease;">
                        <div class="col-4 fw-semibold" style="color: #1e3a8a; font-size: 1.1rem;">
                            <i class="bi bi-person-fill me-2" style="color: #10b981;"></i>Full Name:
                        </div>
                        <div class="col-8" style="color: #1f2937; font-size: 1.1rem;"><?= htmlspecialchars($user['name'] ?? 'Unnamed User', ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                    <div class="col-12 d-flex align-items-center border-bottom pb-3" style="background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); transition: transform 0.2s ease;">
                        <div class="col-4 fw-semibold" style="color: #1e3a8a; font-size: 1.1rem;">
                            <i class="bi bi-person-badge-fill me-2" style="color: #10b981;"></i>Role:
                        </div>
                        <div class="col-8" style="color: #1f2937; font-size: 1.1rem;"><?= htmlspecialchars($user['role'] ?? 'No Role', ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                    <div class="col-12 d-flex align-items-center pb-3" style="background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); transition: transform 0.2s ease;">
                        <div class="col-4 fw-semibold" style="color: #1e3a8a; font-size: 1.1rem;">
                            <i class="bi bi-envelope-fill me-2" style="color: #10b981;"></i>Email:
                        </div>
                        <div class="col-8" style="color: #1f2937; font-size: 1.1rem;"><?= htmlspecialchars($user['email'] ?? 'No Email', ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Dropdown Interaction Script -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const dropdownBtn = document.querySelector(".dropdown-toggle");
                const dropdownMenu = document.querySelector(".dropdown-menu.profile");

                if (dropdownBtn && dropdownMenu) {
                    dropdownBtn.removeAttribute("data-bs-toggle");

                    dropdownBtn.addEventListener("click", function(event) {
                        event.preventDefault();
                        event.stopPropagation();

                        const isVisible = dropdownMenu.classList.contains("show");
                        document.querySelectorAll(".dropdown-menu").forEach(menu => {
                            menu.classList.remove("show");
                            menu.style.display = "none";
                        });

                        if (!isVisible) {
                            dropdownMenu.classList.add("show");
                            dropdownMenu.style.display = "block";
                            dropdownMenu.style.position = "absolute";
                            dropdownMenu.style.top = `${dropdownBtn.offsetHeight}px`;
                            dropdownMenu.style.left = "0";
                            dropdownMenu.style.zIndex = "1000";
                            dropdownMenu.style.transition = "opacity 0.2s ease";
                            dropdownMenu.style.opacity = "1";
                            dropdownMenu.style.background = "#fff";
                            dropdownMenu.style.boxShadow = "0 4px 12px rgba(0, 0, 0, 0.1)";
                            dropdownMenu.style.borderRadius = "8px";
                        }
                    });

                    document.addEventListener("click", function(event) {
                        if (!dropdownBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
                            dropdownMenu.style.opacity = "0";
                            setTimeout(() => {
                                dropdownMenu.classList.remove("show");
                                dropdownMenu.style.display = "none";
                            }, 200);
                        }
                    });

                    // Hover effects for card and rows
                    const card = document.querySelector(".card");
                    const rows = document.querySelectorAll(".row > div");
                    card.addEventListener("mouseenter", () => card.style.transform = "scale(1.02)");
                    card.addEventListener("mouseleave", () => card.style.transform = "scale(1)");
                    rows.forEach(row => {
                        row.addEventListener("mouseenter", () => row.style.transform = "translateY(-5px)");
                        row.addEventListener("mouseleave", () => row.style.transform = "translateY(0)");
                    });
                } else {
                    console.warn("Dropdown elements not found in the DOM.");
                }
            });
        </script>
        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
                crossorigin="anonymous"></script>
    </main>
<?php else: ?>
    <?php 
    header("Location: /users/login");
    exit;
    ?>
<?php endif; ?>