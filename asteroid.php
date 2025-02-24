<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asteroid Watch</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #111;
            color: white;
            padding: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card {
            background-color: #222;
            padding: 20px;
            border-radius: 10px;
            margin: 10px;
            width: 300px;
            box-shadow: 0px 4px 8px rgba(255, 255, 255, 0.2);
        }
        h1 {
            font-size: 24px;
        }
        .distance {
            color: #ffcc00;
            font-size: 18px;
        }
    </style>
</head>
<body>

    <h1>Asteroid Watch</h1>
    <p>The next five closest approaches to Earth</p>
    
    <div class="container" id="asteroid-container">
        <p>Loading...</p>
    </div>

    <script>
        const currentDate = new Date();
        const formattedDate = currentDate.toISOString().split('T')[0]; // Corrected date format

        const API_KEY = 'jIoGAMcniZAqzQX8Ugj4AXKuABAYco9k85K2zeeE'; // Replace with valid API key
        const startDate = formattedDate; // Change as needed
        const endDate = formattedDate;   // Change as needed
        const url = `https://api.nasa.gov/neo/rest/v1/feed?start_date=${startDate}&end_date=${endDate}&api_key=${API_KEY}`;

        async function fetchAsteroids() {
            try {
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                const asteroidContainer = document.getElementById('asteroid-container');
                asteroidContainer.innerHTML = '';

                if (!data.near_earth_objects) {
                    throw new Error("No asteroid data available.");
                }

                const nearEarthObjects = data.near_earth_objects;
                const dates = Object.keys(nearEarthObjects);
                
                let count = 0;

                dates.forEach(date => {
                    nearEarthObjects[date].forEach(asteroid => {
                        if (count >= 5) return;

                        const name = asteroid.name;
                        const closeApproach = asteroid.close_approach_data[0];
                        const approachDate = closeApproach.close_approach_date_full;
                        const distance = parseFloat(closeApproach.miss_distance.kilometers).toLocaleString();
                        const size = asteroid.estimated_diameter.meters.estimated_diameter_max.toFixed(1);

                        const asteroidCard = `
                            <div class="card">
                                <h2>${name}</h2>
                                <p><strong>Date:</strong> ${approachDate}</p>
                                <p class="distance"><strong>Distance:</strong> ${distance} km</p>
                                <p><strong>Size:</strong> ~${size} meters</p>
                            </div>
                        `;

                        asteroidContainer.innerHTML += asteroidCard;
                        count++;
                    });
                });

                if (count === 0) {
                    asteroidContainer.innerHTML = '<p>No asteroids found for this date range.</p>';
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                document.getElementById('asteroid-container').innerHTML = `<p>Error: ${error.message}</p>`;
            }
        }

        fetchAsteroids();
    </script>

</body>
</html>
