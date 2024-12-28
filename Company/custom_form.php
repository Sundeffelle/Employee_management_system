<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Hovering Card Form</title>
    <style>
        body {
            background-color: #f8f9fa; /* Light background for contrast */
            background: url("../img/blue-pink.jpg") no-repeat center center/cover;
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff; /* White background for the card */
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1); /* Soft shadow */
            border-radius: 10px; /* Rounded corners */
            padding: 20px 30px;
            max-width: 400px;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Hover effect transition */
        }

        form:hover {
            transform: translateY(-10px); /* Lifts the card on hover */
            box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.2); /* Darker shadow on hover */
        }

        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333333;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5); /* Highlight border on focus */
        }

        .btn-select {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-select:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .text-center {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<form action="custom_flow_handler.php" method="POST">
    <div class="mb-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text" id="full_name" name="full_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="contact" class="form-label">Your Contact</label>
        <input type="number" id="contact" name="contact" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="subject" class="form-label">Subject</label>
        <input type="text" id="subject" name="subject" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
    </div>
    <div class="text-center">
        <button type="submit" class="btn-select">Submit Request</button>
    </div>
</form>
</body>
</html>
