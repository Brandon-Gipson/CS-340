<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","gipsonb-db","FMePWvFDMglv6uA4","gipsonb-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<body>
<h1> Welcome to the World of Warcraft Guild: No Moral Compass!</h1>
<br>
<h3>Display:</h3>
<!-- Displays the Players -->
<div>
	<table>
		<tr>
			<td><h4>Players:</h4></td>
		</tr>
		<tr>
			<td>Name</td>
			<td>Age</td>
			<td>Time Zone</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT name, age, timezone FROM player"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name, $age, $timezone)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $age . "\n</td>\n<td>\n" . $timezone . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div> 
<br>
<!-- Displays the Characters -->
<div>
	<table>
		<tr>
			<td><h4>Characters:</h4></td>
		</tr>
		<tr>
			<td>Name</td>
			<td>Level</td>
			<td>Class</td>
			<td>Primary Role</td>
			<td>Secondary Role</td>
			<td>Played By</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT c.name, c.cLevel, pc.className, r1.roleType, r2.roleType, p.name FROM pCharacter c INNER JOIN player p ON p.id = c.pid INNER JOIN playable_classes pc ON pc.id = c.classId JOIN roles AS r1 ON r1.id = c.primaryRole JOIN roles AS r2 ON r2.id = c.secondaryRole"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name, $level, $classID, $role1, $role2, $pid)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $level . "\n</td>\n<td>\n" . $classID . "\n</td>\n<td>\n" . $role1 . "\n</td>\n<td>\n" . $role2 . "\n</td>\n<td>\n" . $pid . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div> 
<br>
<!-- Displays the Classes -->
<div>
	<table>
		<tr>
			<td><h4>Classes:</h4></td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT className FROM playable_classes"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $name . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div> 
<br>
<!-- Displays the Roles -->
<div>
	<table>
		<tr>
			<td><h4>Role Types:</h4></td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT roleType FROM roles"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($roleType)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $roleType . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div> 
<br>
<h3>Add:</h3>
<!-- The following div allows for user input into the player table -->
<div>
	<form method="post" action="addplayer.php" autocomplete="off">  <!-- Sends form data to the character add handler -->

		<fieldset>
			<legend>Enter Player Info</legend>
			<p>Name: <input type="text" name="CharacterName" /></p>
			<p>Age: <input type="text" name="age" /></p>
			<p>Time Zone: <input type="text" name="timezone" /></p>
		</fieldset>
		<p><input type="submit" value="Add"/></p>
	</form>
</div>
<br>
<!-- The following div allows for user unput into the pCharacter table -->
<div>
	<form method="post" action="addcharacter.php" autocomplete="off">  <!-- Sends form data to the character add handler -->

		<fieldset>
			<legend>Enter Character Info</legend>
			<p>Name: <input type="text" name="CharacterName" /></p>
			<p>Level: <input type="text" name="level" /></p>
			
			<!-- Displays available classes to choose from the playable_classes table -->
			<p>Class: <select name="class"> 
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, className FROM playable_classes"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($cid, $cname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $cid . ' "> ' . $cname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
			
			<!-- Displays available roles to choose from the role table -->
			<p>Primary Role: <select name="role1"> 
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, roleType FROM roles"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($rid, $rname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $rid . ' "> ' . $rname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>	
			
			<!-- Displays available roles to choose from the role table -->
			<p>Secondary Role: <select name="role2"> 
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, roleType FROM roles"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($rid, $rname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $rid . ' "> ' . $rname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>	
			
			<!-- Displays available players to choose from the players table -->
			<p>Player: <select name="player">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, name FROM player"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
		</fieldset>
		<p><input type="submit" value="Add"/></p>
	</form>
</div>
<br>
<div>
	<form method="post" action="addclass.php" autocomplete="off">  <!-- Sends form data to the character add handler -->

		<fieldset>
			<legend>Add a class</legend>
			<p>Name: <input type="text" name="ClassName" /></p>
		</fieldset>
		<p><input type="submit" value="Add"/></p>
	</form>
</div>
<br>
<div>
	<form method="post" action="addrole.php" autocomplete="off">  <!-- Sends form data to the character add handler -->

		<fieldset>
			<legend>Add a role</legend>
			<p>Role Type: <input type="text" name="roleName" /></p>
		</fieldset>
		<p><input type="submit" value="Add"/></p>
	</form>
</div>
<br>

<h3>Update:</h3>
<!-- The following div allows for updating existing elements in the player table -->
<div>
	<form method="post" action="updateplayer.php" autocomplete="off">  <!-- Sends form data to the character update handler -->

		<fieldset>
			<legend>Update Player Info</legend>
			<p>Player to Update: <select name="player">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, name FROM player"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
			<p>Name: <input type="text" name="CharacterName" /></p>
			<p>Age: <input type="text" name="age" /></p>
			<p>Time Zone: <input type="text" name="timezone" /></p>
		</fieldset>
		<p><input type="submit" value="Update"/></p>
	</form>
