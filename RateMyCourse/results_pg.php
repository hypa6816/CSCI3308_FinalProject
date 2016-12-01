<!DOCTYPE html>
<html>
    <head>
      <link rel="stylesheet" type="text/css" href="result_pg.css">
    </head>

    <body>
      
        
        <div id="result_title_wrap">
        <img src="http://www.colorado.edu/catalog/2016-17/sites/all/themes/cuminimal/logo.png"> 
      <p class ="result_title">RateMyCourse</p>
            </div>
        
          <?php
            $SearchedCourseTitle = $_GET['SearchQuery']; // get the SearchQuery from courseHero.php 
            
            //use EXPLODE to parse the JSON string so users can search by acronym
            list($prefix,$suffix) = explode(" ","$SearchedCourseTitle ");
           
            
        $db = mysql_connect('104.198.161.89', 'prototypeuser', 'flatiron'); //connnect to our mysql base
            if(!$db){
                echo "<p> Failed to connect to DB server </p>"; //error message for a failed connetion
                die();
            }
            $my_db = mysql_select_db('RateMyCourse'); //select our data base
            //TODO: Make sure this is the best way to look for courses or implement more search methods
            $search_query = "select distinct CourseTitle from CourseName where CourseTitle like '%$SearchedCourseTitle%' or (subject like '$prefix' or course like '$suffix') order by CourseTitle" ; // mysql query 
        
       
        
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
