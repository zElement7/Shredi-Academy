<?php
    session_start();
    require_once "./includes/DataBaseConnection.php";

$query = "SELECT id, name FROM exercises ORDER BY name;";

$result = $conndb->query($query);

if (!$result) {
    $message = "Invalid Query";
    echo $message;
    die('Invalid query: ' . mysql_error($conndb));
}

$personalBest = "";
$initialWeight = "";
$datesWithWeights = array();
$exerciseName = "Exercise Progress";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['toShowProgressOn'] !== "Select One") {
    $exerciseToShow = cleanInputValue($conndb, $_POST['toShowProgressOn']);

//    $sqlQuery = "SELECT date, weight, first_entry, personal_best FROM progress WHERE exercise_id = $exerciseToShow;";

    $sqlQuery = "SELECT exercises.name, date, progress.weight, first_entry, personal_best FROM progress "
            . "JOIN exercises ON progress.exercise_id = exercises.id WHERE exercise_id = $exerciseToShow;";

    $graphResults = $conndb->query($sqlQuery);

    if (!$result) {
        $message = "Invalid Query";
        echo $message;
        die('Invalid query: ' . mysql_error($conndb));
    }

    while ($myProgress = $graphResults->fetch_assoc()) {

        //set personal best
        if ($myProgress['personal_best'] == 1) {
            $personalBest = $myProgress['weight'];
        }

        //set initial weight lifted
        if ($myProgress['first_entry'] == 1) {
            $initialWeight = $myProgress['weight'];
        }

        //make an associated array of the dates and weights
        $aweight = (int) $myProgress['weight'];
        $data = array("date" => "{$myProgress['date']}", "weight" => "{$aweight}");
        array_push($datesWithWeights, $data);
        $exerciseName = $myProgress['name']; //to name the graph
    }
}

function showExerciseProgress($pb, $iW, $dateAndWeight) {
    $personalBest = $pb;
    $initialWeight = $iW;
    $jsDatesAndWeights = json_encode($dateAndWeight);
    echo <<<STATS
        
        <script>
           document.getElementById("personalBest").innerHTML="{$personalBest}";
           document.getElementById("initialDiv").innerHTML="{$initialWeight}";
           var datesAndWeights = $jsDatesAndWeights;
           
           var yValues = [];
           var xValues = [];
           
           function getGraphData(datesWithWeights)
           {
                let datesArray = [];
                let weightsArray = [];
             
                for (let index in datesWithWeights)
                  {
                   let data = datesWithWeights[index];
                 
                    datesArray.push(data['date']);
                    weightsArray.push(data['weight']);
                      
                   }
                   xValues = datesArray;
                   yValues = weightsArray;
                         
           }
                   
                 getGraphData(datesAndWeights);
                   console.log(xValues);
                   
                   function updateChart(timeframe, datesWithWeights)
                   {
                       let datesArray = [];
                       let weightsArray = [];
                       const today = new Date();
                       let priorDate = new Date();
                       priorDate.setMonth(today.getMonth() - timeframe);
                       console.log("priorDate " + priorDate.toString());
                   
                    for (let index in datesWithWeights)
                      {
                        let data = datesWithWeights[index];
                        console.log(data['date']);
                       
                        let date = new Date(data['date']);
                            console.log(date);
                        if(date >= priorDate)
                         {
                                datesArray.push(data['date']);
                                weightsArray.push(data['weight']);
                         }
 
                   }
                   console.log(datesArray);
                   
                   xValues = datesArray;
                   yValues = weightsArray;
                   myChart.data.labels = xValues;
                   myChart.data.datasets[0].data = yValues;
                   myChart.update();
                    
                   }
        
                </script>
           
        STATS;
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Progress</title>
        <link rel="stylesheet" href="./css/style.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> 


    </head>
    <body>
<?php include_once("includes/nav.php") ?>
        <div class="contentWrapper">
            <h1>Progress</h1>
            <div id="progressWrapper">
                <div id = "summaryDiv">
                    <form method ="post"> 
                        <select name="toShowProgressOn">
                            <option>Select One</option>
<?php
while ($myExercises = $result->fetch_assoc()) {
    echo <<< HTML
                            <option value="{$myExercises['id']}">{$myExercises['name']}</option>
                            
                            HTML;
}
?>

                        </select>
                        <button type = "submit">></button>
                    </form>
                    <h2>Initial</h2>
                    <div class = "progressRecords" id="initialDiv"></div>
                    <h2>Personal Best</h2>
                    <div class = "progressRecords"id="personalBest"></div>

                </div>

                <div id="progressGraph">
<?php echo "<h2>$exerciseName</h2>";
?>
                    <canvas id="myChart" style="width:100%;max-width:700px"></canvas> 

                    <div id="progressTimeFrame">
                        <div onclick="updateChart(3, datesAndWeights);">3M</div>
                        <div onclick="updateChart(6, datesAndWeights);">6M</div>
                        <div onclick="updateChart(12, datesAndWeights);">1Y</div>
                    </div>                   



                </div>
                <div>
                </div>
                </body>
<?php
showExerciseProgress($personalBest, $initialWeight, $datesWithWeights);

echo <<< SCRIPT
               
               <script>
                  
                  
                    let lineColor = ["#97d5ee"];
                    
                    var myChart = new Chart("myChart", {
                        type: "line",
                        data: {
                            labels: xValues,
                            datasets: [{
                                    backgroundColor: lineColor,
                                    data: yValues,
                                    lineTension: 0
                                }]
                        },
                        options: {
                            
                            legend: {display: false},
                            title: {
                                display: false,
                                text: ""
                            }
                        }
                    });
                </script>
               SCRIPT;
?>
                </html>

                <?php
                $conndb->close();
                