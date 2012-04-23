<!DOCTYPE html>
<html ng-app="Linksy">
<head>
  <title>Linksy</title>
  
  <script src="static/angular-1.0.0rc6.min.js"></script>
  <script src="static/angular-resource-1.0.0rc6.min.js"></script>
  <script src="static/app.js"></script>
 </head>
<body>

<h1>Linksy!</h1>



<div ng-controller="LinkController">

<form name="linkForm">
    <div class="editor" ng-class="{error:linkForm.title.invalid}"> 
        <input type="text" name="title" ng-model="link.title" placeholder="title" required />
        <input type="text" name="url" ng-model="link.url" placeholder="url" required />
        <input type="text" name="tags" ng-model="link.tags" placeholder="tags" required />
        <button ng-click="save()" >Save</button>
    </div>
</form>
<table ng-repeat="link in links">
    <tr>
        <td>{{link.title}}</td>
        <td>{{link.url}}</td>
        <td>{{link.tags}}</td>
    </tr>
</table>

</div>


</body>
</html>
