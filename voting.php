<?php
// PREREQUISITES
require_once ("functions.php");
include_once ("queries.php");


// SESSION START
path_aware_session_start();
$sidc=session_id();


// INITIAL
// Jeśli formularz głosowania został przesłany, zapisz odpowiedź do zmiennej.
// Jeśli formularz nie został przesyłany, to nie powinno Cię tu być, wracaj na początek.
if(isset($_POST['vote'])) {
    unset($_POST['vote']);
    $vote = $_POST['voting'];
    unset($_POST['voting']); // warto robic to unset? Jaka jest różnica pod odświeżeniu strony?
    // Nie warto, i tak przy odświeżaniu przeglądarka pyta, czy ponownie przesłać formularz
    // bo ma w swojej pamięci dane z POSTu. Trzeba by od razu po sprawdzeniu warunku zrobic przekierowanie.
    // A nie chce przekierowania, bo chce użyć POSTu w razie blokowania cookies.

} else {
    header("Location: index.php");
    exit();
}


// HTML HEADER
include ("header.php");
echo '
<h1>Weryfikacja głosu</h1>';

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
echo "<p>Połączono z bazą.</p>";


// CHECK IF TARGET TABLE ALREADY EXISTS.
$result = $dbo->query($query_table_test);
if (!$result) {
    echo "<p>Błąd zapytania.</p>";
    echo "<a href='index.php'>Wróć do formularza.</a></p>";
    exit();
}
$test = $result->fetch(PDO::FETCH_NUM);
if(!$test[0]){
    echo "<p>Brak tabeli w bazie. Próba utworzenia...</p>";
    // CREATE TARGET TABLE IF MISSING
    $result = $dbo->query($query_table_create);
    if (!$result) {
        echo "<p>Błąd zapytania CREATE TABLE.</p>";
        echo "<a href='index.php'>Wróć do formularza.</a></p>";
        exit();
    }
    echo "<p>Utworzono tabelę.</p>";
} else {
    echo "<p>Znaleziono tabelę.</p>";

    // CHECK IF HAS ALREADY VOTED, ONLY IF TABLE WAS FOUND
    // Uwaga na więzy UNIQUE na kolumnie session_id
    $cip4q = unknown_ip($cip); //Jeśli ip potencjalnie nieunikalne, to sprawdzaj tylko po sesji
    $query = query_check_client($sid,$cip4q);
    $result = $dbo->query($query);
    if (!$result) {
        echo "<p>Błąd zapytania SELECT.</p>";
        var_dump($query);
        echo "<a href='index.php'>Wróć do formularza.</a></p>";
        exit();
    }
    echo "<p>Otrzymano odpowiedź od komisji.</p>";

    $test = $result->fetch(PDO::FETCH_NUM);

    if ($test[0]>0) {
        echo "<p>Pobite gary! Głos był już oddany. Wróć do formularza i go shackuj, aby oddać kolejny głos ;)</p>";
        echo "<a href='index.php'>Wróć do formularza.</a></p>";
        echo "<pre>Zapytanie:<br>";
        var_dump($query);
        echo "<br>Wynik: {$test[0]}</pre>";
        exit();
    }
    echo "<p>Głos uznano za ważny. Następuje próba przesyłu do PKW.</p>";
}


// ATTEMPT TO SAVE VOTE TO DB
$query = query_insert_vote($cip,$sid,$vote);
$result = $dbo->exec($query);
if (!$result) {
    echo "<p>Błąd zapytania INSERT.</p>";
    var_dump($query);
    echo "<a href='index.php'>Wróć do formularza.</a></p>";
    exit();
}
echo "<p>Zapisano głos.</p>";


echo "<p><a href='index.php'>Wróć do formularza.</a></p>";
echo "<p><a href='results.php'>Sprawdź wyniki</a></p>";
include ("footer.php");

// Destroying connection to db
$dbo = null;
