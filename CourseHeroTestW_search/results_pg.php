<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="load_style.css">
  
</head>

<body>
  <h1>Results Page </h1>
  <?php
    $SearchedCourseTitle = $_GET['SearchQuery']; // get the SearchQuery (or SearchedCourseTitle in courseHero_search.php)
    echo "<p> Courses Like $SearchedCourseTitle";
    $db = mysql_connect('104.198.161.89', 'prototypeuser', 'flatiron'); //connnect to our mysql base
    if(!$db){
        echo "<p> Failed Connection </p>"; //error message for a failed connetion
        die();
    }
    $my_db = mysql_select_db('RateMyCourse'); //select our data base
    $search_query = "select  CourseTitle, Course from CourseName where Course like 1000 " ; // mysql query hardcoded
    $result = mysql_query($search_query); // send the query to our mysql DB
      //-create  while loop and loop through result set
    while($row=mysql_fetch_assoc($result)){ // for the amount of rows the query returns echo the CourseTitle and Course(number)
    //$course_tile_res = $row['CourseTitle'];
    //$course_num_res = $row['Course'];
    //-display the result of the array
    echo "<ul>\n";
    echo "<p class='rows'>".$row['CourseTitle']."</p>";
    echo "<p class='rows'>".$row['Course']."</p>";
    echo "</ul>";
    }
    
  ?>
</body>
</html>