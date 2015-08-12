<?php
use Parse\ParseQuery;

//default value
$postID = "WzPH1MSoGr";

$query = new ParseQuery("Post");

try
{
    $postResult = $query->get($postID);
} catch (ParseException $ex) 
{
}


$title = $postResult->get("title");
$content = $postResult->get("content");
$author = $postResult->get("author");
$author->fetch();
$unit = $postResult->get("unit");
$unit->fetch();
          
$name = $author->get("name");
$code = $unit->get("code");

$imageArray = $postResult->get("mediaFiles");
$imageCount = count($imageArray);
            
for($x=0; $x < $imageCount; $x++)
{
    $imageTag = "<#I#M#A#G#E#>" . $x . "</#I#M#A#G#E#>";
    $imageUrlTag = "<br/>";
    $content = str_replace($imageTag, $imageUrlTag, $content);
}

?>
        
<div class="postDetails">
    <!--Title-->
    <div class="postTitle">
    <?php echo $title; ?>
    </div>
    
    <!--Post Information-->
    <div class="postInfo">
    <?php echo $name; ?>
    </div>
    
    <!--Post Content-->
    <div class="postContent">
        <p>
        <?php
            echo $content;
        ?>
        </p>
    </div>
</div>        
