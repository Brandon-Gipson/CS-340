<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","gipsonb-db","FMePWvFDMglv6uA4","gipsonb-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
	
if(!($stmt = $mysqli->prepare("UPDATE player SET name = ?, age = ?, timezone = ? WHERE id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("sisi",$_POST['CharacterName'],$_POST['age'],$_POST['timezone'], $_POST['player']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Updated " . $stmt->affected_rows . " rows to player table.";
}
?>
<br>
<button onclick="history.go(-1);">Back </button> <!-- Found @ http://stackoverflow.com/questions/3659782/code-for-back-button -->