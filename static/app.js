

angular.module('Linksy', ['ngResource']);

function TagController($scope, $resource){
    $scope.Tag = $resource('index.php/tags/:id/');
    $scope.tags = $scope.Tag.query();

}

function LinkController($scope, $resource){

    $scope.loader = function() { return $("#linksy-loader") };
    $scope.Link = $resource('index.php/links/:id/');
    $scope.links = $scope.Link.query();    
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
            $scope.links = $scope.Link.query();
       // $scope.links.push({id: link.id, title: link.title, url: link.url, tags:"", image:""});
        $scope.clearForm();
        });
    }
    
    $scope.destroy = function(){
        console.log(this.link);
        $scope.Link.remove({id : this.link.id});
        $scope.links = $scope.Link.query();
    }

    $scope.toggleLoader = function (){
        if($scope.loader().css('display') == 'none')
        {
            $scope.loader().show('slow');
        }
        else {
            $scope.loader().hide('slow');
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
}
