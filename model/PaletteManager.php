<?php
require_once 'Manager.php';

/**
 * paletteManager
 * Contain all functions for collecting and modifying pallet table data;
 * Extends Manager for using SQL query;
 */
class paletteManager extends Manager
{
	
	private $error = []; //Check all errors, and return in array
    private $success = []; //Check the success operation, and return in array

        
    /**
     * secureInput
     * Removes special character and target spaces to avoid security vulnerabilities;
     * @param  mixed $target
     * @return void
     */
	private function secureInput($target) {
		$target = htmlspecialchars($target); 
		$target = trim($target);
	 	$target = strip_tags($target); 

	 	return $target;
	}

	
	/**
	 * testId
	 * Verify if $idPalette is valid, if ID exist in the table, have return data information of the palette else return page not found;
	 * @param  mixed $idPalette
	 * @return array $req OR one throw Exception
	 */
	private function testId($idPalette) {

		try {
			if(!is_numeric($idPalette) || is_null($idPalette) || empty($idPalette)) {
				
				throw new Exception("L'identifiant de la palette est invalide !");
	
			}else {
	
				$idPalette = $this->secureInput($idPalette); 
	
				 $req = $this->pdoSelect("palette", "id = ?", "reference", $idPalette);
	
				if ($req->rowCount() != 0) {
	
					$result = $req->fetch();
					return $result;
	
				}else {
	
					throw new Exception("Aucune palette correspondant à cette identifiant !");
				}
				
			}
			
		} catch (Exception $notFound) {
			require 'view/stock/notFound.php';
			die();
		} 
	}
	
	/**
	 * getPaletteManager
	 * Get the first 10 pallets of the table, for the index page;
	 * @return void
	 */
	public function getPaletteManager() {

		$getpaletteManager = $this->dbConnect()->query('SELECT * FROM palette ORDER BY reference LIMIT 0, 10');

		return $getpaletteManager;
	}

		
	/**
	 * searchPaletteManager
	 * Collect the reference in the search bar and return the list of pallets corresponding to the reference;
	 * @param  mixed $reference;
	 * @return array $searchpalette OR function getPaletteManager()
	 */
	public function searchPaletteManager($reference) {

		if (isset($reference) && !empty($reference) && !is_null($reference)) {

			$reference = $this->secureInput($reference);

			$searchpalette = $this->dbConnect()->prepare('SELECT * FROM palette WHERE reference LIKE ? ORDER BY reference');
			$searchpalette->execute(array("%".$reference."%"));

			return $searchpalette;

		}else {

			return $this->getPaletteManager();
		}
	}
	

	/**
	 * getPaletteByIdManager
	 * If ID exist in the table, have return data information of the palette;
	 * @param  mixed $idPalette
	 * @return void
	 */
	public function getPaletteByIdManager($idPalette) {

		$result = $this->testId($idPalette);
		return $result;
		
	}
	
