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
  
class Thrive_CLI_Helper
{
	const STRICT_OPTIONS = 101;
	const LOOSE_OPTIONS = 102;

	/** @var Thrive_CLI_OptionFactory **/
	protected $op;

	/**
	 * @param Thrive_CLI_OptionFactory $optionFactory
	 * @return Thrive_CLI_Helper
	**/
	public function __construct(Thrive_CLI_OptionFactory $optionFactory = null)
	{
		if ($optionFactory === null) { $optionFactory = new Thrive_CLI_OptionFactory; }
		$this->op = $optionFactory;
	}
	
	/**
	 * @param [requiredOptions] array of required options. Uses the Getopt syntax.
	 * @param int $strictness
	 * @return array of parameters
	**/
	public function getCliParams(array $optionCfgs, $strictness = self::STRICT_OPTIONS)
	{
		global $argv;

		$params = array();
		$params = $GLOBALS['argv'];
		array_shift($params);

		$params = $this->processParams($params);
		$options = $this->op->buildInBulk($optionCfgs);

		try
		{
			$this->validateParams($params, $options, $strictness);
			$this->cullUnusedOptions($options);
			$params = $this->convertToArray($options);
			//foreach ($options as $o) { echo "$o\n"; }
			//print_r($options);
		}
		catch (Thrive_CLI_Exception $e)
		{
			printf("Error: %s\n", $e->getMessage());
			printf("Try '%s --help' for more information.\n", $argv[0]);
			die(1);
		}

		return $params;
	}

	protected function processParams(array $params_in)
	{
		$params = array();
		$num_of_params = count($params_in);
		for ($i = 0; $i < $num_of_params; ++$i)
		{
			$param = $params_in[$i];
			$matches = array();
			$isOption = preg_match('/^(--?)([\w-]+)(=([^ ]+))*/', $param, $matches);
			//print_r($matches); continue;

			if (!$isOption)
			{
				@$params['.extra'] .= $param . ' ';
				continue;
			}

			$key = $matches[2];
			$value = null;

			if (!isset($matches[4]))
			{
				// Make sure there is a next param and that it's not
				// another option.
				if ($i != count($params_in) - 1
				    && $params_in[$i + 1][0] != '-')
				{
					$value = $params_in[$i + 1];

					// Skip the next to avoid dupes.
					++$i;
				}
			}
			else
			{
				$value = $matches[4];
			}

			if (array_key_exists($key, $params))
			{
				if (!is_array($params[$key]))
				{
					$tmpValue = $params[$key];
					unset($params[$key]);
					
					$params[$key][] = $tmpValue;
				}

				$params[$key][] = $value;
			}
			else
			{
				$params[$key] = $value;
			}
		}

		//print_r($params); exit;
		return $params;
	}

	protected function validateParams(array $params, array $options, $strictness)
	{
		foreach ($options as /** @var Thrive_CLI_Option **/ $o)
		{
			$arg = ((strlen($o->name) == 1) ? '-' : '--') . $o->name;

			
			if ($o->isOn(Thrive_CLI_Option::IS_REQUIRED)
			    && (!array_key_exists($o->name, $params)))
			{
				throw new Thrive_CLI_Exception(sprintf(Thrive_CLI_Exception::MISSING_REQ_OPTION, $arg));
			}

			if ($o->isOn(Thrive_CLI_Option::HAS_A_VALUE)
			    && $o->isOff(Thrive_CLI_Option::IS_VALUE_OPTIONAL)
			    && array_key_exists($o->name, $params)
			    && ((is_array($params[$o->name]) && count(array_filter($params[$o->name], 'count')) < count($params[$o->name])) // Does an array 
			        || (!is_array($params[$o->name]) && empty($params[$o->name]))))
			{
				throw new Thrive_CLI_Exception(sprintf(Thrive_CLI_Exception::MISSING_REQ_VALUE, $arg));
			}

			//if (isset($params[$o->name]))
			if (array_key_exists($o->name, $params))
			{
				if (is_array($params[$o->name]))
				{
					if ($o->isOn(Thrive_CLI_Option::IS_VALUE_ARRAY))
					{
						$o->value = $params[$o->name];
					}
					else
					{
						$o->value = end($params[$o->name]);
					}
				}
				else
				{
					$o->value = $params[$o->name];
				}
				
				unset($params[$o->name]);
			}
		}

		// Make sure the provided parameters are valid.
		if ($strictness == Thrive_CLI_Helper::STRICT_OPTIONS && !empty($params))
		{
			$invalidParams = array_keys($params);
			$invalidOptions = '--' . join(', --', $invalidParams);

			throw new Thrive_CLI_Exception(sprintf(Thrive_CLI_Exception::UNRECOGNIZED_OPTION, $invalidOptions));
		}
	}

	/**
	* @param Thrive_CLI_Option $options
	*/
	protected function cullUnusedOptions(&$options)
	{
		$filterEmptyOptions = create_function('$option', 'return (!empty($option->value));');
		$options = array_filter($options, $filterEmptyOptions);
	}

	protected function convertToArray($options)
	{
		$params = array();
		foreach ($options as /** @var Thrive_CLI_Option **/ $o)
		{
			$params[$o->name] = $o->value;
		}

		return $params;
	}
}
