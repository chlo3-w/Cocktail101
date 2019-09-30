<?php
// Array with ALCOHOL NAMES
$a[] = "Cognac";
$a[] = "Bailey's";
$a[] = "Campari";
$a[] = "Gin";
$a[] = "Kahlua";
$a[] = "Bacardi";
$a[] = "Rum";
$a[] = "Gold Rum";
$a[] = "Prosecco";
$a[] = "White Rum";
$a[] = "Vodka";
$a[] = "Citron Vodka";
$a[] = "Dark Rum";
$a[] = "Scotch";
$a[] = "Galliano";
$a[] = "Wine";
$a[] = "Tequila";
$a[] = "Whiskey";
$a[] = "Champagne";
$a[] = "Bourbon";
$a[] = "Rye Whiskey";
$a[] = "Pisco";
$a[] = "Brandy";
$a[] = "Kirsch";
$a[] = "Old Tom Gin";
$a[] = "Triple Sec";
$a[] = "Vermouth";
$a[] = "Aperol";
$a[] = "Cherry Liqueur";
$a[] = "Peach Schnapps";
$a[] = "Absinthe";
$a[] = "Drambuie";
$a[] = "Port";
$a[] = "Beer";
$a[] = "Cointreau";
$a[] = "Ale";
$a[] = "Disarrano";
$a[] = "Raspberry Liqueur";

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "no suggestion" : $hint;
?>