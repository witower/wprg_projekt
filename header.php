<!doctype html>
<html lang='pl'>
<head><meta charset='UTF-8'></head>
<body>
<?php
$c='';
$cip = get_real_IP();

if ((isSet($_POST['sid']) && $sidc <> $_POST['sid'])) {
    $c .= "Client forbids cookies. ";
    $sid = $_POST['sid'];
    $c .= "Session ID retrieved from POST will be used. ";
} else {
    $c .= "Default session ID is used. Assume you like cookies or not submitted form yet or you forbid cookies and have just voted.";
    $sid = $sidc;
}

echo "<p><code><pre>
session_id via cookie:  {$sidc}
session_id via post:    {$_POST['sid']}
client_ip:              {$cip}
comments:               {$c}
</pre></code></p>";

/*
 * Mozna by sie jeszcze pobawic w zapisywanie zmiennych w tablicy $_SESSION
 * i odzyskiwanie do nich dostępu gdy session_id nie jest przekazywane (np. cookie'sy sa zabronione).
 */
?>

