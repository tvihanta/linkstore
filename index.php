<?php
require('lib/Slim/Slim.php');
require('lib/rb.php');

R::setup('mysql:host=localhost;dbname=linksy', 'root','root');

$app = new Slim(array(
				'log.enable'=> true,
				'log.path' => './logs',
				'log.level' => 4				
		));

$app->get('/', function() use ($app){
	return $app->render('home.php');
});

$app->post('/links', function() use ($app)
    {
        $request = $app->request();
        $response = $app->response();
	    $response['Content-Type'] = 'text/plain';
        $link = R::dispense('link');
        $newLink = json_decode($request->getBody());
        echo print_r($newLink);
        $link->title = $newLink->title; //TODO: fetch title if not present
        $link->url=$newLink->url;
        //TODO: split tags and save
        //$link->tags = $request->params('tags');
        //TODO fetch image
        
        $id = R::store($link);
        echo json_encode(array('id'=>$id));
    });

$app->get('/links', function() use ($app){
	$response = $app->response();
	$response['Content-Type'] = 'text/plain';
	$all = R::find('link');
	$res = array();
	foreach($all as $link)
	{
	    $res[] = array("title"=>$link->title, "url"=>$link->url, "tags"=>array(), "img"=>"");
	}
	echo json_encode($res);
	//echo json_encode(array(array("title"=>"google", "url"=>"www.google.com", "img"=>"", "tags"=>array("seppo"))));
});



$app->run();

?>



