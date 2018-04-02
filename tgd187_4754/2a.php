<html>
<body>
<?php

	//Global database variables
	define('HOST', 'mysql.cs.mun.ca');
	define('USER' , 'tgd187');
	define('PASS', 'MKhIIOVg');
	define('NAME' , 'cs4754_tgd187');

	//Connect to, & select, database
	$db = new mysqli(HOST, USER, PASS, NAME);
	if(!$db) { die('Cannot connect to database: '. mysql_error()); }

	//Get input from form
	$pname = $_POST['pname'];
	$checkedAttr = []; //Array of selected attributes to return

	//Check if attribute is selected; if so, add to array
	if (array_key_exists('sid', $_POST)){
			array_push($checkedAttr, 'S.'.$_POST['sid']);
	}
	if (array_key_exists('sname', $_POST)){
			array_push($checkedAttr, 'S.'.$_POST['sname']);
	}
	if (array_key_exists('address', $_POST)){
			array_push($checkedAttr, 'S.'.$_POST['address']);
	}
	if (array_key_exists("cost", $_POST)){
			array_push($checkedAttr, 'C.'.$_POST['cost']);
	}
	
	//Function to convert array to string
	function arrayToString($array){
		$aString = "";
		for($i = 0; $i < count($array); $i++){
			$aString .= $array[$i]; //Concatenate
			if ($i != count($array) - 1){
				$aString .= ', '; //Concatenate
			} 
		}
		return $aString;
	}
	
	//Query the database
	$sql = "SELECT ".arrayToString($checkedAttr)."
			FROM Suppliers S, Catalog C, Parts P
			WHERE S.sid = C.sid AND C.pid = P.pid AND P.pname = '$pname'";

	//Query result
	$result = mysqli_query($db, $sql);
	if (!$result){ die('Invalid query: ' . mysql_error()); }
	
	//Output
	if ($result->num_rows > 0){ 
		while($row = $result ->fetch_assoc()){
			foreach ($row as $info => $value){
				echo $info . ": $value <br>";
			}
			echo "<br>";
		}
	} else{ echo 'No results found'; }
	
	//Close database
	$db->close();
?>

<!--Back buttons-->
<p style="position: fixed; bottom: 0; width:100%; text-align: left"> 
<a href="main.html">&lt Home &gt</a>
<a href="2a.html">&lt Back &gt</a>
</p>

</body>
</html>
