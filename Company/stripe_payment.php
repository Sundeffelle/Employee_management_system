<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Subscription Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url("../img/pinkbackground.jpeg") no-repeat center center/cover;
        }
        .card {
            width: 320px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }
        .card h5 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #333;
        }
        .card p {
            font-size: 1em;
            margin: 10px 0;
            color: #555;
        }
        .card button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .card button:hover {
            background: #0056b3;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="card">
        <h5>PowerFlow</h5>
        <p>$48 per month / $482 per year</p>
        <form method="POST" action="starter_option_form.php">
            <p>PowerFlow Subscription $48 per month / $482 per year</p>
            <button type="submit">Subscribe</button>
        </form>
    </div>
</body>
</html>
