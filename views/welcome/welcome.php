<?php session_start(); ?>
<?php if (isset($_SESSION['users']) && $_SESSION['users'] === true): ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#" onclick="showSales('today')">Today</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showSales('week')">This Week</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showSales('month')">This Month</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Sales <span id="sales-period">| Today</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="sales-count"><?php echo $salesToday['total_quantity']; ?> <?php echo $salesToday['total_quantity'] == 1 ? 'item' : ''; ?></h6>
                                <span id="sales-trend" class="text-success small pt-1 fw-bold
                                    <?php echo $salesToday['trend'] === 'increase' ? 'text-success' : ($salesToday['trend'] === 'decrease' ? 'text-danger' : 'text-muted'); ?>">
                                    <?php 
                                    echo $salesToday['trend'] === 'increase' ? '+'. round($salesToday['percentage']) .'%' : 
                                        ($salesToday['trend'] === 'decrease' ? '-'. round($salesToday['percentage']) .'%' : '0%');
                                    ?>
                                </span>
                                <span class="text-muted small pt-2 ps-1" id="sales-change">
                                    <?php echo $salesToday['trend'] !== 'no-change' ? $salesToday['trend'] : 'no-change'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const salesData = {
                    'today': {
                        quantity: '<?php echo $salesToday['total_quantity']; ?>',
                        trend: '<?php echo $salesToday['trend']; ?>',
                        percentage: '<?php echo $salesToday['percentage']; ?>'
                    },
                    'week': {
                        quantity: '<?php echo $salesWeek['total_quantity']; ?>',
                        trend: '<?php echo $salesWeek['trend']; ?>',
                        percentage: '<?php echo $salesWeek['percentage']; ?>'
                    },
                    'month': {
                        quantity: '<?php echo $salesMonth['total_quantity']; ?>',
                        trend: '<?php echo $salesMonth['trend']; ?>',
                        percentage: '<?php echo $salesMonth['percentage']; ?>'
                    }
                };

                function showSales(period) {
                    const data = salesData[period];
                    document.getElementById('sales-period').textContent = '| ' + 
                        (period === 'today' ? 'Today' : period === 'week' ? 'This Week' : 'This Month');
                    
                    document.getElementById('sales-count').textContent = data.quantity + ' ' + 
                        (parseInt(data.quantity) === 1 ? 'item' : 'items');
                    
                    const trendElement = document.getElementById('sales-trend');
                    trendElement.className = 'small pt-1 fw-bold';
                    if (data.trend === 'increase') {
                        trendElement.classList.add('text-success');
                        trendElement.textContent = '+' + Math.round(data.percentage) + '%';
                    } else if (data.trend === 'decrease') {
                        trendElement.classList.add('text-danger');
                        trendElement.textContent = '-' + Math.round(data.percentage) + '%';
                    } else {
                        trendElement.classList.add('text-muted');
                        trendElement.textContent = '0%';
                    }

                    document.getElementById('sales-change').textContent = 
                        data.trend !== 'no-change' ? data.trend : 'no-change';
                }
            </script>

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#" onclick="showRevenue('daily')">Today</a></li>
                    <li><a class="dropdown-item" href="#" onclick="showRevenue('weekly')">This Week</a></li>
                    <li><a class="dropdown-item" href="#" onclick="showRevenue('monthly')">This Month</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Revenue <span id="revenue-period">| Today</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="revenue-amount">$<?php echo number_format($dailySales['total'], 2); ?></h6>
                      <span id="revenue-percentage" class="small pt-1 fw-bold 
                        <?php echo $dailySales['trend'] === 'increase' ? 'text-success' : 'text-danger'; ?>">
                        <?php echo $dailySales['percentage']; ?>%
                      </span>
                      <span id="revenue-trend" class="text-muted small pt-2 ps-1">
                        <?php echo $dailySales['trend']; ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Revenue Card -->

            <script>
              const revenueData = {
                'daily': {
                  total: '<?php echo $dailySales['total']; ?>',
                  percentage: '<?php echo $dailySales['percentage']; ?>',
                  trend: '<?php echo $dailySales['trend']; ?>'
                },
                'weekly': {
                  total: '<?php echo $weeklySales['total']; ?>',
                  percentage: '<?php echo $weeklySales['percentage']; ?>',
                  trend: '<?php echo $weeklySales['trend']; ?>'
                },
                'monthly': {
                  total: '<?php echo $monthlySales['total']; ?>',
                  percentage: '<?php echo $monthlySales['percentage']; ?>',
                  trend: '<?php echo $monthlySales['trend']; ?>'
                }
              };

              function showRevenue(period) {
                const data = revenueData[period];
                document.getElementById('revenue-period').textContent = '| ' +
                  (period === 'daily' ? 'Today' : period === 'weekly' ? 'This Week' : 'This Month');
                document.getElementById('revenue-amount').textContent = '$' + parseFloat(data.total).toFixed(2);
                document.getElementById('revenue-percentage').textContent = data.percentage + '%';
                document.getElementById('revenue-percentage').className = 'small pt-1 fw-bold ' +
                  (data.trend === 'increase' ? 'text-success' : 'text-danger');
                document.getElementById('revenue-trend').textContent = data.trend;
              }
            </script>

            <!-- Profit Card -->
            <div class="col-xxl-4 col-xl-12">
              <div class="card info-card customers-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="javascript:showProfit('today')">Today</a></li>
                    <li><a class="dropdown-item" href="javascript:showProfit('this_week')">This Week</a></li>
                    <li><a class="dropdown-item" href="javascript:showProfit('this_month')">This Month</a></li>
                  </ul>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Profit <span id="profit-period">| Today</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="profit-amount">$0.00</h6>
                      <span class="text-success small pt-1 fw-bold" id="profit-percentage">+0.00%</span>
                      <span class="text-muted small pt-2 ps-1">Profit</span>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Profit Card -->
            
            <script>
              // Define the profit data for different periods
              const profitData = {
                'today': {
                  total: '<?php echo $profitToday; ?>',
                },
                'this_week': {
                  total: '<?php echo $profitThisWeek; ?>',
                },
                'this_month': {
                  total: '<?php echo $profitThisMonth; ?>',
                }
              };

              // Function to update the displayed profit based on the selected period
              function showProfit(period) {
                const data = profitData[period];
                // Update the period text
                document.getElementById('profit-period').textContent = '| ' + 
                  (period === 'today' ? 'Today' : period === 'this_week' ? 'This Week' : 'This Month');
                // Update the profit amount
                document.getElementById('profit-amount').textContent = '$' + parseFloat(data.total).toFixed(2);
              }

              // Initially show profit for 'today'
              showProfit('today');
            </script>

            <!-- Expense Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card expense-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#" onclick="showExpenses('daily')">Today</a></li>
                    <li><a class="dropdown-item" href="#" onclick="showExpenses('weekly')">This Week</a></li>
                    <li><a class="dropdown-item" href="#" onclick="showExpenses('monthly')">This Month</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Expenses <span id="expense-period">| Today</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                      style="width: 60px; height: 60px; background-color: rgba(255, 0, 0, 0.1);">
                      <i class="bi bi-cart text-danger" style="font-size: 30px;"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="expense-amount">$<?php echo number_format($dailyExpenses['total'], 2); ?></h6>
                      <span id="expense-percentage" class="small pt-1 fw-bold 
                                    <?php echo $dailyExpenses['trend'] === 'increase' ? 'text-danger' : 'text-success'; ?>">
                        <?php echo $dailyExpenses['percentage']; ?>%
                      </span>
                      <span id="expense-trend" class="text-muted small pt-2 ps-1">
                        <?php echo $dailyExpenses['trend']; ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Stock quantity -->

            <div class="col-xxl-4 col-md-6">
              <div class="card info-card inventory-card">
                <div class="card-body">
                  <h5 class="card-title">Inventory</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                      style="width: 60px; height: 60px; background-color: rgba(0, 128, 0, 0.1);">
                      <i class="bi bi-box-seam text-success" style="font-size: 30px;"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="total-inventory"><?php echo number_format($totalInventoryQuantity); ?></h6>
                      <span id="inventory-trend" class="text-muted small pt-2 ps-1">Total Stock</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- end stock -->

            <script>
              const expenseData = {
                'daily': {
                  total: '<?php echo $dailyExpenses['total']; ?>',
                  percentage: '<?php echo $dailyExpenses['percentage']; ?>',
                  trend: '<?php echo $dailyExpenses['trend']; ?>'
                },
                'weekly': {
                  total: '<?php echo $weeklyExpenses['total']; ?>',
                  percentage: '<?php echo $weeklyExpenses['percentage']; ?>',
                  trend: '<?php echo $weeklyExpenses['trend']; ?>'
                },
                'monthly': {
                  total: '<?php echo $monthlyExpenses['total']; ?>',
                  percentage: '<?php echo $monthlyExpenses['percentage']; ?>',
                  trend: '<?php echo $monthlyExpenses['trend']; ?>'
                }
              };

              function showExpenses(period) {
                const data = expenseData[period];
                document.getElementById('expense-period').textContent = '| ' +
                  (period === 'daily' ? 'Today' : period === 'weekly' ? 'This Week' : 'This Month');
                document.getElementById('expense-amount').textContent = '$' + parseFloat(data.total).toFixed(2);
                document.getElementById('expense-percentage').textContent = data.percentage + '%';
                document.getElementById('expense-percentage').className = 'small pt-1 fw-bold ' +
                  (data.trend === 'increase' ? 'text-danger' : 'text-success');
                document.getElementById('expense-trend').textContent = data.trend;
              }
            </script>
            <!-- End Expense Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Monthly Sales</h5>
                  <!-- Bar Chart -->
                  <canvas id="barChart" style="max-height: 300px;"></canvas>
                  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      // Get PHP data and convert to JavaScript array
                      const salesData = <?php echo json_encode($monthlySalesData ?? []); ?>;
                      
                      new Chart(document.querySelector('#barChart'), {
                        type: 'bar',
                        data: {
                          labels: [
                            'January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                          ],
                          datasets: [{
                            label: 'Sales Data',
                            data: salesData, // Use the real data
                            backgroundColor: [
                              'rgba(255, 99, 132, 0.5)', 'rgba(255, 159, 64, 0.5)',
                              'rgba(255, 205, 86, 0.5)', 'rgba(75, 192, 192, 0.5)',
                              'rgba(54, 162, 235, 0.5)', 'rgba(153, 102, 255, 0.5)',
                              'rgba(201, 203, 207, 0.5)', 'rgba(255, 87, 51, 0.5)',
                              'rgba(144, 238, 144, 0.5)', 'rgba(0, 191, 255, 0.5)',
                              'rgba(255, 140, 0, 0.5)', 'rgba(127, 255, 212, 0.5)'
                            ],
                            borderColor: [
                              'rgb(255, 99, 132)', 'rgb(255, 159, 64)',
                              'rgb(255, 205, 86)', 'rgb(75, 192, 192)',
                              'rgb(54, 162, 235)', 'rgb(153, 102, 255)',
                              'rgb(201, 203, 207)', 'rgb(255, 87, 51)',
                              'rgb(144, 238, 144)', 'rgb(0, 191, 255)',
                              'rgb(255, 140, 0)', 'rgb(127, 255, 212)'
                            ],
                            borderWidth: 1
                          }]
                        },
                        options: {
                          responsive: true,
                          plugins: {
                            legend: {
                              display: true,
                              position: 'top'
                            },
                            tooltip: {
                              callbacks: {
                                label: function(tooltipItem) {
                                  return 'Sales: $' + tooltipItem.raw.toFixed(2);
                                }
                              }
                            }
                          },
                          scales: {
                            y: {
                              beginAtZero: true,
                              title: {
                                display: true,
                                text: 'Sales Amount ($)'
                              }
                            }
                          }
                        }
                      });
                    });
                  </script>
                  <!-- End Bar Chart -->
                </div>
              </div>
            </div><!-- End Reports -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
          <!-- Top Selling Products -->
          <div class="card shadow-lg border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
              <h5 class="card-title mb-0 text-gray">Top Selling Products</h5>
              <span class="badge bg-success rounded-pill fs-6"><?= count($topSellingProducts) ?> Products</span>
            </div>

            <div class="card-body p-0">
              <?php if (!empty($topSellingProducts)): ?>
                <div class="table-responsive" style="max-height: 460px; overflow-y: auto;">
                  <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light bg-light">
                      <tr>
                        <th scope="col" class="text-center">Image</th>
                        <th scope="col">Product</th>
                        <th scope="col" class="text-center">Price</th>
                        <th scope="col" class="text-center">Sold</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displayLimit = 3;
                      $displayedProducts = array_slice($topSellingProducts, 0, $displayLimit);
                      foreach ($displayedProducts as $product): ?>
                        <tr class="hover-shadow">
                          <td class="text-center">
                            <img src="/views/uploads/<?= htmlspecialchars($product['image']) ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>" 
                                 class="img-thumbnail rounded-circle" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                          </td>
                          <td class="fw-medium align-middle text-dark">
                            <?= htmlspecialchars($product['name']) ?>
                          </td>
                          <td class="text-center align-middle">
                            <span class="badge p-2 fs-6" style="color: green">
                              $<?= number_format($product['price'], 2) ?>
                            </span>
                          </td>
                          <td class="text-center align-middle">
                            <span class="badge bg-warning text-dark p-2 fs-6">
                              <?= htmlspecialchars($product['total_sold']) ?> pcs
                            </span>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <?php if (count($topSellingProducts) > $displayLimit): ?>
                  <div class="text-center mt-3 mb-3">
                    <a href="/sales/top_selling" class="btn btn-primary btn-sm rounded-pill px-4 py-2">
                      See More <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                  </div>
                <?php endif; ?>

              <?php else: ?>
                <div class="text-center p-4">
                  <img src="https://img.freepik.com/free-vector/men-with-shopping-car-business-coins_24877-53519.jpg?t=st=1742283614~exp=1742287214~hmac=c5f1ce28f14338a680d380538c600e25e5a13e6aec0bf9e2a2034d1b4e582083&w=996" 
                       alt="No Top Selling Products" 
                       class="img-fluid mb-3" 
                       style="max-width: 300px;">
                  <div class="alert alert-info m-3 shadow-sm">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>No top-selling products available.</strong>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Low Stock Alert -->
          <div class="card shadow-lg border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
              <h5 class="card-title mb-0 text-gray">Low Stock Alert</h5>
              <span class="badge bg-danger rounded-pill fs-6"><?= $lowStockCount ?> Items Low</span>
            </div>

            <div class="card-body p-0">
              <?php if (!empty($lowStockProducts)): ?>
                <div class="table-responsive" style="max-height: 460px; overflow-y: auto;">
                  <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light bg-light">
                      <tr>
                        <th scope="col" class="text-center">Image</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col" class="text-center">Stock</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displayLimit = 3;
                      $displayedProducts = array_slice($lowStockProducts, 0, $displayLimit);
                      foreach ($displayedProducts as $product): ?>
                        <tr class="hover-shadow">
                          <td class="text-center">
                            <img src="/views/uploads/<?= htmlspecialchars($product['image']) ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>" 
                                 class="img-thumbnail rounded-circle" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                          </td>
                          <td class="fw-medium align-middle text-dark">
                            <?= htmlspecialchars($product['name']) ?>
                          </td>
                          <td class="text-center align-middle">
                            <span class="badge p-2 fs-6" style="color: green">
                              $<?= number_format($product['price']) ?>
                            </span>
                          </td>
                          <td class="text-center align-middle">
                            <span class="badge bg-warning text-dark p-2 fs-6">
                              <?= htmlspecialchars($product['quantity']) ?> pcs
                            </span>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <?php if (count($lowStockProducts) > $displayLimit): ?>
                  <div class="text-center mt-3 mb-3">
                    <a href="/products/low-stock-alert" class="btn btn-primary btn-sm rounded-pill px-4 py-2">
                      See More <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                  </div>
                <?php endif; ?>

              <?php else: ?>
                <div class="text-center p-4">
                  <img src="https://img.freepik.com/free-vector/men-with-shopping-car-business-coins_24877-53519.jpg?t=st=1742283614~exp=1742287214~hmac=c5f1ce28f14338a680d380538c600e25e5a13e6aec0bf9e2a2034d1b4e582083&w=996" 
                       alt="No Low Stock" 
                       class="img-fluid mb-3" 
                       style="max-width: 300px;">
                  <div class="alert alert-success m-3 shadow-sm">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Good news!</strong> No products are low in stock.
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div><!-- End Right side columns -->
      </div>
    </section>
  </main><!-- End #main -->

<?php else: ?>
  <?php $this->redirect('/users/login'); ?>
<?php endif; ?>