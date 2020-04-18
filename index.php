<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); //POST
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");

include_once 'covid-19-estimator.php';

// get posted data
$data = json_decode(file_get_contents("php://input"));

//call estimator
$response = covid19ImpactEstimator($data);
echo json_encode($response);
echo "\n\r";
