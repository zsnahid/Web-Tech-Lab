<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hourly Weather Forecast</title>
  <link rel="stylesheet" href="../index.css">
  <style>
    .hourly-header {
      text-align: center;
      margin: 2rem 0;
    }

    .hourly-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--foreground);
      margin-bottom: 0.5rem;
    }

    .hourly-subtitle {
      font-size: 1.1rem;
      color: var(--muted-foreground);
      margin-bottom: 1rem;
    }

    .date-display {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 2rem;
    }

    .hourly-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    .hourly-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 2rem;
      margin: 2rem 0;
      overflow-x: auto;
    }

    .hourly-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
      font-size: 0.95rem;
    }

    .hourly-table th,
    .hourly-table td {
      padding: 1rem 0.75rem;
      text-align: center;
      border: 1px solid var(--border);
      white-space: nowrap;
    }

    .hourly-table th {
      background: var(--primary);
      color: var(--primary-foreground);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-size: 0.85rem;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .hourly-table tbody tr:nth-child(even) {
      background: var(--muted);
    }

    .hourly-table tbody tr:hover {
      background: var(--accent);
      color: var(--accent-foreground);
    }

    .time-cell {
      font-weight: 600;
      color: var(--foreground);
      background: var(--secondary) !important;
    }

    .temperature {
      color: var(--chart-1);
      font-weight: 600;
    }

    .wind {
      color: var(--chart-4);
      font-weight: 600;
    }

    .uv {
      color: var(--chart-2);
      font-weight: 600;
    }

    .precipitation {
      color: var(--chart-3);
      font-weight: 600;
    }

    .description {
      font-style: italic;
      color: var(--muted-foreground);
      max-width: 200px;
      white-space: normal;
      text-align: left;
    }

    .back-button {
      display: inline-block;
      margin-bottom: 1rem;
      padding: 0.75rem 1.5rem;
      background: var(--secondary);
      color: var(--secondary-foreground);
      text-decoration: none;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s ease;
      border: 1px solid var(--border);
    }

    .back-button:hover {
      background: var(--primary);
      color: var(--primary-foreground);
    }

    .no-data {
      text-align: center;
      padding: 3rem;
      color: var(--muted-foreground);
      font-size: 1.1rem;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: var(--secondary);
      padding: 1.5rem;
      border-radius: 8px;
      text-align: center;
      border: 1px solid var(--border);
    }

    .stat-label {
      font-size: 0.9rem;
      color: var(--muted-foreground);
      margin-bottom: 0.5rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--foreground);
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
      .hourly-card {
        padding: 1rem;
        margin: 1rem 0;
      }

      .hourly-table {
        font-size: 0.85rem;
      }

      .hourly-table th,
      .hourly-table td {
        padding: 0.75rem 0.5rem;
      }

      .hourly-title {
        font-size: 2rem;
      }

      .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.75rem;
      }

      .stat-card {
        padding: 1rem;
      }

      .description {
        max-width: 150px;
        font-size: 0.8rem;
      }
    }

    /* Print styles */
    @media print {
      .back-button,
      .navbar {
        display: none;
      }

      .hourly-card {
        border: 1px solid #000;
        box-shadow: none;
      }

      .hourly-table th {
        background: #f0f0f0 !important;
        color: #000 !important;
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
    <div class="hourly-container">
      <div class="hourly-header">
        <h1 class="hourly-title">24-Hour Weather Forecast</h1>
        <p class="hourly-subtitle">Detailed hourly weather predictions for today</p>
        <div class="date-display">
          <?php echo date('l, F d, Y'); ?>
        </div>
      </div>

      <a href="forecastController.php" class="back-button">← Back to 5-Day Forecast</a>

      <?php if(isset($hourlyData) && count($hourlyData) > 0): ?>
        <!-- Statistics Summary -->
        <div class="hourly-card">
          <h2 style="margin-bottom: 1rem; color: var(--foreground);">Daily Summary</h2>
          <div class="stats-grid">
            <?php
            $temps = array_column($hourlyData, 'temperature_celsius');
            $winds = array_column($hourlyData, 'wind_speed_kmh');
            $uvs = array_column($hourlyData, 'uv_index');
            $precips = array_column($hourlyData, 'precipitation_probability_percent');
            ?>
            <div class="stat-card">
              <div class="stat-label">High Temperature</div>
              <div class="stat-value temperature"><?php echo max($temps); ?>°C</div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Low Temperature</div>
              <div class="stat-value temperature"><?php echo min($temps); ?>°C</div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Max Wind Speed</div>
              <div class="stat-value wind"><?php echo max($winds); ?> km/h</div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Max UV Index</div>
              <div class="stat-value uv"><?php echo max($uvs); ?></div>
            </div>
            <div class="stat-card">
              <div class="stat-label">Avg Precipitation</div>
              <div class="stat-value precipitation"><?php echo round(array_sum($precips) / count($precips)); ?>%</div>
            </div>
          </div>
        </div>

        <!-- Hourly Data Table -->
        <div class="hourly-card">
          <h2 style="margin-bottom: 1rem; color: var(--foreground);">Hourly Breakdown</h2>
          <div style="overflow-x: auto;">
            <table class="hourly-table">
              <thead>
                <tr>
                  <th>Time</th>
                  <th>Temperature</th>
                  <th>Wind Speed</th>
                  <th>UV Index</th>
                  <th>Precipitation</th>
                  <th>Description</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($hourlyData as $hour): ?>
                <tr>
                  <td class="time-cell">
                    <?php echo date('g:i A', strtotime($hour['forecast_datetime'])); ?>
                  </td>
                  <td class="temperature">
                    <?php echo $hour['temperature_celsius']; ?>°C
                  </td>
                  <td class="wind">
                    <?php echo $hour['wind_speed_kmh']; ?> km/h
                  </td>
                  <td class="uv">
                    <?php echo $hour['uv_index']; ?>
                  </td>
                  <td class="precipitation">
                    <?php echo $hour['precipitation_probability_percent']; ?>%
                  </td>
                  <td class="description">
                    <?php echo htmlspecialchars($hour['weather_description']); ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      <?php else: ?>
        <div class="hourly-card">
          <div class="no-data">
            <h3>No Hourly Data Available</h3>
            <p>No hourly weather forecast data is currently available.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <script>
    // Add any interactive features here if needed
    document.addEventListener('DOMContentLoaded', function() {
      // Highlight current hour for today's forecast
      const currentHour = new Date().getHours();
      const rows = document.querySelectorAll('.hourly-table tbody tr');
      
      if (rows[currentHour]) {
        rows[currentHour].style.backgroundColor = 'var(--accent)';
        rows[currentHour].style.color = 'var(--accent-foreground)';
        rows[currentHour].style.fontWeight = '600';
      }
    });
  </script>
</body>
</html>
