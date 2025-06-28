<?php
session_start()
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Weather App</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>

  <header class="navbar">
    <div class="container">
      <a href="index.php" class="logo">Weather App</a>
      <ul class="nav-links">
        <li><a href="Controller/forecastController.php">5-Day Forecast</a></li>
        <li><a href="Controller/historicalWeatherController.php">Historical Weather</a></li>
        <!-- Conditionally show profile link for logged in user -->
        <?php 
          if(isset($_SESSION['user'])){
        ?>
          <li><a href="View/profileView.php">Profile</a></li>
        <?php  } ?>
      </ul>
    </div>
  </header>

  <main class="main-content">
    <div class="container">
      <div class="hero-section">
        <h1 class="hero-title">Weather App</h1>
        <p class="hero-subtitle">Get accurate weather information and historical data</p>
        
        <!-- Login Form -->
        <div class="login-container">
          <div class="login-card">
            <h2 class="login-title">Login to Continue</h2>
            <form class="login-form" action="Controller/loginController.php" method="POST">
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" required>
              </div>
              
              <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
              </div>

              <!-- Show error message if any -->
              <?php 
                if(isset($_SESSION['error'])){
              ?>
                <p class="error"><?php echo $_SESSION['error']; ?></p>
              <?php  } ?>
              
              <input type="submit" name="login" value="Login" class="btn btn-primary btn-full">
              
              <div class="form-footer">
                <a href="#" class="signup-link">Don't have an account? Sign up</a>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </main>

  <style>
    .login-container {
      max-width: 400px;
      margin: 3rem auto 0;
    }

    .login-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 2.5rem;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .login-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--foreground);
      text-align: center;
      margin-bottom: 2rem;
    }

    .login-form {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .form-label {
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--foreground);
      margin-bottom: 0.25rem;
    }

    .form-input {
      padding: 0.875rem 1rem;
      border: 1px solid var(--border);
      border-radius: 8px;
      background: var(--input);
      color: var(--foreground);
      font-size: 1rem;
      transition: all 0.2s ease;
    }

    .form-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px var(--ring);
    }

    .form-input::placeholder {
      color: var(--muted-foreground);
    }

    .btn-full {
      width: 100%;
      padding: 0.875rem 1rem;
      font-size: 1rem;
      font-weight: 600;
      margin-top: 0.5rem;
    }

    .form-footer {
      text-align: center;
      margin-top: 1rem;
    }

    .signup-link {
      font-size: 0.9rem;
      color: var(--muted-foreground);
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .signup-link:hover {
      color: var(--primary);
      text-decoration: underline;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
      .login-container {
        margin: 2rem 1rem 0;
        max-width: none;
      }

      .login-card {
        padding: 2rem;
      }

      .login-title {
        font-size: 1.3rem;
      }
    }

    /* Form validation styles */
    .form-input:invalid {
      border-color: var(--destructive);
    }

    .form-input:valid {
      border-color: var(--chart-2);
    }

    .signup-link:focus {
      outline: 2px solid var(--ring);
      outline-offset: 2px;
      border-radius: 4px;
    }
  </style>
</body>
</html>