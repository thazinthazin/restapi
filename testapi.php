<?php
//http://www.tutorialsface.com/2016/02/simple-php-mysql-rest-api-sample-example-tutorial/
//http://www.tutorialsface.com/2016/02/simple-php-mysql-rest-api-sample-example-tutorial/
//https://www.youtube.com/watch?v=vu5tKZodFuw

header("Content-Type:application/json");
date_default_timezone_set("Asia/Yangon"); 
include('config.php');
$arr = array();
$results = array();

if(isset($_POST["authkey"]) && isset($_POST["function"]) && isset($_POST["userid"]))
{
    $usrid = $_POST["userid"];
    if((string)$_POST["function"] == "usersbycourses" && $_POST["authkey"] == (string)(date_format(new DateTime(), 'YmdH') . 'oakpes'))
    {
        // Check connection
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        //$sql = "SELECT id,name,intro FROM `mdl_attendance` LIMIT 10";
        $sql = "SELECT DISTINCT C.* FROM mdl_course AS c
                    INNER JOIN mdl_context AS cx ON c.id = cx.instanceid
                    INNER JOIN mdl_role_assignments AS ra ON cx.id = ra.contextid
                    INNER JOIN mdl_role AS r ON ra.roleid = r.id
                    INNER JOIN mdl_user AS usr ON ra.userid = usr.id
                    WHERE r.shortname IN ('editingteacher','teacher') AND usr.id = $usrid";
        
        if($result = mysqli_query($link, $sql)){

            if(mysqli_num_rows($result) > 0){        
                while($row = mysqli_fetch_array($result)){
                    array_push($results,
                        array('id'=>$row[0],
                        'category'=>$row[1],
                        'sortorder'=>$row[2],
                        'fullname'=>$row[3],
                        'shortname'=>$row[4],
                        'classcode'=>$row[5],
                        'idnumber'=>$row[6],
                        'summary'=>$row[7],
                        'summaryformat'=>$row[8],
                        'format'=>$row[9],
                        'showgrades'=>$row[10],
                        'newsitems'=>$row[11],
                        'startdate'=>$row[12],
                        'enddate'=>$row[13],
                        'marker'=>$row[14],
                        'maxbytes'=>$row[15],
                        'legacyfiles'=>$row[16],
                        'showreports'=>$row[17],
                        'visible'=>$row[18],
                        'visibleold'=>$row[19],
                        'groupmode'=>$row[20],
                        'groupmodeforce'=>$row[21],
                        'defaultgroupingid'=>$row[22],
                        'lang'=>$row[23],
                        'calendartype'=>$row[24],
                        'theme'=>$row[25],
                        'timecreated'=>$row[26],
                        'timemodified'=>$row[27],
                        'requested'=>$row[28],
                        'enablecompletion'=>$row[29],
                        'completionnotify'=>$row[30],
                        'cacherev'=>$row[31]
                    ));
                    $arr[] = $row;
                }
                //echo '{"data":' . json_encode($arr, JSON_UNESCAPED_UNICODE) . '}';
                echo json_encode(array("coureclassdata"=>$results), JSON_UNESCAPED_UNICODE);  
                // Free result set
                mysqli_free_result($result);
            } else{
                array_push($results,
                array('status'=>"success",
                    'desp'=>"No data found",
                    //'responseat'=>(new DateTime())->format('Ymdhm')
                    'responseat'=>date_format(new DateTime(), 'YmdH')
                ));
                //date_format(new DateTime(), 'Y-m-d H:i:s');
                echo json_encode(array("data"=>$results), JSON_UNESCAPED_UNICODE);  
            }

        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        } 
    }
    else
    {            
        array_push($results,
                array('status'=>"failed",
                    'desp'=>"Invalid Authkey or Function Name",
                    //'responseat'=>(new DateTime())->format('Ymdhm')                    
                    'responseat'=>date_format(new DateTime(), 'YmdH'),
                    'Requested Form Data' => 'function:' . $_POST['function'] . ';authkey:' 
                            . $_POST['authkey'] . ';userid:' . $_POST['userid']
                )); 
        //date_format(new DateTime(), 'Y-m-d H:i:s');
        echo json_encode(array("data"=>$results), JSON_UNESCAPED_UNICODE);  
    }
}
else
{
    array_push($results,
                array('status'=>"failed",
                    'desp'=>"No Form Data Found",
                    //'responseat'=>(new DateTime())->format('Ymdhm')
                    'responseat'=>date_format(new DateTime(), 'YmdH')
                ));
        //date_format(new DateTime(), 'Y-m-d H:i:s');
        echo json_encode(array("data"=>$results), JSON_UNESCAPED_UNICODE);  
}

// Close connection
mysqli_close($link);
?>