	/**
	 * movePaletteManager
	 * Move the palette selected;
	 * @param  mixed $idPalette
	 * @param  mixed $quantity_at_move
	 * @param  mixed $new_weg
	 * @param  mixed $new_shelf
	 */
	public function movePaletteManager($idPalette, $quantity_at_move, $new_weg, $new_shelf) {

		$resultPaletteByID = $this->testId($idPalette);

		if (!is_null($quantity_at_move) || !empty($quantity_at_move) || isset($quantity_at_move) || !is_null($new_weg) || !empty($new_weg) || isset($new_weg) || !is_null($new_shelf) || !empty($new_shelf) || isset($new_shelf)) {
			
			$new_weg = $this->secureInput($new_weg);
			$new_weg = substr($new_weg, 1);
			
			$new_shelf = $this->secureInput($new_shelf); 
			$new_shelf = substr($new_shelf, 1);

			if ($new_weg < 1 || $new_weg > 14) { //Verify the location exist A1 AND A14 = R1 at R24 AND other = R1 at R22
				$this->error['location'] = "Le chiffre de l'allée indiqué est incorrecte !";
				
			}elseif (($new_weg != 1 && $new_shelf > 22) && ($new_weg != 14 && $new_shelf > 22)) {
				$this->error['location'] = 'Le rayon ' . $new_shelf . ' n\'existe pas dans l\'allée ' . $new_weg;

			}elseif(($new_weg == 1 && $new_shelf > 24) || ($new_weg == 14 && $new_shelf > 24)) {
				$this->error['location'] = 'Le rayon ' . $new_shelf . ' n\'existe pas dans l\'allée ' . $new_weg;

			}elseif($new_weg == $resultPaletteByID['weg'] && $new_shelf == $resultPaletteByID['shelf']) {
				$this->error['location'] = 'Vous ne pouvez pas saisir le même emplacement que celui actuellement utilisé !';
			}

		}else {

			$this->error['location'] = "Veuillez remplir tous les champs du formulaire";

		}

		if (empty($this->error)) {
			
			$refExistAtTheLocation = $this->dbConnect()->prepare('SELECT * FROM palette WHERE reference = ? AND weg = ? AND shelf = ?');
			$refExistAtTheLocation->execute(array($resultPaletteByID['reference'], $new_weg, $new_shelf));

			if ($quantity_at_move == $resultPaletteByID['quantity']) { // Verify if have move all palette

				if ($refExistAtTheLocation->rowCount() != 0) { // Verify if one palette of the reference exist in the new location

					$searchQuantity = $refExistAtTheLocation -> fetch();
					$newQuantity = $resultPaletteByID['quantity'] + $searchQuantity['quantity']; 

					$this->pdoDelete("palette", "id = ". $searchQuantity['id']); // The pallet already in the new location is removed

					$this->pdoUpdate("palette", "weg = $new_weg, shelf = $new_weg, quantity = $newQuantity", "id = $idPalette"); // The pallet to be moved is updated by adding the amount of the pallet remove

					$this->success['location'] = "Palette déplacé avec success en A$new_weg | R$new_weg";

				}else {
					$this->pdoUpdate("palette", "weg = $new_weg, shelf = $new_weg", "id = $idPalette");

					$this->success['location'] = "Palette déplacé avec success en A$new_weg | R$new_weg";
				}

			}elseif ($quantity_at_move <= $resultPaletteByID['quantity'] && $quantity_at_move >= 1) { // We check if the number of pallets is greater than 1 and less than the total number of pallets

					$newQuantity = $resultPaletteByID['quantity'] - $quantity_at_move;
					$this->pdoUpdate("palette", "quantity = $newQuantity", "id = $idPalette");

					if ($refExistAtTheLocation -> rowCount() != 0) { // Verify if one palette of the reference exist in the new
						$searchQuantity = $refExistAtTheLocation -> fetch();
						$newQuantity = $quantity_at_move + $searchQuantity['quantity'];

						$id =$searchQuantity['id'];
						$this->pdoUpdate("palette", "quantity = $newQuantity", "id = $id"); 

						$this->success['location'] = "Palette déplacé avec success en A$new_weg | R$new_shelf";

					}else {
						$this->pdoInsert("palette", $resultPaletteByID['reference'], $new_weg, $new_shelf, $quantity_at_move);

						$this->success['location'] = "Palette déplacé avec success en A$new_weg | R$new_weg";
					}

			}else {
				$this->error['quantity_at_move'] = "Le nombre de palette à déplacer est plus grand que le nombre de palettes total pour cette référence";

				$_SESSION['error'] = $this->error;
			}
			
			$_SESSION['success'] = $this->success;
		}else {
			$_SESSION['error'] = $this->error;
		}
	}
	
	
	/**
	 * updateQuantityManager
	 * Modify the quantity of palette in one location
	 * @param  mixed $idPalette
	 * @param  mixed $newQuantity
	 */
	public function updateQuantityManager($idPalette, $newQuantity) {
		$result = $this->testId($idPalette);

		if (!is_numeric($newQuantity) || $newQuantity < 0 || !isset($newQuantity)) {
			$this->error['quantity'] = "La quantité n'est pas valide !";
		}

		$newQuantity = $this->secureInput($newQuantity);

		if (empty($this->error)) {

			if ($newQuantity == 0) { // If the new quantity = 0 then delete the palette

				$this->pdoDelete("palette", "id=$idPalette");

				$success['quantity'] = "La quantité à bien été mis à jour !";
				$_SESSION['success'] = $success;
				header('Location: index.php');

			}else {
				$this->pdoUpdate ("palette", "quantity = $newQuantity", "id = $idPalette");

				$success['quantity'] = "La quantité à bien été mis à jour !";
				$_SESSION['success'] = $success;
				header('Location: index.php?action=getpalette&idpalette='.$idPalette);
			}
		}
	}
	
	/**
	 * checkReferenceManager
	 * Verify if the reference exist in the db 
	 * @param  mixed $reference
	 * @return void
	 */
	public function checkReferenceManager($reference) {
		$req = $this->dbConnect()->prepare('SELECT * FROM reference_gpal WHERE reference = ?');
		$req->execute(array($reference));

		if ($req->rowCount() == 0 ) { // If don't exist, return error message for add new reference 
			$this->error['ref'] = "<span class='center_message_flash'>Cette référence existe pas, souhaitez-vous l'ajouter ? <br><br> <a class='button_add_reference' href=\"index.php?action=addreference&reference=$reference\">Ajouter</a></span>";
			$_SESSION['error'] = $this->error;
			
			header("location:".  $_SERVER['HTTP_REFERER']); 
		}else { // Call the complete form for add palette
			require 'view/stock/addPalette.php';
		}
	}
	
