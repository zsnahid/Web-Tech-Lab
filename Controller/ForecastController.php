<?php
/**
 * ForecastController class
 * 
 * Handles HTTP requests for the weather forecast application.
 * Acts as an intermediary between the WeatherModel and the forecast view,
 * managing both regular page loads and AJAX requests for weather data.
 * 
 * @author Weather App Team
 * @version 1.0
 */

// Include the WeatherModel for data operations
require_once '../Model/WeatherModel.php';

class ForecastController {
    /** @var WeatherModel Instance of the weather data model */
    private $weatherModel;
    
    /**
     * Constructor - Initialize the controller with a WeatherModel instance
     */
    public function __construct() {
        $this->weatherModel = new WeatherModel();
    }
    
    /**
     * Main page controller method
     * 
     * Handles the initial page load for the forecast carousel.
     * Fetches weather data and includes the view template.
     * If an error occurs, passes the error message to the view for display.
     * 
     * @return void
     */
    public function index() {
        try {
            // Attempt to fetch 5-day forecast data
            $forecast = $this->weatherModel->get5DayForecast();
            // Include the view template (forecast data will be available as $forecast variable)
            include '../View/forecast.php';
        } catch (Exception $e) {
            // If an error occurs, pass it to the view for display
            $error = $e->getMessage();
            include '../View/forecast.php';
        }
    }
    
    /**
     * AJAX endpoint for fetching weather data
     * 
     * Returns weather forecast data as JSON for asynchronous requests.
     * Used by the JavaScript in the view to dynamically load weather data
     * without requiring a full page refresh.
     * 
     * @return void Outputs JSON response directly
     */
    public function getForecastData() {
        try {
            // Fetch weather data from the model
            $forecast = $this->weatherModel->get5DayForecast();
            
            // Set appropriate headers for JSON response
            header('Content-Type: application/json');
            
            // Output the forecast data as JSON
            echo json_encode($forecast);
        } catch (Exception $e) {
            // Handle errors by returning JSON error response
            header('Content-Type: application/json');
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

// ============================================================================
// REQUEST ROUTING
// ============================================================================

// Determine request type and route to appropriate controller method
if (isset($_GET['action']) && $_GET['action'] === 'getForecast') {
    // Handle AJAX request for forecast data
    $controller = new ForecastController();
    $controller->getForecastData();
} else {
    // Handle regular page load request
    $controller = new ForecastController();
    $controller->index();
}
?>
