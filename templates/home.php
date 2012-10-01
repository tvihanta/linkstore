<!DOCTYPE html>
<html ng-app="Linksy">
<head>
  <title>Linksy</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
  <script src="static/angular-1.0.0rc6.min.js"></script>
  <script src="static/angular-resource-1.0.0rc6.min.js"></script>
  <script src="static/app.js"></script>
  
  <link href="static/uitheme/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css"> 
  <link href="static/linksy.css" rel="stylesheet" type="text/css">
 </head>
<body>

<h1>Linksy!</h1>

<div id="linksy-loader"><img src="static/img/loader.gif"/></div>
<div ng-controller="TagController" id="tag-list">
    <ul  class="linksy-tags">
        <li ng-repeat="tag in tags">
            {{tag.tag}} <span>( {{tag.nbr}} )</span>
        </li>
    </ul>

</div>
<div ng-controller="LinkController" id="links-container">

<form name="linkForm">
    <div class="editor" ng-class="{error:linkForm.title.invalid}"> 
      
        <input style="width: 100%; font-size: 18px;" type="url" name="linkUrl" ng-model="link.url" placeholder="url" required/>
        <span ng-show="linkForm.url.$error.url" class="inline-help">invalid url</span>
        <br/>
        <div>
         <input type="text" name="linkTitle" ng-model="link.title" placeholder="title"  />
        <input type="text" name="linkTags" ng-model="link.tags" id="tags" placeholder="tags" />
        </div>
        <button ng-click="save()" ng-disabled="linkForm.$invalid" >Save</button>
    </div>
</form>

<table  class="linksy-link-table">
    <tr ng-repeat="link in links">
        <td style="width: 100px;"><img src="{{link.img}}" alt="{{link.title}}" class="linksy-link-img"></td>
        <td><a href="{{link.url}}" >{{link.title}}</a></td>
        <td>{{link.tags}}</td>
        <td><a href="#remove" ng-click="destroy()"  class="remove-link">x</a></td>
        <td><a href="#edit" ng-click="edit()"  class="edit-link">m</a></td>
    </tr>
</table>
</div>
    <script>
        function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}
    
        $(document).ready(function(){
            $( "#tags" ).autocomplete({
			        source: 'index.php/tags/',
			        focus: function() {
					    // prevent value inserted on focus
					    return false;
				    },
				    select: function( event, ui ) {
					    var terms = split( this.value );
					    // remove the current input
					    terms.pop();
					    // add the selected item
					    terms.push( ui.item.value );
					    // add placeholder to get the comma-and-space at the end
					    terms.push( "" );
					    this.value = terms.join( ", " );
					    return false;
				    }
			    });
        });
    </script>
</body>
</html>