</div>
<br>
<!-- The following div allows for users to update the data in the pCharacter table -->
<div>
	<form method="post" action="updatecharacter.php" autocomplete="off">  <!-- Sends form data to the character update handler -->

		<fieldset>
			<legend>Update Character Info</legend>
			<p>Character to Update: <select name="character">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, name FROM pCharacter"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
			<p>Name: <input type="text" name="CharacterName" /></p>
			<p>Level: <input type="text" name="level" /></p>
			
			<!-- Displays available classes to choose from the playable_classes table -->
			<p>Class: <select name="class"> 
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, className FROM playable_classes"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($cid, $cname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $cid . ' "> ' . $cname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
			
			<!-- Displays available roles to choose from the role table -->
			<p>Primary Role: <select name="role1"> 
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, roleType FROM roles"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($rid, $rname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $rid . ' "> ' . $rname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>

			<!-- Displays available roles to choose from the role table -->
			<p>Secondary Role: <select name="role2"> 
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, roleType FROM roles"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($rid, $rname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $rid . ' "> ' . $rname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
			
			<!-- Displays available players to choose from the players table -->
			<p>Player: <select name="player">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, name FROM player"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
		</fieldset>
		<p><input type="submit" value="Update"/></p>
	</form>
</div>
<br>
<div>
	<form method="post" action="updateclass.php" autocomplete="off">  <!-- Sends form data to the character update handler -->

		<fieldset>
			<legend>Update a class</legend>
			<p>Class to Update: <select name="class">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, className FROM playable_classes"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
			<p>Name: <input type="text" name="newName" /></p>
		</fieldset>
		<p><input type="submit" value="Update"/></p>
	</form>
</div>
<br>
<div>
	<form method="post" action="updaterole.php" autocomplete="off">  <!-- Sends form data to the role update handler -->

		<fieldset>
			<legend>Update a role</legend>
			<p>Role to Update: <select name="role">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, roleType FROM roles"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
			<p>Role Type: <input type="text" name="roleName" /></p>
		</fieldset>
		<p><input type="submit" value="Update"/></p>
	</form>
</div>
<br>
<h3>Delete:</h3>
<div>
	<form method="post" action="deleteplayer.php" autocomplete="off">  <!-- Sends form data to the character add handler -->

		<fieldset>
			<legend>Delete Player Info</legend>
			<p>Player to Delete: <select name="player">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, name FROM player"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
		</fieldset>
		<p><input type="submit" value="Delete"/></p>
	</form>
</div>
<br>
<!-- The following div allows for user unput into the pCharacter table -->
<div>
	<form method="post" action="deletecharacter.php" autocomplete="off">  <!-- Sends form data to the character add handler -->

		<fieldset>
			<legend>Delete Character Info</legend>
			<p>Character to Delete: <select name="character">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, name FROM pCharacter"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
		</fieldset>
		<p><input type="submit" value="Delete"/></p>
	</form>
</div>
<br>
<div>
	<form method="post" action="deleteclass.php" autocomplete="off">  <!-- Sends form data to the character add handler -->

		<fieldset>
			<legend>Delete a class</legend>
			<p>Class to Delete: <select name="class">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, className FROM playable_classes"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
		</fieldset>
		<p><input type="submit" value="Delete"/></p>
	</form>
</div>
<br>
<div>
	<form method="post" action="deleterole.php" autocomplete="off">  <!-- Sends form data to the character add handler -->

		<fieldset>
			<legend>Delete a role</legend>
			<p>Role to Delete: <select name="role">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, roleType FROM roles"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
		</fieldset>
		<p><input type="submit" value="Delete"/></p>
	</form>
</div>
<br>
<h3>Filters:</h3>
<!-- Filters all characters by inputed player -->
<div>
	<form method="post" action="filteralt.php" autocomplete="off">
		<fieldset>
			<legend>Filter Characters By Player</legend>
				<p>Player: <select name="alt">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, name FROM player"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
		</fieldset>
		<br>
		<input type="submit" value="Run Filter" />
	</form>
</div>
<br>
<!-- Filters all characters by inputed role -->
<div>
	<form method="post" action="filterrole.php" autocomplete="off">
		<fieldset>
			<legend>Filter Characters By Role</legend>
				<p>Role: <select name="classRole">
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, roleType FROM roles"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($pid, $pname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
				}
				$stmt->close();
			?>
			</select></p>
		</fieldset>
		<br>
		<input type="submit" value="Run Filter" />
	</form>
</div>
	
</body>
</html>