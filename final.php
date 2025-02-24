<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>NASA APOD</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
      color: #333;
    }
  .container {
      max-width: 960px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }
    img {
      max-width: 100%;
      height: auto;
      display: block;
      margin: 20px auto;
      border-radius: 5px;
      transition: width 0.3s ease; /* Add transition for smooth resizing */
    }
    h1, h2, p {
      text-align: center;
    }
  .button-container {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="container">
  <?php
  $apiKey = 'r23Ye9idnwCS9Wcg4yPkRFAYgzaw8rXIg2iRyCaX';
  $apodUrl = "https://api.nasa.gov/planetary/apod?api_key=$apiKey";

  // Initialize cURL session
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $apodUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  // Execute cURL session and get the response
  $response = curl_exec($ch);
  // Close cURL session
  curl_close($ch);

  $data = json_decode($response, true);

  $imageUrl = $data['url'];
  $title = $data['title'];
  $description = $data['explanation'];
?>

  <h1><?php echo $title;?></h1>
  <img src="<?php echo $imageUrl;?>" alt="<?php echo $title;?>" id="apod-image">
  <p><?php echo $description;?></p>

  <div class="button-container">
    <button id="edit-button">Adjust Size</button>
  </div>
</div>

<script>
  const image = document.getElementById('apod-image');
  const editButton = document.getElementById('edit-button');
  let currentWidth = '100%'; // Initial width

  editButton.addEventListener('click', () => {
    // Toggle between two sizes, for example
    if (currentWidth === '100%') {
      currentWidth = '50%';
    } else {
      currentWidth = '100%';
    }
    image.style.width = currentWidth;
  });
</script>

</body>
</html>