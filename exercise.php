<?php
    $exercises = array(
        array("name" => "Shoulder Press", "exerciseId" => 1, "isCustom" => True), 
        array("name" => "Squats", "exerciseId" => 2, "isCustom" => True),
        array("name" => "Curls", "exerciseId" => 3, "isCustom" => False),
        array("name" => "Skull Crushers", "exerciseId" => 4, "isCustom" => False),
        array("name" => "Crunches", "exerciseId" => 5, "isCustom" => True)
        );
    
    function addExercise()
    {
        
    }
    
    function deleteExercise()
    {
        
    }
    
    function editExercise()
    {
        
    }

?>
<!doctype html>
<html lang="en">
    <head>
        <title>Prototype</title>
           <link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css"> 
        <link rel="stylesheet" href="./css/style.css" type="text/css">
        
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
     
    </head>
    <body>
        <?php include_once("includes/nav.php") ?>
        <div class="contentWrapper">
            <h1>Exercises</h1>
        <button>Order by Muscle Group</button>
        
        
        <div class="interactiveBoxesDiv">
            <form>
                
            <div id="addExerciseBox">Add Exercise</div>
            </form>
            <?php 
            foreach ($exercises as $myExercises)
            {
                //if this is a custom exercise allow the user to delete it by adding a clickable trashcan
                //icon.  If it is a default exercise do not allow this functionaility
                if($myExercises['isCustom'] == True)
                {
                    echo <<<HTML
                    <div class='exerciseDiv'>
                        <form method="post" action="individualExercise.php" style="width:100%;">
                            <button class='exerciseBox' type="submit" name ="exerciseId" value='{$myExercises['exerciseId']}'> 
                            <div id='exercise{$myExercises['exerciseId']}' class = 'exerciseText'>
                                {$myExercises['name']}
                            </div>
                        </button>
                         </form>
                        <span class='glyphicon glyphicon-trash'></span>
                    <div>
                    HTML;
                }
                else
                {
                    echo <<<HTML
                    <div class='exerciseDiv'>
                    <form method="post" action="individualExercise.php" style="width:100%;">
                        <button class='exerciseBox' type="submit" name ="exerciseId" value='{$myExercises['exerciseId']}'> 
                            <div id='exercise {$myExercises['exerciseId']}' class = 'exerciseText'>
                                {$myExercises['name']}
                                    </div>
                        </button>
                                </form>
                                <span></span>
                    <div>
                    HTML;
                }
                
                echo "</div></div>";
                
                
                
            }
            
            ?>
            
      
        </div>
    </body>
</html>