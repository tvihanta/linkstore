<?php
require('lib/Slim/Slim.php');
require('lib/rb.php');
require('lib/linksy.php');


R::setup('mysql:host=localhost;dbname=linksy', 'root','root');

$app = new Slim(array(
				'log.enable'=> true,
				'log.path' => './logs',
				'log.level' => 4				
		));

$app->get('/', function() use ($app){
	return $app->render('home.php');
});

$app->get('/tags/', function() use ($app){
    echo json_encode(R::find('tag'));
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
        
        if (isset($newLink->tags))
        {
            $tags = $newLink->tags;
        }
        else
            $tags = "";
        
        if (isset($newLink->id))
        {
            $res = saveLink($id = $newLink->id, $newLink->title, $newLink->url, $tags);
        }
        else{
            $res = saveLink($id = null,$newLink->title, $newLink->url, $tags);
        }
        
        if (is_string($res))
        {
            $res = array("error"=>$res);
        }
        else
        {
            $res = array("id"=>$res);
        }
        
        echo json_encode($res);
    });

$app->get('/links/:id', function($id) use ($app){
	$response = $app->response();
	$response['Content-Type'] = 'text/plain';
	
    $link = R::load('link', $id);
    if (!$link->id)
    {
        echo "no link found.";
        return 0;    
    }        
	
	$res= array("id"=>$link->id,"title"=>$link->title, "url"=>$link->url, "tags"=>array(), "img"=>"");
	echo json_encode($res);
	//echo json_encode(array(array("title"=>"google", "url"=>"www.google.com", "img"=>"", "tags"=>array("seppo"))));
});

$app->get('/links', function() use ($app){
	$response = $app->response();
	$response['Content-Type'] = 'text/plain';
	$all = R::find('link');
	$res = array();
	foreach($all as $link)
	{
	    $res[] = array("id"=>$link->id,"title"=>$link->title, "url"=>$link->url, "tags"=>array(), "img"=>"");
	}
	echo json_encode($res);
	//echo json_encode(array(array("title"=>"google", "url"=>"www.google.com", "img"=>"", "tags"=>array("seppo"))));
});




$app->run();

?>



