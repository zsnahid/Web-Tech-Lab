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
        <li><a href="Controller/historicalWeatherController.php">Historical Weather</a></li>
      </ul>
    </div>
  </header>

  <main class="main-content">
    <div class="container">
      <div class="hero-section">
        <h1 class="hero-title">Weather App</h1>
        <p class="hero-subtitle">Get accurate weather information and historical data</p>
        <div class="hero-actions">
          <a href="Controller/historicalWeatherController.php" class="btn btn-primary">View Historical Weather</a>
        </div>
      </div>
    </div>
  </main>
</body>
</html>