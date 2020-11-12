<?php
require_once 'model/WarehousemanManager.php';

function logout()
{
    $warehousemanManager = new WarehousemanManager();
    $warehousemanManager->logoutMember();    
}

function login($warehousemanUsername, $warehousemanPassword) {
	$warehousemanManager = new WarehousemanManager();
	$warehousemanManager->loginMember($warehousemanUsername, $warehousemanPassword);
}

function loginByCookie() {
    $warehousemanManager = new WarehousemanManager();
    $warehousemanManager->loginByCookieMember();
}