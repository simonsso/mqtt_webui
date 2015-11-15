<?php
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

$sql = "SELECT unix_timestamp(timestamp) as x, temperature, humidity FROM temperatures WHERE sensorid=4";
$result = $conn->query($sql);
header('Content-Type: application/json');

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       //echo "timestamp: " . $row["x"]. " - Temperature: " . $row["temperature"]. " " . $row["humidity"]. "<br>";
      $time[]=$row["x"];
      $temperature[]=$row["temperature"];
      $humidity[]=$row["humidity"];
    }
} else {
    echo "0 results";
}
$datas=array( time => $time,
              temperature => $temperature,
              humidity => $humidity
            );
echo json_encode($datas);
$conn->close();
?>
