<?php

function mergeQueryParameters() {
	$queryParameters = [
		'mainGuestName' => null,
		'mainGuestIsComing' => null,
		'mainGuestIsComingWithSomebody' => null,
		'plusOneName' => null,
		'mainGuestIsComintWithKid' => null,
		'kidsCount' => null,
		'shouldProvideKidsChair' => null,
		'mainGuestIsVegetarian' => null,
		'guestPlusOneIsVegetarian' => null,
		'guestCount' => null,
		'message' => '',
	];
	return array_merge($queryParameters, $_POST);

}

function parseQueryParameters($parameters) {
	return array_map(
		function($parameter) {
			if($parameter == "True") {
				return 1;
			} else if($parameter == "False" || is_null($parameter)) {
				return 0;
			}
			return $parameter;
		},
		$parameters
	);
}

function getQueryParameters() {
	$queryParameters = mergeQueryParameters();
	return parseQueryParameters($queryParameters);
}

function connectToDB() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "test";

	try {
	    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	    // set the PDO error mode to exception
	    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    return $connection;
    }
	catch(PDOException $e)
    {
    	echo "Connection to database failed";
    }
}

function insertIntoDB($params) {
	$connection = connectToDB();
	$statement = $connection->prepare("
		INSERT INTO guests (
			main_guest_name,
			main_guest_is_coming,
			main_guest_is_coming_with_somebody,
			plus_one_name,
			main_guest_is_coming_with_kid,
			number_of_kids,
			should_provide_kids_chair,
			main_guest_is_vegetarian,
			guest_plus_one_is_vegeterian,
			message
		)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
	);

	$statement->bindParam(1, $params['mainGuestName']);
	$statement->bindParam(2, $params['mainGuestIsComing']);
	$statement->bindParam(3, $params['mainGuestIsComingWithSomebody']);
	$statement->bindParam(4, $params['plusOneName']);
	$statement->bindParam(5, $params['mainGuestIsComintWithKid']);
	$statement->bindParam(6, $params['kidsCount']);
	$statement->bindParam(7, $params['shouldProvideKidsChair']);
	$statement->bindParam(8, $params['mainGuestIsVegetarian']);
	$statement->bindParam(9, $params['guestPlusOneIsVegetarian']);
	$statement->bindParam(10, $params['message']);

	$statement->execute();

	header('Location: /');
}

function save() {
	$queryParameters = getQueryParameters();
	insertIntoDB($queryParameters);
}

save();