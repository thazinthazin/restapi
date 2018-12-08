<?php 
require_once('include/mysqli_connect.php');
header('content-type:application/json');

$actionName = $_POST["actionName"];

if ($actionName == "selectPost") {

	$query = "SELECT * FROM post ORDER BY id DESC";
	$result = mysqli_query($conn, $query);

	$rowCount = mysqli_num_rows($result);

	if ($rowCount . 0) {
		$postData = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$postData[] = $row;
		}
		$resultData = array('status' => true, 'postData' => $postData);
	} else {
		$resultData = array('status' => false, 'message' => 'No Post Found ...');
	}

	echo json_encode($resultData);
}

// if ($actionName == "insertPost") {

// 	$postName = isset($_POST["postName"]) ? $_POST["postName"] : '';
// 	$postDesc = isset($_POST["postDesc"]) ? $_POST["postDesc"] : '';

// 	$query = "INSERT INTO post(post_title, post_desc, status) VALUES('$postName', '$postDesc', 0)";
// 	$result = mysqli_query($conn, $query);

// 	if (!empty($postName) && !empty($postDesc)) {
// 		if ($result) {
// 			$resultData = array('status' => true, 'message' => 'New Post Inserted SUccessfully...');
// 		} else {
// 			$resultData = array('status' => false, 'message' => 'Cannot new Post Insert ...');
// 		}
// 	} else {
// 		$resultData = array('status' => false, 'message' => 'Please enter post details ...');
// 	}

// 	echo json_encode($resultData);
// }

 ?>