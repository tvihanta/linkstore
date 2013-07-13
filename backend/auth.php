<?php
require_once('lib/utils.php'); 
class LinksyAuth extends \Slim\Middleware
{
    protected $pathWhitelist = array("/login");

    public function deny_access() {
        $res = $this->app->response();
        $res->status(401);
        return;
        //$res->header('WWW-Authenticate', sprintf('Basic realm="%s"', $this->realm));        
    }
     public function authenticate($token) {
          if($token == generateToken()){
            return true;
          } else {
            return false;
          }  

    }

    public function call()
    {
        $req = $this->app->request();
        $res = $this->app->response();
        $token = $req->headers('linksy-token');
        if(in_array($req->getResourceUri(), $this->pathWhitelist)){
            $this->next->call();
            return;
        }

        if ($token and $this->authenticate($token)) {
            $this->next->call();
        } else {
            $this->deny_access();
        }
    }
}

?>