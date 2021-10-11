<?php

use App\Repository\CurrencyRepo;

class CurrencyRepoTest extends TestCase
{
    /**
     * @group must
     * 
     * @dataProvider currencyTypeDataProvider
     *
     * @return void
     */
    public function testIsCurrencyTypeValid($testData, $expectedResult)
    {
        $isValid = CurrencyRepo::isCurrencyTypeValid($testData);
        $this->assertEquals($expectedResult, $isValid);
    }

    public function currencyTypeDataProvider()
    {
        return [
            ['TWD', true],
            ['JPY', true],
            ['USD', true],
            ['', false],
            ['123', false],
            ['TW5', false],
            ['<?>', false],
            [',$%JSP', false],
            [0, false],
            [123, false],
            [null, false],
        ];
    }

    /**
     * @group must
     * 
     * @dataProvider amountDataProvider
     *
     * amountDataProvider
     * 
     * @return void
     */
    public function testIsAmountValid($testData, $expectedResult)
    {
        $isValid = CurrencyRepo::isAmountValid($testData);
        $this->assertEquals($expectedResult, $isValid);
    }

    public function amountDataProvider()
    {
        return [
            [256.56, true],
            [0.5678, true],
            [0, true],
            [10000000000000001, true],
            [-12345.45678, false],
            ['54,321', true],
            ['54321.12345', true],
            ['', false],
            ['TWD', false],
            [',$%JSP', false],
            [null, false],
        ];
    }

    /**
     * @group must
     * 
     * @dataProvider testAmountDataProvider
     *
     * @return void
     */
    public function testGetCurrency($testSrcCurrencyType, $testDstCurrencyType, $testAmount, $expectedResult)
    {
        $dstAmount = CurrencyRepo::getCurrency($testSrcCurrencyType, $testDstCurrencyType, $testAmount);
        $this->assertEquals($expectedResult, $dstAmount);
    }

    public function testAmountDataProvider()
    {
        return [
            ['TWD', 'TWD', 777.567, '777.57'],
            ['TWD', 'TWD', 0.5678, '0.57'],
            ['TWD', 'TWD', 0, '0.00'],
            ['TWD', 'TWD', -12345.45678, null],
            ['TWD', 'TWD', '1,234,567.345', '1,234,567.35'],
            ['TWD', 'JPY', 777, '2,850.81'],
            ['TWD', 'JPY', 777.567, '2,852.89'],
            ['TWD', 'USD', 777, '25.49'],
            ['TWD', 'USD', 777.567, '25.51'],
            ['JPY', 'JPY', 777, '777.00'],
            ['JPY', 'JPY', 777.567, '777.57'],
            ['JPY', 'TWD', 777, '209.45'],
            ['JPY', 'TWD', 777.567, '209.60'],
            ['JPY', 'USD', 777, '6.88'],
            ['JPY', 'USD', 777.567, '6.88'],
            ['USD', 'USD', 777, '777.00'],
            ['USD', 'USD', 777.567, '777.57'],
            ['USD', 'TWD', 777, '23,654.99'],
            ['USD', 'TWD', 777.567, '23,672.25'],
            ['USD', 'JPY', 777, '86,869.38'],
            ['USD', 'JPY', 777.567, '86,932.77'],
            ['USD', 'JPY', '', null],
            ['USD', 'JPY', 'abc', null],
            ['USD', 'JPY', null, null],
            ['avds', 'JPY', 1123, null],
            ['USD', '<?php>', 1123, null],
            ['USD', '', 0, null],
        ];
    }

}