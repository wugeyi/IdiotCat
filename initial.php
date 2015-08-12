<?php
use Parse\ParseClient;

date_default_timezone_set("UTC");
require "autoload.php";

$app_id = "UfhHlFN8D7VKIqtmEEKZmwjrOjesnL3ng4seZmzA";
$rest_key = "arZRU6XnGAtrecMQriDvpt27UDrzkcpsFDfIdFno";
$master_key = "HDbRL4H8YjOCg0D2tNHBbmiIvP8viGWf3onHTx0u";

session_start();

ParseClient::initialize($app_id, $rest_key, $master_key);
