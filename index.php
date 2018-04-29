<!DOCTYPE HTML>
<html lang="en">
    <head>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="dictionary.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
        <script src='https://code.responsivevoice.org/responsivevoice.js'></script>

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
                    $wordDefLang2[] = $row["WordDefLang2"];
                    $wordFolder[] = $row["FolderInID"];
                    $wordExample[] = $row["Example"];
                    $wordNote[] = $row["Note"];
                }
            }
            $sql = "SELECT * FROM folders ORDER BY FolderID DESC";
            $result = $conn->query($sql);

            if($result->num_rows >0){
                while($row = $result->fetch_assoc()){
                    $folderID[] = $row["FolderID"];
                    $folderName[] = $row["FolderName"];
                }
            }
        ?>
        
        <!--have to check-->
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["name"])){
                    $sql = "INSERT INTO folders (FolderName)
                    VALUES ('" . $_POST['name'] . "')";
                    $result = $conn->query($sql);
                }
                else{
                    $sql = "INSERT INTO words (WordText, WordDefEng, WordDefLang2, Example, Note)
                    VALUES ('" . $_POST['word'] . "', '" . $_POST['defEng'] . "', '" . $_POST['defLang2'] . "', '" . $_POST['ex'] . "', '" . $_POST['note'] . "')";
                    echo "INSERT INTO words (WordText, WordDefEng, WordDefLang2, Example, Note)
                    VALUES ('" . $_POST['word'] . "', '" . $_POST['defEng'] . "', '" . $_POST['defLang2'] . "', '" . $_POST['ex'] . "', '" . $_POST['note'] . "')";
                    $result = $conn->query($sql);
                }
            }
        ?>
       
        <nav>
            <div id="new-folder">
                <i class="fas fa-plus"></i>
                <div class="form">
                    <form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <h3>
                        <input type="text" name="name" placeholder="New Folder">
                        </h3>
                        <button type="submit">
                            <i class="fas fa-check-circle"></i>
                        </button>
                    </form>
                </div>
            </div>
            <?php
                for($x=0; $x<count($folderID); $x++){
                    echo '<div class="folder">
                            <i class="fas fa-folder"></i>
                            <h3>' . $folderName[$x] . '</h3>
                            <i style="margin-left: 2%;" class="fas fa-caret-down"></i>
                            <div class="dropdown folder-dropdown">';

                    for($y=0; $y<count($wordID); $y++){
                        if($wordFolder[$y] == $folderID[$x]){
                            echo '<h4>' . $word[$y] . '</h4>';
                        }
                    }
                        
                    echo '</div>
                    </div>';
                }
            ?>
        </nav>
        
        <div id="account-settings">
            <i class="fas fa-plus-circle" id="account-tab"></i>
            <div class="dropdown" id="account-dropdown">
                <form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                   <h4>Word:</h4>
                   <input type ="text" name="word"><br/><br/>

                   <h4>Definition (First Language):</h4>
                   <textarea rows="4" cols="50" name="defEng"></textarea><br/><br/>

                   <h4>Examples:</h4>
                   <textarea rows="4" cols="50" name="ex"></textarea><br/><br/>

                   <h4>Definition (Second Language):</h4>
                   <textarea rows="4" cols="50" name="defLang2"></textarea><br/><br/>

                   <h4>Note:</h4>
                   <textarea rows="4" cols="50" name="note"></textarea><br/><br/>
                    
                   <input type="submit" name="newWord" value="Submit">
               </form>
            </div>
        </div>
        
        <div id="main">
            <?php
                for($x=0; $x<count($wordID); $x++){
                    echo '<div class="word">
                    <div class="term">
                        <h1>' . $word[$x] . '</h1>
                        <i class="fas fa-volume-up speak" onclick=responsiveVoice.speak("' . $word[$x] . '");></i>
                    </div>
                    <form class="pick-folder" pickmethod="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>
                            <h5>Folder:</h5>
                            <select name="folder">';
                    if($wordFolder[$x] == 0){
                        echo '<option value="null">---</option>';
                    }
                    else{
                        echo '<option value="' . $folderName[$wordFolder[$x]]  . '">' . $folderName[$wordFolder[$x]] . '</option>';
                        echo "HI";
                    }
                    for($y=0; $y<count($folderID); $y++){
                        echo '<option value="' . $folderName[$y] . '">' . $folderName[$y] . '</option>';
                    }
                    echo '</select>
                    </form>
                    <div class="definitions">
                        <div class="def lang1">
                            <p>' . $wordDefEng[$x] . '</p>
                            <p class="ex">Example: ' . $wordExample[$x] . '</p>
                        </div>
                        <div class="def lang2">
                            <p>' . $wordDefLang2[$x] . '</p>
                        </div>
                    </div>
                    
                    <br/>
                    <p class="note">Note: ' . $wordNote[$x] . '</p>
                    
                </div>';
                }
            ?>
            
        </div>
    </body>
</html>