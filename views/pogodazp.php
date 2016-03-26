<?php include ROOT . '/views/layouts/header.php'; ?>
<?php
echo "<div style='font-size: 25px'>";
echo "<p align='center'>".$today."</p>";
echo "<h1 align='center'style='font-size: 45px'> Погода в Запорожье на сегодня</h1>";
echo "<p align='center'>Температура воздуха: ". $temp[1]."</p>"; 
echo "<p align='center'>Скорость ветра: ".$wind_ms[1]."</p>";  
echo "<p align='center'>Давление: ".$press[1]."</p>";
echo "<p align='center'>Влажность: ".$wicon_hum[1]."</p>"; 
echo "<p align='center'>Температура воды: ".$temp_water[1]."</p>";
echo "<p align='center'><a href=\"http://www.gismeteo.ua/city/daily/5093/\">
        		Gismeteo Прогноз погоды</a></p>";
echo "</div>";
?>
<?php include ROOT . '/views/layouts/footer.php'; ?>

