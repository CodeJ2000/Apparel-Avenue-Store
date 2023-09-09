<?php
namespace App\Services;

class CalculationService {

    //calculate the subtotal with tax
    public function calculateTax($amount)
    {
        $amount = str_replace(['$', ','], '', $amount); //Remove the dollar symbol and comma in the price
        $calculatedTax = (float)$amount * 0.12; // multiply the amount with the 12% tax rate
        $total = $amount + $calculatedTax; //Sum up the multiplied tax rate to the amount price
        $total = '$' . number_format($total, 2, '.', ','); // Format the total price with dollar symbol and comma for thousands
        $calculatedTax = '+ $' . number_format($calculatedTax, 2, '.', ','); //Format the calculated tax with  the dollar symbol and comma for thousand

        //Include the result in to the data object
        $data = (object) [
            'totalAmount' => $total,
            'calculatedTax' => $calculatedTax
        ];

        //return the object
        return $data;
    }

     //remove the dollar, comma, space and + in the price
     public function removeDollar($value)
     {
         return str_replace(['$', ',', ' ', '+'], '', $value);
     }
    
}