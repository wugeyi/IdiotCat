<?php
use Parse\ParseQuery;

function postItem($postID='')
{
    //Set Default value for tet
    if($postID == '')
    {
        $postID = "WzPH1MSoGr";
    }
    
    $query = new ParseQuery("Post");
    $query->includeKey("author");
    $query->includeKey("unit");
    $query->includeKey("unit.faculty");
    
    try
    {
        $postResult = $query->get($postID);
    } catch (ParseException $ex) 
    {
    }
    
    postItemTemplate($postResult);
}

function postItemTemplate($postResult)
{
    $title = $postResult->get("title");
    
    $author = $postResult->get("author");
    $authorName = $author->get("name");
    
    $unit = $postResult->get("unit");
    $unitName = $unit->get("name");
    $code = $unit->get("code");
    
    $faculty = $unit->get("faculty");
    $facultyName = $faculty->get("name");
    
    $createdAt = date_format($postResult->getCreatedAt(), 'Y-m-d H:i:s');
?>

<div>
    <div>
        <span><?php echo $facultyName?></span><span><?php echo $code ?></span><span><?php echo $unitName ?></span>
    </div>
    <div>
        <span><?php echo $authorName?></span> : <span><?php echo postLink($postResult)?></span> <span><?php echo $createdAt?></span>
    </div>
</div>        

<?php
}
function postLink($postResult)
{
    $link = "<a href='post.php?pid=".$postResult->getObjectId()."'>".$postResult->get("title")."</a>";
    return $link;
}
