<?php

function getUrl($url)
{
    $curl_handle=curl_init();
    curl_setopt($curl_handle,CURLOPT_URL,'http://example.com');
    curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
    curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);

    if (empty($buffer))
    {
        print "Sorry, example.com are a bunch of poopy-heads.<p>";
    }
    else
    {
        print $buffer;
    }
}

function saveLink($title, $url, $tags)
{
    if ($url != "" || $url != null){
       
        $url = cleanString($url);
        $hasHttp = strrpos($url, "http://");        
        if ($hasHttp===false)
            $url = "http://".$url;
        echo $url;
        
        $exists = R::find("link", "url=?", array($url));
        echo $exists;
        if(count($exists) == 0){
            $link = R::dispense('link');
            $link->url = $url;
            
            $id = R::store($link);
            echo json_encode(array('id'=>$id));
            if ($title != "")
            {
                $link->title=cleanString($title);
            }else
            {
                //fetch title from url
                
            }
            if (count($tags) > 0)
            {
            
            }
            R::store($link);
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
