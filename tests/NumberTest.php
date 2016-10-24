<?php
// This file is a part of the Thrive Framework, a PHPExperts.pro Project.
//
// Copyright (c) 2012 PHP Experts, Inc.
//     Author: Theodore R.Smith (theodore@phpexperts.pro)
//             http://users.phpexperts.pro/tsmith/
// Provided by the PHP University (www.phpu.cc) and PHPExperts.pro (www.phpexperts.pro)
//
// This project is licensed under two licenses. It is NOT dual licensed in
// traditional sense that one may pick and choose which license they wish to
// abide by:
//
//     YOU MUST ABIDE BY BOTH LICENSES SIMULTANEOUSLY.
//
// The licenses are
// * The Creative Commons Attribution License v3.0 (CC-BY_A)
//   This license gives the rights to copy, modify and distribute this source
//   code for your own projects, and to compile it into your projects. It does
//   not require you to open source your own code (as a copyleft license would).
//
//   All that is required is for you to provide proper attribution that your
//   project includes code from the Thrive Framework and links to the URL
//   http://www.phpexperts.pro/thrive.

// * The Open Source Software Alliance License v1.0 (OSSAL)
//   This license *must* be included with any distribution of the source code.
//   It prohibits the mixing of this package's code with a copyleft project,
//   such as those licensed under the GPL, LGPL, or Creative Commons ShareAlike
//   licenses.

class NumberTest extends PHPUnit_Framework_TestCase
{
	/** @var Thrive_Number */
	protected  $number;

	protected function setUp()
	{
	}
	
	protected function tearDown()
	{
	}
/*
	public function testCanSetAndGetBackANumber()
	{
		$numberToTest = rand(0, 1000);
		$number = new Thrive_Number($numberToTest);
		$this->assertEquals($numberToTest, (int)$number->__toString(), 'Did not get the expected number back.');
	}

	public function testCanSetAndGetBackANumberOfAnArbitraryBaseLessThan429()
	{
		$numberToTest = 'A';
		$base = rand(2, 428);
		$number = new Thrive_Number($numberToTest, NULL, $base);
		$expectedResult = 'A';
		$this->assertEquals($expectedResult, $number->__toString(), "Did not get the expected number back: $numberToTest($base)");
		$this->assertEquals($base, $number->getBase());
	}

	public function testCanConvertFromBase10ToAHigherBase()
	{
		$number = new Thrive_Number(10);
		$expectedResult = 'A';
		$this->assertEquals($expectedResult, $number->convertToBase(11));
	}

	public function testCanConvertFromBase10ToALowerBase()
	{
		$base = 9;
		$number = new Thrive_Number($base);
		$expectedResult = '10';
		$this->assertEquals($expectedResult, $number->convertToBase($base));
	}

	public function testCanConvertFromBase10ToBase2()
	{
		$number = new Thrive_Number(11);
		$expectedResult = '1011';
		$this->assertEquals($expectedResult, $number->convertToBase(2));
	}

	public function testCanConvertFromBase10ToBase8()
	{
		$number = new Thrive_Number(9);
		$expectedResult = '11';
		$this->assertEquals($expectedResult, $number->convertToBase(8));
	}

	public function testCanConvertFromBase10ToBase16()
	{
		$number = new Thrive_Number(26);
		$expectedResult = '1A';
		$this->assertEquals($expectedResult, $number->convertToBase(16));
	}

	public function testCanConvertFromBase10ToBase26()
	{
		$number = new Thrive_Number(26);
		$expectedResult = '10';
		$this->assertEquals($expectedResult, $number->convertToBase(26));
	}

	public static function provideBases()
	{
		$bases = array();
		$digits = Thrive_Number::DIGITS;
		$max = strlen($digits);
		for ($a = 2; $a <= $max; ++$a)
		{
			$expectedResult = $digits[$a - 1] . $digits[$a - 1];
			$bases[] = array($a, $expectedResult);
		}

		return $bases;
	}

	/**
	 * @dataProvider provideBases
	 *|
	public function testCanConvertFromBase10UpToBase419($base, $expectedResult)
	{
		$base10Num = $base * $base - 1;
		$number = new Thrive_Number(($base10Num));
		$result = $number->convertToBase($base);
		//print "Base 10 Num: $base10Num | Number: " . $result . " b$base\n";
		$this->assertEquals($expectedResult, $result, "Could not convert to base $base correctly.");
	}

	public function testCannotConvertFromBase10LowerThanBase2()
	{
		$base = rand(0, 1);
		$base10Num = $base * $base - 1;
		$number = new Thrive_Number(($base10Num));
		try {
			$result = $number->convertToBase($base);
			print "Base 10 Num: $base10Num | Number: " . $result . " b$base\n";
			$this->fail("Converted to higher than base 2.");
		}
		catch (RangeException $e)
		{
			$this->assertTrue(true);
		}
	}

	public function testCannotConvertFromBase10HigherThanBase428()
	{
		$base = 429;
		$base10Num = $base * $base - 1;
		$number = new Thrive_Number(($base10Num));
		try {
			$result = $number->convertToBase($base);
			$this->fail("Converted to higher than base 428.");
		}
		catch (RangeException $e)
		{
			$this->assertTrue(true);
		}
	}

	public function testCanConvertFromALowerBaseToBase10()
	{
		$number = new Thrive_Number(11);
		$expectedResult = '1011';
		$this->assertEquals($expectedResult, $number->convertToBase(2));

	}
*/

