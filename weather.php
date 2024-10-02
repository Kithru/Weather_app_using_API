<?php
require_once "../Classes/Classes.php";

$classManager = new classmanager();
$status = '';
$fullWeather = '';
if (isset($_REQUEST['city'])) {
    $city = $_REQUEST['city'];
}

if (isset($_POST["submit"])) {
   
    $fullWeather = $classManager->getweatherdata($city);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Search</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link to your CSS file -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

     
    <style>
        /* Add CSS directly here for simplicity */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('image.jpg'); /* Add the path to your background image here */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        form {
            text-align: center; /* Center text within the form */
            padding: 20px;
            width: 900px;
            height: 130px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for better visibility */
            background-color: #fff; /* Optional: Form background color */
        }
        
        input[type="text"] {
            padding: 10px;
            margin-right: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 700px;
            /*width: 100%;*/
            max-width: 500px; /* Optional: Maximum width of the input */
        }
        
        h1 {
            margin-bottom: 20px; /* Space between heading and input field */
            font-size: 24px;
        }
         button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #0056b3;
        }
        .container {
            /*max-width: 600px;*/
            margin: 0 auto;
            padding: 20px;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <form action="weather.php" style="text-align: center;" method="POST">
            <h1>What's the Weather today?</h1>
            <input type="text" name="city" id="city" placeholder="Enter city name e.g Bambalapitiya, Nugegoda.." required>
            <button type="submit" name="submit">Search</button>
        </form> 
    
        <div style="text-align: center; margin-top:50px;">
            <?php if($fullWeather) : ?>
                <div class="alert alert-success bg-success text-white"><?php echo $fullWeather; ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>




<!--https://api.openweathermap.org/data/2.5/weather?q={city%20name}&appid=ed5bcbbbe0d11340d34e2148b92f2a23-->