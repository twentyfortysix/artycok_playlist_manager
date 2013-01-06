<html ng-app="myApp">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Angular ui-sortable Directive - jsFiddle demo</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

	<script src="js/angular.min.js"></script>
	<script src="js/angular-ui.min.js"></script>
	<!--<script src="js/angular-ui.sortable.js"></script>-->

	<script src="js/controler.js"></script>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>

<body class="ng-scope">
	<div class="container" ng-controller="PhoneListCtrl">
		<div class="row">
			<div class="span4 offset4">
				<!--Sidebar content-->
				Celkovy pocet videi: {{items.length}} 
				<br>
				<input type="text" class="wide" ng-model="query" placeholder="filter">
				
			</div>
			<div class="span4 offset4">
				<!--Body content-->

				<ul class="items">
					<li ng-repeat="item in items | filter:{done:false} | filter:query " ng-click="doneTrue()" class="item">
						<!--<input type="checkbox" ng-model="item.done">-->{{item.pos}} / {{item.name}}

						<!-- <div class="hide">
							<br><small><b>360p: </b>{{item.360p}}</small>
							<br><small><b>720p: </b>{{item.720p}}</small>
							<br><small><b>1080p: </b>{{item.1080p}}</small>
						</div> -->
					</li>
				</ul>
			</div>
			<div class="span4">
				<h4>Playlist</h4>
				<div class="thumbnail">
					
					<ul ui-sortable ui-options="{update: update, axis: 'y'}" ng-model="items">
						<li ng-repeat="item in items | filter:{done:true}">
							<span class="item">i{{$index}} {{ item.pos }} / {{ item.name }}</span> <i class="icon-eject" ng-click="doneFalse()"></i>
						</li>
					</ul>					
				</div>
			</div>
		</div>
		<ul ui-sortable ui-options="{update: update, axis: 'y'}" ng-model="videos">
			<li ng-repeat="item in videos | orderBy:pos:reverse" >
				{{item.pos}} / {{item.name}} <i class="icon-eject" ng-click="doneFalse()"	></i>
			</li>
		</ul>
		
		<!-- <pre ng-bind="videos | orderBy:pos | json "></pre> -->
	</div>
</body>
</html>
