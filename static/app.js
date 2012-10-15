

var linksy = angular.module('Linksy', ['ngResource', 'linksyMediator', 'directives']).
            config(['$routeProvider', '$locationProvider',function($routeProvider, $locationProvider) {
            $routeProvider.
              when('/',{controller:LinkController, templateUrl: 'list.html'}).
              when('/tag/:tag', {controller:LinkController, templateUrl: 'templates/list.html'}).
              otherwise({redirectTo:'/'});
              
             console.log($locationProvider);
          }]);
  
  

function TagController($scope, $resource, mediator){
    $scope.Tag = $resource('index.php/tags/:id/');
    
    $scope.tags = $scope.Tag.query();
    
    $scope.reloadTags = function(){
       console.log("linksave in tags");
       $scope.tags = $scope.Tag.query(); 
    }
    
    $scope.remove = function() {
        $scope.Tag.remove({id:this.tag.id}, function(){
            mediator.publish("fetchTags");
            mediator.publish("fetchLinks");
        });
    }
    
    $scope.edit = function(){
        $scope.Tag.get({id: this.tag.id}, function (tag) {
            self.original = tag;
            $scope.tag = tag;
            
        });
    }
    
    mediator.subscribe("fetchTags", $scope.reloadTags);
   
}

function LinkController($scope, $resource, $location, $routeParams, mediator){
    console.log("linkController")
    var param = String($location.$$url).replace("tag/", "").replace("/", "");

    $scope.tagFilter= "porn";
    
    $scope.reset = function(){
        console.log("reset");
        if($scope.filter != ""){
            $scope.links = $scope.Link.query({filter:param});    
        }else{
            $scope.links = $scope.Link.query();
        }
    }
    
    $scope.loader = function() { return $("#linksy-loader") };
    $scope.Link = $resource('index.php/links/:id/');
    $scope.reset();   
    $scope.clearForm = function(){
        $scope.link = null;
        linkForm.linkTitle.value = null;
        linkForm.linkTags.value = null;
        linkForm.linkUrl.value = null;
        
    };
    
    $scope.save = function(){
        $scope.toggleLoader();
        $scope.Link.save($scope.link, function(link){
            $scope.toggleLoader();
            console.log("www:" +link.title);
            $scope.reset();
            mediator.publish("fetchTags");
       // $scope.links.push({id: link.id, title: link.title, url: link.url, tags:"", image:""});
        $scope.clearForm();
        });
    }
    
    $scope.destroy = function(){
        console.log(this.link);
        $scope.Link.remove({id : this.link.id});
        $scope.reset();
    }

    $scope.toggleLoader = function (){
        console.log($scope.loader);
        if($scope.loader().css('display') == 'none')
        {
            $scope.loader().show();
        }
        else {
            $scope.loader().hide();
        }
    }

    $scope.edit = function(){
        $scope.Link.get({id: this.link.id}, function (link) {
            self.original = link;
            $scope.link = link;
            linkForm.linkTitle.value = self.original.title;
            linkForm.linkTags.value = self.original.tags;
            linkForm.linkUrl.value = self.original.url;
            //$scope.Link = new $scope.Link(self.original);
        });
    }    
    
    
    mediator.subscribe("fetchLinks", $scope.reset);
    
}


var directives = angular.module('directives', ['linksyMediator']);
 
directives.directive('tag', function(mediator) {
   return function(scope, element, attrs) {
       $(".edit-link", element).bind('click', function(){
           $(".tag-text", element).toggle();
           $(".tag-input",element).toggle();
           var editedTagText = $(".tag-input input",element).val();
           if( editedTagText !== scope.tag.tag && editedTagText != ""){
               scope.tag.tag = editedTagText;
               scope.Tag.save(scope.tag, function(){
                   mediator.publish("fetchLinks");
               }); 
               
           }
       });
       
       
   }
});
