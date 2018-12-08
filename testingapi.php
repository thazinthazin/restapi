<?php

header("Content-Type:application/json");

$conn = mysqli_connect("localhost", "root", "", "testingdb");

$actionName = $_POST["actionName"];

if ($actionName == "selectPost") {

	$query = "SELECT id,username,password FROM `mdl_user` ORDER BY id DESC LIMIT 3";
	$result = mysqli_query($conn, $query);

	$rowCount = mysqli_num_rows($result) > 0;
        
	if ($rowCount) {
		$postData = array();
		while ($row = mysqli_fetch_assoc($result)) {
                    array_push($results,
                        array("id" => $id,
                            "username" => $username,
                            "password" => $password
                    ));
			$postData[] = $row;
		}
		$resultData = array('status' => true, 'postData' => $postData);
	} else {
		$resultData = array('status' => false, 'message' => 'No Post Found ...');
	}

	echo json_encode($resultData);
}


// Close connection
mysqli_close($conn);
?>
