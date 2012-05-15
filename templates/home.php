<!DOCTYPE html>
<html ng-app="Linksy">
<head>
  <title>Linksy</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
  <script src="static/angular-1.0.0rc6.min.js"></script>
  <script src="static/angular-resource-1.0.0rc6.min.js"></script>
  <script src="static/app.js"></script>
   
  <link href="static/linksy.css" rel="stylesheet" type="text/css">
 </head>
<body>

<h1>Linksy!</h1>


<div ng-controller="LinkController">

<form name="linkForm">
    <div class="editor" ng-class="{error:linkForm.title.invalid}"> 
        <input type="text" name="linkTitle" ng-model="link.title" placeholder="title"  />
        <input type="url" name="linkUrl" ng-model="link.url" placeholder="url" required/>
        <span ng-show="linkForm.url.$error.url" class="inline-help">invalid url</span>
        <input type="text" name="linkTags" ng-model="link.tags" id="tags" placeholder="tags" />
        <button ng-click="save()" ng-disabled="linkForm.$invalid" >Save</button>
    </div>
</form>
<table ng-repeat="link in links">
    <tr>
        <td>{{link.title}}</td>
        <td>{{link.url}}</td>
        <td>{{link.tags}}</td>
        <td><a href="#remove" ng-click="destroy()"  class="remove-link">x</a></td>
        <td><a href="#edit" ng-click="edit()"  class="edit-link">m</a></td>
    </tr>
</table>

</div>

<script>
    $(document).ready(function(){
        $( "#tags" ).autocomplete({
			    source: 'index.php/tags/'
			});
    });
</script>
</body>
</html>
