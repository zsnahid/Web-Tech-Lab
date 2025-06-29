<?php
require_once('db.php');

function auth($email, $password)
{
	$con=getConnection();
	$sql="select * from users where email='$email' and password='$password'";
	$res=mysqli_query($con,$sql);
	return $res;
}

function getHistoricalWeather(){
	$con=getConnection();
	$sql='select * from historical_weather';
	$res=mysqli_query($con,$sql);
	return $res;
}

function getWeatherByDate($date){
	$con=getConnection();
	$sql="SELECT * FROM historical_weather WHERE record_date = '$date'";
	$result = mysqli_query($con, $sql);
	return mysqli_fetch_assoc($result);
}

function getWeatherByDateRange($startDate, $endDate){
	$con=getConnection();
	$sql="SELECT * FROM historical_weather WHERE record_date BETWEEN '$startDate' AND '$endDate' ORDER BY record_date";
	$result = mysqli_query($con,$sql);
	return $result;
}

function getRecordHighs(){
	$con=getConnection();
	$sql="SELECT 
			MAX(max_temperature_celsius) as highest_temp,
			MIN(min_temperature_celsius) as lowest_temp,
			MAX(total_precipitation_mm) as highest_precipitation,
			MAX(avg_wind_speed_kmh) as highest_wind_speed,
			MAX(avg_humidity_percent) as highest_humidity,
			(SELECT record_date FROM historical_weather WHERE max_temperature_celsius = (SELECT MAX(max_temperature_celsius) FROM historical_weather) LIMIT 1) as highest_temp_date,
			(SELECT record_date FROM historical_weather WHERE min_temperature_celsius = (SELECT MIN(min_temperature_celsius) FROM historical_weather) LIMIT 1) as lowest_temp_date
		FROM historical_weather";
	$res=mysqli_query($con,$sql);
	return mysqli_fetch_assoc($res);
}

function getMonthlyStats(){
	$con=getConnection();
	$sql="SELECT 
			AVG(avg_temperature_celsius) as avg_temp,
			AVG(avg_humidity_percent) as avg_humidity,
			SUM(total_precipitation_mm) as total_precipitation,
			AVG(avg_wind_speed_kmh) as avg_wind_speed,
			COUNT(*) as total_days
		FROM historical_weather";
	$res=mysqli_query($con,$sql);
	return mysqli_fetch_assoc($res);
}

function getWeatherDataForChart(){
	$con=getConnection();
	$sql="SELECT record_date, avg_temperature_celsius, max_temperature_celsius, min_temperature_celsius, total_precipitation_mm FROM historical_weather ORDER BY record_date";
	$res=mysqli_query($con,$sql);
	$data = array();
	while($row = mysqli_fetch_assoc($res)){
		$data[] = $row;
	}
	return $data;
}

// Forecast functions
function getForecastData(){
	$con=getConnection();
	$sql="SELECT * FROM weather_forecast ORDER BY forecast_date LIMIT 5";
	$res=mysqli_query($con,$sql);
	$data = array();
	while($row = mysqli_fetch_assoc($res)){
		$data[] = $row;
	}
	return $data;
}

function getForecastByDate($date){
	$con=getConnection();
	$sql="SELECT * FROM weather_forecast WHERE forecast_date = '$date'";
	$result = mysqli_query($con,$sql);
	return mysqli_fetch_assoc($result);
}

// Hourly forecast functions
function getHourlyForecastByDate($date){
	$con=getConnection();
	$sql="SELECT * FROM hourly_weather_forecast WHERE DATE(forecast_datetime) = '$date' ORDER BY forecast_datetime";
	$result = mysqli_query($con,$sql);
	$data = array();
	while($row = mysqli_fetch_assoc($result)){
		$data[] = $row;
	}
	return $data;
}

function getAllHourlyForecast(){
	$con=getConnection();
	$sql="SELECT * FROM hourly_weather_forecast ORDER BY forecast_datetime";
	$res=mysqli_query($con,$sql);
	$data = array();
	while($row = mysqli_fetch_assoc($res)){
		$data[] = $row;
	}
	return $data;
}

function getUserData($email){
  $con = getConnection();
  $sql = "SELECT * FROM users WHERE email='$email'";
  $res = mysqli_query($con, $sql);
  return mysqli_fetch_assoc($res);
}

function updateUserData($email, $name, $password, $phone){
  $con = getConnection();
  $sql = "UPDATE users SET name='$name', password='$password', phone_number='$phone' WHERE email='$email'";
  $res = mysqli_query($con, $sql);
  return $res;
}
?>