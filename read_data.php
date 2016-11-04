<? php
    include_once 'dbconfig.php';
    //retreive data from mysql and return as JSON, returns back to UI as a result
    $key=$_GET['key'];
    $array = array();
    $query = mysql_query("SELECT * FROM CourseName where <column_name> LIKE '%{$key}%'");
    while($row = mysql_fetch_assoc($query))
    {
        $array[] = $row['CourseName'];
    }
    echo json_encode($array);
?>