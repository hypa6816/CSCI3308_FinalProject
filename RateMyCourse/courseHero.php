 <!DOCTYPE html>
<html> 
      <!--//Equivalent of a Header File -->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Course Hero</title>
        <meta name="description" content="An interactive getting started guide for Brackets.">
        <link rel="stylesheet"  type="text/css" href="main.css"> 
        <script language="javascript" type="text/javascript" src="js/jquery-2.2.0.js"></script> <!--// java include-->
    </head>
      
    <body>
        <img src="http://www.colorado.edu/catalog/2016-17/sites/all/themes/cuminimal/logo.png"> 
        <div class="background-image">
            <div class="content">
                <h1>RateMyCourse</h1>       
                <!--
                    MADE WITH <3 AND JAVASCRIPT
                -->
                <!-- TODO: Incorporate Live search bar -->
                <!--//Form for search textbox and button declared-->
                <form method="post" action="courseHero.php?go"  id="searchform">
                    <input  class = 'search_box' type="text" name="searched_course_title" placeholder="Type the name of the Course or CourseID..."><!--//text box input--> <!--//searched_course_title is the variable which holds the query typed in the search box-->
                    <input  type="submit" name="submit" value="Search"> <!--// button input -->
                </form>
                <?php //logic for search method
                    if(isset($_POST['submit']))
                    { //if the user hits the submit button
                        if(isset($_GET['go']))
                        { // not sure think it checks to see if the ?go is appended to our url
                            if(preg_match("/[a-zA-Z]/i", $_POST['searched_course_title']))
                            { // make sure the user types in a lower or uppercase letter
                                $SearchedCourseTitle=$_POST['searched_course_title']; // save user inputed search query as SearchedCourseTitle
                                header("Location: http://localhost:81/RateMyCourse/results_pg.php?SearchQuery=".urlencode($SearchedCourseTitle)); 
                                // this header line sends the user to the results page and sends SearchedCourseTitle via urlencode
                            }
                        }
                    }      
                ?>

                <p class ='text1'>
                    Over 4,800 courses' FCQ information on ratings, difficulty, grade distribution, and hours spent right at your finger tips.
                </p>

                <p class ='text2'>
                All information gathered since 2006 from CU Boulder FCQs.
                </p>
                
            </div>
        </div> 
    </body>
        
</html>
