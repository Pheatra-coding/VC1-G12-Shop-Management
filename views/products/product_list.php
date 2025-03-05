<main id="main" class="main">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom styles for specific adjustments */
        .table-container {
            max-width: 1000px;
            margin: 20px auto;
        }

        .table-image {
            width: 30px;
            height: 30px;
        }

        .action-dropdown {
            border: none;
            background: none;
            padding: 0;
        }

        .action-dropdown:focus {
            box-shadow: none;
        }
    </style>
    </head>

    <body>
        <h1 class="mb-4">Data Table</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary">Add Product</button>
            <div class="input-group w-50">
                <input type="text" id="searchInput" class="form-control" placeholder="Search Product" onkeyup="searchTable()">
                <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th style="width: 10%;">Image</th>
                    <th>Name</th>
                    <th>End Date</th>
                    <th>Barcode</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
</main>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.querySelector(".form-control.w-25");
        const tableRows = document.querySelectorAll("tbody tr");

        searchInput.addEventListener("input", function() {
            const searchText = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const rowText = row.innerText.toLowerCase();
                row.style.display = rowText.includes(searchText) ? "" : "none";
            });
        });
    });
</script>