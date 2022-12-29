<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<?php
require("phpMQTT.php");
require("config.php");
$topic="iot/suhu";

$message = @$_GET['message'];

if(empty($message)) {$message = "TEST";}

$mqtt = new bluerhinos\phpMQTT($host, $port, "ClientID".rand());

if ($mqtt->connect(true,NULL,$username,$password)) {
    $mqtt->publish($topic,$message, 0);
    $mqtt->close();
  }else{
    echo "Fail or time out
  ";
  }

?>
<center>
    <tr>
<a href="/MQTT-PHP/onoff.php?message=D1=1" class = "btn btn-success">D1 ON</a> &nbsp;
<a href="/MQTT-PHP/onoff.php?message=D1=0" class = "btn btn-danger">D1 OFF</a>
<br> <br>
<a href="/MQTT-PHP/onoff.php?message=D2=1" class = "btn btn-success">D2 ON</a> &nbsp;
<a href="/MQTT-PHP/onoff.php?message=D2=0" class = "btn btn-danger">D2 OFF</a>
<br> <br>
<a href="/MQTT-PHP/onoff.php?message=D3=1" class = "btn btn-success">D3 ON</a> &nbsp;
<a href="/MQTT-PHP/onoff.php?message=D3=0" class = "btn btn-danger">D3 OFF</a> 
    </tr>
</center>