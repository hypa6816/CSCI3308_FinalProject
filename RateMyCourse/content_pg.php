<!DOCTYPE html>
<html>
    <head>
      <link rel="stylesheet" type="text/css"
            href="content_pg.css">

    </head>

    <body>
        
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
        
            $SubjectQuery = "select Subject from CourseName where CourseTitle like '%$CourseTitle%'";
            $CourseNumQuery = "select Course from CourseName where CourseTitle like '%$CourseTitle%'";
        
            $SubjectResult = mysql_query($SubjectQuery) or die($SubjectQuery."<br/><br/>".mysql_error());
            $CourseNumResult = mysql_query($CourseNumQuery)or die($CourseNumQuery."<br/><br/>".mysql_error());
        
            $SubjectRow=mysql_fetch_object($SubjectResult); //Result of Subject Query returned as an object
            $CourseNumRow=mysql_fetch_object($CourseNumResult); // Result of the Course Number Query returned as an object
        
            echo "<ul>\n";
            echo "<p class='SubjectRows'>".$SubjectRow->Subject."</p>"; //Display 4 Letter abrv. Course Subject         
            echo "<p class='CourseNumRows'>".$CourseNumRow->Course."</p>"; // Display 4 Number Course Number
        
            $GradeDistQuery = "select avg(PCT_A),avg(PCT_B),avg(PCT_C),avg(PCT_DF) from GradeDistribution where Course = $CourseNumRow->Course and Subject='$SubjectRow->Subject' "; // query which fetches the averaged grade pctgs for all semesters of the course specidied by Course Subject and Course Number
            $GradeDistResult = mysql_query($GradeDistQuery);
            $GradeRow=mysql_fetch_assoc($GradeDistResult); //Result of the Grade Dist Query returned as an associatve array
        //This was just a debug print uncomment if you want to see the numbers match up between the piechart and what the query returned
//            echo "<ul>\n";
//            echo "<p> Average percent of Students Who Got an A: </p>";
//            echo "<p class='rows'>".$GradeRow['avg(PCT_A)']."</p>";
//            echo "<p> Average percent of Students Who Got a B: </p>";
//            echo "<p class='rows'>".$GradeRow['avg(PCT_B)']."</p>";
//            echo "<p> Average percent of Students Who Got a C: </p>";
//            echo "<p class='rows'>".$GradeRow['avg(PCT_C)']."</p>";
//            echo "<p> Average percent of Students Who Got a D or a F: </p>";
//            echo "<p class='rows'>".$GradeRow['avg(PCT_DF)']."</p>";
//            echo "</ul>"; 
        ?>
            
              <!-- Google Visualization Tool Setup -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> <!-- Load API -->
        <!-- Actual Implementation of Visualization Tool -->
        <script type="text/javascript"> 
          google.charts.load("current", {packages:["corechart"]}); // Load the chart package you want to use
          google.charts.setOnLoadCallback(drawChart); // Declares when to load the chart in our case instantly or when the page loads
            function drawChart() {
                // Create and populate the data table.
                var data = google.visualization.arrayToDataTable([
                    ['Grade', 'Average % of people who got that grade'],
                    ['A', <?php echo $GradeRow['avg(PCT_A)'] ?>],
                    ['B', <?php echo $GradeRow['avg(PCT_B)'] ?>],
                    ['C', <?php echo $GradeRow['avg(PCT_C)'] ?>],
                    ['D F', <?php echo $GradeRow['avg(PCT_DF)'] ?>] 
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
        </script>

        <div id="piechart_3d" style="width: 600px; height: 400px;"></div> <!--Container for Chart-->
        
    </body>
</html>
