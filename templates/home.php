<!DOCTYPE html>
<html ng-app="Linksy"  lang="en">
<head>
  <title>Linksy</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
  <script src="static/angular-1.0.0rc6.min.js"></script>
  <script src="static/angular-resource-1.0.0rc6.min.js"></script>
  <script src="static/mediator.js"></script>
  <script src="static/app.js"></script>
  
  <link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="static/fa/css/font-awesome.css">
  <link href="static/uitheme/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css"> 
  <link href="static/linksy.css" rel="stylesheet" type="text/css">
 </head>
<body>
<div id="linksy-loader"><img src="static/img/loader.gif"/></div>
<div class="row-fluid">
    <div class="span12">
        <a href="/linkstore"><h1>Linksy!</h1></a>
    </div>    
</div>
<div class="row-fluid">
        <div ng-controller="TagController" id="tag-list" class="span2">
            <ul  class="linksy-tags">
                <li tag ng-repeat="tag in tags">
                    <div class="tag-text" style="display:inline;">
                        <a href="#tag/{{tag.tag}}">
                            {{tag.tag}}</a> <span>( {{tag.nbr}} )</span></div>
                    <div class="tag-input" style="display: none;">
                        <input type="text"  value="{{tag.tag}}" style="display:inline; float:left;"/>
                        <a ng-click="remove()"><i class="icon-remove"></i></a>
                    </div>
                    <a class="edit-link"><i class="icon-edit"></i></a>
                </li>
            </ul>
        </div>
        <div ng-controller="LinkController" ng-view id="links-container" class="span10">
            <form name="linkForm">
                <div class="editor" ng-class="{error:linkForm.title.invalid}"> 
                    <input id="url-input" type="url" name="linkUrl" ng-model="link.url" placeholder="url" required/>
                    <button ng-click="save()" class="btn" ng-disabled="linkForm.$invalid" >Save</button>
                    <span ng-show="linkForm.url.$error.url" class="inline-help">invalid url</span>
                    <br/>
                    <div>
                     <input type="text" name="linkTitle" ng-model="link.title" placeholder="title"  />
                    <input type="text" name="linkTags" ng-model="link.tags" id="tags" placeholder="tags" />
                    </div>
                </div>
            </form>
            <span id="tag-filter" ng-model="tagFilter">{{tagFilter}}</span>
            <table  class="linksy-link-table">
                <tr ng-repeat="link in links | orderBy:link.url" >
                    <td style="width: 50px;">
                        <div class="linksy-link-img" style="background: url({{link.img}}) no-repeat center center;"></div>    
                    </td>
                    <td><a href="{{link.url}}" >{{link.title}}</a></td>
                    <td>
                        ( <span ng-repeat="tag in link.tags">{{tag}} </span>)
                    </td>
                    <td><a ng-click="destroy()"  class="remove-link"><i class="icon-remove icon-large"></i></a></td>
                    <td><a ng-click="edit()"  class="edit-link"><i class="icon-edit icon-large"></i></a></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
