this.myApp = angular.module('myApp', ['ui']);
// fade in custom directive when item is added by ng-repeat
// myApp.directive('fadey', function() {
// 	return {
//         // restrict: 'A',
//         link: function(scope, elm, attrs) {
//         	var duration = parseInt(attrs.fadey);
//         	if (isNaN(duration)) {
//         		duration = 200;
//         	}
//         	elm = jQuery(elm);
//         	elm.hide();
//         	elm.fadeIn(duration)

//         	scope.destroy = function(complete) {
//         		elm.fadeOut(duration, function() {
//         			if (complete) {
//         				complete.apply(scope);
//         			}
//         		});
//         	};
//         }
//     };
// });

function PhoneListCtrl($scope, $filter, $parse, $http) {
	$scope.default_playlist_error = '';
	$scope.items_error = '';
	// IP of the TV box
	$scope.box_IP = '';
	// get default playlist
	$scope.default_playlist = [];
	$http.get('http://manager.artycok.tv/?page_id=15').success(function(data) {
		if (typeof data=="object"){
			$scope.default_playlist = data;
		}else{
			$scope.default_playlist = [];
			$scope.default_playlist_error = '<div class="alert alert-error">Nepodařilo se načíst data</div>';
		}

	});
	
	// get the external JSON file of all videos
	$scope.videos = [];
	$http.get('http://manager.artycok.tv/?page_id=12').success(function(data) {
		if (typeof data=="object"){
			$scope.items = data;
			// pus the filtred items to videos
			// videos have lateer proper position index when sorted by user
			// unlike items which index is recounted in general of all items no mattar what "dona" state they have
			// in other words: Videos are just helper
			$scope.videos = $filter('filter')($scope.items, {'done': true});
		}else{
			$scope.videos = [];
			$scope.items = [];
			$scope.items_error = '<div class="alert alert-error">Nepodařilo se načíst data</div>';
		}
	});

	// $scope.videos = data;
	// if true vidluv playlist will be used instead
	$scope.playlist_switch = '';
	// answer from the saving process
	$scope.answer = '';
	// nonce for security
	//  used in the form data transaction
	$scope.nonce = '';
	// if chekbox checked during save the remote TV box will restart it's browser
	$scope.force_tv_restart = '';
	
	// setter for done
	$scope.doneTrue = function() {
		this.item.done = true;
		$scope.videos.push(this.item);
		$scope.update;
	};
	// setter for done
	$scope.doneFalse = function() {
		this.item.done = false;
		// reset position
		this.item.pos = 0;
		// remove this from the vides array
		$scope.videos.splice($scope.videos.indexOf(this.item), 1);
	};
	// cear filter
	 $scope.clearFilter = function() {
      $scope.query = '';
    };
	$scope.showModal = function(video) {
		// define the video link out of the curent object
		video_link = 'rtmp://server5.streaming.cesnet.cz/vod/_definst_/others/avu/artycok/' + video;
		//  setup jwplayer
		jwplayer('player_modal').setup({
			file: video_link,
			autostart: "true",
	    	width: 510,
	    	height: 305
	    });
	    //  show the player in the bootstrap modal view
		$('#myModal').modal();
	};

	$scope.update = function($parse) {
		var e, i, _i, _len, _ref, test;
		// unfiltered array
		// _ref = $scope.isStatus($scope.items);
		
		// filter the items for done:true items
		_ref = $filter('filter')($scope.videos, {'done': true});

		// _ref = $scope.videos;
		// write item position to pos value
		// 
		// the index is not correct becausei is counted 
		// for the whole array indexes
		// not current sortable ui index !
		// 
		for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
			e = _ref[i];
			// console.log('p:' + e.pos + ' i:' + i);
			e.pos = i;
			// console.log(e.pos + '>' + e.name);
		}
		// console.log('===========');
		// return console.log(["Updated", $scope.items]);
	};
	// load the default playlist in the user playlist
	$scope.loadDefaultPlaylist = function(){
		// merge the default playlist values with the whole items array
		// basicaly change the "done" value to "true"
		angular.forEach($scope.items, function(i_value, i_key){
			angular.forEach($scope.default_playlist, function(p_value, p_key){
				if(i_value.name == p_value.name){
					i_value.done = true;
				}
			});
		});
		// update scope.videos
		$scope.videos = $filter('filter')($scope.items, {'done': true});
	};
	//~ THIS has to be changed according to the real link!
	// var url = 'http://localhost/artycokTV/wordpress/wp-content/themes/manager/helper.php';
	var url = 'http://manager.artycok.tv/?page_id=10';
	$scope.submit = function() {
		 // Create the http post request
		// the data holds the keywords
		// The request is a JSON request.
		var message = {
			'playlist' : $scope.videos,
			'playlist_switch' : $scope.playlist_switch,
			'nonce' : $scope.nonce,
			'box_IP' : $scope.box_IP,
			'force_tv_restart' : $scope.force_tv_restart
		};
		$http.post(url, { "data" : message}).
		success(function(data, status) {
			$scope.status = status;
			$scope.answer = data;
		}
		)
		.
		error(function(data, status) {
			$scope.answer = data || "EHhm, někdo vytáhl kabel ze zdi. Radši nám napište email... 2046@artycok.cz";
			$scope.status = status;         
		});
	};
}