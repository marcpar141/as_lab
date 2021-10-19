<?php
require_once dirname(__FILE__).'/../config.php';

include _ROOT_PATH.'/app/security/check.php';

function getParams(&$loan,&$interest,&$numOfInstallment){
	$loan = isset($_REQUEST['loan']) ? $_REQUEST['loan'] : null;
	$interest = isset($_REQUEST['interest']) ? $_REQUEST['interest'] : null;
	$numOfInstallment = isset($_REQUEST['numOfInstallment']) ? $_REQUEST['numOfInstallment'] : null;	
}

function validate(&$loan,&$interest,&$numOfInstallment,&$messages){

	if ( ! (isset($loan) && isset($interest) && isset($numOfInstallment))) {

		return false;
	}

	if ( $loan == "") {
		$messages [] = 'Nie podano kwoty kredytu';
	}
	if ( $interest == "") {
		$messages [] = 'Nie podano wartosci oprocentowania';
	}
	if ( $numOfInstallment == "")
	{
	    $messages [] = 'Nie podano ilosci rat';
	}


	if (count ( $messages ) != 0) return false;
	
	if (! is_numeric( $loan )) {
		$messages [] = 'Wartosc kredytu nie jest wartoscia liczbowa';
	}
	
	if (! is_numeric( $interest )) {
		$messages [] = 'Wartosc oprocentowania nie jest wartoscia liczbowa';
	}
	
	if(! is_numeric($numOfInstallment))
	{
	    $messages [] = 'Bledna ilosc rat';
	}
	
	if ($loan <= 0)
	{
	   $messages [] = 'Nie mozesz wziac kredytu na kwote mniejsza badz zeru';   
	}
	
	if ($interest < 0)
	{
	    $messages [] = 'Oprocentowanie kredytu nie moze byc wartoscia ujemna';
	}
	
	if ($numOfInstallment <= 0)
	{
	    $messages [] = 'Liczba rat musi byc liczba dodatnia';
	}

	if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$loan,&$interest,&$numOfInstallment,&$messages,&$loanInstallment, &$loanCost, &$loanInterest, &$percentageInterest){
	global $role;
	
	$loan = intval($loan);
	$interest = intval($interest);
	$numOfInstallment = intval($numOfInstallment);
	
	$loanInstallment = 0;
	
	for($i = 1; $i <= $numOfInstallment; $i++) {
	    $loanInstallment=$loanInstallment+(1/(pow(1+(($interest/100)/12),$i)));
	}
	
	if ($role != 'premium')
	{
	    $messages [] = 'Tylko uzytkownik konta premium moze poznac szczegoly kredytu';
	}
	
	$loanInstallment=round($loan/$loanInstallment,2);
	$loanCost=round($numOfInstallment*$loanInstallment,2);
	$loanInterest=$loanCost-$loan;
	$percentageInterest=round((($loanCost/$loan)-1)*100,2);
		
}

$loan = null;
$interest = null;
$numOfInstallment = null;
$loanInstallment = null;
$loanCost = null;
$loanInterest = null;
$percentageInterest = null;
$messages = array();

getParams($loan,$interest,$numOfInstallment);
if ( validate($loan,$interest,$numOfInstallment,$messages) ) {
    process($loan,$interest,$numOfInstallment,$messages, $loanInstallment, $loanCost, $loanInterest, $percentageInterest);
}

include 'calc_view.php';