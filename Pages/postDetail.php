<?php

use Parse\ParseQuery;

//if (isset($_POST["logout"])) {
//    ParseUser::logOut();
//    $currentUser = ParseUser::getCurrentUser();
//    echo "<script language=JavaScript> location.replace(index.php);</script>";
//}
//
?>
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

for ($x = 0; $x < $imageCount; $x++) {
    $imageTag = "<#I#M#A#G#E#>" . $x . "</#I#M#A#G#E#>";
    $imageUrl = $imageArray[$x]->getURL();
    $imageUrlTag = "<br/><img src='" . $imageUrl . "'/><br/>";
    $content = str_replace($imageTag, $imageUrlTag, $content);
    //echo $content;
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
<!--Post Comment-->
<div class="postComment">
    <?php
    $queryReply = new ParseQuery("Reply");
    $queryReply->includeKey("author");
    $queryReply->includeKey("replyTo.author");
    $queryReply->equalTo("belongTo", $postResult);
    $replyList = $queryReply->find();
    //$replyList->fetchAll();

    $replyCount = $queryReply->count();
    ?>
    <div class="comment-Header">
        <?php
        echo $replyCount . "个回复";
        ?>
    </div>
    <?php
    for ($i = 0; $i < $replyCount; $i++) {
        $replyTo = $replyList[$i]->get("replyTo");
        if (empty($replyTo)) {
            // echo "Reply To is: " . $replyToAuthorName;
            $replyAuthor = $replyList[$i]->get("author");
            //$replyAuthor->fetch();
            $name = $replyAuthor->get("name");
            //var_dump($replyList[$i]->getCreatedAt());
            //$date = date("Y-m-d H:i", $replyList[$i]->getCreatedAt());
            $date = date_format($replyList[$i]->getCreatedAt(), "Y-m-d H:i:s");
            $replyContent = $replyList[$i]->get("replyContent");

            echo "<div class=\"replyStyle\">";
            echo "<div class=\"replyAuthor\">";
            echo "<span class=\"glyphicon glyphicon-user\"></span>";
            echo " ";
            echo $name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<span class=\"glyphicon glyphicon-time\"></span>";
            echo " ";
            echo $date;
            echo "</div>";

            echo "<div class=\"replyContent\">";
            echo $replyContent;
            echo "</div>";
            echo "<br>";
            echo "</div>";
            //------------------------------------------------------------------------------------
            //回复的回复：
//            echo "<div class=\"replyToReply\">";
//            echo "--------回复的回复--------";
//
//
//
//
//
//            echo "</div>";
        } else {
            echo "空空空空";
        }
    }
    ?>
</div>