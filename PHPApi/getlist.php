<?php
/**
 * Returns the list of sensors.
 */
require 'connect.php';
    
$sensors = [];
$sql = 
"SELECT *
FROM sensors
ORDER BY date DESC";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $sensors[$cr]['id_sensor']    = $row['id_sensor'];
    $sensors[$cr]['temperature'] = $row['temperature'];
    $sensors[$cr]['hour'] = $row['hour'];
    $sensors[$cr]['date'] = $row['date'];
    $sensors[$cr]['humidity'] = $row['humidity'];
    $sensors[$cr]['pressure'] = $row['pressure'];
    $sensors[$cr]['altitude'] = $row['altitude'];
    $sensors[$cr]['ativo'] = $row['ativo'];
    $cr++;
  }
    
  echo json_encode(['data'=>$sensors]);
}
else
{
  http_response_code(404);
}