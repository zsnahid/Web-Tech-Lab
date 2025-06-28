<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historical Weather</title>
  <link rel="stylesheet" href="../index.css">
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Date picker CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <style>
    .weather-dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin: 2rem 0;
    }
    
    .weather-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 1.5rem;
      transition: transform 0.3s ease;
    }
    
    .weather-card:hover {
      transform: translateY(-2px);
    }
    
    .card-title {
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--foreground);
      margin-bottom: 1rem;
      border-bottom: 2px solid var(--primary);
      padding-bottom: 0.5rem;
    }
    
    .weather-info {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1rem;
      margin-top: 1rem;
    }
    
    .info-item {
      text-align: center;
      padding: 1rem;
      background: var(--secondary);
      border-radius: 8px;
    }
    
    .info-label {
      font-size: 0.9rem;
      color: var(--muted-foreground);
      margin-bottom: 0.5rem;
    }
    
    .info-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--foreground);
    }
    
    .chart-container {
      position: relative;
      height: 400px;
      margin: 1rem 0;
    }
    
    .form-group {
      margin-bottom: 1rem;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: var(--foreground);
    }
    
    .form-control {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid var(--border);
      border-radius: 6px;
      background: var(--input);
      color: var(--foreground);
      font-size: 1rem;
    }
    
    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px var(--ring);
    }
    
    .comparison-result {
      margin-top: 1rem;
      padding: 1rem;
      background: var(--muted);
      border-radius: 8px;
      display: none;
    }
    
    .record-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.75rem;
      margin: 0.5rem 0;
      background: var(--accent);
      border-radius: 6px;
    }
    
    .record-label {
      font-weight: 500;
      color: var(--accent-foreground);
    }
    
    .record-value {
      font-weight: 700;
      color: var(--chart-1);
    }
    
    .weather-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    
    .weather-table th,
    .weather-table td {
      padding: 0.75rem;
      text-align: left;
      border: 1px solid var(--border);
    }
    
    .weather-table th {
      background: var(--secondary);
      font-weight: 600;
      color: var(--secondary-foreground);
    }
    
    .weather-table tr:nth-child(even) {
      background: var(--muted);
    }
    
    .temperature {
      color: var(--chart-1);
      font-weight: 600;
    }
    
    .humidity {
      color: var(--chart-2);
      font-weight: 600;
    }
    
    .precipitation {
      color: var(--chart-3);
      font-weight: 600;
    }
    
    .wind {
      color: var(--chart-4);
      font-weight: 600;
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
      <div class="hero-section">
        <h1 class="hero-title">Historical Weather Data</h1>
        <p class="hero-subtitle">Explore weather patterns for May 2025</p>
      </div>

      <div class="weather-dashboard">
        <!-- Date Lookup Section -->
        <div class="weather-card">
          <h2 class="card-title">🔍 Look Up Weather by Date</h2>
          <div class="form-group">
            <label for="lookupDate">Select Date:</label>
            <input type="text" id="lookupDate" class="form-control" placeholder="Select a date...">
          </div>
          <button onclick="lookupWeather()" class="btn btn-primary">Look Up Weather</button>
          
          <div id="lookupResult" style="display: none; margin-top: 1rem;">
            <h3>Weather Details</h3>
            <div class="weather-info" id="weatherDetails">
            </div>
          </div>
        </div>

        <!-- Weather Comparison Section -->
        <div class="weather-card">
          <h2 class="card-title">📊 Compare Weather Data</h2>
          <div class="form-group">
            <label for="startDate">Start Date:</label>
            <input type="text" id="startDate" class="form-control" placeholder="Select start date...">
          </div>
          <div class="form-group">
            <label for="endDate">End Date:</label>
            <input type="text" id="endDate" class="form-control" placeholder="Select end date...">
          </div>
          <button onclick="compareWeather()" class="btn btn-secondary">Compare Weather</button>
          
          <div id="comparisonResult" class="comparison-result">
            <h3>Comparison Results</h3>
            <div id="comparisonChart" style="height: 300px;">
              <canvas id="comparisonCanvas"></canvas>
            </div>
          </div>
        </div>

        <!-- Record Highs/Lows Section -->
        <div class="weather-card">
          <h2 class="card-title">🏆 Record Highs & Lows</h2>
          <?php if(isset($recordData)): ?>
          <div class="record-item">
            <span class="record-label">Highest Temperature:</span>
            <span class="record-value temperature"><?php echo $recordData['highest_temp']; ?>°C (<?php echo date('M d', strtotime($recordData['highest_temp_date'])); ?>)</span>
          </div>
          <div class="record-item">
            <span class="record-label">Lowest Temperature:</span>
            <span class="record-value temperature"><?php echo $recordData['lowest_temp']; ?>°C (<?php echo date('M d', strtotime($recordData['lowest_temp_date'])); ?>)</span>
          </div>
          <div class="record-item">
            <span class="record-label">Highest Precipitation:</span>
            <span class="record-value precipitation"><?php echo $recordData['highest_precipitation']; ?>mm</span>
          </div>
          <div class="record-item">
            <span class="record-label">Highest Wind Speed:</span>
            <span class="record-value wind"><?php echo $recordData['highest_wind_speed']; ?> km/h</span>
          </div>
          <div class="record-item">
            <span class="record-label">Highest Humidity:</span>
            <span class="record-value humidity"><?php echo $recordData['highest_humidity']; ?>%</span>
          </div>
          <?php endif; ?>
        </div>

        <!-- Monthly Statistics -->
        <div class="weather-card">
          <h2 class="card-title">📈 Monthly Statistics</h2>
          <?php if(isset($monthlyStats)): ?>
          <div class="weather-info">
            <div class="info-item">
              <div class="info-label">Average Temperature</div>
              <div class="info-value temperature"><?php echo round($monthlyStats['avg_temp'], 1); ?>°C</div>
            </div>
            <div class="info-item">
              <div class="info-label">Average Humidity</div>
              <div class="info-value humidity"><?php echo round($monthlyStats['avg_humidity']); ?>%</div>
            </div>
            <div class="info-item">
              <div class="info-label">Total Precipitation</div>
              <div class="info-value precipitation"><?php echo round($monthlyStats['total_precipitation'], 1); ?>mm</div>
            </div>
            <div class="info-item">
              <div class="info-label">Average Wind Speed</div>
              <div class="info-value wind"><?php echo round($monthlyStats['avg_wind_speed'], 1); ?> km/h</div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Temperature Trend Chart -->
      <div class="weather-card" style="grid-column: 1 / -1;">
        <h2 class="card-title">🌡️ Temperature Trends - May 2025</h2>
        <div class="chart-container">
          <canvas id="temperatureChart"></canvas>
        </div>
      </div>

      <!-- All Weather Data Table -->
      <div class="weather-card" style="grid-column: 1 / -1;">
        <h2 class="card-title">📋 Complete Weather Data</h2>
        <div style="overflow-x: auto;">
          <table class="weather-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Avg Temp (°C)</th>
                <th>Max Temp (°C)</th>
                <th>Min Temp (°C)</th>
                <th>Humidity (%)</th>
                <th>Precipitation (mm)</th>
                <th>Wind Speed (km/h)</th>
                <th>Condition</th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($allWeatherData)): ?>
                <?php while($row = mysqli_fetch_assoc($allWeatherData)): ?>
                <tr>
                  <td><?php echo date('M d, Y', strtotime($row['record_date'])); ?></td>
                  <td class="temperature"><?php echo $row['avg_temperature_celsius']; ?>°C</td>
                  <td class="temperature"><?php echo $row['max_temperature_celsius']; ?>°C</td>
                  <td class="temperature"><?php echo $row['min_temperature_celsius']; ?>°C</td>
                  <td class="humidity"><?php echo $row['avg_humidity_percent']; ?>%</td>
                  <td class="precipitation"><?php echo $row['total_precipitation_mm']; ?>mm</td>
                  <td class="wind"><?php echo $row['avg_wind_speed_kmh']; ?> km/h</td>
                  <td><?php echo $row['weather_condition']; ?></td>
                </tr>
                <?php endwhile; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Initialize date pickers
    flatpickr("#lookupDate", {
      dateFormat: "Y-m-d",
      minDate: "2025-05-01",
      maxDate: "2025-05-31"
    });

    flatpickr("#startDate", {
      dateFormat: "Y-m-d",
      minDate: "2025-05-01",
      maxDate: "2025-05-31"
    });

    flatpickr("#endDate", {
      dateFormat: "Y-m-d",
      minDate: "2025-05-01",
      maxDate: "2025-05-31"
    });

    // Chart data from PHP
    const chartData = <?php echo json_encode($chartData); ?>;

    // Initialize temperature chart
    const ctx = document.getElementById('temperatureChart').getContext('2d');
    const temperatureChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: chartData.map(item => new Date(item.record_date).toLocaleDateString()),
        datasets: [{
          label: 'Average Temperature',
          data: chartData.map(item => item.avg_temperature_celsius),
          borderColor: 'rgb(75, 192, 192)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          tension: 0.1
        }, {
          label: 'Max Temperature',
          data: chartData.map(item => item.max_temperature_celsius),
          borderColor: 'rgb(255, 99, 132)',
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          tension: 0.1
        }, {
          label: 'Min Temperature',
          data: chartData.map(item => item.min_temperature_celsius),
          borderColor: 'rgb(54, 162, 235)',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          tension: 0.1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            text: 'Daily Temperature Variations'
          }
        },
        scales: {
          y: {
            beginAtZero: false,
            title: {
              display: true,
              text: 'Temperature (°C)'
            }
          }
        }
      }
    });

    // Look up weather by date
    async function lookupWeather() {
      const date = document.getElementById('lookupDate').value;
      if (!date) {
        alert('Please select a date');
        return;
      }

      try {
        const response = await fetch(`../Controller/historicalWeatherController.php?action=getWeatherByDate&date=${date}`);
        const data = await response.json();
        
        if (data) {
          document.getElementById('lookupResult').style.display = 'block';
          document.getElementById('weatherDetails').innerHTML = `
            <div class="info-item">
              <div class="info-label">Average Temperature</div>
              <div class="info-value temperature">${data.avg_temperature_celsius}°C</div>
            </div>
            <div class="info-item">
              <div class="info-label">Max Temperature</div>
              <div class="info-value temperature">${data.max_temperature_celsius}°C</div>
            </div>
            <div class="info-item">
              <div class="info-label">Min Temperature</div>
              <div class="info-value temperature">${data.min_temperature_celsius}°C</div>
            </div>
            <div class="info-item">
              <div class="info-label">Humidity</div>
              <div class="info-value humidity">${data.avg_humidity_percent}%</div>
            </div>
            <div class="info-item">
              <div class="info-label">Precipitation</div>
              <div class="info-value precipitation">${data.total_precipitation_mm}mm</div>
            </div>
            <div class="info-item">
              <div class="info-label">Wind Speed</div>
              <div class="info-value wind">${data.avg_wind_speed_kmh} km/h</div>
            </div>
            <div class="info-item" style="grid-column: 1 / -1;">
              <div class="info-label">Condition</div>
              <div class="info-value">${data.weather_condition}</div>
            </div>
          `;
        } else {
          alert('No weather data found for this date');
        }
      } catch (error) {
        alert('Error fetching weather data');
        console.error(error);
      }
    }

    // Compare weather data
    let comparisonChart;
    async function compareWeather() {
      const startDate = document.getElementById('startDate').value;
      const endDate = document.getElementById('endDate').value;
      
      if (!startDate || !endDate) {
        alert('Please select both start and end dates');
        return;
      }

      if (startDate > endDate) {
        alert('Start date must be before end date');
        return;
      }

      try {
        const response = await fetch(`../Controller/historicalWeatherController.php?action=compareWeather&startDate=${startDate}&endDate=${endDate}`);
        const data = await response.json();
        
        if (data && data.length > 0) {
          document.getElementById('comparisonResult').style.display = 'block';
          
          // Destroy existing chart if it exists
          if (comparisonChart) {
            comparisonChart.destroy();
          }
          
          // Create comparison chart
          const compCtx = document.getElementById('comparisonCanvas').getContext('2d');
          comparisonChart = new Chart(compCtx, {
            type: 'bar',
            data: {
              labels: data.map(item => new Date(item.record_date).toLocaleDateString()),
              datasets: [{
                label: 'Average Temperature (°C)',
                data: data.map(item => item.avg_temperature_celsius),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1,
                yAxisID: 'y'
              }, {
                label: 'Precipitation (mm)',
                data: data.map(item => item.total_precipitation_mm),
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                borderColor: 'rgb(255, 206, 86)',
                borderWidth: 1,
                yAxisID: 'y1'
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                title: {
                  display: true,
                  text: `Weather Comparison: ${startDate} to ${endDate}`
                }
              },
              scales: {
                y: {
                  type: 'linear',
                  display: true,
                  position: 'left',
                  title: {
                    display: true,
                    text: 'Temperature (°C)'
                  }
                },
                y1: {
                  type: 'linear',
                  display: true,
                  position: 'right',
                  title: {
                    display: true,
                    text: 'Precipitation (mm)'
                  },
                  grid: {
                    drawOnChartArea: false,
                  },
                }
              }
            }
          });
        } else {
          alert('No weather data found for this date range');
        }
      } catch (error) {
        alert('Error fetching comparison data');
        console.error(error);
      }
    }
  </script>
</body>
</html>