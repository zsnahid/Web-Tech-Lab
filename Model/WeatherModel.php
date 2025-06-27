<?php
/**
 * WeatherModel class
 * 
 * Handles all weather data operations including fetching data from the Open-Meteo API
 * and formatting it for use in the application.
 * 
 * @author Weather App Team
 * @version 1.0
 */
class WeatherModel {
    // Open-Meteo API endpoint for weather forecasts
    private $apiUrl = 'https://api.open-meteo.com/v1/forecast';
    
    // Coordinates for Dhaka, Bangladesh
    private $latitude = 23.7104;
    private $longitude = 90.4074;
    
    /**
     * Fetches and formats 5-day weather forecast data
     * 
     * Makes an API call to Open-Meteo to retrieve weather data for the next 5 days,
     * then formats the response into a structured array for easy consumption by the view.
     * 
     * @return array Formatted weather forecast data for 5 days
     * @throws Exception If API request fails or data cannot be parsed
     */
    public function get5DayForecast() {
        // Build API URL with required parameters
        $params = [
            'latitude' => $this->latitude,           // Location latitude
            'longitude' => $this->longitude,         // Location longitude
            'daily' => 'sunrise,sunset,temperature_2m_max,temperature_2m_min,uv_index_max,wind_speed_10m_max', // Daily data fields
            'timezone' => 'auto',                    // Automatic timezone detection
            'forecast_days' => 5                     // Number of forecast days
        ];
        
        // Construct full API URL with query parameters
        $url = $this->apiUrl . '?' . http_build_query($params);
        
        // Make HTTP request to the weather API
        $response = file_get_contents($url);
        
        // Check if the API request was successful
        if ($response === false) {
            throw new Exception('Failed to fetch weather data');
        }
        
        // Parse JSON response
        $data = json_decode($response, true);
        
        // Verify JSON was parsed successfully
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Failed to parse weather data');
        }
        
        // Format the raw API data for application use
        return $this->formatForecastData($data);
    }
    
    /**
     * Formats raw API weather data into a structured array
     * 
     * Processes the API response to extract relevant weather information
     * and formats it for easy display in the carousel view.
     * 
     * @param array $data Raw weather data from the API
     * @return array Formatted forecast data with organized daily information
     */
    private function formatForecastData($data) {
        $forecast = [];
        
        // Process each of the 5 forecast days
        for ($i = 0; $i < 5; $i++) {
            // Extract date and format it for display
            $date = $data['daily']['time'][$i];
            $dayName = date('l', strtotime($date));     // Full day name (e.g., "Monday")
            $dayShort = date('M j', strtotime($date));  // Short date format (e.g., "Jun 27")
            
            // Build structured forecast data for this day
            $forecast[$i] = [
                'date' => $date,                                                           // ISO date string
                'day_name' => $dayName,                                                   // Full day name
                'day_short' => $dayShort,                                                // Short date format
                'sunrise' => date('g:i A', strtotime($data['daily']['sunrise'][$i])),   // Formatted sunrise time
                'sunset' => date('g:i A', strtotime($data['daily']['sunset'][$i])),     // Formatted sunset time
                'temp_max' => round($data['daily']['temperature_2m_max'][$i]),          // Max temperature (rounded)
                'temp_min' => round($data['daily']['temperature_2m_min'][$i]),          // Min temperature (rounded)
                'uv_index' => round($data['daily']['uv_index_max'][$i]),                // UV index (rounded)
                'wind_speed' => round($data['daily']['wind_speed_10m_max'][$i])         // Wind speed (rounded)
            ];
        }
        
        return $forecast;
    }
}
?>
