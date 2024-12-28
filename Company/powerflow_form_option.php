<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerFlow Subscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-lg p-4" style="max-width: 500px; border-radius: 12px;">
            <h2 class="text-center text-primary">PowerFlow Subscription</h2>
            <p class="text-center text-muted">Choose a payment plan to proceed:</p>
            <form id="payment-form" action="power_flow.php" method="GET" class="mt-4">
                <!-- Payment Plan Options -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_type" id="monthly" value="monthly" checked>
                    <label class="form-check-label" for="monthly">
                        <strong>Monthly Plan:</strong> $48
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_type" id="yearly" value="yearly">
                    <label class="form-check-label" for="yearly">
                        <strong>Yearly Plan:</strong> $482
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Proceed to Payment</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
