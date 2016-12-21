<?php 

$typeOfInfo = $_GET['Type'];
$id = $_GET['BCID'];
$username = $_GET['BCUNAME'];
$format = $_GET['Format'];

$doc = new DOMDocument;
$doc->preserveWhiteSpace = false;
$doc->strictErrorChecking = false;
$doc->recover = true;
$doc->loadHTMLFile("https://www.bloxcity.com/users/$id/$username/");
$xpath = new DOMXPath($doc);
$query = "//div[@style='font-size:22px;']";
$entries = $xpath->query($query);
if ( $typeOfInfo == 'gameVisits' ) {
	$result = $entries->item(0)->textContent;
} elseif ( $typeOfInfo == 'joinDate' ) {
	$result = $entries->item(1)->textContent;
} elseif ( $typeOfInfo == 'friendCount' ) {
	$result = $entries->item(2)->textContent;
} elseif ( $typeOfInfo == 'forumPosts' ) {
	$result = $entries->item(3)->textContent;
}
if ( $format == 'text' ) {
	if (strlen($result) > 0) {
		echo $result;
	} else {
		echo 'Error';
	}
} elseif ( $format == 'json' ) {
	header('Content-Type: application/json');
	if (strlen($result) > 0) {
		$informationArray = array($typeOfInfo => $result);
		echo json_encode($informationArray);
	} else {
		echo 'Error';
	}
} else {
	echo 'Invalid Format!';
}
?>