<!DOCTYPE html>
<html>
    <head>
      <link rel="stylesheet" type="text/css"
            href="content_pg.css">

    </head>

    <body>
        
        <img src="http://www.colorado.edu/catalog/2016-17/sites/all/themes/cuminimal/logo.png"> 
        
        <?php
            $CourseTitle = $_GET['CourseTitle']; // Get Course_title from results_pg.php
            $db = mysql_connect('104.198.161.89', 'prototypeuser', 'flatiron'); //connnect to our mysql base
            if(!$db)
            {
                echo "<p> Failed Connection </p>"; //error message for a failed connetion
                die();
            }
            $my_db = mysql_select_db('RateMyCourse'); //select our data base
            echo "<p>  $CourseTitle </p>";
            
        //Pull Relavent Course information from our selected course
            $SubjectQuery = "select Subject from CourseName where CourseTitle like '%$CourseTitle%'";
            $CourseNumQuery = "select Course from CourseName where CourseTitle like '%$CourseTitle%'";
        
            $SubjectResult = mysql_query($SubjectQuery) or die($SubjectQuery."<br/><br/>".mysql_error());
            $CourseNumResult = mysql_query($CourseNumQuery)or die($CourseNumQuery."<br/><br/>".mysql_error());
        
            $SubjectRow=mysql_fetch_object($SubjectResult); //Result of Subject Query returned as an object
            $CourseNumRow=mysql_fetch_object($CourseNumResult); // Result of the Course Number Query returned as an object
        
            echo "<ul>\n";
            echo "<p class='SubjectRows'>".$SubjectRow->Subject."</p>"; //Display 4 Letter abrv. Course Subject         
            echo "<p class='CourseNumRows'>".$CourseNumRow->Course."</p>"; // Display 4 Number Course Number
 
        /* queries for each data visualization  */
        
        //GRADE DISTRIBUTION QUERY
            $GradeDistQuery = "select avg(PCT_A),avg(PCT_B),avg(PCT_C),avg(PCT_DF) from GradeDistribution where Course = $CourseNumRow->Course and Subject='$SubjectRow->Subject' "; // query which fetches the averaged grade pctgs for all semesters of the course specidied by Course Subject and Course Number
            $GradeDistResult = mysql_query($GradeDistQuery);
            $GradeRow=mysql_fetch_assoc($GradeDistResult); //Result of the Grade Dist Query returned as an associatve array
        //This was just a debug print uncomment if you want to see the numbers match up between the piechart and what the query returned
        
        //GRADE RATING QUERY
            $GradeRatingQuery = "select AverageGrade from CourseDifficulty where Course =$CourseNumRow->Course and Subject='$SubjectRow->Subject'";
            $GradeRatingResult = mysql_query($GradeRatingQuery);
            $DifficultyRow = mysql_fetch_assoc($GradeRatingResult);
        
        //HOURS SPENT QUERY
            $HoursSpentQuery = "select WorkloadRaw from CourseDifficulty where Course =$CourseNumRow->Course and Subject='$SubjectRow->Subject'";
            $HoursSpentResult = mysql_query($HoursSpentQuery);
            $HourRow = mysql_fetch_assoc($HoursSpentResult);
        
        // Course Rating Query
            $CourseRatingQuery = "select CourseRating from CourseRating where Course =$CourseNumRow->Course and Subject='$SubjectRow->Subject'";
            $CourseRatingResult = mysql_query($CourseRatingQuery);
            $RatingRow = mysql_fetch_assoc($CourseRatingResult);
        
        
            if($HourRow['WorkloadRaw']>=-1 and $HourRow['WorkloadRaw']<1){
                $HourRange = json_encode('0-3');
            }
            elseif($HourRow['WorkloadRaw']>=1 and $HourRow['WorkloadRaw']<2){
                $HourRange = json_encode('4-6');
            }
            elseif($HourRow['WorkloadRaw']>=2 and $HourRow['WorkloadRaw']<3){
                $HourRange = json_encode('7-9');
            }
            elseif($HourRow['WorkloadRaw']>=3 and $HourRow['WorkloadRaw']<4){
                $HourRange = json_encode('10-12');
            }
            elseif($HourRow['WorkloadRaw']>=4 and $HourRow['WorkloadRaw']<5){
                $HourRange = json_encode('13-15');
            }
            elseif($HourRow['WorkloadRaw']>=5 and $HourRow['WorkloadRaw']<6){
                $HourRange = json_encode('16+');
            }
        
        ?>
            
              <!-- Google Visualization Tool Setup -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> <!-- Load API -->
        <!-- Actual Implementation of Visualization Tool -->
        <script type="text/javascript"> 
            google.charts.load("current", {packages:["corechart","gauge","table"]}); // Load the chart package you want to use
            google.charts.setOnLoadCallback(drawChart); 
            google.charts.setOnLoadCallback(drawGauge);
            google.charts.setOnLoadCallback(drawTable);// Declares when to load the chart in our case instantly or when the page loads
            google.charts.setOnLoadCallback(drawTable_rating);// Declares when to load the chart in our case instantly or when the page loads
            
            function drawChart() {
                // Create and populate the data table.
                var data = google.visualization.arrayToDataTable([
                    ['Grade', 'Average % of people who got that grade'],
                    ['A', <?php echo $GradeRow['avg(PCT_A)'] ?>],
                    ['B', <?php echo $GradeRow['avg(PCT_B)'] ?>],
                    ['C', <?php echo $GradeRow['avg(PCT_C)'] ?>],
                    ['D, F', <?php echo $GradeRow['avg(PCT_DF)'] ?>] 
                ]);
                //Different options for the graph
                var options = { 
                    title: 'Grade Distribution',
                    is3D: true,
                    backgroundColor:'none',
                    colors:['gold','black','grey','white'],
                    titleTextStyle:
                    {
                        color:'white',
                    },
                   legendTextStyle:{
                    color:'white',
                },
                };
                // Create and draw the visualization .
                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d')); // getElementById declares which container we want to put in ie. our div id = piechart_3d
                chart.draw(data, options); // make chart with given paramaters
            }
            
        function drawGauge() {
                var data = google.visualization.arrayToDataTable([
                  ['Label', 'Value'],
                  ['Course Difficulty', <?php echo $DifficultyRow['AverageGrade'] ?>],
                ]);
                var options = {
                  width: 800, height: 240,
                  max:6,
                  greenFrom:0,greenTo:2,
                  yellowFrom:4,yellowTo:5,
                  redFrom:5, redTo:6,
                  majorTicks:6,
                  minorTicks:4,
                  //is3d: true,
                };
                var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
                chart.draw(data, options);
                    setInterval(function() {
                  data.setValue();   //setValue(NULL) = NO STUPID TICKING
                  chart.draw(data, options);
                }, 13000);
                setInterval(function() {
                  data.setValue(); //setValue(NULL) = NO STUPID TICKING
                  chart.draw(data, options);
                }, 5000);
                setInterval(function() {
                  data.setValue(); //setValue(NULL) = NO STUPID TICKING
                  chart.draw(data, options);
                }, 26000); 
              }
                var cssClassNames = {
                    'headerRow': 'CSSheaderRow',
                    'tableRow': 'CSStableRow',
                    'oddTableRow': 'CSSoddTableRow',
                    'selectedTableRow':'CSSselectedTableRow',
                    'hoverTableRow':'CSShoverTableRow',
                    'headerCell':'CSSheaderCell',
                    'tableCell':'CSStableCell',
                    'rowNumberCell':'CSSrowNumberCell',
            };
            function drawTable() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Average Hours Spent Per Week');
                data.addRows([
                  [<?php echo $HourRange ?>],
                ]);
                var table = new google.visualization.Table(document.getElementById('table_div'));
                table.draw(data, {showRowNumber: false, width: '100%', height: '100%', sort:'disable','cssClassNames': cssClassNames,});
              }
            
            var cssClassNames1 = {
                    'headerRow': 'CSSheaderRow',
                    'tableRow': 'CSStableRow',
                    'oddTableRow': 'CSSoddTableRow',
                    'selectedTableRow':'CSSselectedTableRow',
                    'hoverTableRow':'CSShoverTableRow',
                    'headerCell':'CSSheaderCell',
                    'tableCell':'CSStableCell',
                    'rowNumberCell':'CSSrowNumberCell',
            };
            
            function drawTable_rating() {
                var data = new google.visualization.DataTable();
                data.addColumn('number', 'Course Rating');
                data.addRows([
                  [<?php echo $RatingRow['CourseRating'] ?>],
                ]);
                
                
                var table_rating = new google.visualization.Table(document.getElementById('table_div_rating'));
                table_rating.draw(data, {showRowNumber: false, width: '100%', height: '100%', sort:'disable','cssClassNames': cssClassNames1,});
              }
 
      
        </script>
          
        <div id="piechart_3d" style="width: 600px; height: 400px; margin-left: 115px;"></div> <!--Container for Chart-->
        <div id="chart_div" style="width: 400px; height: 120px; margin-left: 750px; margin-top:-500px;"></div>
        <div id="table_div" style="width: 200px; height: 200px; margin-left:1100px; margin-top:-100px;"></div>
        <div id="table_div_rating" style="width: 200px; height: 200px; margin-left:900px; margin-top:25px;"></div>
             
    </body>
</html>
