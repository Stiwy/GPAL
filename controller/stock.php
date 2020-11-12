<?php
require_once ('model/PaletteManager.php');

function index() {
	if (isset($_SESSION['warehouseman'])) {
		$paletteManager = new PaletteManager();
		$getPalette = $paletteManager->getPaletteManager();

		include ('view/stock/paletteManager.php');
	}else {
		require 'view/member/login.php';
	}
}

function searchPalette($reference) {
	$paletteManager = new PaletteManager();
	$getPalette = $paletteManager->searchPaletteManager($reference);
	require ('view/stock/paletteManager.php');
}

function getPaletteById($idPalette) {
	$paletteManager = new PaletteManager();
	$getPaletteById = $paletteManager->getPaletteByIdManager($idPalette);

	include 'view/stock/getPaletteById.php';
}

function movePalette($idPalette, $quanity_at_move, $new_weg, $new_shelf) {
	$paletteManager = new PaletteManager();
	$paletteManager->movePaletteManager($idPalette, $quanity_at_move, $new_weg, $new_shelf);
	
	header('Location: index.php?action=getpalette&idpalette='.$idPalette);
}

function updateQuantity($idPalette, $newQuantity) {
	$paletteManager = new PaletteManager();
	$paletteManager->updateQuantityManager($idPalette, $newQuantity);
}

function checkReference($checkReference) {
	$paletteManager = new PaletteManager();
	$paletteManager->checkReferenceManager($checkReference);
}

function addReference($reference) {
	$paletteManager = new PaletteManager();
	$paletteManager->addReferencManager($reference);
}

function addPalette($reference, $weg, $shelf, $quantity) {

	$paletteManager = new PaletteManager();
	$paletteManager->addPaletteManager($reference, $weg, $shelf, $quantity);

	header('Location: index.php?action=addpalette');
}

function notFound() {
	require 'view/stock/notFound.php';
}