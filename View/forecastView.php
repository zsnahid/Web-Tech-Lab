<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>5-Day Weather Forecast</title>
  <link rel="stylesheet" href="../index.css">
  <style>
    /* Slideshow container */
    .slideshow-container {
      max-width: 800px;
      position: relative;
      margin: auto;
      background: var(--card);
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid var(--border);
    }

    /* Hide all slides by default */
    .mySlides {
      display: none;
      padding: 2rem;
      text-align: center;
      min-height: 400px;
    }

    /* Show the first slide */
    .mySlides.active {
      display: block;
    }

    /* Slide content */
    .slide-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin-top: 1rem;
    }

    .weather-detail {
      background: var(--secondary);
      padding: 1rem;
      border-radius: 8px;
      border: 1px solid var(--border);
    }

    .weather-detail h3 {
      font-size: 0.9rem;
      color: var(--muted-foreground);
      margin-bottom: 0.5rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .weather-detail p {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--foreground);
      margin: 0;
    }

    .slide-date {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 0.5rem;
    }

    .slide-summary {
      font-size: 1.1rem;
      color: var(--muted-foreground);
      margin-bottom: 1.5rem;
    }

    /* Next & previous buttons */
    .prev, .next {
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      margin-top: -22px;
      padding: 16px;
      color: var(--foreground);
      font-weight: bold;
      font-size: 18px;
      transition: 0.3s ease;
      border-radius: 0 3px 3px 0;
      background-color: var(--muted);
      user-select: none;
      border: 1px solid var(--border);
    }

    /* Position the "next button" to the right */
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }

    /* On hover, add a background color */
    .prev:hover, .next:hover {
      background-color: var(--primary);
      color: var(--primary-foreground);
    }

    /* The dots/bullets/indicators */
    .dots-container {
      text-align: center;
      padding: 1rem;
      background: var(--muted);
    }

    .dot {
      cursor: pointer;
      height: 15px;
      width: 15px;
      margin: 0 5px;
      background-color: var(--muted-foreground);
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.3s ease;
      border: 2px solid var(--border);
    }

    .dot.active, .dot:hover {
      background-color: var(--primary);
    }

    /* Forecast header */
    .forecast-header {
      text-align: center;
      margin: 2rem 0;
    }

    .forecast-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--foreground);
      margin-bottom: 0.5rem;
    }

    .forecast-subtitle {
      font-size: 1.1rem;
      color: var(--muted-foreground);
    }

    /* Temperature styling */
    .temperature {
      color: var(--chart-1);
    }

    .precipitation {
      color: var(--chart-3);
    }

    .wind {
      color: var(--chart-4);
    }

    .uv {
      color: var(--chart-2);
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
      .slideshow-container {
        margin: 1rem;
      }

      .mySlides {
        padding: 1rem;
        min-height: 350px;
      }

      .slide-content {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
      }

      .slide-date {
        font-size: 1.5rem;
      }

      .forecast-title {
        font-size: 2rem;
      }

      .prev, .next {
        padding: 12px;
        font-size: 16px;
      }
    }
  </style>
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
      <div class="forecast-header">
        <h1 class="forecast-title">5-Day Weather Forecast</h1>
        <p class="forecast-subtitle">Navigate through the next 5 days of weather predictions</p>
      </div>

      <!-- Slideshow container -->
      <div class="slideshow-container">
        <?php if(isset($forecastData) && count($forecastData) > 0): ?>
          <?php foreach($forecastData as $index => $forecast): ?>
            <div class="mySlides <?php echo $index === 0 ? 'active' : ''; ?>">
              <div class="slide-date">
                <?php echo date('l, M d Y', strtotime($forecast['forecast_date'])); ?>
              </div>
              <div class="slide-summary">
                <?php echo htmlspecialchars($forecast['weather_summary']); ?>
              </div>
              
              <div class="slide-content">
                <div class="weather-detail">
                  <h3>High Temperature</h3>
                  <p class="temperature"><?php echo $forecast['max_temperature_celsius']; ?>°C</p>
                </div>
                
                <div class="weather-detail">
                  <h3>Low Temperature</h3>
                  <p class="temperature"><?php echo $forecast['min_temperature_celsius']; ?>°C</p>
                </div>
                
                <div class="weather-detail">
                  <h3>Precipitation</h3>
                  <p class="precipitation"><?php echo $forecast['precipitation_probability_percent']; ?>%</p>
                </div>
                
                <div class="weather-detail">
                  <h3>Max Wind Speed</h3>
                  <p class="wind"><?php echo $forecast['wind_speed_max_kmh']; ?> km/h</p>
                </div>
                
                <div class="weather-detail">
                  <h3>UV Index</h3>
                  <p class="uv"><?php echo $forecast['uv_index_max']; ?></p>
                </div>
              </div>
              
              <div style="margin-top: 1.5rem;">
                <a href="hourlyForecastController.php" class="btn btn-primary">
                  📊 Hourly Forecast
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="mySlides active">
            <div class="slide-date">No Forecast Data</div>
            <div class="slide-summary">No weather forecast data is currently available.</div>
          </div>
        <?php endif; ?>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
      </div>

      <!-- The dots/circles for the slides -->
      <div class="dots-container">
        <?php if(isset($forecastData) && count($forecastData) > 0): ?>
          <?php foreach($forecastData as $index => $forecast): ?>
            <span class="dot <?php echo $index === 0 ? 'active' : ''; ?>" onclick="currentSlide(<?php echo $index + 1; ?>)"></span>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <script>
    let slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      
      if (n > slides.length) { slideIndex = 1; }
      if (n < 1) { slideIndex = slides.length; }
      
      // Hide all slides
      for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
      }
      
      // Remove active class from all dots
      for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
      }
      
      // Show current slide and highlight current dot
      if (slides.length > 0) {
        slides[slideIndex - 1].classList.add("active");
      }
      if (dots.length > 0) {
        dots[slideIndex - 1].classList.add("active");
      }
    }

    // Auto slide every 10 seconds
    setInterval(function() {
      plusSlides(1);
    }, 10000);

    // Keyboard navigation
    document.addEventListener('keydown', function(event) {
      if (event.key === 'ArrowLeft') {
        plusSlides(-1);
      } else if (event.key === 'ArrowRight') {
        plusSlides(1);
      }
    });
  </script>
</body>
</html>
