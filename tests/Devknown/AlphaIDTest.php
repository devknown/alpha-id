<?php

use PHPUnit\Framework\TestCase;

class AlphaIDTest extends TestCase
{
    protected function setUp(): void
    {
        \Devknown\AlphaID::config('globalkey');
    }

    public function testEncodeAndDecodeWithGlobalKey()
    {
        $number = 1234567890;

        $encoded = \Devknown\AlphaID::convert($number);
        $decoded = \Devknown\AlphaID::recover($encoded);

        $this->assertEquals($number, $decoded);
    }

    public function testEncodeAndDecodeWithSpecificKey()
    {
        $number = 987654321;
        $key = 'specifickey';

        $encoded = \Devknown\AlphaID::convert($number, $key);
        $decoded = \Devknown\AlphaID::recover($encoded, $key);

        $this->assertEquals($number, $decoded);
    }

    public function testEncodeAndDecodeWithEmptyKey()
    {
        $number = 54321;

        $encoded = \Devknown\AlphaID::convert($number, '');
        $decoded = \Devknown\AlphaID::recover($encoded, '');

        $this->assertEquals($number, $decoded);
    }

    /**
     * @dataProvider numericToEncodedStringDataProvider
     */
    public function testEncodeNumberToEncodedString($number, $expectedEncodedString)
    {
        $encoded = \Devknown\AlphaID::convert($number);

        $this->assertEquals($expectedEncodedString, $encoded);
    }

    /**
     * @dataProvider encodedStringToNumericDataProvider
     */
    public function testDecodeEncodedStringToNumber($encodedString, $expectedNumber)
    {
        $decoded = \Devknown\AlphaID::recover($encodedString);

        $this->assertEquals($expectedNumber, $decoded);
    }

    /**
     * @dataProvider nonNumericToEncodedStringDataProvider
     * @expectedException InvalidArgumentException
     */
    // public function testEncodeNonNumericInput($nonNumericInput)
    // {
    //     \Devknown\AlphaID::convert($nonNumericInput);
    // }

    /**
     * @dataProvider nonStringToNumericDataProvider
     * @expectedException InvalidArgumentException
     */
    // public function testDecodeNonStringInput($nonStringInput)
    // {
    //     \Devknown\AlphaID::recover($nonStringInput);
    // }

    public function numericToEncodedStringDataProvider()
    {
        return [
            [123456, '3ygxRZ'],
            [987654, '3ycMuJ'],
            [54321, '3ygih0'],
            [89815, '3ygH9C'],
        ];
    }

    public function encodedStringToNumericDataProvider()
    {
        return [
            ['3ygxRZ', 123456],
            ['3ycMuJ', 987654],
            ['3ygih0', 54321],
            ['3ygH9C', 89815],
        ];
    }

    // public function nonNumericToEncodedStringDataProvider()
    // {
    //     return [
    //         ['invalid'],
    //         ['abc123'],
    //     ];
    // }

    // public function nonStringToNumericDataProvider()
    // {
    //     return [
    //         [null],
    //         [123],
    //     ];
    // }
}
