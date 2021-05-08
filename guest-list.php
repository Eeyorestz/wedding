<?php
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

function getGuests() {
	$connection = connectToDB();
	return $connection
		->query("SELECT * FROM guests LIMIT 500")
		->fetchAll();
}

function drawTable(){
	$guests = getGuests();
	// var_dump($guests);
	echo "<table border=1>"; 
		echo "<tr>"; 
			echo "<td>ID</td>"; 
			echo "<td>Guest name</td>"; 
			echo "<td>Main Guest will come</td>";
			echo "<td>Is coming with somebody</td>"; 
			echo "<td>Plus one name</td>";
			echo "<td>Is coming with kid</td>"; 
			echo "<td>Kids number</td>"; 
			echo "<td>shouldProvideKidsChair</td>"; 
			echo "<td>mainGuestIsVegetarian</td>"; 
			echo "<td>guestPlusOneIsVegetarian</td>"; 
			echo "<td>Message</td>"; 
		echo "</tr>"; 
		foreach($guests as $guest){
			echo "<tr>"; 
				echo "<td>" . $guest['id']. "</td>"; 
				echo "<td>" . $guest['main_guest_name']. "</td>"; 
				echo "<td>" . $guest['main_guest_is_coming']. "</td>"; 
				echo "<td>" . $guest['main_guest_is_coming_with_somebody']. "</td>"; 
				echo "<td>" . $guest['plus_one_name']. "</td>"; 
				echo "<td>" . $guest['main_guest_is_coming_with_kid']. "</td>"; 
			    echo "<td>" . $guest['number_of_kids']. "</td>"; 
				echo "<td>" . $guest['should_provide_kids_chair']. "</td>"; 
				echo "<td>" . $guest['main_guest_is_vegetarian']. "</td>"; 
				echo "<td>" . $guest['guest_plus_one_is_vegeterian']. "</td>"; 
				echo "<td>" . $guest['message']. "</td>"; 
			echo "</tr>"; 
		}
	echo "</table>";
}

drawTable();