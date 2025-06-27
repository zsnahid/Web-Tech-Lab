<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5-Day Weather Forecast</title>
    <style>
        /* ========================================================================
           GLOBAL STYLES
           ======================================================================== */
        
        /* Reset default browser styles and set box-sizing */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        /* Main body styling with gradient background */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        /* Main container for responsive layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* ========================================================================
           HEADER STYLES
           ======================================================================== */
        
        /* Main header styling */
        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        
        /* Main title styling */
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        /* Subtitle styling */
        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        /* ========================================================================
           CAROUSEL/SLIDESHOW STYLES
           ======================================================================== */
        
        /* Main slideshow container with glassmorphism effect */
        .slideshow-container {
            max-width: 900px;
            position: relative;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Individual slide styling - hidden by default */
        .mySlides {
            display: none;
            padding: 40px;
            text-align: center;
            color: white;
            min-height: 500px;
        }
        
        /* Active slide display */
        .mySlides.active {
            display: block;
        }
        
        /* ========================================================================
           DAY HEADER STYLES
           ======================================================================== */
        
        /* Container for day name and date */
        .day-header {
            margin-bottom: 30px;
        }
        
        /* Main day name (e.g., "Monday") */
        .day-name {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        /* Short date format (e.g., "Jun 27") */
        .day-date {
            font-size: 1.2rem;
            opacity: 0.8;
        }
        
        /* ========================================================================
           WEATHER INFO CARD STYLES
           ======================================================================== */
        
        /* Grid container for weather information cards */
        .weather-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        /* Individual weather information card */
        .weather-card {
            background: rgba(255, 255, 255, 0.15);
            padding: 20px;
            border-radius: 15px;
            backdrop-filter: blur(5px);
        }
        
        /* Weather card section headers */
        .weather-card h3 {
            font-size: 1.1rem;
            margin-bottom: 15px;
            opacity: 0.9;
        }
        
        /* Large temperature display with icon */
        .temp-display {
            font-size: 3rem;
            font-weight: bold;
            margin: 10px 0;
        }
        
        /* High/low temperature range display */
        .temp-range {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        
        /* Grid layout for detailed weather information */
        .weather-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            font-size: 0.95rem;
        }
        
        /* Individual detail items (sunrise, sunset, etc.) */
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        
        /* ========================================================================
           NAVIGATION CONTROLS
           ======================================================================== */
        
        /* Previous and Next navigation buttons */
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            margin-top: -22px;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            background-color: rgba(0,0,0,0.3);
            border: none;
        }
        
        /* Position next button on the right side */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }
        
        /* Hover effects for navigation buttons */
        .prev:hover, .next:hover {
            background-color: rgba(0,0,0,0.6);
        }
        
        /* ========================================================================
           DOT INDICATORS
           ======================================================================== */
        
        /* Container for dot navigation indicators */
        .dots-container {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
        }
        
        /* Individual dot indicators for slide navigation */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 5px;
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }
        
        /* Active and hover states for dots */
        .dot.active, .dot:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        /* ========================================================================
           UTILITY STYLES
           ======================================================================== */
        
        /* Slide number indicator (e.g., "1 / 5") */
        .numbertext {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(0,0,0,0.3);
            border-radius: 0 20px 0 10px;
        }
        
        /* Loading state styling */
        .loading {
            text-align: center;
            padding: 50px;
            color: white;
            font-size: 1.2rem;
        }
        
        /* Error state styling */
        .error {
            text-align: center;
            padding: 50px;
            color: #ff6b6b;
            font-size: 1.2rem;
            background: rgba(255, 107, 107, 0.1);
            border-radius: 10px;
            margin: 20px;
        }
        
        /* ========================================================================
           RESPONSIVE DESIGN
           ======================================================================== */
        
        /* Mobile and tablet optimizations */
        @media (max-width: 768px) {
            .slideshow-container {
                margin: 10px;
            }
            
            .mySlides {
                padding: 20px;
            }
            
            .weather-info {
                grid-template-columns: 1fr;
            }
            
            .day-name {
                font-size: 1.5rem;
            }
            
            .temp-display {
                font-size: 2rem;
            }
        }
        
        /* ========================================================================
           ANIMATIONS
           ======================================================================== */
        
        /* Fade transition class for slide changes */
        .fade {
            animation-name: fade;
            animation-duration: 0.5s;
        }
        
        /* Fade animation keyframes */
        @keyframes fade {
            from {opacity: 0.4}
            to {opacity: 1}
        }
    </style>
</head>
<body>
    <!-- ========================================================================
         MAIN CONTENT STRUCTURE
         ======================================================================== -->
    
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
        /* ====================================================================
           GLOBAL VARIABLES
           ==================================================================== */
        
        // Current slide index (1-based, following W3Schools convention)
        let slideIndex = 1;
        
        // Array to store weather forecast data from API
        let forecastData = [];
        
        /* ====================================================================
           INITIALIZATION
           ==================================================================== */
        
        /**
         * Initialize the application when DOM is fully loaded
         */
        document.addEventListener('DOMContentLoaded', function() {
            loadWeatherData();
        });
        
        /* ====================================================================
           DATA LOADING FUNCTIONS
           ==================================================================== */
        
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
        
        /* ====================================================================
           SLIDE GENERATION FUNCTIONS
           ==================================================================== */
        
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
                    </div>
                `;
            });
            
            // Insert generated HTML into the container
            container.innerHTML = slidesHtml;
            
            // Hide loading indicator and show the slides
            document.getElementById('loading').style.display = 'none';
            document.getElementById('slides-container').style.display = 'block';
        }
        
        /* ====================================================================
           SLIDESHOW NAVIGATION FUNCTIONS (Based on W3Schools Guide)
           ==================================================================== */
        
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
        
        /* ====================================================================
           KEYBOARD NAVIGATION
           ==================================================================== */
        
        /**
         * Enable keyboard navigation for the slideshow
         * Left arrow = previous slide, Right arrow = next slide
         */
        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowLeft') {
                plusSlides(-1);  // Go to previous slide
            } else if (event.key === 'ArrowRight') {
                plusSlides(1);   // Go to next slide
            }
        });
    </script>
</body>
</html>
