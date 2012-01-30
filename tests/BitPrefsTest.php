<?php
// This file is a part of the Thrive Framework, a PHPExperts.pro Project.
//
// Copyright (c) 2012 Theodore R.Smith (theodore@phpexperts.pro)
// DSA-1024 Fingerprint: 10A0 6372 9092 85A2 BB7F  907B CB8B 654B E33B F1ED
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

require_once realpath(dirname(__FILE__) . '/../BitPrefs.php');

class TestableBitPrefs extends Thrive_BitPrefs
{
	public function getPrefs()
	{
		return $this->prefsMask;
	}
}

class BitPrefsTest extends PHPUnit_Framework_TestCase
{
	const TEST_PARAM1 = 1;
	const TEST_PARAM2 = 2;
	const TEST_PARAM3 = 4;
	const TEST_PARAM4 = 8;

	/** @var TestableBitPrefs */
	protected  $prefs;

	protected function setUp()
	{
		$this->prefs = new TestableBitPrefs;
	}
	
	protected function tearDown()
	{
		unset($this->prefs);
	}
	
	public function testPrefsCanBeSetAtInstantiation()
	{
		$prefs = new TestableBitPrefs(4);
		$this->assertEquals(4, $prefs->getPrefs());
	}

	public function testCanSetAPreference()
	{
		$this->prefs->turnOn(self::TEST_PARAM3);
		$this->assertEquals(self::TEST_PARAM3, $this->prefs->getPrefs());
	}

	public function testCanTestAPreference()
	{
		$this->prefs->turnOn(self::TEST_PARAM3);
		$this->assertTrue($this->prefs->isOn(self::TEST_PARAM3));
	}

	public function testCanSetMultiplePrefs()
	{
		$this->prefs->turnOn(self::TEST_PARAM2);
		$this->prefs->turnOn(self::TEST_PARAM4);
		$this->assertFalse($this->prefs->isOn(self::TEST_PARAM1));
		$this->assertEquals(10, $this->prefs->getPrefs());
	}

	public function testCanSetMultiplePrefsAtOnce()
	{
		$this->prefs->turnOn(self::TEST_PARAM1 | self::TEST_PARAM3);
		$this->assertFalse($this->prefs->isOn(self::TEST_PARAM2));
		$this->assertTrue($this->prefs->isOn(self::TEST_PARAM3 | self::TEST_PARAM1));
	}

	public function testWontReturnFalsePositives()
	{
		$this->prefs->turnOn(self::TEST_PARAM1 | self::TEST_PARAM3);
		$this->assertFalse($this->prefs->isOn(self::TEST_PARAM1 | self::TEST_PARAM2 | self::TEST_PARAM3));
	}

	public function testCanTurnOffAPref()
	{
		$this->prefs->turnOn(self::TEST_PARAM1);
		$this->prefs->turnOff(self::TEST_PARAM1);
		$this->assertEquals(0, $this->prefs->isOn(self::TEST_PARAM1));

		$this->prefs->turnOn(self::TEST_PARAM1 | self::TEST_PARAM3);
		$this->prefs->turnOff(self::TEST_PARAM1);
		$this->assertEquals(self::TEST_PARAM3, $this->prefs->getPrefs());
	}

	public function testCanTurnOffMultiplePrefsAtOnce()
	{
		$this->prefs->turnOn(self::TEST_PARAM1 | self::TEST_PARAM3 | self::TEST_PARAM4);
		$this->prefs->turnOff(self::TEST_PARAM1 | self::TEST_PARAM4);
		$this->assertEquals(self::TEST_PARAM3, $this->prefs->getPrefs());
	}

	public function testCanClearAllPrefs()
	{
		$this->prefs->turnOn(self::TEST_PARAM1 | self::TEST_PARAM3 | self::TEST_PARAM4);
		$this->prefs->clear();
		$this->assertEquals(0, $this->prefs->getPrefs());		
	}
}
