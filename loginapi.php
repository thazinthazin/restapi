<?php
//https://docs.moodle.org/dev/Authentication_API
header("Content-Type:application/json");
require('config.php');
require_once('lib.php');
$arr = array();
$results = array();
$user = false;

// if(isset($_POST["function"]) && isset($_POST["username"]) && isset($_POST["password"]))
if(($_POST["function"] == "usersbycourses") && isset($_POST["username"]) && isset($_POST["password"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check connection
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT id,username,password FROM users WHERE username like '$username'";
        
        if($result = mysqli_query($link, $sql)){

            if(mysqli_num_rows($result) > 0){        
                while($row = mysqli_fetch_array($result)){
                    if(password_verify($password, $row[2])){
                        //success
                        array_push($results,
                            array('id'=>$row[0],
                            'username'=>$row[1],
                            'password'=>$row[2]
                        ));
                        $arr[] = $row;

                        //echo '{"data":' . json_encode($arr, JSON_UNESCAPED_UNICODE) . '}';
                        echo json_encode(array("logindata"=>$results), JSON_UNESCAPED_UNICODE);  
                        // Free result set
                        mysqli_free_result($result);
                    }
                    else{
                        //failed
                        array_push($results,
                        array('status'=>"success",
                            'desp'=>"Wrong Password!",
                            //'responseat'=>(new DateTime())->format('Ymdhm')
                            'responseat'=>date_format(new DateTime(), 'YmdH')
                        ));
                        //date_format(new DateTime(), 'Y-m-d H:i:s');
                        echo json_encode(array("data"=>$results), JSON_UNESCAPED_UNICODE);  
                    }
                    
                }
            } else{
                array_push($results,
                array('status'=>"success",
                    'desp'=>"Invalid Username!",
                    //'responseat'=>(new DateTime())->format('Ymdhm')
                    'responseat'=>date_format(new DateTime(), 'YmdH')
                ));
                //date_format(new DateTime(), 'Y-m-d H:i:s');
                echo json_encode(array("data"=>$results), JSON_UNESCAPED_UNICODE);  
            }
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