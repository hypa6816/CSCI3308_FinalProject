<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="load_style.css">
  
</head>

<body>
  <h1>Results Page </h1>
  <?php
    $SearchedCourseTitle = $_GET['SearchQuery'];
    echo "<p> Courses Like $SearchedCourseTitle";
    $db = mysql_connect('104.198.161.89', 'prototypeuser', 'flatiron');
    if(!$db){
        echo "<p> Failed Connection </p>";
        die();
    }
    $my_db = mysql_select_db('RateMyCourse');
    $search_query = "select  CourseTitle, Course from CourseName where Course like 1000 " ;
    $result = mysql_query($search_query);
      //-create  while loop and loop through result set
    while($row=mysql_fetch_assoc($result)){
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