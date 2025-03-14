<main id="main" class="main">
    <div class="pagetitle">
        <h1>Input Product Sale</h1>
    </div>
    <!-- Products Creation Form -->
    <form action="" method="post" enctype="multipart/form-data">
        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="">

        

        <div class="row">
            <!-- First Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="endDate" class="form-label">Sale Date:</label>
                    <input type="date" class="form-control" id="endDate" name="end_date" required>
                </div>

                <div class="mb-3">
                    <label for="barcode" class="form-label">Barcode:</label>
                    <input type="text" class="form-control" id="barcode" placeholder="Enter barcode" name="barcode" required>
                </div>
            </div>

            <!-- Second Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="price" class="form-label">Price($):</label>
                    <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" step="1" required>
                </div>
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>


    <!-- sole products -->
        <div class="pagetitle mt-4">
            <h1>Products Sale</h1>
        </div>
                 <div class="d-flex justify-content-end mb-3">
                    <div class="input-group w-50">
                        <input
                            type="text"
                            id="searchInput"
                            class="form-control"
                            placeholder="Search product..."
                            onkeyup="searchTable()">
                        <button class="btn btn-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            <div class="table-responsive">
                <table id="productTable" class="table" style="vertical-align: middle;">
                    <thead>
                        <tr>
                            <th>Sale Date</th>
                            <th>Price</th>
                            <th>Barcode</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                     
                    </tbody>
                </table>
            </div>
</main>