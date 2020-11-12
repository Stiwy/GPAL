function getPalette ($id) {
    document.location.href="http://bor.santedistri.com/gpal/index.php?action=getpalette&idpalette=".concat($id);
}

function index() {
	if (document.getElementById('gpbi_move_palette_section').classList.contains('d-block')) {
		if (confirm("Souhaitez-vous retourner à l'accueil sans valider les modifications en cours ?")) {
			document.location.href="http://bor.santedistri.com/gpal/index.php";
		}
	}else if (document.getElementById('gpbi_update_quantity_section').classList.contains('d-block')) {
		if (confirm("Souhaitez-vous retourner à l'accueil sans valider les modifications en cours ?")) {
			document.location.href="http://bor.santedistri.com/gpal/index.php";
		}
	}else {
		document.location.href="http://bor.santedistri.com/gpal/index.php";
	}
}

function indexAdd() {
	document.location.href="http://bor.santedistri.com/gpal/index.php";
}

function buttonMovePalette(){

	let form = document.getElementById('gpbi_move_palette_section');
	let button = document.getElementById('buttonMovePalette');

	if (form.classList.contains('d-block')) {
		form.classList.remove('d-block');
		form.style.display = "none";
		button.style.background = '#117198';
	}else {
		form.classList.add('d-block');
		form.style.display = "block";
		button.style.background = '#01abd4';

	}
}

function buttonUpdateQuantity(){

		let form = document.getElementById('gpbi_update_quantity_section');	
		let button = document.getElementById('updateQuantity');

		if (form.classList.contains('d-block')) {
			form.classList.remove('d-block');
			form.style.display = "none";
			button.style.background = '#117198';
		}else {
			form.classList.add('d-block');
			form.style.display = "block";
			button.style.background = '#01abd4';
		}
}

function buttonAdd(){
	document.location.href = "http://bor.santedistri.com/gpal/index.php?action=addpalette";
}

function buttonLogout() {
	if(confirm('Souhaitez-vous vous déconnecter ?')) {
		document.location.href = "http://bor.santedistri.com/gpal/index.php?action=logout";
	}
}

function getValueSelctWeg() {
	var $wegValue = document.getElementById('new_weg').value;

	if ($wegValue != "A1" && $wegValue != "A14") {
		document.getElementById('r23').style.display ="none";
		document.getElementById('r24').style.display ="none";
	}else if ($wegValue == "A1" || $wegValue == "A14") {
		document.getElementById('r23').style.display ="block";
		document.getElementById('r24').style.display ="block";
	}
}

