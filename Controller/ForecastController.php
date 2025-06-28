<?php
/**
 * ForecastController - Handles weather forecast requests
 * 
 * Manages HTTP requests for the weather forecast application using
 * function-based weather data operations.
 */

// Include the weather functions
require_once '../Model/WeatherModel.php';

class ForecastController {
    
    /**
     * Main page controller method
     * Handles the initial page load for the forecast carousel
     */
    public function index() {
        try {
            $forecast = get5DayForecast();
            include '../View/forecast-carousel.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include '../View/forecast-carousel.php';
        }
    }
    
    /**
     * AJAX endpoint for fetching weather data
     * Returns weather forecast data as JSON
     */
    public function getForecastData() {
        try {
            $forecast = get5DayForecast();
            header('Content-Type: application/json');
            echo json_encode($forecast);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Hourly forecast page controller method
     */
    public function hourlyForecast() {
        try {
            $hourlyForecast = getHourlyForecast();
            include '../View/hourly-forecast.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include '../View/hourly-forecast.php';
        }
    }
    
    /**
     * AJAX endpoint for fetching hourly weather data
     */
    public function getHourlyData() {
        try {
            $hourlyForecast = getHourlyForecast();
            header('Content-Type: application/json');
            echo json_encode($hourlyForecast);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

// ============================================================================
// REQUEST ROUTING
// ============================================================================

// Determine request type and route to appropriate controller method
if (isset($_GET['action'])) {
    $controller = new ForecastController();
    
    switch ($_GET['action']) {
        case 'getForecast':
            $controller->getForecastData();
            break;
        case 'hourly':
            $controller->hourlyForecast();
            break;
        case 'getHourlyData':
            $controller->getHourlyData();
            break;
        default:
            $controller->index();
    }
} else {
    $controller = new ForecastController();
    $controller->index();
}
?>
