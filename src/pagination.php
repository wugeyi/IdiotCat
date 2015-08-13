<?php

function pagination($currentPage=1)
{
    if($currentPage < 0 || $currentPage > MAX_PAGE)
    {
        $currentPage = 1;
    }
    $offset = 3;

?>
<div>
<?php
    if($currentPage>1)
    {
        echo pageLink($currentPage-1, "Previous");
        echo "&nbsp";
    }
    
    if($currentPage < 1+$offset)
    {
        for($i = 1; $i < 7; $i++)
        {
            echo pageLink($i, $i);
            echo "&nbsp";
        }
    }
    else
    {
        echo pageLink(1, "1");
        echo "...";
        echo "&nbsp";
        for($i = $currentPage-$offset+1; $i < $currentPage+$offset; $i++)
        {
            echo pageLink($i, $i);
            echo "&nbsp";
        }
    }
    
    if($currentPage<MAX_PAGE)
    {
        echo "...";
        echo "&nbsp";
        echo pageLink($currentPage+1, "Next");
    }
    
?>
</div>
<?php
}  

function pageLink($pageNumber,$description)
{
        $link = "<a href='?page=".$pageNumber."'>".$description."</a>";
        return $link;
}
?>
