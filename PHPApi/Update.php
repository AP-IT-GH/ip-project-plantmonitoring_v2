<?php
require 'connect.php';

// Get the posted data.
$postdata = file_get_contents("localhost:4000");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if ((int)$request->id < 1 || trim($request->username) == '' || (float)$request->password < 0) {
    return http_response_code(400);
  }

  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->id);
  $username = mysqli_real_escape_string($con, trim($request->usename));
  $password = mysqli_real_escape_string($con, (float)$request->password);

  // Update.
  $sql = "UPDATE `users` SET `username`='$username',`password`='$password' WHERE `id` = '{$id}' LIMIT 1";

  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}