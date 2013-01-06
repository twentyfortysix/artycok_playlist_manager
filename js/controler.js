this.myApp = angular.module('myApp', ['ui']);

function PhoneListCtrl($scope, $filter, $parse, $http) {
	// get the external JSON file 
	$http.get('tree03.php').success(function(data) {
		$scope.items = data;
	});

	$scope.videos = [];

	// setter for done
	$scope.doneTrue = function() {
		this.item.done = true;
		$scope.videos.push(this.item);
	};
	// setter for done
	$scope.doneFalse = function() {
		this.item.done = false;
		$scope.videos.splice($scope.videos.indexOf(this.item), 1);
	};
$scope.justRemove = function(obj) {
        $scope.videos.splice(obj, 1);
    };

	$scope.update = function($parse) {
		var e, i, _i, _len, _ref, test;
		// unfiltered array
		// _ref = $scope.isStatus($scope.items);
		
		// filter the items for done:true items
		_ref = $filter('filter')($scope.videos, {'done': true});
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
}