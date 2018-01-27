<?php
// PREREQUISITES
require_once ("functions.php");


// SESSION START
path_aware_session_start();
$sidc=session_id();


// HTML START
include ("header.php");


echo <<<EOT
<h1>Witaj Wędrowcze!</h1>
<h2>Dzieci i ryby głosu nie mają, a pozostałych zapraszamy do głosowania.</h2>
<form action="voting.php" method="POST">
    <fieldset>
        <legend>Wędrując przez las i dochodząc do skrzyżowania dróg, co robisz?</legend>
        <input type="radio" name="voting" value="left" checked>Skręcam w lewo!<br>
        <input type="radio" name="voting" value="forward">Idę prosto!<br>
        <input type="radio" name="voting" value="right">Skręcam w prawo!<br>
        <input type="radio" name="voting" value="backward">Zawracam!<br>
        <input type="radio" name="voting" value="break">Robię sobię przerwę! Nie jestem leniwy, tylko Enegrooszczędny!<br>
    </fieldset>
    <input type="hidden" name="sid" value="{$sid}">
    <input type="submit" name="vote" value="Głosuj">
</form>
<p><a href="results.php">Sprawdź wyniki</a></p>
EOT;


include ("footer.php");
// HTML END
?>
