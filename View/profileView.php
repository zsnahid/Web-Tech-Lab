<?php
  session_start();
  if(isset($_SESSION['user'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Management</title>
  <link rel="stylesheet" href="../index.css">
</head>
<body>
  <header class="navbar">
    <div class="container">
      <a href="../index.php" class="logo">Weather App</a>
      <ul class="nav-links">
        <li><a href="../index.php">Home</a></li>
        <li><a href="forecastController.php">5-Day Forecast</a></li>
        <li><a href="historicalWeatherController.php">Historical Weather</a></li>
      </ul>
    </div>
  </header>
  
  <main class="main-content">
    <div class="container">
        <h1 class="profile-title">Manage Profile</h1>
        <form action="../Controller/logoutController.php">
          <input type="submit" name="logout" value='Logout' class="btn btn-secondary">
        </form>
    </div>
  </main>
</body>
</html>

<?php }
else{
  header('location: ../index.php');
}
?>