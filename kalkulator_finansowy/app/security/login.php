<?php
require_once dirname(__FILE__).'/../../config.php';

function getParamsLogin(&$form){
	$form['login'] = isset ($_REQUEST ['login']) ? $_REQUEST ['login'] : null;
	$form['pass'] = isset ($_REQUEST ['pass']) ? $_REQUEST ['pass'] : null;
}

function validateLogin(&$form,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($form['login']) && isset($form['pass']))) {
	    
		return false;
	}

	if ( $form['login'] == "") {
		$messages [] = 'Nie podano loginu';
	}
	if ( $form['pass'] == "") {
		$messages [] = 'Nie podano hasła';
	}

	if (count ( $messages ) > 0) return false;

	if ($form['login'] == "premium" && $form['pass'] == "4321") {
		session_start();
		$_SESSION['role'] = 'premium';
		return true;
	}
	if ($form['login'] == "free" && $form['pass'] == "1234") {
		session_start();
		$_SESSION['role'] = 'free';
		return true;
	}
	
	$messages [] = 'Niepoprawny login lub haslo';
	return false; 
}


$form = array();
$messages = array();


getParamsLogin($form);

if (!validateLogin($form,$messages)) {

	include _ROOT_PATH.'/app/security/login_view.php';
} else { 
	
	header("Location: "._APP_URL);

}