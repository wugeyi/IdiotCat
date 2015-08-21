<?php
use Parse\ParseQuery;
require_once 'postItem.php';
require_once 'pagination.php';

function postItemList($unitId='all', $page=1)
{
    if(!isset($page))
    {
        $page = 1;
    }
    
    if($page < 0 || $page > MAX_PAGE )
    {
        $page = 1;
    }
    
    $offset = ($page - 1) * POSTS_PER_PAGE;
    
    $query = new ParseQuery("Post");
    
    if($unitId != 'all')
    {
        $unitQuery = new ParseQuery("Unit");
        $unitQuery->equalTo('objectId', $unitId);
        $unit = $unitQuery->first();
        $query->matchesQuery("unit", $unitQuery);
        
        echo "<h2>".$unit->get("code")."&nbsp".$unit->get("name")."</h2>";
    }
    else
    {
        echo "<h2>All Units</h2>";
    }
    
    $query->skip($offset);
    $query->limit(POSTS_PER_PAGE);
    $query->includeKey("author");
    $query->includeKey("unit");
    $query->includeKey("unit.faculty");
    $query->descending("createdAt");
    $results = $query->find();

    
    for ($i = 0; $i < count($results); $i++) 
    {
        $postResult = $results[$i];
        postItemTemplate($postResult);
        echo "<br/>";
    }
    
    
    pagination($unitId,$page);
}