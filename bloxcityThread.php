<?php 

$typeOfInfo = $_GET['Type'];
$id = $_GET['ThreadID'];
$format = $_GET['Format'];
$nl2br = $_GET['nl2br'];

$doc = new DOMDocument;
$doc->preserveWhiteSpace = false;
$doc->strictErrorChecking = false;
$doc->recover = true;
$doc->loadHTMLFile("https://www.bloxcity.com/forum/thread/$id/");
$xpath = new DOMXPath($doc);
$query2 = "//div[@style='font-size:18px;color:#666;padding-bottom:15px;']";
$entries2 = $xpath->query($query2);
$result2 = $entries2->item(0)->textContent;

if ($result2 == "This forum post could not be found. It is likely that a moderator deleted this post or it never existed.") {
	die('Error: Forum post not found.');
}

if ( $typeOfInfo == 'threadBody' ) { 
	$query = "//div[@style='word-break:break-word;']";
	$entries = $xpath->query($query);
	$result = $entries->item(0)->textContent;
} elseif ( $typeOfInfo == 'threadDate' ) {
	$query = "//div[@style='font-size:14px;color:#777;padding-bottom:10px;']";
	$entries = $xpath->query($query);
	$result = $entries->item(0)->textContent;
	$result = substr($result , 13 , -1);
} elseif ( $typeOfInfo == 'threadTitle' ) {
	$query = "//div[@style='color:white;padding:15px 25px;']";
	$entries = $xpath->query($query);
	$result = $entries->item(0)->textContent;
	$result = substr($result , 1 , -1);
} elseif ( $typeOfInfo == 'threadCreator' ) {
	$query = "//a";
	$entries = $xpath->query($query);
	$result = $entries->item(21)->textContent;
} elseif ( $typeOfInfo == 'threadTopic' ) {
	$query = "//a";
	$entries = $xpath->query($query);
	$result = $entries->item(20)->textContent;
} elseif ( $typeOfInfo == 'threadTopicExtended' ) {
	$query = "//a";
	$entries = $xpath->query($query);
	$r1 = $entries->item(18)->textContent;
	$r2 = $entries->item(19)->textContent;
	$r3 = $entries->item(20)->textContent;
	
	$result = $r1.' > '. $r2 .' > '. $r3;
} elseif ( $typeOfInfo == 'threadPages' ) {
	$query = "//ul[@class='pagination center-align']";
	$entries = $xpath->query($query);
	$result = $entries->item(0)->textContent;
	if ($result == NULL ) {
		$result = "1";
	} else {
		$result = "2+";
	}
} elseif ( $typeOfInfo == 'all' ) { 
	
}
if ( $format == 'text' ) {
	if (strlen($result) > 0) {
		if ($nl2br == true) {
		echo nl2br($result);
		} else {
		echo $result;
		}
	} else {
		echo 'Error';
	}
} elseif ( $format == 'json' ) {
	header('Content-Type: application/json');
	if (strlen($result) > 0) {
		$informationArray = array($typeOfInfo => $result);
		echo json_encode( $informationArray);
	} else {
		echo 'Error';
	}
} else {
	echo 'Invalid Format!';
}
?>