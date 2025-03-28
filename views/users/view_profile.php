<?php
if (isset($_SESSION['users']) && $_SESSION['users'] === true && isset($user) && $user['status'] === 'Active'):
?>
    <style>
        body {
            overflow: hidden;
        }
    </style>
    <main id="main" class="main d-flex justify-content-center bg-light" style="min-height: 100vh; padding: 60px 0; background: linear-gradient(145deg, #f0f4f8, #f8f9fa);">
        <div class="card position-relative rounded-3" style="max-width: 800px; width: 100%; background: #ffffff; border: none; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
            <!-- Modern gradient header with interesting design -->
            <div class="position-absolute top-0 start-0 end-0 rounded-top-3" style="height: 100px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); overflow: hidden;">
                <!-- Abstract geometric shapes for visual interest -->
                <div style="position: absolute; width: 150px; height: 150px; right: -30px; top: -30px; background: rgba(255, 255, 255, 0.1); border-radius: 30% 70% 70% 30% / 30% 40% 60% 70%; transform: rotate(15deg);"></div>
                <div style="position: absolute; width: 80px; height: 80px; left: 40px; bottom: -20px; background: rgba(255, 255, 255, 0.12); border-radius: 30% 50% 60% 40% / 60% 30% 70% 40%;"></div>
                <div style="position: absolute; width: 60px; height: 60px; left: 60%; top: 20px; background: rgba(255, 255, 255, 0.08); border-radius: 50%;"></div>
            </div>

            <div class="card-body pt-5 px-4 pb-4" style="position: relative; z-index: 1; margin-top: 40px;">
                <!-- Profile Header Container with interesting shadow effect -->
                <div style="background: linear-gradient(to right, #ffffff, #f8fafc); padding: 20px; border-radius: 10px; display: flex; align-items: center; margin-bottom: 30px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06), 0 2px 4px rgba(0, 0, 0, 0.08); border-left: 4px solid #3b82f6;">
                    <!-- Profile Avatar with subtle hover effect -->
                    <div style="margin-right: 20px; position: relative;">
                        <div style="width: 110px; height: 110px; border-radius: 15px; background: #3b82f6; transform: rotate(-3deg); position: absolute; top: -4px; left: -4px; z-index: -1; opacity: 0.5;"></div>
                        <img src="/views/uploads/<?= htmlspecialchars($user['image'] ?? 'default.jpg', ENT_QUOTES, 'UTF-8') ?>"
                            alt="User Profile"
                            class="rounded-3 border-2 border-white"
                            style="width: 110px; height: 110px; object-fit: cover; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;"
                            onmouseover="this.style.transform='scale(1.03)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <!-- User Identification with professional yet modern typography -->
                    <div style="flex-grow: 1; margin-right: 20px;">
                        <h2 class="fw-bold mb-1" style="color: #1e3a8a; font-size: 1.7rem; letter-spacing: -0.01em;"><?= htmlspecialchars($user['name'] ?? 'Unnamed User', ENT_QUOTES, 'UTF-8') ?></h2>
                        <h3 class="mb-2" style="color: #64748b; font-size: 1.05rem; font-weight: 500;"><?= htmlspecialchars($user['role'] ?? 'No Role', ENT_QUOTES, 'UTF-8') ?></h3>
                        <div style="width: 40px; height: 3px; background: linear-gradient(to right, #3b82f6, transparent); margin-top: 5px;"></div>
                    </div>
                    <div>
                        <a href="/users/logout">
                        </a>
                    </div>
                </div>

                <!-- Profile Section Title with modern design -->
                <div style="margin-bottom: 25px;">
                    <h1 style="color: #1e3a8a; font-size: 1.8rem; font-weight: 700; padding-bottom: 8px; position: relative;">
                        My Profile
                        <div style="position: absolute; bottom: 0; left: 0; width: 120px; height: 3px; background: linear-gradient(to right, #3b82f6, transparent);"></div>
                    </h1>
                </div>

                <!-- Profile Information Grid with tabs-like visual -->
                <div style="background: linear-gradient(to bottom right, #f8fafc, #ffffff); padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03); border: 1px solid #e2e8f0;">
                    <div class="row g-4 mb-3">
                        <div class="col-md-6 d-flex align-items-center">
                            <label class="fw-medium" style="width: 100px; color: #1e3a8a; font-size: 0.95rem;">
                                <i class="bi bi-person me-2"></i>Name:
                            </label>
                            <span style="color: #334155; font-size: 0.95rem; flex-grow: 1; font-weight: 500; background: #ffffff; padding: 12px 16px; border-radius: 6px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02); transition: all 0.3s ease;"
                                onmouseover="this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.06)'; this.style.borderColor='#d1d5db';"
                                onmouseout="this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.02)'; this.style.borderColor='#e5e7eb';">
                                <?= htmlspecialchars($user['name'] ?? 'Unnamed User', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <label class="fw-medium" style="width: 100px; color: #1e3a8a; font-size: 0.95rem;">
                                <i class="bi bi-briefcase me-2"></i>Role:
                            </label>
                            <span style="color: #334155; font-size: 0.95rem; flex-grow: 1; font-weight: 500; background: #ffffff; padding: 12px 16px; border-radius: 6px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02); transition: all 0.3s ease;"
                                onmouseover="this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.06)'; this.style.borderColor='#d1d5db';"
                                onmouseout="this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.02)'; this.style.borderColor='#e5e7eb';">
                                <?= htmlspecialchars($user['role'] ?? 'No Role', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 d-flex align-items-center">
                            <label class="fw-medium" style="width: 100px; color: #1e3a8a; font-size: 0.95rem;">
                                <i class="bi bi-envelope me-2"></i>Email:
                            </label>
                            <span style="color: #334155; font-size: 0.95rem; flex-grow: 1; font-weight: 500; background: #ffffff; padding: 12px 16px; border-radius: 6px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02); transition: all 0.3s ease;"
                                onmouseover="this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.06)'; this.style.borderColor='#d1d5db';"
                                onmouseout="this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.02)'; this.style.borderColor='#e5e7eb';">
                                <?= htmlspecialchars($user['email'] ?? 'No Email', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Decorative element at the bottom -->
                <div class="d-flex justify-content-center mt-4">
                    <div style="width: 60px; height: 4px; background: #e2e8f0; border-radius: 2px; margin: 0 2px;"></div>
                    <div style="width: 20px; height: 4px; background: #3b82f6; border-radius: 2px; margin: 0 2px;"></div>
                    <div style="width: 60px; height: 4px; background: #e2e8f0; border-radius: 2px; margin: 0 2px;"></div>
                </div>
            </div>
        </div>
    </main>
<?php else: ?>
    <?php
    header("Location: /users/login");
    exit;
    ?>
<?php endif; ?>