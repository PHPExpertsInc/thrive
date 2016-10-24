<?php
// This file is a part of the Thrive Framework, a PHPExperts.pro Project.
//
// Copyright (c) 2012 PHP Experts, Inc.
// Author: Theodore R.Smith (theodore@phpexperts.pro)
//         http://users.phpexperts.pro/tsmith/
// Provided by the PHP University (www.phpu.cc) and PHPExperts.pro (www.phpexperts.pro)
//
// This file is dually licensed under the terms of the following licenses:
// * Primary License: OSSAL v1.0 - Open Source Software Alliance License
//   * Key points:
//       5.Redistributions of source code in any non-textual form (i.e.
//          binary or object form, etc.) must not be linked to software that is
//          released with a license that requires disclosure of source code
//          (ex: the GPL).
//       6.Redistributions of source code must be licensed under more than one
//          license and must not have the terms of the OSSAL removed.
//   * See LICENSE.ossal for complete details.
//
// * Secondary License: Creative Commons Attribution License v3.0
//   * Key Points:
//       * You are free:
//           * to copy, distribute, display, and perform the work
//           * to make non-commercial or commercial use of the work in its original form
//       * Under the following conditions:
//           * Attribution. You must give the original author credit. You must retain all
//             Copyright notices and you must include the sentence, "Based upon work from
//             PHPExperts.pro (www.phpexperts.pro).", wherever you list contributors.
//   * See LICENSE.cc_by for complete details.

// TODO: Create Unit Tests
class Thrive_Number extends fNumber
{
	const DIGITS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_!"#$%&\'()*,/:;<=>?@[\]^`{|}ẠẮẰẶẤẦẨẬẼẸẾỀỂỄỆỐỒỔỖỘỢỚỜỞỊỎỌỈỦŨỤỲÕắằặấầẨậẽẹếềểễệốồổỗỠƠộờởịỰỨỪỬơớƯÀÁÂÃẢĂẳẵÈÉÊẺÌÍĨỳĐứÒÓÔạỷừửÙÚỹỵÝỡưàáâãảăữẫèéêẻìíĩỉđựòóôõỏọụùúũủýợ';
	protected $base = 10;

	public function __construct($value, $scale = NULL, $base = 10)
	{
		$this->setNumber($value, $scale, $base);
	}

	protected function setNumber($value, $scale = NULL, $base = 10)
	{
		$this->base = $base;
		if ($base > 10)
		{
			$this->scale = NULL;
			$this->value = $value;

			return;
		}

		$value = self::parse($value, 'array', $base);

		if ($scale !== NULL) {
			if (strlen($value['fraction']) > $scale) {
				$value['fraction'] = substr($value['fraction'], 0, $scale);
			} else {
				$value['fraction'] = str_pad($value['fraction'], $scale, '0', STR_PAD_RIGHT);
			}
		}

		$this->value = (strlen($value['fraction'])) ? join('.', $value) : $value['integer'];
		$this->scale = strlen($value['fraction']);
	}

	public function convertToBase($toBase)
	{
		$this->ensureProperBase($toBase);

		if ($this->base != 10)
		{
			$number = $this->convertToBase10($this->base);
			//$this->setNumber($number, NULL, 10);
		}
		else
		{
			$number = (int)$this->__toString();
		}

		// can't handle numbers larger than 2^31-1 = 2147483647
		$chars = self::DIGITS;
		$str = '';
		do {
			$i = $number % $toBase;
			$str = $chars[$i] . $str;
			$number = ($number - $i) / $toBase;
		} while ($number > 0);

		$this->value = $str;
		$this->base = $toBase;

		return $str;
	}

	/*
	 * TODO: Check this function out.
	 */
	/*
	function static intToAlphaBaseN($n,$baseArray) {
	    $l=count($baseArray);
	    $s = '';
	    for ($i = 1; $n >= 0 && $i < 10; $i++) {
	        $s =  $baseArray[($n % pow($l, $i) / pow($l, $i - 1))].$s;
	        $n -= pow($l, $i);
	    }
	    return $s;
	}
*/

	protected function convertToBase10($fromBase)
	{
		//$this->ensureProperBase($fromBase);
		$number = $this->__toString();

		$len = strlen($number);
		$value = 0;
		$chars = self::DIGITS;
		$arr = array_flip(str_split($chars));

		for ($i = 0; $i < $len; ++$i) {
			$value += $arr[$number[$i]] * pow($fromBase, $len-$i-1);
		}

		$this->setNumber($value, NULL, 10);

		return $value;
	}

	// Author: JR
	// Obtained from http://www.php.net/manual/en/function.base-convert.php#105414
	// License: Public Domain
	public function toRomanNumerals()
	{
		$N = $this->value;

		$c='IVXLCDM';
		for($a=5,$b=$s='';$N;$b++,$a^=7)
			for($o=$N%$a,$N=$N/$a^0;$o--;$s=$c[$o>2?$b+$N-($N&=-2)+$o=1:$b].$s);
		return $s;
	}

	protected function ensureProperBase($desiredBase)
	{
		if ($desiredBase < 2)
		{
			throw new RangeException("Cannot convert to/from a base lower than 2");
		}
		if ($desiredBase > strlen(self::DIGITS))
		{
			throw new RangeException("Cannot convert to/from a base higher than " . strlen(self::DIGITS));
		}

		$number = $this->__toString();

		if ($this->base == 10 || $this->base == $desiredBase)
		{
			return $number;
		}
	}

	public function getBase()
	{
		return $this->base;
	}

	public function __toString()
	{
		return (string)parent::__toString();
	}

}

//$converter = new Thrive_Number_BaseConverter;
//echo $converter->convertToBase10('3456789ABCDEF', 16) . "\n";