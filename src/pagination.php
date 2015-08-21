<?php

function pagination($unitId='all',$currentPage=1)
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
        echo pageLink($unitId,$currentPage-1, "Previous");
        echo "&nbsp";
    }
    
    if($currentPage < 1+$offset)
    {
        for($i = 1; $i < 7; $i++)
        {
            echo pageLink($unitId,$i, $i);
            echo "&nbsp";
        }
    }
    else
    {
        echo pageLink($unitId,1, "1");
        echo "...";
        echo "&nbsp";
        for($i = $currentPage-$offset+1; $i < $currentPage+$offset; $i++)
        {
            echo pageLink($unitId,$i, $i);
            echo "&nbsp";
        }
    }
    
    if($currentPage<MAX_PAGE)
    {
        echo "...";
        echo "&nbsp";
        echo pageLink($unitId,$currentPage+1, "Next");
    }
    
?>
</div>
<?php
}  

function pageLink($unitId,$pageNumber,$description)
{
        $link = "<a href='?p=".$pageNumber."&u=".$unitId."'>".$description."</a>";
        return $link;
}
?>
