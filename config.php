<?php

//Parse API KEY configuration
define('APP_ID','UfhHlFN8D7VKIqtmEEKZmwjrOjesnL3ng4seZmzA');
define('REST_KEY', 'arZRU6XnGAtrecMQriDvpt27UDrzkcpsFDfIdFno');
define('MASTER_KEY','HDbRL4H8YjOCg0D2tNHBbmiIvP8viGWf3onHTx0u');

//1-1000
define('POSTS_PER_PAGE',10);

define('MAX_POSTS', 10000);

define('MAX_PAGE',ceil(MAX_POSTS/POSTS_PER_PAGE));
        
define('BASE',  dirname(__FILE__));

require_once './settings.php';