	/**
	 * addReferencManager
	 * Add the reference in the table reference_gpal
	 * @param  mixed $reference
	 * @return void
	 */
	public function addReferencManager($reference) {

		if (!empty($reference) && isset($reference) && !is_null($reference)) {
			$reference = $this->secureInput($reference);
			$reference = strtoupper($reference); 
			 
			$this->dbConnect()->prepare('INSERT INTO reference_gpal(reference) VALUE(?)')->execute(array($reference));
			$this->success['ref'] = 'Référence ajouté avec success !';
			
			$_SESSION['success'] = $this->success;
			require 'view/stock/addPalette.php';
		}else {
			$this->error['reference'] = "Veuillez saisir une référence";
			header("location:".  $_SERVER['HTTP_REFERER']); 
		}
	}
	
	/**
	 * addPaletteManager
	 *
	 * @param  mixed $reference
	 * @param  mixed $weg
	 * @param  mixed $shelf
	 * @param  mixed $quantity
	 * @return void
	 */
	public function addPaletteManager($reference, $weg, $shelf, $quantity) {

		if (!empty($reference) && isset($reference) && !is_null($reference)) {
			$reference = $this->secureInput($reference);
		 	$reference = strtoupper($reference); 
		}else {
			$this->error['reference'] = "Veuillez saisir une référence";
		}

	 	if (!empty($weg) && isset($weg) && !is_null($weg) && !empty($shelf) && isset($shelf) && !is_null($shelf)) {
	 		$weg = $this->secureInput($weg);
	 		$weg = substr($weg, 1);
	 		
	 		$shelf = $this->secureInput($shelf); 
	 		$shelf = substr($shelf, 1);

	 		if ($weg < 1 || $weg > 14) {
	 			$this->error['location'] = "Le chiffre de l'allée indiqué est incorrecte !";
	 		}
	 		if (($weg != 1 && $shelf > 22) && ($weg != 14 && $shelf > 22)) {
	 			$this->error['location'] = 'Le rayon ' . $shelf . ' n\'existe pas dans l\'allée ' . $weg;
	 		}elseif(($weg == 1 && $shelf > 24) || ($weg == 14 && $shelf > 24)) {
	 			$this->error['location'] = 'Le rayon ' . $shelf . ' n\'existe pas dans l\'allée ' . $weg;
	 		}
	 	}else {
	 		$this->error['location'] = "Veuillez saisir un emplacement";
	 	}

	 	if (!empty($quantity) && isset($quantity) && !is_null($quantity)) {

	 		$quantity = $this->secureInput($quantity);

	 		if(!is_numeric($quantity)) {
	 			$this->error['quantity'] = "La valeur de la quantité doit être numérique !";
	 		}

	 		if ($quantity < 0 || $quantity > 100) {
	 			$this->error['quantity'] = "La quantité doit êtres compris entre 0 et 100 !";
	 		}
	 	}else {
	 		$this->error['quantity'] = "Veuillez saisir la quantité";
		 }
		

	 	if (empty($this->error)) {

			$refExistAtTheLocation = $this->dbConnect()->prepare('SELECT * FROM palette WHERE reference = ? AND weg = ? AND shelf = ?');
			$refExistAtTheLocation->execute(array($reference, $weg, $shelf));


			if ($refExistAtTheLocation->rowCount() != 0) { //If you add a pallet by selecting a location already taken by a pallet of the same reference you add just the two quantities

				$resultRefExistAtTheLocation = $refExistAtTheLocation->fetch();
				$newQuantity = $resultRefExistAtTheLocation['quantity'] + $quantity;
				$id = $resultRefExistAtTheLocation['id'];
				
				$this->pdoUpdate("palette", "quantity = $newQuantity", "id = $id");

			} else {

				$this->pdoInsert("palette", $reference, $weg, $shelf, $quantity);
			}

			 if (session_status() == PHP_SESSION_NONE){session_start();}
			 
			$this->success['addpalette'] = "La palette à bien été ajouté";
			$_SESSION['success'] = $this->success;
	 	}else {

	 		if (session_status() == PHP_SESSION_NONE){session_start();}
			 $_SESSION['error'] = $this->error;
			 
	 	}
	}
}