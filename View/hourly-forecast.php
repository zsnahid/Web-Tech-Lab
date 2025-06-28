<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hourly Weather Forecast</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="styles/hourly-forecast.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>24-Hour Weather Forecast</h1>
            <a href="../Controller/ForecastController.php" class="back-btn">← Back to 5-Day Forecast</a>
        </header>

        <main>
            <!-- Precipitation Chart Section -->
            <section class="chart-section">
                <h2>Precipitation Probability</h2>
                <div class="chart-container">
                    <canvas id="precipitationChart"></canvas>
                </div>
            </section>

            <!-- Hourly Forecast Table -->
            <section class="hourly-section">
                <h2>Hourly Details</h2>
                <?php if (isset($hourlyForecast) && is_array($hourlyForecast)): ?>
                    <div class="table-container">
                        <table class="hourly-table">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Temperature</th>
                                    <th>Wind Speed</th>
                                    <th>UV Index</th>
                                    <th>Precipitation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hourlyForecast as $hour): ?>
                                    <tr>
                                        <td class="time-cell">
                                            <?php 
                                            $time = new DateTime($hour['time']);
                                            echo $time->format('H:i');
                                            ?>
                                        </td>
                                        <td class="temp-cell"><?php echo $hour['temperature_celsius']; ?>°C</td>
                                        <td class="wind-cell">💨 <?php echo $hour['wind_speed_kmh']; ?> km/h</td>
                                        <td class="uv-cell">☀️ <?php echo $hour['uv_index']; ?></td>
                                        <td class="rain-cell">🌧️ <?php echo $hour['precipitation_probability_percent']; ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="error">
                        <p><?php echo isset($error) ? htmlspecialchars($error) : 'No hourly forecast data available.'; ?></p>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <script>
        // Prepare chart data
        const hourlyData = <?php echo isset($hourlyForecast) ? json_encode($hourlyForecast) : '[]'; ?>;
        
        // Extract data for chart
        const labels = hourlyData.map(hour => {
            const time = new Date(hour.time);
            return time.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        });
        
        const precipitationData = hourlyData.map(hour => hour.precipitation_probability_percent);

        // Create precipitation chart
        const ctx = document.getElementById('precipitationChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Precipitation Probability (%)',
                    data: precipitationData,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>
</html>