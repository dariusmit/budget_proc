<?php

// Funkciju failas

// Funkcija skaityti failams ir sukurti failu masyvui.
function readFiles() {

    $dirName = dirname(__DIR__, 1) . '/transaction_files/';

    // Skanuojam direktorija ir sukuriam failu masyva.
    foreach(scandir($dirName) as $file) {
        if (is_dir($file)) {
            continue;
        }
        $filesNames[] = $dirName . $file;
    }

    // Skanuojam failu masyva is sukuriam ju turinio masyva.
    foreach($filesNames as $file) {
        $file = fopen($file, 'r');
        while (!feof($file)) {
            $contentsPre[] = fgetcsv($file);
        }
        array_pop($contentsPre);
        fclose($file);
    }

    // Sukuriam etikeciu masyva ir pasalinam jas is turinio  masyvo.
    foreach($contentsPre as $key => $value) {
        foreach($value as $key1 => $value1) {
            if($value1 == 'Date') {
                $keys = $value;
                unset($contentsPre[$key]);
            }
        }
    }

    $contentsPre = array_values($contentsPre); // Is naujo sudedam indeksus masyvui, kad butu nuo 0.

    // Uzdedam etiketes reikiamoje vietoje.
    foreach($contentsPre as $value) {
        $contents[] = array_combine($keys, $value);
    }

    unset($contentsPre); // Sunaikinam nebereikalinga masyva.
    
    return $contents; // Grazinam tvarkinga galutini failu turinio masyva.

}
$contents = readFiles();

// Funkcija sukurti masyvui is kiekio(amount) reiksmiu. Taip pat filtruojam simbolius ir konvertuojam tipa.
function createAmountArray($contents) {

    foreach($contents as $value) {
        foreach($value as $value1) {
            $value['Amount'] = floatval(str_replace(['$', ','], '', $value['Amount']));
            $amounts[] = round($value['Amount'], 2);
            break;
        }
    }

    return $amounts;

}
$amounts = createAmountArray($contents);

// Funkcija apskaiciuoti pajamas, islaidas ir pelna.
function calculateTotals($amounts) {

    $totals = ['Income' => 0, 'Expense' => 0, 'Net' => 0];

    foreach($amounts as $amount) {
        if ($amount > 0) {
            $totals['Income'] += $amount;
        }
    }

    foreach($amounts as $amount) {
        if ($amount < 0) {
            $totals['Expense'] += abs($amount);
        }
    }

    foreach($amounts as $amount) {
        $totals['Net'] = $totals['Income'] + $totals['Expense'];
    }

    return $totals;

}
$totals = calculateTotals($amounts);

?>
