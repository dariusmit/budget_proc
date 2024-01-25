<?php

// Biudzeto planavimo programeles praktine uzduotis.

// Display errors.
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require(dirname(__DIR__, 1) . '/app/app.php');
require(dirname(__DIR__, 1) . '/views/transactions.php');

readFiles();
createAmountArray($contents);
calculateTotals($amounts);

?>
