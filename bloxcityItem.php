<?php 

$typeOfInfo = $_GET['Type'];
$id = $_GET['ID'];
$format = $_GET['Format'];
$nl2br = $_GET['nl2br'];

$doc = new DOMDocument;
$doc->preserveWhiteSpace = false;
$doc->strictErrorChecking = false;
$doc->recover = true;
$doc->loadHTMLFile("https://www.bloxcity.com/market/$id/");
$xpath = new DOMXPath($doc);
$query2 = "//center";
$entries2 = $xpath->query($query2);
$result2 = $entries2->item(0)->textContent;
$errorArray = array (
			'Error' => 'Item not found'
		);
$errorJSON = json_encode($errorArray);

if ($result2 == "We're sorry, this item could not be found." && $format == "json") {
	header('Content-Type: application/json');
	$errorArray = array (
			'Error' => 'Item not found'
	);
	$errorJSON = json_encode($errorArray);
	echo $errorJSON;
	die();
} elseif($result2 == "We're sorry, this item could not be found." && $format == "text") {
	echo 'Item not found!';
	die();
}

if ( $typeOfInfo == 'ev' ) { 
$itemQ7 = "//div[@style='font-size:12px;color:#E71D36;']";
	$itemE7 = $xpath->query($itemQ7);
	$itemR7 = $itemE7->item(0)->textContent;
	if (strlen($itemR7) == 0) {
		$ItemResult15 = false;
	} elseif (strlen($itemR7) > 0) {
		$ItemResult15 = true;
	} else {
		$ItemResult15 = "unknown";
	}
	if ($ItemResult15 == true) {
		$itemQ8 = "//font[@color='#00b200']";
		$itemE8 = $xpath->query($itemQ8);
		$ItemResult16 = $itemE8->item(0)->textContent;
		$result = intval(preg_replace('/[^0-9]+/', '', $ItemResult16), 10);
	} elseif($ItemResult15 == false) {
		$result = 0;
	} elseif($ItemResult15 == "unknown") {
		$result = "error";
	}
} elseif ( $typeOfInfo == 'threadDate' ) {
	$query = "//div[@style='font-size:14px;color:#777;padding-bottom:10px;']";
	$entries = $xpath->query($query);
	$result = $entries->item(0)->textContent;
	$result = substr($result , 13 , -1);
} elseif ( $typeOfInfo == 'all' ) {
	
	$itemAVATARTypes = array (
		" AVATAR hat",
		" AVATAR accessory",
		" AVATAR shirt",
		" AVATAR pants",
		" AVATAR tshirt",
	);
	
	$itemTypes = array (
		"hat",
		"accessory",
		"shirt",
		"pants",
		"tshirt",
	);
	
	// Get cost of Item
	$itemQ1CA = "//a[@class='waves-effect waves-light btn green disabled']";
	$itemE1CA = $xpath->query($itemQ1CA);
	$itemQ1CO = "//a[@class='waves-effect waves-light btn orange lighten-2 disabled']";
	$itemE1CO = $xpath->query($itemQ1CO);
	$ItemResult = $itemE1CA->item(0)->textContent;
	$ItemResultCO = $itemE1CO->item(0)->textContent;
	if(strlen($ItemResult) == 0 && strlen($ItemResult) == 0) { 
		$ItemResult = "0 ";
		$ItemResult9 = "none";
		$ItemResult14 = false;
	} elseif(empty($ItemResult) && strlen($ItemResultCO) > 0) {
		$ItemResult = $itemE1CO->item(0)->htmlContent;
		$ItemResult9 = "coins";
		$ItemResult14 = true;
	} elseif (empty($ItemResultCO) && strlen($ItemResult) > 0) {
		$ItemResult = $itemE1CA->item(0)->textContent;
		$ItemResult9 = "cash";
		$ItemResult14 = true;
	} 
	if(strlen($ItemResult) > 0 && strlen($ItemResultCO) > 0) {
		$ItemResult9 = "both";
	}
	$ItemResult = intval(preg_replace('/[^0-9]+/', '', $ItemResult), 10);
	
	// Get creator of an Item
	$itemQ2 = "//a[@style='padding-top:12px;font-size:16px;display:inline-block;']";
	$itemE2 = $xpath->query($itemQ2);
	$ItemResult2 = $itemE2->item(0)->textContent;
	
	//Get Creator's ID
	$userInfo = array (
		"https://www.bloxcity.com/users/",
		"/$ItemResult2/"
	);
	$profileLINK = $itemE2->item(0)->attributes->getNamedItem('href')->nodeValue;
	$CreatorID = str_replace($userInfo, "" , $profileLINK);
	
	// Get main information of an Item
	$itemQ3 = "//div[@style='font-size:20px;']";
	$itemE3 = $xpath->query($itemQ3);
	$ItemResult3 = $itemE3->item(0)->textContent; // Get date created of an Item
	$ItemResult4 = $itemE3->item(1)->textContent; // Get last updated date of an Item
	$ItemResult5 = $itemE3->item(2)->textContent; // Get number sold of an Item
	$ItemResult6 = $itemE3->item(3)->textContent; // Get number favorited of an Item
	
	//Get Item Name
	$itemQ4 = "//div[@style='font-size:32px;font-weight:300;']";
	$itemE4 = $xpath->query($itemQ4);
	$ItemResult7 = $itemE4->item(0)->textContent; // Get title of an Item
	$ItemResult7 = str_replace( $itemAVATARTypes, '' , $ItemResult7 );
	
	//Get Item Type
	$ItemResult8 = $itemE4->item(0)->textContent; // Get title of an Item
	$ItemResult8 = str_replace( $ItemResult7, '', $ItemResult8 );
	$ItemResult8 = str_replace( $itemAVATARTypes, $itemTypes , $ItemResult8 );
	
	//Get Item Thumbnail
	$itemQ5 = "//img[@class='responsive-img']";
	$itemE5 = $xpath->query($itemQ5);
	$ItemResult10 = $itemE5->item(0)->attributes->getNamedItem('src')->nodeValue;
	
	//Get Item ID
	$ItemResult11 = htmlentities(intval($id));
	
	//Get Item Description
	$itemQ6 = "//div[@style='color:#777;font-size:14px;']";
	$itemE6 = $xpath->query($itemQ6);
	$ItemResult12 = $itemE6->item(0)->textContent; // Get title of an Item
	
	// Find if item is a collectible
	$itemQ7 = "//div[@style='font-size:12px;color:#E71D36;']";
	$itemE7 = $xpath->query($itemQ7);
	$itemR7 = $itemE7->item(0)->textContent;
	if (strlen($itemR7) == 0) {
		$ItemResult15 = false;
	} elseif (strlen($itemR7) > 0) {
		$ItemResult15 = true;
	} else {
		$ItemResult15 = "unknown";
	}
	
	// Find item's stock
	if ($ItemResult15 == true) {
		$stock = explode(" out of ", $itemR7);
		$availableStock = $stock[0];
		$unavailableStock = str_replace(" remaining", "", $stock[1]);
	} elseif ($ItemResult15 == false && $onSale == true) {
		$availableStock = "infinite";
		$unavailableStock = $ItemResult5;
	} elseif ($ItemResult15 == false && $onSale == false) {
		$availableStock = "0";
		$unavailableStock = $ItemResult5;
	} else {
		$availableStock = 'error';
		$unavailableStock = $ItemResult5;
	}
	// Find item's stock estimated value
	if ($ItemResult15 == true) {
		$itemQ8 = "//font[@color='#00b200']";
		$itemE8 = $xpath->query($itemQ8);
		$ItemResult16 = $itemE8->item(0)->textContent;
		$ItemResult16 = intval(preg_replace('/[^0-9]+/', '', $ItemResult16), 10);
	} elseif($ItemResult15 == false) {
		$ItemResult16 = 0;
	}
	//Get Creator's Avatar 
	$avatarAPI = file_get_contents("https://www.bloxcity.com/API/GetAvatar.php?UserID=$CreatorID");
	$avatarJSON = json_decode($avatarAPI, true);
	$avatarImage = $avatarJSON['avatar'];
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
	if (strlen($result || $ItemResult) > 0 || $ItemResult == 0) {
		if ($typeOfInfo == 'all' ) {
			if ($ItemResult9 === "both") {
				
			}
			$informationArray = array("price" => $ItemResult, "creator" => $ItemResult2, "creatorID" => $CreatorID, "created" => $ItemResult3, "updated" => $ItemResult4, "sold" => $ItemResult5, "favorited" => $ItemResult6, "title" => $ItemResult7, "type" => $ItemResult8, "currency" => $ItemResult9, "thumbnail" => $ItemResult10, "ID" => $ItemResult11, "creatorAvatar" => $avatarImage, "onSale" => $ItemResult14, "collectible" => $ItemResult15, "availableStock" => $availableStock, "unavailableStock" => $unavailableStock, "estimatedValue" => $ItemResult16 , "itemDescription" => $ItemResult12);
			echo json_encode( array ("Item", $informationArray), JSON_PRETTY_PRINT );
		} else {
			$informationArray = array( $typeOfInfo => $result);
			echo json_encode( $informationArray, JSON_PRETTY_PRINT );
		}
	} else {
		echo 'Error';
	}
} else {
	echo 'Invalid Format!';
}
?>