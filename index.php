<?php

$title = "Monash Survival Guide";

require_once 'config.php';

$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
$unit = isset($_GET['u']) ? $_GET['u'] : 'all';

require './sharedViews/header.php';
require './sharedViews/searchBar.php';
postItemList($unit,$page);

require './sharedViews/footer.php';