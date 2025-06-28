<?php
/**
 * Weather data functions using Open-Meteo API
 */

/**
 * Get 5-day weather forecast
 * @return array Formatted forecast data
 */
function get5DayForecast() {
    $apiUrl = 'https://api.open-meteo.com/v1/forecast';
    $latitude = 23.7104;  // Dhaka, Bangladesh
    $longitude = 90.4074;
    
    $params = [
        'latitude' => $latitude,
        'longitude' => $longitude,
        'daily' => 'sunrise,sunset,temperature_2m_max,temperature_2m_min,uv_index_max,wind_speed_10m_max',
        'timezone' => 'auto',
        'forecast_days' => 5
    ];
    
    $url = $apiUrl . '?' . http_build_query($params);
    $response = file_get_contents($url);
    
    if (!$response) {
        throw new Exception('Failed to fetch weather data');
    }
    
    $data = json_decode($response, true);
    if (!$data) {
        throw new Exception('Invalid weather data received');
    }
    
    return formatForecastData($data);
}

/**
 * Formats raw API weather data into a structured array
 * @param array $data Raw weather data from the API
 * @return array Formatted forecast data
 */
function formatForecastData($data) {
    $forecast = [];
    
    // Process each of the 5 forecast days
    for ($i = 0; $i < 5; $i++) {
        $date = $data['daily']['time'][$i];
        
        $forecast[$i] = [
            'date' => $date,
            'day_name' => date('l', strtotime($date)),
            'day_short' => date('M j', strtotime($date)),
            'sunrise' => date('g:i A', strtotime($data['daily']['sunrise'][$i])),
            'sunset' => date('g:i A', strtotime($data['daily']['sunset'][$i])),
            'temp_max' => round($data['daily']['temperature_2m_max'][$i]),
            'temp_min' => round($data['daily']['temperature_2m_min'][$i]),
            'uv_index' => round($data['daily']['uv_index_max'][$i]),
            'wind_speed' => round($data['daily']['wind_speed_10m_max'][$i])
        ];
    }
    
    return $forecast;
}

/**
 * Get hourly forecast data from JSON file
 * @return array Hourly forecast data
 */
function getHourlyForecast() {
    $jsonFile = __DIR__ . '/hourly-forecast.json';
    
    if (!file_exists($jsonFile)) {
        throw new Exception('Hourly forecast data file not found');
    }
    
    $jsonContent = file_get_contents($jsonFile);
    if ($jsonContent === false) {
        throw new Exception('Failed to read hourly forecast data');
    }
    
    $hourlyData = json_decode($jsonContent, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Failed to parse hourly forecast data');
    }
    
    return $hourlyData;
}
?>
