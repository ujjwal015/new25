<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL); 

echo @$fname = $_POST["customer_fname"];

echo @$_POST["subscriptionTypeId"].'<br>';

echo @$_POST["transactionId"]."<br>";

echo @$_POST["timestamp"];


$response = file_get_contents('php://input');
$data = json_decode($response);
print_r($data);


$postedXml = file_get_contents("php://input");
$xml = simplexml_load_string($postedXml);
print_r($xml);
echo  "Success response will display here :";

//Make sure that this is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    //If it isn't, send back a 405 Method Not Allowed header.
    @header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
    exit;
}
 
 
//Get the raw POST data from PHP's input stream.
//This raw data should contain XML.
$postData = trim(file_get_contents('php://input'));
 
 
//Use internal errors for better error handling.
libxml_use_internal_errors(true);
 
 
//Parse the POST data as XML.
$xml = simplexml_load_string($postData);
 
 
//If the XML could not be parsed properly.
if($xml === false) {
    //Send a 400 Bad Request error.
    header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
    //Print out details about the error and kill the script.
    foreach(libxml_get_errors() as $xmlError) {
        echo $xmlError->message . "\n";
    }
    exit;
}
 
 
//var_dump the structure, which will be a SimpleXMLElement object.
var_dump($xml);

$postedXml = file_get_contents("php://input");
$array = json_decode(json_encode(simplexml_load_string($postedXml)),true);
echo "<pre>";
print_r($array);
?>