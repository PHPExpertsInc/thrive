<?php
// This file is a part of the Thrive Framework, a PHPExperts.pro Project.
//
// Copyright (c) 2012 PHP Experts, Inc.
//     Author: Theodore R. Smith (theodore@phpexperts.pro)
//             http://users.phpexperts.pro/tsmith/
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

class Thrive_FileSystemException extends fUnexpectedException {}

class Thrive_FileSystem
{
	public static function ensureFileIsEditable($filename)
	{
		// Make sure the directory exists.
		$dirname = dirname($filename);
		if (!file_exists($dirname))
		{
			throw new Thrive_FileSystemException("The directory $dirname does not exist.");
		}

		// And is writable.
		if (!is_writable($dirname))
		{
			throw new Thrive_FileSystemException("The directory $dirname is not writable.");
		}

		// Make sure the file is writable if it already exists.
		if (file_exists($filename) && is_writable($filename))
		{
			throw new Thrive_FileSystemException("The file $filename exists but is not writable.");
		}
	}
}

