<?php
use Parse\ParseQuery;
require_once 'postItem.php';
require_once 'pagination.php';

function postItemList($page=1)
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
    
    
    pagination($page);
}