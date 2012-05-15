

angular.module('Linksy', ['ngResource']);

function LinkController($scope, $resource){
    $scope.Link = $resource('index.php/links/:id/');
    console.log($scope);
    $scope.links = $scope.Link.query();    
    $scope.clearForm = function(){
        $scope.link = null;
        linkForm.linkTitle.value = null;
        linkForm.linkTags.value = null;
        linkForm.linkUrl.value = null;
    };
    
    $scope.save = function(){
        console.log($scope.Link.$save);
        $scope.Link.save($scope.link);
       
        $scope.clearForm();
        $scope.links = $scope.Link.query();
         $scope.links = $scope.Link.query();
    }
    
    $scope.destroy = function(){
        console.log(this.link);
        $scope.Link.remove({id : this.link.id});
        $scope.links = $scope.Link.query();
    }


    $scope.edit = function(){
        console.log(this.link)
        console.log($scope.linkForm);
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
