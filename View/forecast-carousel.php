<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5-Day Weather Forecast</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../View/styles/forecast-carousel.css">
</head>
<body>
    <!-- Main container for the entire application -->
    <div class="container">
        
        <!-- Application header with title and location -->
        <div class="header">
            <h1>🌤️ 5-Day Weather Forecast</h1>
            <p>Dhaka, Bangladesh</p>
        </div>
        
        <!-- Main slideshow/carousel container -->
        <div class="slideshow-container">
            
            <!-- Loading indicator (shown while data is being fetched) -->
            <div id="loading" class="loading">
                <p>Loading weather data... ⏳</p>
            </div>
            
            <!-- Error display (shown if PHP encounters an error) -->
            <?php if (isset($error)): ?>
                <div class="error">
                    <p>❌ Error loading weather data: <?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Dynamic slides container (populated by JavaScript) -->
            <div id="slides-container" style="display: none;"></div>
            
            <!-- Navigation arrows for manual slide control -->
            <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
            <button class="next" onclick="plusSlides(1)">&#10095;</button>
        </div>
        
        <!-- Dot indicators for direct slide navigation -->
        <div class="dots-container">
            <!-- Individual dot indicators (one for each of 5 days) -->
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
            <span class="dot" onclick="currentSlide(5)"></span>
        </div>
    </div>

    <script>
        // Current slide index (1-based, following W3Schools convention)
        let slideIndex = 1;
        
        // Array to store weather forecast data from API
        let forecastData = [];
        
        /**
         * Initialize the application when DOM is fully loaded
         */
        document.addEventListener('DOMContentLoaded', function() {
            loadWeatherData();
        });
        
        /**
         * Asynchronously loads weather data from the PHP controller
         * Handles both successful responses and error conditions
         */
        async function loadWeatherData() {
            try {
                // Make AJAX request to get forecast data
                const response = await fetch('<?php echo $_SERVER['PHP_SELF']; ?>?action=getForecast');
                
                // Check if the HTTP request was successful
                if (!response.ok) {
                    throw new Error('Failed to fetch weather data');
                }
                
                // Parse JSON response
                forecastData = await response.json();
                
                // Check if the API returned an error
                if (forecastData.error) {
                    throw new Error(forecastData.error);
                }
                
                // Generate HTML slides from the data and display first slide
                renderSlides();
                showSlides(slideIndex);
                
            } catch (error) {
                // Log error and display user-friendly message
                console.error('Error loading weather data:', error);
                document.getElementById('loading').innerHTML = 
                    '<p>❌ Error loading weather data: ' + error.message + '</p>';
            }
        }
        
        /**
         * Generates HTML content for all 5 weather slides
         * Creates structured cards with weather information for each day
         */
        function renderSlides() {
            const container = document.getElementById('slides-container');
            let slidesHtml = '';
            
            // Loop through each day's forecast data
            forecastData.forEach((day, index) => {
                // Calculate average temperature for display
                const avgTemp = Math.round((day.temp_max + day.temp_min) / 2);
                
                // Simple weather icon based on UV index
                const mainIcon = day.uv_index > 5 ? '☀️' : '🌤️';
                
                // Build HTML structure for this slide
                slidesHtml += `
                    <div class="mySlides fade">
                        <!-- Slide counter (e.g., "1 / 5") -->
                        <div class="numbertext">${index + 1} / 5</div>
                        
                        <!-- Day name and date header -->
                        <div class="day-header">
                            <div class="day-name">${day.day_name}</div>
                            <div class="day-date">${day.day_short}</div>
                        </div>
                        
                        <!-- Weather information grid -->
                        <div class="weather-info">
                            <!-- Temperature card -->
                            <div class="weather-card">
                                <h3>🌡️ Temperature</h3>
                                <div class="temp-display">${mainIcon} ${avgTemp}°C</div>
                                <div class="temp-range">
                                    High: ${day.temp_max}°C | Low: ${day.temp_min}°C
                                </div>
                            </div>
                            
                            <!-- Detailed weather information card -->
                            <div class="weather-card">
                                <h3>📊 Details</h3>
                                <div class="weather-details">
                                    <!-- Individual weather detail items -->
                                    <div class="detail-item">
                                        <span>🌅 Sunrise:</span>
                                        <span>${day.sunrise}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span>🌇 Sunset:</span>
                                        <span>${day.sunset}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span>☀️ UV Index:</span>
                                        <span>${day.uv_index}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span>💨 Wind Speed:</span>
                                        <span>${day.wind_speed} km/h</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hourly forecast button -->
                        <div class="hourly-button-container">
                            <a href="ForecastController.php?action=hourly" class="hourly-button">
                                Hourly Forecast
                            </a>
                        </div>
                    </div>
                `;
            });
            
            // Insert generated HTML into the container
            container.innerHTML = slidesHtml;
            
            // Hide loading indicator and show the slides
            document.getElementById('loading').style.display = 'none';
            document.getElementById('slides-container').style.display = 'block';
        }

        /**
         * Navigate to next/previous slide
         * @param {number} n - Number of slides to move (1 for next, -1 for previous)
         */
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }
        
        /**
         * Navigate directly to a specific slide
         * @param {number} n - Slide number to show (1-based index)
         */
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }
        
        /**
         * Display the specified slide and update navigation indicators
         * Core slideshow logic following W3Schools pattern
         * @param {number} n - Slide number to display (1-based index)
         */
        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            
            // Handle wrap-around: if past last slide, go to first
            if (n > slides.length) { slideIndex = 1 }
            
            // Handle wrap-around: if before first slide, go to last
            if (n < 1) { slideIndex = slides.length }
            
            // Hide all slides
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            
            // Remove active class from all dots
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            
            // Show the current slide and activate corresponding dot
            if (slides[slideIndex - 1]) {
                slides[slideIndex - 1].style.display = "block";
                dots[slideIndex - 1].className += " active";
            }
        }
    </script>
</body>
</html>
