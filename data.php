<?php
$mode=$_REQUEST['mode'];
$sensor=intval($_REQUEST['sensor']);
$servername = "localhost";
$username = "climate";
$password = "uKSujvp2AxUsP7cn";
$dbname = "climate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT unix_timestamp(timestamp) as x, temperature, humidity FROM temperatures WHERE sensorid=$sensor";
$result = $conn->query($sql);
header('Content-Type: application/json');

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       if($mode=="line"){
          $time[]=$row["x"];
          $temperature[]=$row["temperature"];
          $humidity[]=$row["humidity"];
       }
       if($mode=="xy"){
          $time=$row["x"];
          $temperature[]=array($time,$row["temperature"]);
          $humidity[]=array($time,$row["humidity"]);
       } 
    }
} else {
    echo "// 0 results";
}
if($mode=="line"){
$datas=array( time => $time,
              temperature => $temperature,
              humidity => $humidity
            );
}elseif($mode=="xy"){
$datas=array( 
              temperature => $temperature,
              humidity => $humidity
            );

}
echo json_encode($datas);
$conn->close();
?>
