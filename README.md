# 5-Day Weather Forecast App

A responsive weather application built with PHP, HTML, CSS, and JavaScript that displays a 5-day weather forecast in an interactive carousel format.

## Features

- **5-Day Forecast Carousel**: Interactive slideshow displaying weather data for 5 days
- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **Weather Data**: Displays temperature, sunrise/sunset, UV index, wind speed
- **Hourly Preview**: Shows sample hourly weather data for each day
- **Auto-advance**: Automatically cycles through slides every 10 seconds
- **Keyboard Navigation**: Use arrow keys to navigate slides
- **Beautiful UI**: Modern glassmorphism design with smooth animations

## Technology Stack

- **Backend**: PHP (MVC architecture)
- **Frontend**: HTML5, CSS3, JavaScript
- **Weather API**: Open-Meteo API
- **Location**: Dhaka, Bangladesh (23.7104°N, 90.4074°E)

## Project Structure

```
webtech/
├── Controller/
│   └── ForecastController.php    # Handles requests and coordinates between Model and View
├── Model/
│   └── WeatherModel.php          # Fetches and processes weather data from API
├── View/
│   └── forecast.php              # Main carousel view with HTML/CSS/JS
└── index.php                     # Entry point that redirects to controller
```

## Setup Instructions

1. **Install XAMPP**: Make sure you have XAMPP installed and running
2. **Place Files**: Copy the `webtech` folder to `c:\xampp\htdocs\`
3. **Start Services**: Start Apache service in XAMPP Control Panel
4. **Access Application**: Open browser and navigate to `http://localhost/webtech`

## API Information

The application uses the Open-Meteo API which provides:

- **Daily Data**: Temperature highs/lows, sunrise/sunset, UV index, wind speed
- **Hourly Data**: Temperature, precipitation probability, wind speed, UV index
- **Free**: No API key required
- **Reliable**: High availability weather service

## Carousel Implementation

Based on W3Schools slideshow guide with enhancements:

- **Navigation**: Previous/Next buttons, dot indicators, keyboard support
- **Auto-advance**: Slides change automatically every 10 seconds
- **Smooth Transitions**: CSS fade animations between slides
- **Responsive**: Adapts to different screen sizes

## Browser Compatibility

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Mobile browsers

## Future Enhancements

- Hourly breakdown view (separate detailed view)
- Location selection
- Weather alerts
- Historical data
- Multiple cities
- Weather maps

## License

Open source - feel free to modify and use for educational purposes.
