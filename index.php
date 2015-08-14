<?php

$title = "Monash Survival Guide";

require_once 'config.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;


require './sharedViews/header.php';

postItemList($page);

require './sharedViews/footer.php';