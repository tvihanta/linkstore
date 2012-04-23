

angular.module('Linksy', ['ngResource']);

function LinkController($scope, $resource){
    $scope.Link = $resource('index.php/links/:id/');
    console.log($scope);
    $scope.links = $scope.Link.query();    
    $scope.addLink = function(){
        $scope.links.push({title:$scope.linkTitle, url:$scope.urlTitle, tags:[], img:""});
    };
    
    $scope.save = function(){
        console.log($scope.Link.$save);
        $scope.Link.save($scope.link);
        $scope.links = $scope.Link.query();
    }
    
}
