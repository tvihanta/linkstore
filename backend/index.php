<?php
require('lib/Slim/Slim.php');
require('lib/rb.php');
require('lib/linksy.php');
R::setup('mysql:host=localhost;dbname=linksy', 'root','root');

$app = new Slim(array(
                'debug' => true,
				'log.enable'=> true,
				'log.path' => 'logs',
				'log.level' => 4				
		));

$app->get('/', function() use ($app){
	$response = $app->response();
	$response['Content-Type'] = 'text/plain';
    
    if(isset($_GET['filter']) && $_GET['filter'] != ""){
        $tag = R::findOne('tag', "tag=?" , array($_GET['filter']));    
        if ($tag != NULL){
            $all = R::related( $tag, 'link' );
        }
        else {
         return 0;     
        }
    }
    else{
        $all = R::find('link');    
    }
	$res = array();
	foreach($all as $link)
	{
	    $tags = getTagArray( R::related( $link, 'tag' ) );
	    
	    $res[] = array("id"=>$link->id,"title"=>$link->title, "url"=>$link->url, "tags"=>$tags, "img"=>$link->image);
	}
	echo json_encode($res);
});


$app->delete( '/links/:id', function ($id) use ($app)
{
    echo $id;
    $link = R::load('link', $id);
    echo $link;    
    if (!$link->id)
    {
        echo "no link found.";
        return 0;    
    }        
    R::trash($link);
    echo 1;
    return 1;
});

$app->post('/links', function() use ($app)
    {
        $request = $app->request();
        $response = $app->response();
	    $response['Content-Type'] = 'text/plain';
        $link = R::dispense('link');
        $newLink = json_decode($request->getBody());
        //echo $newLink->tags;
        if (!isset($newLink->tags))
             $newLink->tags = "";
        
        if (isset($newLink->id))
        {
            $res = saveLink($newLink, $id = $newLink->id);
        }
        else{
            $res = saveLink($newLink,$id = null);
        }
        
        /*if (is_string($res))
        {
            echo $res;
            $res = array("error"=>$res);
            //echo "error".$res;
        }
        else
        {*/
            return  getLinkJSON($res);
            //$return= array("id"=>$res->id,"title"=>$res->title, "url"=>$res->url, "tags"=>array(), "img"=>$res->image);
    	    //echo json_encode($return);
        //}
        
    });


$app->get('/links', function() use ($app){
	$response = $app->response();
	$response['Content-Type'] = 'text/plain';
    
    if(isset($_GET['filter']) && $_GET['filter'] != ""){
        $tag = R::findOne('tag', "tag=?" , array($_GET['filter']));    
        if ($tag != NULL){
            $all = R::related( $tag, 'link' );
        }
        else {
         return 0;     
        }
    }
    else{
        $all = R::find('link');    
    }
	$res = array();
	foreach($all as $link)
	{
	    $tags = getTagArray( R::related( $link, 'tag' ) );
	    
	    $res[] = array("id"=>$link->id,"title"=>$link->title, "url"=>$link->url, "tags"=>$tags, "img"=>$link->image);
	}
	echo json_encode($res);
	//echo json_encode(array(array("title"=>"google", "url"=>"www.google.com", "img"=>"", "tags"=>array("seppo"))));
});

$app->get('/links/:id', function($id) use ($app){

	$response = $app->response();
	$response['Content-Type'] = 'text/plain';
	
    $link = getLinkJSON($id);
	echo $link;
	return 1;
	//echo json_encode(array(array("title"=>"google", "url"=>"www.google.com", "img"=>"", "tags"=>array("seppo"))));
});


$app->get('/tags', function() use ($app){
    $tags = R::find('tag');
    foreach($tags as $tag)
    {
        $nbrOfLinks = count( R::related( $tag, 'link' ) );
        
        $res[] = array("id"=>$tag->id,"tag"=>$tag->tag, "nbr"=>$nbrOfLinks);
    }
    echo json_encode($res);
});

$app->post('/tags', function() use ($app){
    $request = $app->request();
    $response = $app->response();
    $response['Content-Type'] = 'text/plain';
    $tag = json_decode($request->getBody());
    echo saveTag($tag);
});

$app->put('/tags/:id', function() use ($app){
    $request = $app->request();
    $response = $app->response();
    $response['Content-Type'] = 'text/plain';
    $tag = json_decode($request->getBody());
    echo saveTag($tag);
});

$app->delete( '/tags/:id', function ($id) use ($app)
{
    $tag = R::load('tag', $id);
    if (!$tag->id)
    {
        echo "no tag found.";
        return 0;    
    }        
    
    R::clearRelations( $tag, 'link' );
    R::trash($tag);
    echo 1;
});


function getLinkJSON($id){
    $link = R::load('link', $id);
    if (!$link->id)
    {
        echo "no link found.";
        return 0;    
    }        
	$tags = getTagArray( R::related( $link, 'tag' ) );
	$res= array("id"=>$link->id,"title"=>$link->title, "url"=>$link->url, "tags"=>$tags, "img"=>$link->image);
	return json_encode($res);
}

function getTagJSON($pLink){
    if(count($pLink->tags) > 0){
        $res = array();
        foreach ($pLink->tags as $tag) {
               
           $tagArr = array("tag"=>$tag->tag);
           
           $res[] = $tag;
        }
        return json_encode($res);
    }
    
}





$app->run();

?>



