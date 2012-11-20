<?php
require_once('simple_html_dom.php');
function getUrl($url)
{
    try {
    $html = file_get_html($url);
    } catch (Exception $e) {
        return null;
    }
    $post_html = str_get_html($html);

    if(isset($post_html)) {
        return $post_html;
        }
    else
        return null;
}

function getTagArray($tags) {
    $res =  array();
    foreach($tags as $tag){
        $res[] = $tag->tag;
    }
    return $res;
}

function getFirstImage($dom)
{
    $first_img = $dom->find('img', 0);
    if($first_img !== null) {
        return $first_img->src;
    }
    return "";
}

function getTitle($dom)
{
    if($dom != null ) {
        $title = $dom->find('title', 0);
        if($title !== null) {
            return $title->plaintext;
        }
    }
    else {
        return "no title found.";
    }
}

function parseAndSaveTags($tagString, $link)
{
    try {
        $tags  = explode(",", $tagString);
    } catch (Exception $e)
    {
        return null;
    }
    
    foreach ($tags as $tag){
        $tag = cleanString($tag);
        //try to find existing
        $tagexists = R::findOne("tag", "tag=?", array($tag)); 
        if(count( $tagexists ) != 0){
            
            R::associate( $link, $tagexists);
        }
        else {
            $tagObj = R::dispense('tag');
            $tagObj->tag = $tag;
            R::store($tagObj);
            R::associate( $link, $tagObj );
        }        
    }
        
}

function saveTag($pTag){
    $tagObj = R::findOne("tag", "id=?", array($pTag->id)); 
    if(count( $tagObj ) == 0){
        $tagObj = R::dispense('tag');
    }
    $tagObj->tag = $pTag->tag;
    R::store($tagObj);
    return 1;
}

function saveLink($pLink, $id)
{
    if ($pLink->url != "" || $pLink->url != null){
       
        $url = cleanString($pLink->url);
        $hasHttp = strrpos($url, "http://");        
        if ($hasHttp===false)
            $url = "http://".$url;
        
        if ($id != null)
        {
            $exists = array();
        }
        else
            $exists = R::find("link", "url=?", array($url));
        
        
        if(count($exists) == 0){
            if ($id != null)
            {
                $link = R::load('link', $id);
            }
            else
            {
                $link = R::dispense('link'); 
                $dom = getUrl($url);
            }
            $link->url = $url;
            $id = R::store($link);
            if ($link->title != "")
            {
                $link->title=cleanString($pLink->title);
            }else
            {
                //fetch title from url
                $link->title=cleanString(getTitle($dom));
            }
            if(isset($dom) && $dom != null )
                $link->image=getFirstImage($dom);
            R::clearRelations($link, "tag");
            R::store($link);            
            
            //echo "tags:".$pLink->tags;
            if ($pLink->tags !="")
            {
                
                parseAndSaveTags($pLink->tags, $link);
            }
            

            return $link->id;        
        }
        else
        {
            return "url already exists";
        }
    }
    else
    {
        return "no url given";
    }
}

function cleanString($string)
{
  $string = trim($string);
  $string = strip_tags($string);
  $string = strtolower($string);   
  return $string;
}

?>
