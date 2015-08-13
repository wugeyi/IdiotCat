<?php

date_default_timezone_set("UTC");

require_once './vendor/autoload.php';
require_once './src/postItemList.php';
require_once './src/postDetail.php';

use Parse\ParseClient;
ParseClient::initialize(APP_ID, REST_KEY, MASTER_KEY);
