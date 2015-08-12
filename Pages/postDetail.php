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
            
            for($x=0; $x < $imageCount; $x++)
            {
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