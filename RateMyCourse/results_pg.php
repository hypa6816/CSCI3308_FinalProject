<!DOCTYPE html>
<html>
    <head>
      <link rel="stylesheet" type="text/css" href="load_style.css">
    </head>

    <body>
      <h1>Results Page </h1>
          <?php
            $SearchedCourseTitle = $_GET['SearchQuery']; // get the SearchQuery from courseHero.php 
            echo "<p> Courses Like: $SearchedCourseTitle";

            $db = mysql_connect('104.198.161.89', 'prototypeuser', 'flatiron'); //connnect to our mysql base
            if(!$db){
                echo "<p> Failed to connect to DB server </p>"; //error message for a failed connetion
                die();
            }
            $my_db = mysql_select_db('RateMyCourse'); //select our data base

            //TODO: Make sure this is the best way to look for courses or implement more search methods
            $search_query = "select distinct CourseTitle from CourseName where CourseTitle like '$SearchedCourseTitle%' order by CourseTitle" ; // mysql query 
            $result = mysql_query($search_query) or die($search_query."<br/><br/>".mysql_error()); // send the query to our mysql DB. post error code if query fails     
            while($row=mysql_fetch_assoc($result)) // for the amount of rows the query returns echo the CourseTitle as a hyperlink to our content_pg.php
            { 
                //-display the result of the search as hyperlink
                echo "<ul>\n";
                echo '<a href="/RateMyCourse/content_pg.php?CourseTitle='.$row['CourseTitle'].'">'.$row['CourseTitle'].'</a>'; //create hyper link with name CourseTitle
                echo "</ul>";
            }

          ?>
    </body>
</html>