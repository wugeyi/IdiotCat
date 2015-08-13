<?php

function cleanDesTag($content)
{
    $desStartTag = "<#T#E#X#T#>";
    $desEndTag = "</#T#E#X#T#>";
    $content = str_replace($desStartTag, '', $content);
    $content = str_replace($desEndTag, '', $content);
    return $content;
}
