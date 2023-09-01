<?php
$weather = "";
$error = "";

  if(array_key_exists('submit', $_GET))
  {
    if (!$_GET['city']) 
    {
      $error = "Your Input Field Is Empty";
    }
    if ($_GET['city']) 
    {

      $apidata = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".
        $_GET['city']."&APPID=496a12ccad84e049e5a19ce8334c10b5");

        $weatherarray = json_decode($apidata,true);

        if($weatherarray['cod'] == 200)
        {

          //C = K - 273.15
          $tempCelsius = $weatherarray['main']['temp'] - 273;

          $weather = "<b>" .$weatherarray['name'].", ".$weatherarray['sys']['country']." : ".intval($tempCelsius)." &deg;C</b> <br>";

          $weather .= "<b>Weather Condition : </b>" .$weatherarray['weather']['0']['description'];

          $weather .="<b> Atmospheric Pressure : </b>" .$weatherarray['main']['pressure']."hPa<br> ";

          $weather .="<b> Wind Speed : </b>" .$weatherarray['wind']['speed']."meter/sec<br>";

          $weather .="<b> Cloudness : </b>" .$weatherarray['clouds']['all']."%<br>";

          date_default_timezone_set('Asia/Kolkata');

          $sunrise = $weatherarray['sys']['sunrise'];

          $weather .= "<b> Sunrise : </b>" .date("g:i a", $sunrise)."<br>";

          $weather .= "<b> Current Time : </b>" .date("F j,Y, g:i a");

        }

        else
        {
          $error = "Couldn't be process, Your City Name is Invalid";
        }

     }
  }

?>



<!doctype html>
<html lang="en">
  <head>
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Weather Forcast </title>

   <style>

     .crud {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            display: inline-block;
            padding: 10px 20px;
            margin-top: 30px;
        }
     
     body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-image: url(weather1.jpg);
            font-family: 'Poppins', 'Times New Roman', Times, sans-serif;
            font-size: large;
            color: white;
            background-size: cover;
            background-attachment: fixed;
        }
     .container
     {
      text-align: center;
      justify-content: center;
      align-items: center;
      width: 440px;
     }

     h1
     {

      font-weight: 700;
      margin-top: 100px;
      margin-bottom: 0px;
     }

     input
     {
      width: 350px;
      padding: 5px;
     }

   </style>

  </head>
  <body>



    <div class="container">

    <div class="crud">
<form method="post" action="crudop.php">
    <button type="submit">Crud Operations</button>
</form>
</div>

      <p><h1>Search Global Weather </h1></p>
      <form action="" method="GET">
        <p><label for="city">Enter Your City Name</label></p>
        <p><input type="text" name="city" id="city" placeholder="City Name"></p>
        <button type="submit" name="submit" class="btn btn-success"> Submit Now</button>

        <div class="output mt-3">

          <?php

          if ($weather) 
          {
            echo '<div class="alert alert-Success" role="alert">
              
              ' . $weather . '
             </div>';
          }

          if ($error) 
          {
            echo '<div class="alert alert-danger" role="alert">
              
              ' . $error . '
             </div>';
          }
          

          ?>



        </div>
      </form>

    </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>