<?php
date_default_timezone_set("UTC");
require "autoload.php";

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;

$app_id = "UfhHlFN8D7VKIqtmEEKZmwjrOjesnL3ng4seZmzA";
$rest_key = "arZRU6XnGAtrecMQriDvpt27UDrzkcpsFDfIdFno";
$master_key = "HDbRL4H8YjOCg0D2tNHBbmiIvP8viGWf3onHTx0u";

session_start();

ParseClient::initialize($app_id, $rest_key, $master_key);

//if (isset($_POST["logout"])) {
//    ParseUser::logOut();
//    $currentUser = ParseUser::getCurrentUser();
//    echo "<script language=JavaScript> location.replace(index.php);</script>";
//}
//
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Monash Survival Guide</title>
    </head>
    <body>
        <!-- CONTENT -->
        <?php
        //$postID = $_GET['pid'];
        $postID = "WzPH1MSoGr";
        $query = new ParseQuery("Post");
        try {
            $postResult = $query->get($postID);
        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
        }


        $title = $postResult->get("title");
        $content = $postResult->get("content");
        $author = $postResult->get("author");
        $author->fetch();
        $unit = $postResult->get("unit");
        $unit->fetch();
//            
        $name = $author->get("name");
        $code = $unit->get("code");
//array:
        $imageArray = $postResult->get("mediaFiles");

        $imageCount = count($imageArray);
            
            for($x=0; $x < $imageCount; $x++)
            {
                $imageTag = "<#I#M#A#G#E#>" . $x . "</#I#M#A#G#E#><#T#E#X#T#></#T#E#X#T#>";
                $imageUrl = $imageArray[$x]->getURL();
                $imageUrlTag = "<br/><img src='" . $imageUrl . "'/><br/>";
                $content = str_replace($imageTag, $imageUrlTag, $content);
                echo $content;
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
        
        
        
    </body>
</html>
