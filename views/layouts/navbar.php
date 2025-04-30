<style>
  /* Active link styling */
.sidebar-nav .nav-link.active {
  background-color:#f6f9ff !important;  /* Lighter background color */
  color: #4154f1 !important;  /* Icon color adjusted to match text */
}

 /* Add to your existing style block */
  body.locked-customer-view {
    overflow: hidden;
  }
  
  body.locked-customer-view #header,
  body.locked-customer-view #sidebar,
  body.locked-customer-view .toggle-sidebar-btn {
    display: none !important;
  }
  
  body.locked-customer-view .main {
    margin-left: 0 !important;
    padding-top: 0 !important;
    width: 100% !important;
    max-width: 100% !important;
  }
  
  /* Exit button styling */
  .exit-customer-view {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
  }



</style>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']); // Check if user is logged in

// If user is logged in, show the full layout
if ($isLoggedIn): 
?>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <!-- style font-family and font-size -->
    <style>
      th {
        font-family: "Nunito", sans-serif;
        font-size:18px;
        height: 9vh;
      }

      th,
      td {
          vertical-align: middle;
          /* Ensure content is aligned properly */
        }

      td {
        font-family: "Nunito", sans-serif;
        font-size: 15px;
      }

      .btn {
        font-family: "Nunito", sans-serif;
      }
    </style>
<!-- logo  -->
    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img src="/views/assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Shop Management</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <!-- Ensure the image is styled as a rounded circle -->
        <img src="/views/uploads/<?php echo isset($_SESSION['user_image']) ? htmlspecialchars($_SESSION['user_image']) : 'https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png'; ?>" alt="Profile" class="rounded-circle" style="width: 38px; height: 40px; object-fit: cover; border-radius: 50%;">
        <span class="d-none d-md-block dropdown-toggle ps-2">
            <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest'; ?>
        </span>
    </a><!-- End Profile Image Icon -->

    <ul class="dropdown-menu dropdown-menu-end  profile">
        <li class="dropdown-header">
            <h6><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest'; ?></h6>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        <li>
            <hr class="dropdown-divider">
        </li>

        <li>
              <a class="dropdown-item d-flex align-items-center" href="/users/profile">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>

        <li>
            <a class="dropdown-item d-flex align-items-center" href="/users/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </li>
    </ul><!-- End Profile Dropdown Items -->
</li><!-- End Profile Nav -->


      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link collapsed"  href="/">
    <i class="bi bi-speedometer2"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  
  <li class="nav-item">
     <a class="nav-link collapsed" href="/scan_barcodes/barcode">
    <i class="bi bi-box-seam"></i><span>Sold Products</span>
    </a>
  </li><!-- End Forms Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-layout-text-window-reverse"></i><span>All Products</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a class="nav-link collapsed" href="/sales/top_selling">
          <i class="bi bi-circle"></i><span>Top Selling</span>
        </a>
      </li>
      <li>
      <a class="nav-link collapsed" href="/sales/low_selling">
          <i class="bi bi-circle"></i><span>Low Selling</span>
        </a>
      </li>
      <li>
      <a class="nav-link collapsed" href="/products/product_expiring">
          <i class="bi bi-circle"></i><span>Expiring Inventory</span>
        </a>
      </li>
      <li>
        <a class="nav-link collapsed" href="/products/low-stock-alert">
          <i class="bi bi-circle"></i><span>Low Stock Products</span>
        </a>
      </li>
    </ul>
  </li><!-- End Tables Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="/categories">
    <i class="bi bi-grid"></i></i></i><span>Categories</span></i>
    </a>
  </li><!-- End Charts Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="/products">
    <i class="bi bi-table"></i><span>Products</span></i>
    </a>
  </li><!-- End Icons Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="/sold_history/sold_history">
    <i class="bi bi-clock-history"></i>
      <span>Sell History</span>
    </a>
  </li><!-- End Profile Page Nav -->

  <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="/users">
    <i class="bi bi-people-fill"></i>
      <span>Employees</span>
    </a>
  </li><!-- End Profile Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="/users/deleted">
    <i class="bi bi-trash"></i>
      <span>Trash</span>
    </a>
  </li><!-- End Profile Page Nav -->
  <?php endif; ?>
  
<li class="nav-item">
    <a class="nav-link collapsed lock-to-customer-page" href="/scan_barcodes/customer">
    <i class="bi bi-person"></i><span>Costumer</span></i>
    </a>
</li><!-- End Icons Nav -->

</ul>

</aside><!-- End Sidebar-->
<script>
  document.querySelectorAll('.sidebar-nav .nav-link').forEach(function(link) {
  if (link.href === window.location.href) {
    link.classList.add('active');
  }
});

   // Lock to Customer Page functionality
   document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the customer page
    const isCustomerPage = window.location.pathname.includes('/scan_barcodes/customer');
    
    if (isCustomerPage) {
      // Hide header and sidebar
      document.querySelector('body').classList.add('locked-customer-view');
      document.getElementById('header').style.display = 'none';
      document.getElementById('sidebar').style.display = 'none';
      
      // Prevent navigation attempts
      window.addEventListener('beforeunload', function(e) {
        e.preventDefault();
        e.returnValue = 'You are currently locked in Customer view. Are you sure you want to leave?';
        return e.returnValue;
      });
      
      // Disable all navigation links
      document.querySelectorAll('a:not(.lock-to-customer-page)').forEach(link => {
        link.addEventListener('click', function(e) {
          if (!this.href.includes('/scan_barcodes/customer')) {
            e.preventDefault();
            alert('Please exit Customer view first before navigating elsewhere');
          }
        });
      });
    }
  });

</script>

<?php endif; ?>