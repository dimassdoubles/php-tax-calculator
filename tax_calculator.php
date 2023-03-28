<?php

include 'const.php';

interface TaxCalculator {
    public function calculate(float $amount) : float;
};

function getPrecentageOfAmount(float $precentage, float $amount) : float {
    return $precentage / 100 * $amount;
}

function getTaxInsideAmountWithTax(float $precentage, float $amountWithTax) : float {
    return $precentage/(100+$precentage)*$amountWithTax;
}

class TaxCalculatorPpn10 implements TaxCalculator {
    public function calculate(float $amount) : float {
        return getPrecentageOfAmount(10, $amount);
    }
}

class TaxCalculatorPpn11 implements TaxCalculator {
    public function calculate(float $amount) : float {
        return getPrecentageOfAmount(11, $amount);
    }
}

class TaxCalculatorPpn10IncludeTax implements TaxCalculator {
    public function calculate(float $amount) : float {
        return getTaxInsideAmountWithTax(10, $amount);
    }
}

class TaxCalculatorPpn11IncludeTax implements TaxCalculator {
    public function calculate(float $amount) : float {
        return getTaxInsideAmountWithTax(11, $amount);
    }
}

class TaxCalculatorPph21 implements TaxCalculator {
    public function calculate(float $amount) : float {
        $million = 1000000;
        $taxPrecentage = 0;

        // mencari presentase pajak yang harus dibayarkan
        if ($amount >= 500*$million) {
            $taxPrecentage = 30;
        } else if ($amount >= 250*$million) {
            $taxPrecentage = 25;
        } else if ($amount >= 50*$million) {
            $taxPrecentage = 15;
        } else if ($amount >= 40*$million) {
            $taxPrecentage = 5;
        } 

        return getPrecentageOfAmount($taxPrecentage, $amount);
    }
};

class UnknownCalc implements TaxCalculator {
    function calculate(float $amount) : float {
        return $amount;
    }
}

function calculatorFactory(string $calculatorType) : TaxCalculator {
    global $PPN10, $PPN11, $PPN10INCL, $PPN11INCL, $PPH21;

    switch ($calculatorType) {
        case $PPN10;
            return new TaxCalculatorPpn10();
        case $PPN11:
            return new TaxCalculatorPpn11();
        case $PPN10INCL:
            return new TaxCalculatorPpn10IncludeTax();
        case $PPN11INCL:
            return new TaxCalculatorPpn11IncludeTax();
        case $PPH21:
            return new TaxCalculatorPph21();
        default:
        return new UnknownCalc();
    }
}

