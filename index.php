<!DOCTYPE HTML>
<html lang="en">
    <head>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="dictionary.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
        <script src='https://cdn.rawgit.com/naptha/tesseract.js/1.0.10/dist/tesseract.js'></script>

    </head>
    <body>
        <?php 
            require_once "../private/sql-bits.php";
            $conn = new mysqli($servername, $username, $password, $dbname);

            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
                echo("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM words ORDER BY WordID DESC";
            $result = $conn->query($sql);

            if($result->num_rows >0){
                while($row = $result->fetch_assoc()){
                    $wordID[] = $row["WordID"];
                    $wordDate[] = $row["WordDate"];
                    $word[] = $row["WordText"];
                    $wordDefEng[] = $row["WordDefEng"];
                }
            }
        ?>
        
       
        <nav>
            <div id="new-folder">
                <i class="fas fa-plus"></i>
                <div class="form">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <h3>
                        <input type="text" name="name" value="Folder Name">
                        </h3>
                        <br/><br/>


                        <input type="submit" value="Submit" id="submit">
                    </form>
                </div>
            </div>
            <div class="folder">
                <i class="fas fa-folder"></i>
                <h3>Folder</h3>
            </div>
        </nav>
        
        <div id="account-settings">
            <i class="fas fa-user-circle" id="account-tab"></i>
            <div class="dropdown" id="account-dropdown">
                <a href="#">Settings</a>
                <hr>
                <a href="#" class="strong">Log Out</a>
            </div>
        </div>
        
        <div id="main">
            <?php
                for($x=0; $x<count($wordID); $x++){
                    echo '<div class="word">
                    <h4 class="date">' . date_format(new DateTime($wordDate[$x]), "m/d/y") . '</h4>
                    <div class="term">
                        <h1>' . $word[$x] . '</h1>
                        <i class="fas fa-volume-up speak" onclick="readWord()"></i>
                    </div>
                    <div class="definitions">
                        <div class="def lang1">
                            <p>' . $wordDefEng[$x] . '</p>
                        </div>
                        <!--<div class="def lang2">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sed est mattis, aliquam eros in, varius libero.</p>
                            <p class="ex">Lorem ipsum dolor sit amet.</p>
                        </div>-->
                    </div>
                    
                </div>';
                }
            ?>
            
            <?php
                 $conn = new mysqli($servername, $username, $password, "entries");

            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
                echo("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT word FROM entries";
            $result = $conn->query($sql);

            if($result->num_rows >0){
                while($row = $result->fetch_assoc()){
                    $wordTest[] = $row["word"];
                }
            }
            echo $wordTest[0];
            ?>
            
        </div>
    </body>
</html>