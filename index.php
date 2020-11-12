<?php
require_once('controller/member.php');
require_once('controller/stock.php');;
if (session_status() == PHP_SESSION_NONE){session_start();}

if (isset($_COOKIE['PHPUSERID'])) {
	loginByCookie();
}

//##################
//If user is connect
//##################

if (isset($_SESSION["warehouseman"])) {

	if(isset($_GET["action"])){

		switch ($_GET["action"]) {

		    case "logout":
		        logout();
				break;
				
	        case "searchpalette":
		        searchPalette($_POST['shearchRefs']);
				break;

			case "addreference";
				if (isset($_GET['reference'])) {
					addReference($_GET['reference']);
				}
				break;

		    case "addpalette":
		    	if ($_POST) {
					if (isset($_POST['checkReference'])) {
						checkReference($_POST['checkReference']);
					}elseif (isset($_POST['reference']) && isset($_GET['reference']) && $_GET['reference'] == $_POST['reference']) {
						addPalette($_POST['reference'], $_POST['weg'], $_POST['shelf'], $_POST['quantity']);
					}else {
						require ('view/stock/checkReference.php');
					}
		    	}else {
					require ('view/stock/checkReference.php');
				}
				break;

			case "movepalette":
				if(isset($_GET["idpalette"])){
					movePalette($_GET["idpalette"], $_POST['quanity_at_move'], $_POST['new_weg'], $_POST['new_shelf']);
				}else {
					index();
				}
				break;

			case "updatequantity":
				if(isset($_GET["idpalette"])){
					updateQuantity($_GET["idpalette"], $_POST['new_quantity']);
				}else {
					index();
				}
				break;

			case "getpalette":
				if($_GET['idpalette']) {
					getPaletteById($_GET["idpalette"]);
				}else {
					index();
				}
				break;

			case "notfound":
				notFound();
				break;

		    default:
		        index();
		        break;
		}
	}else {
		index();
	}
	
//######################
//If user is not connect
//######################
}else {
	
	if (isset($_GET["action"])) {
		if ($_GET["action"] == "login"){
			login($_POST['warehousemanUsername'], $_POST['warehousemanUsername']);
		}else {
			index();
		}
	}else {
		index();
	}
}