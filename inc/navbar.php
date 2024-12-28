<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management System</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="shortcut icon" href="/img/patmacyechlogo.jpeg">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="">
            <i class="fa-solid fa-users"></i> 
            <?php 
            
            if (isset($_SESSION['company_name'])) {
                echo htmlspecialchars($_SESSION['company_name']); 
            } else {
                echo "Management System"; // Fallback if not logged in
            }
            ?>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link" href="main_page.php"><i class="fa-solid fa-list fa-lg"></i> Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="login.php"><i class="fa-solid fa-plus fa-lg"></i> Login</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
</body>
</html>
