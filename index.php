<?php
    if (isset($_POST['submit'])) {
        $city = $_POST['city'];

        $url = "https://api.openweathermap.org/data/2.5/forecast?q=" . $city . "&appid=fd65df3fd56ce45fd9b36820ef734946&units=metric";

        $content = file_get_contents($url);
        $climate = json_decode($content);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Site</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <main class="d-flex flex-column min-vh-100 mb-5">
        <section>
            <div class="container py-5">
                <div class="row text-center">
                    <p class="mb-3 text-black50 fw-bold fs-2">Welcome To The Weather Site</p>
                    <p class="mb-3 text-black50 fw-bold fs-4">Enter a city name below to check out the 5-Day Weather Forecast!</p>
                    <form action="index.php" method="POST" class="d-flex justify-content-center">
                            <input type="text" name="city" class="form-control" placeholder="Enter a city name" title="Enter city name">
                            <button type="submit" class="btn btn-primary rounded" name="submit" value="search">Search</button>
                    </form>
                </div>
            </div>

            <div class="container pb-4">
                <div class="row justify-content-center text-justify text-white fs-2 fw-bolder">
                    <div class="col-12 text-center">
                        <?php
                            if(isset($climate)){
                                $cityName = $climate->city->name;
                                $country = $climate->city->country;
                                $current_temp = $climate->list[0]->main->temp;
                                echo '<h1>Weather of ' . $cityName .', '.$country.'</h1>';
                                echo '<h3>Current Temperature: ' . $current_temp .'&degC</h3>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="container">
                <div class="row text-center justify-content-evenly mb-5">
                    <?php
                        if(isset($climate)){
                            for($i=0; $i<sizeof($climate->list); $i=$i+8){
                                $temperature = $climate->list[$i]->main->temp;
                                $feelsLike = $climate->list[$i]->main->feels_like;
                                $tempMin = $climate->list[$i]->main->temp_min;
                                $tempMax = $climate->list[$i]->main->temp_max;
                                $humidity = $climate->list[$i]->main->humidity;
                                $weatherDescription = $climate->list[$i]->weather[0]->description;
                                $weatherIcon = $climate->list[$i]->weather[0]->icon;
                                $windSpeed = $climate->list[$i]->wind->speed;
                                $dt_txt = $climate->list[$i]->dt_txt;
                                $date = substr($dt_txt, 0 , 10);
                                $time = substr($dt_txt, 12 , 20);

                                echo '<div class="col-lg-3 py-3 px-3 mx-3 my-2 border-bottom border-start border-warning border-4 border-opacity-100 rounded-5" id="forecastDiv">';
                                    echo '<strong class="fs-3">Date: '.$date.'</strong><br>';
                                    echo '<strong class="fs-4">Time: '.$time.'</strong><br><br>';
                                    echo '<div class="fs-5 text-start px-2">Temperature: '.$temperature.' &degC<br>';
                                    echo 'Feels Like: '.$feelsLike.' &degC<br>';
                                    echo 'Min Temperature: '.$tempMin.' &degC<br>';
                                    echo 'Max Temperature: '.$tempMax.' &degC<br>';
                                    echo 'Humidity: '.$humidity.' %<br>';
                                    echo 'Wind Speed: '.$windSpeed.' m/s<br>';
                                    echo ucwords($weatherDescription).' <img src="https://openweathermap.org/img/wn/'.$weatherIcon.'@2x.png" alt="Weather Icon"></div>';
                                echo'</div>';
                            }
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>
    
    <footer class="footer fixed-bottom mt-5">
        <div class="text-center p-lg-3 fs-5">
            <p>© 2023 <a class="text-reset fw-bold text-decoration-none" href="https://github.com/IramDhrubo31" target="_blank">Iram Ahmed Dhrubo</a>. All rights reserved.</p>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>