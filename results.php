<?php
// PREREQUISITES
require_once ("functions.php");
include_once ("queries.php");


// SESSION START
path_aware_session_start();
$sidc=session_id();


include ("header.php");


echo "<h1>Wyniki głosowania:</h1>";


// ESTABLISHING CONNECTION
echo "<p>Łączenie z bazą...</p>";
try {
    $dbo = new VotingPDO();
}
catch (PDOException $e) {
    echo "<p>Błąd połączenia: {$e->getMessage()}</p>";
    echo "<p>Spróbuj jeszcze raz. ";
    echo "<a href='index.php'>Wróć do formularza.</a></p>";
    exit();
}
echo "<p>Połączono z bazą. Rozpoczęto pobieranie wyników.</p>";

//echo "<p>Nikt jeszcze nie głosował. <a href='index.php'>Wróć do formularza i zagłosuj.</a></p>";
// PULL RESULTS
$result = $dbo->query($query_results_all);
if (!$result) {
    echo "<p>Błąd zapytania SELECT.</p>";
    var_dump($query);
    echo "
<p>Coś poszło nie tak. Prawdopodobnie nikt jeszcze nie głosował. 
<a href='index.php'>Wróć do formularza i zagłosuj.</a></p>";
    exit();
}
echo "<p>Pobrano wyniki.</p>";


// CREATE TABLE VAR FOR STRUCTURED RESULTS
$results = array(
    "left" => 0,
    "forward" => 0,
    "right" => 0,
    "backward" => 0,
    "break" => 0
);


// PUT RESULTS TO TABLE
while ($row = $result->fetch(PDO::FETCH_NUM)){
    $results["$row[0]"] += $row[1];
}


// ECHO RESULTS
echo "
<table>
    <tr><td>Skręcam w lewo!:</td><td>{$results['left']}</td></tr>
    <tr><td>Idę prosto!:</td><td>{$results['forward']}</td></tr>
    <tr><td>Skręcam w prawo!:</td><td>{$results['right']}</td></tr>
    <tr><td>Zawracam!:</td><td>{$results['backward']}</td></tr>
    <tr><td>Robię sobię przerwę! <br>
    Nie jestem leniwy, <br>
    tylko Enegrooszczędny!:</td><td>{$results['break']}</td></tr>
</table>";


echo "<p><a href='index.php'>Wróć do formularza.</a></p>";
include ("footer.php");

session_destroy();
$dbo = null;