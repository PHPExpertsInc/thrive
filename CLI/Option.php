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

class Thrive_CLI_Option extends Thrive_BitPrefs
{
	const NO_OPTIONS        = 0;
	const IS_REQUIRED       = 1;
	const HAS_A_VALUE       = 2;
	const IS_VALUE_OPTIONAL = 4;
	const IS_VALUE_ARRAY    = 8;

	protected $name = '';
	public $value;

	public function __get($property)
	{
		if ($property == 'name') { return $this->name; }
	}

	public function __construct($name, $value = null, $prefsMask = 0)
	{
		parent::__construct($prefsMask);

		$this->name = $name;

		if ($value !== null)
		{
			$this->value = $value;
			$this->turnOn(self::HAS_A_VALUE);
		}
	}

	public function __toString()
	{
		$o = new Thrive_CLI_Option($this->name, $this->value, $this->prefsMask);

		$o->isRequired = ($this->isOn(self::IS_REQUIRED) ? 'Yes' : 'No');
		$o->hasAValue = ($this->isOn(self::HAS_A_VALUE) ? 'Yes' : 'No');
		$o->valueIsOptional = ($this->isOn(self::IS_VALUE_OPTIONAL) ? 'Yes' : 'No');
		$o->valueIsArray = ($this->isOn(self::IS_VALUE_ARRAY) ? 'Yes' : 'No');
		unset($o->prefsMask);
		$output = print_r($o, true);
		unset($o);

		return $output;
	}
}
