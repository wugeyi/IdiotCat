<?php

use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseUser;
use Parse\ParseClient;

ParseClient::initialize(APP_ID, REST_KEY, MASTER_KEY);

require_once 'utilities.php';

function postDetail($postID) {
    //echo "AAAAAFSDFSDFSDF".date('y-m-d h:i');
    $query = new ParseQuery("Post");
    $query->includeKey("author");
    $query->includeKey("unit");
    $query->includeKey("unit.faculty");

    try {
        $postResult = $query->get($postID);
    } catch (ParseException $ex) {
        echo "404 error";
    }

    $title = $postResult->get("title");
    $content = $postResult->get("content");
    $author = $postResult->get("author");
    $unit = $postResult->get("unit");
    $name = $author->get("name");
    $code = $unit->get("code");
    $imageArray = $postResult->get("mediaFiles");
    $imageCount = count($imageArray);

    for ($x = 0; $x < $imageCount; $x++) {
        $imageTag = "<#I#M#A#G#E#>" . $x . "</#I#M#A#G#E#>";
        $imageUrl = $imageArray[$x]->getURL();
        $imageUrlTag = "<br/><img src='" . $imageUrl . "'/><br/>";
        $content = str_replace($imageTag, $imageUrlTag, $content);
    }

    cleanDesTag($content);
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
    <?php
    $queryReply = new ParseQuery("Reply");
    $queryReply->includeKey("author");
    $queryReply->includeKey("replyTo.author");
    $queryReply->includeKey("replyTo");
    $queryReply->includeKey("replyTo.replyTo");
    $queryReply->includeKey("belongTo");
    //$queryReply->includeKey("replyTo.replyTo.replyTo");
    $queryReply->equalTo("belongTo", $postResult);
    $replyList = $queryReply->find();
    $replyCount = $queryReply->count();


    //Function: find root reply:
//    function findRootReply($currentReply) {
////        $currentReplyID = $currentReply -> getObjectId();
//        $currentReplyTo = $currentReply->get("replyTo");     
//        if (empty($currentReplyTo)) {
//            return $currentReply;
//        } else {
//            //$id = $currentReplyTo ->getObjectId();
//            return findRootReply($currentReplyTo);
//        }
//    }
    ?>
    <!--Post Comment-->
    <div class="postComment">
        <div class="comment-Header">
            <?php
            echo $replyCount . "个回复";
            ?>
        </div>
        <?php
        for ($i = 0; $i < $replyCount; $i++) {
            $replyTo = $replyList[$i]->get("replyTo");
            $replyAuthor = $replyList[$i]->get("author");

            $name = $replyAuthor->get("name");

            $date = date_format($replyList[$i]->getCreatedAt(), "Y-m-d H:i:s");
            $replyContent = $replyList[$i]->get("replyContent");
            $replyPost = $replyList[$i]->get("belongTo");
            $replyPostID = $replyPost->getObjectId();
            $replyID = $replyList[$i]->getObjectId();
            if (empty($replyTo)) {

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
                echo "<div class=\"replyButton\">";
                echo "<a onclick=\"reply();\" href=\"?pid=$postID&rtoid=$replyID#add_comment\">回复 </a>";
                echo "</div>";
                echo "<br>";
                echo "</div>";
                //------------------------------------------------------------------------------------
                //回复的回复：
//                echo "<div class=\"replyToReply\">";
//                echo "--------回复的回复--------";
//                for ($n = 0; $n < $replyCount; $n++) {
//                    $rootReply = new ParseObject("Reply");
//                    $rootReply = findRootReply($replyList[$n]);
//
//                    if ($rootReply->getObjectId() === $replyList[$i]->getObjectId()) {
//                        $replyAuthorAA = $replyList[$n]->get("author");
//                        $nameAA = $replyAuthor->get("name");
//                        $replyContentAA = $replyList[$n]->get("replyContent");
//                        echo $nameAA;
//                        echo "&nbsp;&nbsp;";
//                        echo $replyContentAA;
//                        echo "<br>";
//                    }
//                }
                echo "</div>";
                echo "------------------------------------------------------------------------------------";
            } else {
                //$replyToAuthor = $replyTo -> get("author");
                //$replyAuthorName =  $replyToAuthor -> get("name");
                $replyToContent = $replyTo->get("replyContent");

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
                echo "<div class=\"replyToOriginal\">";
                echo "+++++++++++Original++++++++++++";
                echo "<br>";
                echo $replyToContent;
                echo "<br>";
                echo "+++++++++++++++++++++++++++++++";
                echo "<br>";

                echo "</div>";
                echo $replyContent;

                echo "</div>";

                echo "<div class=\"replyButton\">";
                echo "<a onclick=\"reply();\" href=\"?pid=$postID&rtoid=$replyID#add_comment\">回复</a>";
                echo "</div>";


                echo "<br>";
                echo "</div>";

                echo "</div>";
                echo "------------------------------------------------------------------------------------";
            }
        }
        ?>
    </div>
    <div class="inputReply">
        <?php
        echo "添加回复***************";
        echo "<br>";
        ?>
        <script type="text/javascript">
            function reply()
            {
                //document.getElementById("myReply").focus().select();
                $('#add_comment').find('myReply').focus();

            }

        </script>

        <div>
            <form id="reply-form" method="post" action="">
                <?php
                echo "<input type=\"hidden\" name=\"replyToID\" id=\"replyToID\" value=\"$replyID\">";
                echo "<input type=\"hidden\" name=\"belongToID\" id=\"belongToID\" value=\"$replyPostID\">";
                ?>

                <textarea type="text" name="add_comment" id="add_comment" rows="10" cols="60" > </textarea>
                <br>
                <input name="Mysubmitted" id="Mysubmitted" value="SEND"  class="button medium" type="submit" />
            </form>
        </div>

    </div>
    <?php
    if (isset($_POST["Mysubmitted"])) {
        $replyPostID = $_REQUEST['pid'];
        echo $replyPostID;
        $replyToID = $_REQUEST['rtoid'];
        echo $replyToID;
        $replyContent = $_POST['add_comment'];


        try {
            $user = ParseUser::logIn("acer", "zhouhongji");
            // Do stuff after successful login.
        } catch (ParseException $error) {
            // The login failed. Check error to see why.
        }

        $currentUser = ParseUser::getCurrentUser();
        $replySave = new ParseObject("Reply");
        $replySave->set("author", $currentUser);
        $replySave->set("belongTo", $postResult);
        $replySave->set("replyContent", $replyContent);
        if (!empty($replyToID)) {
            //get ReplyTo:
            $queryReplyTo = new ParseQuery("Reply");
            try {
                $replyToResult = $queryReplyTo->get($replyToID);
            } catch (ParseException $ex) {
                echo "404 error";
            }
            $replySave->set("replyTo", $replyToResult);
            
        } else {
            
        }
        $replySave->save();
        
        //set repliedAt：
        //echo date('y-m-d h:i',time());
        //echo "AAAAAFSDFSDFSDF".$replySave->getCreatedAt();
        $postResult->set("repliedAt",$replySave->getCreatedAt());
        $postResult->set("replied",$postResult->get("replied")+1);
        $postResult->save();
        
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.'pid='.$replyPostID;
        echo $url;
        echo "<META HTTP-EQUIV=\"Refresh\" content='0;URL=$url'>"; 
    }
    
    
}