	public function testCanConvertFromAHigherBaseToBase10()
	{
		$base = rand(11, 428);
		$numberToTest = 100;
		$expectedResult = $base * $base;
		$number = new Thrive_Number($numberToTest, NULL, $base);

		$this->assertEquals($expectedResult, $number->convertToBase(10));
	}

	public function testCanConvertFromALowerBaseToBase10()
	{
		$base = rand(2, 9);
		$numberToTest = 100;
		$expectedResult = $base * $base;
		$number = new Thrive_Number($numberToTest, NULL, $base);

		$this->assertEquals($expectedResult, $number->convertToBase(10));
	}

	public function testCanConvertFromBase10ToBase2()
	{
		$number = new Thrive_Number(11);
		$expectedResult = '1011';
		$this->assertEquals($expectedResult, $number->convertToBase(2));
	}

	public function testCanConvertFromBase10ToBase8()
	{
		$number = new Thrive_Number(9);
		$expectedResult = '11';
		$this->assertEquals($expectedResult, $number->convertToBase(8));
	}

	public function testCanConvertFromBase10ToBase16()
	{
		$number = new Thrive_Number(26);
		$expectedResult = '1A';
		$this->assertEquals($expectedResult, $number->convertToBase(16));
	}

	public function testCanConvertFromBase10ToBase26()
	{
		$number = new Thrive_Number(26);
		$expectedResult = '10';
		$this->assertEquals($expectedResult, $number->convertToBase(26));
	}

	/**
	 * @dataProvider provideBases
	 *|
	public function testCanConvertFromBase10UpToBase419($base, $expectedResult)
	{
		$base10Num = $base * $base - 1;
		$number = new Thrive_Number(($base10Num));
		$result = $number->convertToBase($base);
		//print "Base 10 Num: $base10Num | Number: " . $result . " b$base\n";
		$this->assertEquals($expectedResult, $result, "Could not convert to base $base correctly.");
	}

	public function testCannotConvertFromBase10LowerThanBase2()
	{
		$base = rand(0, 1);
		$base10Num = $base * $base - 1;
		$number = new Thrive_Number(($base10Num));
		try {
			$result = $number->convertToBase($base);
			print "Base 10 Num: $base10Num | Number: " . $result . " b$base\n";
			$this->fail("Converted to higher than base 2.");
		}
		catch (RangeException $e)
		{
			$this->assertTrue(true);
		}
	}

	public function testCannotConvertFromBase10HigherThanBase428()
	{
		$base = 429;
		$base10Num = $base * $base - 1;
		$number = new Thrive_Number(($base10Num));
		try {
			$result = $number->convertToBase($base);
			$this->fail("Converted to higher than base 428.");
		}
		catch (RangeException $e)
		{
			$this->assertTrue(true);
		}
	}

	public function testCanConvertFromALowerBaseToBase10()
	{
		$number = new Thrive_Number(11);
		$expectedResult = '1011';
		$this->assertEquals($expectedResult, $number->convertToBase(2));

	}
*/
}
