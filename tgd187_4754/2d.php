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
	$address = $_POST['address'];
	$color = $_POST['color'];
	//Query the database
	$sql = "SELECT P.pname 
			FROM  Parts P
			WHERE  NOT EXISTS (SELECT S.sid
							FROM  Suppliers S
							WHERE  S.address = '$address' AND 
						NOT EXISTS
							(SELECT  C.sid
							FROM  Catalog C
							WHERE C.pid = P.pid AND C.sid = S.sid AND P.color = '$color'))";

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
<a href="2d.html">&lt Back &gt</a>
</p>

</body>
</html>
