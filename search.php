<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>
<?php 
            if(isset($_POST[‘submit-search’])){
                $search=mysqli_real_escape_string($conn,$POST[‘search’]);
                $sql=“SELECT * FROM words WHERE WordText LIKE ‘%$search%’”;
                $result=mysqli_query($conn,$sql);
                $queryResult=mysqli_num_row($result);
                if($queryResult=0){
                    echo "There are 0 result."
                }
            }
                
                ?>
    </body>
</html>