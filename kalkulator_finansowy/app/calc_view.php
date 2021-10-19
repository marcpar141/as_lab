<?php ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Kalkulator</title>
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
	<a href="<?php print(_APP_ROOT); ?>/app/inna_chroniona.php" class="pure-button">kolejna chroniona strona</a>
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
</div>

<div style="width:90%; margin: 2em auto;">

<form action="<?php print(_APP_ROOT); ?>/app/calc.php" method="post" class="pure-form pure-form-stacked">
	<legend>Kalkulator</legend>
	<fieldset>
		<label for="id_loan">Kwota kredytu: </label>
		<input id="id_loan" type="text" name="loan" value="<?php out($loan) ?>" />
		<label for="id_interest">Oprocentowanie kredytu: </label>
		<input id="id_interest" type="text" name="interest" value="<?php out($interest) ?>" />
		<label for="id_numOfInstallment">Ilosc rat: </label>
		<input id="id_numOfInstallment" type="text" name="numOfInstallment" value="<?php out($numOfInstallment) ?>" />
	</fieldset>	
	<input type="submit" value="Oblicz" class="pure-button pure-button-primary" />
</form>	

<?php

if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #f88; width:25em;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($loanInstallment) & isset($loanCost) & isset($loanInterest) & isset($percentageInterest) & $role == 'premium'){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:350px;">
<?php
 echo 'Rata kredytu: '.$loanInstallment.' zl<br>'; 
 echo 'Koszt kredytu: '.$loanCost.' zl<br>';
 echo 'Odsetki: '.$loanInterest.' zl<br>';
 echo 'Rzeczywiste oprocentowanie: '.$percentageInterest.' %<br>';
 ?>
</div>
<?php } ?>

</body>
</html>