<?php

namespace App\Repository;

use App\Classes\Currency;

class CurrencyRepo
{
    public static function isCurrencyTypeValid($currencyType)
    {
        // not empty string
        if( empty($currencyType) ) {
            return false;
        }

        // is equal to three English letters
        if ( !preg_match('/^[A-Z]{3,3}$/', $currencyType) ) {
            return false;
        }

        // exists in defined currency types
        $currency = new Currency();
        $exchangeRateMap = $currency->getExchangeRateMap();
        $definedCurrencyTypes = array_keys($exchangeRateMap);
        if( !in_array($currencyType, $definedCurrencyTypes) ) {
            return false;
        }

        return true;
    }

    public static function isAmountValid($amount)
    {
        $amount = str_replace(',', '', $amount);

        // is number
        if( !is_numeric($amount) ) {
            return false;
        }

        // is positive
        if( $amount < 0 ) {
            return false;
        }

        return true;
    }

    public static function getCurrency($srcCurrencyType, $dstCurrencyType, $srcAmount)
    {
        $srcAmount = str_replace(',', '', $srcAmount);

        if( !self::isCurrencyTypeValid($srcCurrencyType) || !self::isCurrencyTypeValid($dstCurrencyType) || !self::isAmountValid($srcAmount) ) {
            return null;
        }

        $currency = new Currency();
        $exchangeRateMap = $currency->getExchangeRateMap();

        if( !isset($exchangeRateMap[$srcCurrencyType][$dstCurrencyType]) ) {
            return null;
        }

        $rate = floatval($exchangeRateMap[$srcCurrencyType][$dstCurrencyType]);

        $dstAmount = number_format($rate * $srcAmount, 2);

        return $dstAmount;
    }

}