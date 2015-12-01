<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","gipsonb-db","FMePWvFDMglv6uA4","gipsonb-db");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<body>
<div>
	<table>
		<tr>
			<td><h2>Characters Sorted by Their Role</h2></td>
		</tr>
		<tr>
			<td>Character Name</td>
			<td>Level</td>
			<td>Class</td>
		</tr>
	
<?php
if(!($stmt = $mysqli->prepare("SELECT c.name, c.cLevel, pc.className FROM pCharacter c INNER JOIN playable_classes pc ON c.classId = pc.id INNER JOIN roles AS r1 ON r1.id = c.primaryRole INNER JOIN roles AS r2 ON r2.id = c.secondaryRole WHERE r.id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param("i",$_POST['classRole']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name, $level, $class)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $level . "\n</td>\n<td>\n" . $class . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>
<br>
<button onclick="history.go(-1);">Back </button> <!-- Found @ http://stackoverflow.com/questions/3659782/code-for-back-button -->
</body>
</html>