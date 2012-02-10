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

class Thrive_CLI_OptionFactory
{
	/** 
	  * Builds a CLI option.
	  * @param $optionCfg string
	  * @return Thrive_CLI_Option
	 **/
	public function build($optionCfg)
	{
		$lastChar = substr($optionCfg, -1);

		$optionName = $this->getOptionName($optionCfg);
		$option = new Thrive_CLI_Option($optionName);

		// An option is required if it begins with '!'.
		if ($optionCfg[0] === '!')
		{
			$option->turnOn(Thrive_CLI_Option::IS_REQUIRED);
		}

		// An option has a valued associated with it if it ends with
		// either '=', ':', or '@'.
		if (in_array($lastChar, array(':', '=', '@')))
		{
			$option->turnOn(Thrive_CLI_Option::HAS_A_VALUE);
		}

		// An option has an optional value if it ends in ':'.
		if ($lastChar === ':')
		{
			$option->turnOn(Thrive_CLI_Option::IS_VALUE_OPTIONAL);
		}

		// An option has an optional value if it ends in '@'.
		if ($lastChar === '@')
		{
			$option->turnOn(Thrive_CLI_Option::IS_VALUE_ARRAY);
		}

		return $option;
	}

	public function buildInBulk(array $optionCfgs)
	{
		$options = array();
		foreach ($optionCfgs as $optionCfg)
		{
			if (!is_string($optionCfg)) { throw new Thrive_CLI_Exception(Thrive_CLI_Exception::OPTIONCFG_NOT_STRING); }

			$option = $this->build($optionCfg);
			//print_r($option);
			$options[] = $option;
		}

		return $options;
	}

	
	protected function getOptionName($optionCfg)
	{		
		$matches = array();
		preg_match('/^!?([\w-]+)/', $optionCfg, $matches);

		return $matches[1];
 	}

	public static function buildOptionConfig($name, $prefs)
	{
		$o = new Thrive_CLI_Option($name, $prefs);
		
		//echo "---- $name ----\n";
		//echo "Prefs: $prefs\n";
		//if ($o->isOn(Thrive_CLI_Option::IS_REQUIRED)) { echo "Is required...\n"; }
		//if ($o->isOn(Thrive_CLI_Option::HAS_A_VALUE)) { echo "Has a value...\n"; }
		//if ($o->isOn(Thrive_CLI_Option::IS_VALUE_OPTIONAL)) { echo "Value is optional...\n"; }
		//if ($o->isOn(Thrive_CLI_Option::IS_VALUE_ARRAY)) { echo "Value is array...\n"; }

		$optionCfg = ($o->isOn(Thrive_CLI_Option::IS_REQUIRED) ? '!' : '') . 
		             $name . 
		             (!$o->isOn(Thrive_CLI_Option::HAS_A_VALUE) ? '' :
		                 ($o->isOn(Thrive_CLI_Option::IS_VALUE_OPTIONAL) ? ':' : 
		                     ($o->isOn(Thrive_CLI_Option::IS_VALUE_ARRAY) ? '@' : '=')
		                 )
		             );

		echo "Option Config: $optionCfg\n";
	}
}

/*
$op->buildOptionConfig('host',    Thrive_CLI_Option::IS_REQUIRED 
                                | Thrive_CLI_Option::HAS_A_VALUE);
$op->buildOptionConfig('user',    Thrive_CLI_Option::HAS_A_VALUE);
$op->buildOptionConfig('verbose', Thrive_CLI_Option::HAS_A_VALUE
                                | Thrive_CLI_Option::IS_VALUE_OPTIONAL);
$op->buildOptionConfig('exclude', Thrive_CLI_Option::HAS_A_VALUE
                                | Thrive_CLI_Option::IS_VALUE_ARRAY);
$op->buildOptionConfig('line',    Thrive_CLI_Option::IS_REQUIRED);
$op->buildOptionConfig('line',    Thrive_CLI_Option::NO_OPTIONS);
*/
