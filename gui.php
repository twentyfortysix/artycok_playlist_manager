<!doctype html>
<html lang="en" ng-app>
<head>
	<meta charset="utf-8">
	<title>My HTML File</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="js/angular.min.js"></script>
	<script src="js/controler.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
</head>
<body ng-app="playlistManager"  ng-controller="PhoneListCtrl">
	<div class="container">
		<div class="row">
			<div class="span4 offset4">
				<!--Sidebar content-->
				Celkovy pocet videi: {{structure.length}} 
				<br>
				<input type="text" class="wide" ng-model="query" placeholder="filter">

			</div>
			<div class="span4 offset4">
				<!--Body content-->

				<ul class="items">
					<li ng-repeat="item in structure | filter:query | filter:{done:false}" ng-click="doneTrue()">
						<!--<input type="checkbox" ng-model="item.done">-->{{item.name}}

						<div class="hide">
							<br><small><b>360p: </b>{{item.360p}}</small>
							<br><small><b>720p: </b>{{item.720p}}</small>
							<br><small><b>1080p: </b>{{item.1080p}}</small>
						</div>
					</li>
				</ul>
			</div>

			<div class="span4">
				<h4>Playlist</h4>
				<div class="thumbnail">
					<ul class="items playlist" id="sortable">
						<li ng-repeat="item in structure | filter:{done:true} | orderBy:order" > <!--  ng-bind="item"  -->
							<span class="item" >i:{{$index}} o:{{item.order}} <input type="text" value="{{item.order}}" ng-model="item.order" class="tiny order_number"> {{item.name}}</span> <i class="icon-eject" ng-click="doneFalse()"></i>
						</li>
					</ul>
					<form action="">
						<input type="submit" class="btn wide btn-success" value="save">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>