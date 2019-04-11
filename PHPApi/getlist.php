<?php
/**
 * Returns the list of sensors.
 */
require 'connect.php';
    
$sensors = [];
$sql = "SELECT sensor_id,temperature ,date,hour , humidity , pressure , altitude , ativo FROM sensors";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $sensors[$cr]['sensor_id']    = $row['sensor_id'];
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