<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
    }

    .form-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        max-width: 400px;
        margin: auto;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        width: 100%;
    }

    .form-label {
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #007bff;
        border-radius: 5px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #0056b3;
        outline: none;
    }

    .btn {
        background-color: #007bff;
        color: white;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        padding: 10px;
        transition: background-color 0.3s;
        width: 100%;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #007bff !important;
        border-radius: 5px;
        height: 38px !important;
        padding: 8px;
        background-color: white;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:hover {
        border-color: #007bff !important;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Product Sale</h1>
    </div>

    <form action="/input_products/updateSale/<?= htmlspecialchars($sale['id'] ?? ''); ?>" method="post">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="sale_id" value="<?= htmlspecialchars($sale['id'] ?? ''); ?>">

        <div class="form-container">
            <div class="form-group">
                <label for="productSelect" class="form-label">Select Product:</label>
                <select class="form-control select2" id="productSelect" name="product_id" required>
                    <option></option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id']; ?>" <?= ($sale['product_id'] ?? '') == $product['id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($product['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" step="1" value="<?= htmlspecialchars($sale['quantity'] ?? ''); ?>" required>
            </div>

            <button type="submit" class="btn">Update Sale</button>
            <a href="/input_products/sold_product" class="btn btn-secondary mt-3">Cancel</a>
        </div>
    </form>
</main>

<script>
    $(document).ready(function () {
        $('#productSelect').select2({
            placeholder: "Select a product",
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 3
        });
    });
</script>