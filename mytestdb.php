<?php


$conn = mysqli_connect("localhost", "root", "", "crud55");

$username = "admin";
$password = "admin@12";


$query = "SELECT * FROM users WHERE name like '$username'";
$result = mysqli_query($conn, $query);

$rowCount = mysqli_num_rows($result);
if ($rowCount > 0) {
    $row = mysqli_fetch_assoc($result);
    // echo json_encode($row);
    if(password_verify($password, $row["password"])){
        //success
        echo "Login Success";
    }
    else{
        //failed
        echo "Wrong Password";
    }
    
} else {
	echo "Invalid User";
}


    
/*if ($rowCount > 0) {
	$postData = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$postData[] = $row;
	}
	$resultData = array('status' => true, 'postData' => $postData);
} else {
	$resultData = array('status' => false, 'message' => 'No Post Found ...');
}*/

// echo json_encode($resultData);



// Close connection
mysqli_close($conn);
?>
