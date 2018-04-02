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
	$pid = $_POST['pid'];
	//Query the database
	$sql = "SELECT  S.sname, S.address
			FROM Suppliers S, Catalog C, Parts P
			WHERE C.pid = P.pid AND C.sid = S.sid AND P.pid = '$pid' AND C.cost = (
						SELECT MAX(C1.cost)
						FROM Catalog C1
						WHERE C1.pid = P.pid)";

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
<a href="2c.html">&lt Back &gt</a>
</p>

</body>
</html>
