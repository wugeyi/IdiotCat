<?php
require 'config.php';

$pid = isset($_GET['pid']) ? $_GET['pid'] : '';
if($pid=='')
{
    header('location:index.php');
}
else 
{
     
$title = "Monash Survival Guide";

require './sharedViews/header.php';

postDetail($pid);

require './sharedViews/footer.php';
}
