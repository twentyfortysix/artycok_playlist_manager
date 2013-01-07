// add the filter to your application module
angular.module('PlaylistBuilder', ['filters']);
/**
 * Truncate Filter
 * @Param string
 * @Param int, default = 10
 * @Param string, default = "..."
 * @return string
 */

/*
angular.module('filters', []).
	filter('truncate', function () {
		return function (text, length, end) {
			if (isNaN(length))
				length = 10;

			if (end === undefined)
				end = "...";

			if (text.length <= length || text.length - end.length <= length) {
				return text;
			}
			else {
				return String(text).substring(0, length-end.length) + end;
			}

		};
	});
*/	
function SectionForm($scope, $http){
	//~ get the prices from the external json file
	$scope.structure = {};

	$http.get('tree03.php')
	// $http.get('fake.php')
	.then(function(res){
		jsonData = res.data;
		$scope.structure = jsonData;
	});
		$scope.addTodo = function() {
		$scope.todos.push({text:$scope.todoText, done:false});
		$scope.todoText = '';
	  };
	 
	  $scope.remaining = function() {
		var count = 0;
		angular.forEach($scope.todos, function(todo) {
		  count += todo.done ? 0 : 1;
		});
		return count;
	  };
	 
	  $scope.archive = function() {
		var oldTodos = $scope.todos;
		$scope.todos = [];
		angular.forEach(oldTodos, function(todo) {
		  if (!todo.done) $scope.todos.push(todo);
		});
	  };
	
}		
	/*
	//~ add new button type
	$scope.add = function(item) {
		$scope.master.sections.push(item);
	};
	//~ remove checked button types
	//~ $scope.rem = function(section) {
		//~ $scope.master.sections = _.filter($scope.master.sections, function(section){
			//~ return !section.deleteme;
		//~ });
	//~ };
	//~ remove checked button types
	$scope.del = function(section) {
		$scope.master.sections.splice($scope.master.sections.indexOf(section), 1);
	};
	
	//~ add new defaults
	//~ $scope.append_button = function() {
		//~ $scope.
	//~ };
	$scope.total_price_func = function(b_amount) {
		var ActSections = [];
		var ActSection = [];
		var ActButton = [];
		
		var the_sum = 0;
		var amountToPrice =$scope.master.amount_to_price;
		var preparationToPrice =$scope.master.preparation_to_price;
		var postageToPrice =$scope.master.postage_to_price;
		
		//~ console.log(amountToPrice);
		jsonObj = angular.toJson($scope.master.sections);
		//~ console.log(jsonObj);
		//~ loop through sections
		var i = 0;
		var postage_actual_price = 0;
		angular.forEach($scope.master.sections, function(value, key){
			i = i + 1;
			ActSections = key;
			//~ console.log(key + ': ' + value);
			//~ loop through each section
			angular.forEach(value, function(value, key){
				ActSection = key;
				 //~ console.log('--' + key + ': ' + value);
				 //~ the rest for buttons
				if (key == "buttons"){
					//~ loop through each buttons
					 angular.forEach(value, function(value, key){
						 ActButton = key;
						 //~ console.log('----' + key + ': ' + value);
						 var each_amount = 0;
						 var each_type = 0;
						 var prep = 0;
						 angular.forEach(value, function(value, key){
							if(key == "amount"){
								 each_amount = parseInt(value);
							}
							if(key == "type"){
								 each_type = value;
							}
							if(key == "preparation"){
								 prep = value;
							}
							//~ console.log('------' + key + ': ' + value);
						});
						//~ define var for actual price level the user set in the form
						var price_level = 1;
						//~ get the actual price level determined by number of buttons
						angular.forEach(amountToPrice[0], function(value, key){
							if(each_amount > key){
								price_level = key;
							}
						});
						
						var preparation_actual_price = 0;
						angular.forEach(preparationToPrice[0], function(value, key){
							if(prep == key){
								preparation_actual_price = value;
							}
						});
						
						
						//~ console.log();
						//~ determin the button price - based on the ammount and the button type
						var price_per_item_in_cur_level = amountToPrice[0][price_level][0][each_type];
						$scope.master.sections[ActSections].buttons[ActButton].actual_item_price = price_per_item_in_cur_level;
						//~ console.log('type = ' + each_type + '-' + price_per_item_in_cur_level);
						buttons_price = (each_amount * price_per_item_in_cur_level) + preparation_actual_price ;
						//~ WRITE THAT actual sum per button type back to the master object
						$scope.master.sections[ActSections].buttons[ActButton].actual_sum = buttons_price;
						//~ console.log($scope.master.sections[ActSections].buttons[ActButton].actual_sum);
						//~ console.log('sum: ' + buttons_price);
						
					});
					the_sum = the_sum + buttons_price;
					
				}
			});
			//~ write the number iteration to the global count val
			$scope.master.button_number = i;
			//~ console.log('total price: ' + the_sum);
			//~ console.log('----------');
			angular.forEach(postageToPrice[0], function(value, key){
				if($scope.master.postage == key){
					postage_actual_price = value;
				}
			});
			$scope.master.total_price = the_sum + postage_actual_price;
			
		});
	}
	//~ THIS has to be changed according to the real link!
	$scope.url = 'http://localhost/mysquare/objednavka';
	$scope.submit = function() {
		 // Create the http post request
		// the data holds the keywords
		// The request is a JSON request.
		$http.post($scope.url, { "data" : $scope.master}).
		success(function(data, status) {
			$scope.status = status;
			$scope.data = data;
			$scope.result = data; // Show result from server in our <pre></pre> element
		})
		.
		error(function(data, status) {
			$scope.data = data || "EHhm, někdo vytáhl kabel ze zdi. Radši nám napište email... mysquare@mysquare.cz";
			$scope.status = status;		 
		});
		//~ console.log($scope.data);
	};
}
*/