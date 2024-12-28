<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plan Selection</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/subscription_plan.css">
    <style>
        body {
            background-color: #f8f9fa;
            background: url('../img/pinkbackground.jpeg') center center/cover;
            backdrop-filter: blur(250px);
        }
        .container {
            margin-top: 50px;
        }
        .plan-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .plan-card h5 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #343a40;
        }
        .plan-card ul {
            list-style: none;
            padding: 0;
        }
        .plan-card ul li {
            font-size: 1rem;
            padding: 5px 0;
        }
        .btn-select {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            transition: background-color 0.2s ease;
        }
        .btn-select:hover {
            background-color: #0056b3;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        footer a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
            font-size: 1.2rem;
        }
        footer a:hover {
            color: #0056b3;
        }
        .social-icons {
            margin-top: 10px;
        }
        .social-icons i {
            margin: 0 15px;
            font-size: 1.5rem;
            color: #fff;
            transition: color 0.2s ease;
        }
        .social-icons i:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Testing Plan (Free Version)</h1>
        <div class="row">
            <!-- Testing Plan -->
            <div class="col-md-3 offset-md-3 mb-4">
                <div class="plan-card text-center">
                    <h5>Testing</h5>
                    <p>Free Trial (7 Days)</p>
                    <ul>
                        <li>Basic Features</li>
                        <li>7 Days Unlimited Access</li>
                        <li>Evaluate Before Paying</li>
                    </ul>
                    <form action="free_subscription.php" method="POST">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" readonly>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn-select">Activate Free Trial</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <h1 class="text-center mb-4">Choose Your Subscription Plan</h1>
        <div class="row">
            <!-- StarterFlow Plan -->
            <div class="col-md-3 mb-4">
                <div class="plan-card text-center">
                    <h5>StarterFlow</h5>
                    <p>$27 per month / $280 per year</p>
                    <ul>
                        <li>Basic Features</li>
                        <li>Limited Access</li>
                    </ul>
                    <form action="starter_option_form.php" method="POST">
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                           <!-- <option value="Paystack">Paystack</option> -->
                                <option value="Stripe">Pay With Card</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn-select">Choose StarterFlow</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- GrowthFlow Plan -->
            <div class="col-md-3 mb-4">
                <div class="plan-card text-center">
                    <h5>GrowthFlow</h5>
                    <p>$35 per month / $345 per year</p>
                    <ul>
                        <li>Advanced Features</li>
                        <li>Unlimited Users</li>
                    </ul>
                    <form action="subscription_option_form.php" method="POST">
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                               <!-- <option value="Paystack">Paystack</option> -->
                                <option value="Stripe">Pay With Card</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn-select">Choose GrowthFlow</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- PowerFlow Plan -->
            <div class="col-md-3 mb-4">
                <div class="plan-card text-center">
                    <h5>PowerFlow</h5>
                    <p>$48 per month / $482 per year</p>
                    <ul>
                        <li>All Features</li>
                        <li>Priority Support</li>
                    </ul>
                    <form action="powerflow_form_option.php" method="POST">
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                               <!-- <option value="Paystack">Paystack</option>-->
                                <option value="Stripe">Pay With Card</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn-select">Choose PowerFlow</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- CustomFlow Plan -->
            <div class="col-md-3 mb-4">
                <div class="plan-card text-center">
                    <h5>CustomFlow</h5>
                    <p>Contact Us for Pricing</p>
                    <p>Contact us to discuss your specific 
                        requirements and 
                        receive a customized quote.</p>
                    <ul>
                        
                        <li>Tailored Solutions</li>
                        <li>Custom Integrations</li>
                        <li>Through Any Language</li>
                    </ul>
                    <form action="custom_form.php" method="POST">
                        <div class="mb-3">
                           
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn-select"> <a href="custom_form.php">Choose CustomFlow</button></a> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>Connect with us on social media!</p>
        <div class="social-icons">
            <a href="https://www.facebook.com/patmactechukltd/" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
            <a href="https://www.instagram.com/patmactechukltd/profilecard/?igsh=OWFyaWk4c20zdTF4" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="https://www.tiktok.com/@patmactechukltd?_t=8rrQqTly7yC&_r=1" target="_blank"><i class="fab fa-tiktok"></i> TikTok</a>
            <a href="www.linkedin.com/company/patmactech-uk-ltd" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a>
        </div>
    </footer>
</body>
</html>
