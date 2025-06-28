<?php
require_once('../Model/alldb.php');

// Get forecast data for the next 5 days
$forecastData = getForecastData();

// Handle AJAX requests for specific date lookups
if(isset($_GET['action']) && $_GET['action'] == 'getForecastByDate' && isset($_GET['date'])){
    $forecastByDate = getForecastByDate($_GET['date']);
    header('Content-Type: application/json');
    echo json_encode($forecastByDate);
    exit;
}

// Include the view
include('../View/forecastView.php');
?>
