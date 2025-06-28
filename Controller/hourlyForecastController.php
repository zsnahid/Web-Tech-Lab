<?php
require_once('../Model/alldb.php');

// Generate dummy hourly data for today
$selectedDate = date('Y-m-d');
$hourlyData = [];

// Create 24 hours of dummy data
for ($hour = 0; $hour < 24; $hour++) {
    $hourlyData[] = [
        'id' => $hour + 1,
        'forecast_datetime' => $selectedDate . ' ' . sprintf('%02d:00:00', $hour),
        'temperature_celsius' => rand(18, 32) + (rand(0, 9) / 10), // Random temp between 18-32°C
        'wind_speed_kmh' => rand(5, 25) + (rand(0, 9) / 10), // Random wind 5-25 km/h
        'uv_index' => rand(1, 11), // UV index 1-11
        'precipitation_probability_percent' => rand(0, 80), // 0-80% chance of rain
        'weather_description' => [
            'Clear sky', 'Partly cloudy', 'Cloudy', 'Light rain', 'Sunny', 
            'Overcast', 'Light showers', 'Mostly sunny', 'Scattered clouds', 'Fair'
        ][rand(0, 9)]
    ];
}

// Include the view
include('../View/hourlyForecastView.php');
?>
