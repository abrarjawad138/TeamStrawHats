<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mars Rover Images</title>
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
            padding: 10px;
            border-radius: 10px;
            margin: 10px;
            width: 250px;
            box-shadow: 0px 4px 8px rgba(255, 255, 255, 0.2);
            transition: transform 0.2s ease; /* Add transition for hover effect */
        }
      .card:hover {
            transform: translateY(-5px); /* Add hover effect */
        }
        img {
            width: 100%;
            border-radius: 5px;
            cursor: pointer; /* Add cursor style for image zoom */
        }
        select {
            margin: 10px;
            padding: 5px;
        }

        /* Modal styles */
      .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px;
        }
      .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            position: relative; /* To position the close button */
        }
      .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
      .close:hover,
      .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h1>Mars Rover Images</h1>
    <p>Latest images from NASA's Perseverance Rover</p>

    <label for="camera">Select Camera:</label>
    <select id="camera">
        <option value="">All</option>
        <option value="FHAZ">Front Hazard Avoidance Camera</option>
        <option value="RHAZ">Rear Hazard Avoidance Camera</option>
        <option value="NAVCAM">Navigation Camera</option>
    </select>

    <div class="container" id="image-container">
        <p>Loading images...</p>
    </div>

    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        const API_KEY = 'KBi7XSIJ5N1riPjIxfgvdKuFCnExyBPJnGlhefUn'; // Replace with a valid NASA API key
        const sol = 1000;  // Martian sol (day)
        const rover = 'perseverance';

        async function fetchMarsImages(camera = '') {
            try {
                const url = `https://api.nasa.gov/mars-photos/api/v1/rovers/${rover}/photos?sol=${sol}&api_key=${API_KEY}&camera=${camera}`;
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                const imageContainer = document.getElementById('image-container');
                imageContainer.innerHTML = '';

                if (data.photos.length === 0) {
                    imageContainer.innerHTML = '<p>No images available for this camera.</p>';
                    return;
                }

                data.photos.slice(0, 20).forEach(photo => {
                    const imgCard = `
                        <div class="card">
                            <img src="${photo.img_src}" alt="Mars Rover Image" onclick="openModal('${photo.img_src}')">
                            <p><strong>Camera:</strong> ${photo.camera.full_name}</p>
                            <p><strong>Earth Date:</strong> ${photo.earth_date}</p>
                        </div>
                    `;
                    imageContainer.innerHTML += imgCard;
                });
            } catch (error) {
                console.error('Error fetching data:', error);
                document.getElementById('image-container').innerHTML = '<p>Error fetching images.</p>';
            }
        }

        document.getElementById('camera').addEventListener('change', (event) => {
            fetchMarsImages(event.target.value);
        });

        fetchMarsImages(); // Fetch all images on page load

        // Modal functions
        function openModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
    </script>

</body>
</html>