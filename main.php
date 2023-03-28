<?php

include 'const.php';
include 'tax_calculator.php';

function getTaxType(): string
{
    global $PPN10, $PPN11, $PPN10INCL, $PPN11INCL, $PPH21, $UNKNOWN;

    echo "Silahkan pilih jenis pajak :\n";
    echo "1. PPN 10 %\n";
    echo "2. PPN 11 %\n";
    echo "3. PPH 21\n";
    $taxType = trim(readline("Masukan pilihan anda : "));

    if ($taxType == "1" || $taxType == "2") {
        echo "Silahkan pilih jenis amount pajak :\n";
        echo "1. Include Tax\n";
        echo "2. Exclude Tax\n";
        $amountType = trim(readline("Masukan pilihan anda : "));
        $taxType = $taxType . $amountType;
    }

    switch ($taxType) {
        case "11":
            return $PPN10INCL;
        case "12":
            return $PPN10;
        case "21":
            return $PPN11INCL;
        case "22":
            return $PPN11;
        case "3";
            return $PPH21;
        default:
            return $UNKNOWN;
    }
}

function getAmount(): float
{
    $amount = (float) readline("Masukan amount : ");
    return $amount;
}

function printResult(string $taxType, float $amount, float $tax)
{
    echo "\nHasil Perhitungan Pajak\n";
    echo "-----------------------\n";
    echo "Jenis Pajak  : " . $taxType . "\n";
    echo "Nilai Amount : " . number_format($amount, 0, ",", ".") . "\n";
    echo "Pajak        : " . number_format($tax, 0, ",", ".") . "\n";
}

function main()
{
    global $PPN10, $PPn11, $PPN10INCL, $PPN11INCL, $PPH21, $UNKNOWN;

    $taxType = getTaxType();

    if ($taxType != $UNKNOWN) {
        $calculator = calculatorFactory($taxType);
        echo "\n";
        $amount = getAmount();
        $tax = $calculator->calculate($amount);
        printResult($taxType, $amount, $tax);
        echo "\n";
    } else {
        echo "Jenis pajak tidak terdaftar\n";
    }
}

while (true) {
    main();
}
