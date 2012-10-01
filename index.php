<?php
require('lib/Slim/Slim.php');
require('lib/rb.php');
require('lib/linksy.php');


R::setup('mysql:host=localhost;dbname=linksy', 'root','root');

$app = new Slim(array(
				'log.enable'=> true,
				'log.path' => 'logs',
				'log.level' => 4				
		));

$app->get('/', function() use ($app){
	return $app->render('home.php');
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
        echo $newLink->tags;
        /*if (!isset($newLink->tags))
             $newLink->tags = "";*/
        
        if (isset($newLink->id))
        {
            $res = saveLink($newLink, $id = $newLink->id);
        }
        else{
            $res = saveLink($newLink,$id = null);
        }
        
        if (is_string($res))
        {
            $res = array("error"=>$res);
            echo "error".$res;
        }
        else
        {
            echo getLinkJSON($res);
            //$return= array("id"=>$res->id,"title"=>$res->title, "url"=>$res->url, "tags"=>array(), "img"=>$res->image);
    	    //echo json_encode($return);
        }
        
    });


$app->get('/links', function() use ($app){
	$response = $app->response();
	$response['Content-Type'] = 'text/plain';
	$all = R::find('link');
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

function getLinkJSON($id){
    $link = R::load('link', $id);
    if (!$link->id)
    {
        echo "no link found.";
        return 0;    
    }        
	
	$res= array("id"=>$link->id,"title"=>$link->title, "url"=>$link->url, "tags"=>array(), "img"=>$link->image);
	return json_encode($res);
}

$app->run();

?>



