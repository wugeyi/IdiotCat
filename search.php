<?php
require_once 'config.php';
use Parse\ParseQuery;

$q = $_POST['q'];
if(empty($q))
{
    echo "Please input keyword";
    header("location:index.php");
}
else
{
    $query = new ParseQuery("Unit");
    $query->equalTo("code", $q);
    $units = $query->find();
    if(count($units)>0)
    {
        $unit = $units[0];
        $unitId = $unit->getObjectId();
        header("location:index.php?u=".$unitId);
    }
    else {
        echo "No units found:".$q;
    }
}