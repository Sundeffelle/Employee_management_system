<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StarterFlow Subscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .subscription-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .subscription-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-check-label {
            font-size: 1.1rem;
            color: #495057;
        }

        .form-check-input:checked + .form-check-label {
            font-weight: bold;
            color: #007bff;
        }

        h2 {
            font-weight: 600;
            color: #343a40;
        }

        p {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card subscription-card p-4 border-0 shadow-lg" style="max-width: 500px;">
            <h2 class="text-center">StarterFlow Subscription</h2>
            <p class="text-center">Select a subscription plan to proceed with payment:</p>
            <form id="payment-form" action="checkout.php" method="GET" class="mt-4">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_type" id="monthly" value="monthly" checked>
                    <label class="form-check-label" for="monthly">
                        Monthly Plan - <strong>$27</strong>
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_type" id="yearly" value="yearly">
                    <label class="form-check-label" for="yearly">
                        Yearly Plan - <strong>$280</strong>
                    </label>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Proceed to Payment</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
