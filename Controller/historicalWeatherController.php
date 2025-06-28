<?php
require_once('../Model/alldb.php');

// Get all weather data
$allWeatherData = getHistoricalWeather();

// Get record highs/lows
$recordData = getRecordHighs();

// Get monthly statistics
$monthlyStats = getMonthlyStats();

// Get chart data
$chartData = getWeatherDataForChart();

// Handle AJAX requests for specific date lookups
if(isset($_GET['action']) && $_GET['action'] == 'getWeatherByDate' && isset($_GET['date'])){
    $weatherData = getWeatherByDate($_GET['date']);
    header('Content-Type: application/json');
    echo json_encode($weatherData);
    exit;
}

// Handle AJAX requests for date range comparisons
if(isset($_GET['action']) && $_GET['action'] == 'compareWeather' && isset($_GET['startDate']) && isset($_GET['endDate'])){
    $comparisonData = getWeatherByDateRange($_GET['startDate'], $_GET['endDate']);
    $result = array();
    while($row = mysqli_fetch_assoc($comparisonData)){
        $result[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

// Include the view
include('../View/historicalWeatherView.php');
?>