
<?php
require_once "../private/sql-bits.php";
            $conn = new mysqli($servername, $username, $password, $dbname);

            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
                echo("Connection failed: " . $conn->connect_error);
            }
?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>
<?php
   $query = $_GET['query'];
   // gets value sent over search form
       
       
       
       $raw_results = mysql_query("SELECT * FROM articles
           WHERE (`word` LIKE '%".$query."%')")  or die(mysql_error());
           
       if(mysql_num_rows($raw_results) > 0){            
           echo "No results";
       }
   
?>
</body>
</html>