<?php
require_once "../Classes/DBConnect.php";
class Classmanager {
    
    public function getweatherdata($city) {    
        if ($city != '') {
            $data = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".$city."&appid=ed5bcbbbe0d11340d34e2148b92f2a23");
            $weather = json_decode($data,true);
            $tempInCel = intval($weather['main']['temp'] - 273);
            $fullWeather = "The weather in ".$city." is ".$weather['weather'][0]['main']." and tempture is ".$tempInCel." C";
        }
        return $fullWeather;
    }    
    //deve by kithru
    
}

?>
