#!/bin/env php
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
/*
require_once 'BitPrefs.php';
require_once 'CLI/Exception.php';
require_once 'CLI/Helper.php';
require_once 'CLI/Option.php';
require_once 'CLI/OptionFactory.php';
*/

require_once realpath(dirname(__FILE__) . '/../Thrive.php');

Thrive::init();

function showHelp()
{
	print "Thrive's Handle Command Line Arguments in PHP Demo\n";
	print "Copyright (c) Theodore R. Smith <theodore@phpexperts.pro>\n";
	print "Built on the Thrive and Flourish frameworks.\n\n";
	print "Arguments:\n";
	print "   -h or --help\t\tDisplay this help and exit.\n";
	print "   --host <host>\t[Required] Sets the SQL server hostname.\n";
	print "   --user <user>\tSets the SQL server username [default: 'root'].\n";
	print "   --pass <pass>\tSets the SQL server password [default: ''].\n";
	print "   --database <db>\t[Required] Sets the SQL server database.\n";
	print "   --exclude <pattern>\tExclude files matching PATTERN.\n";
	print "   --debug\t\tShow debugging info.\n";
	print "   --verbose [x]\tIncrease verbosity [optionally by X amount].\n";
	print "\n";
	print "\nTry running \n";
	print "  \$ ./handle_cli_args.php --host localhost --database wordpress --exclude a --exclude b --exclude c --host a --user=foo\n";
}

$cli = new Thrive_CLI_Helper;
// Long options are based on PERL's CommandLine_Parse syntax.
$longOpts = array('!host=', 'user=', 'pass=', '!database=', 'filter=', 'verbose:', 'debug', 'exclude@');
try
{
	$params = $cli->getParams($longOpts);
}
catch (Thrive_CLI_Exception $e)
{
	if ($e->getCode() == Thrive_CLI_Exception::HELP_REQUESTED)
	{
		showHelp();
		die(1);
	}
}

print "Value of passed CLI params:\n";
print_r($params);

