<?php
/**
 * Application Entry Point
 * 
 * This file serves as the main entry point for the 5-Day Weather Forecast application.
 * It immediately redirects users to the forecast controller to display the weather carousel.
 * 
 * Usage: Access http://localhost/webtech/ and this file will automatically
 *        redirect to Controller/ForecastController.php
 * 
 * @author Weather App Team
 * @version 1.0
 */

// Redirect all requests to the main forecast controller
header('Location: Controller/ForecastController.php');

// Ensure script execution stops after redirect
exit();
?>
