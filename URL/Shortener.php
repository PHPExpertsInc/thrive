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

/**
 * This class creates and handles short URLs.
 *
 * Loosely coupled with fDatabase.
 * Tightly coupled with Thrive_Number, fNumber.
 */

// TODO: Decouple from fDatabase; use Thrive_URL_DirectoryService
class Thrive_URL_Shortener
{
	const URL_KEY_NUMBASE = 62;

	/** @var fDatabase */
	protected $db;

	public function __construct(fDatabase $db)
	{
		$this->db = $db;
	}

	public function createShortUrlKey($longURL)
	{
		// 1. Store the long URL.
		// TODO: Use PHP to create the binary checksum for maximum DB compatibility.
		$sql = <<<SQL
INSERT INTO urls (url, hash) VALUES (%s, UNHEX(SHA(%s)));
SQL;
		$stmt = $this->db->prepare($sql);

		try
		{
			$result = $this->db->query($stmt, $longURL, $longURL);

			// 2. Get the last insert ID.
			$urlId = $result->getAutoIncrementedValue();

			// 3. Get URL key.
			$urlKey = $this->convertUrlIdToKey($urlId);
		}
		catch (fSQLException $e)
		{
			// TODO: File bug report that fSQLException doesnt give a code on duplicate key.
			//if ($e->getCode() == fSQLException::)
			// TODO: Definitely create unit test for this.
			// If there's a duplicate, return the pre-existing short URL.
			if (strpos($e->getMessage(), 'Duplicate entry') !== false)
			{
				$urlKey = $this->findUrlKey($longURL);
			}
		}

		// 4. Build the short URL.
		$urlPath = substr($_SERVER["SCRIPT_URL"], 0, strrpos($_SERVER["SCRIPT_URL"], '/'));
		$miniURL = 'http://' . $_SERVER['HTTP_HOST'] . $urlPath . '/url/' . $urlKey;

		return $miniURL;
	}

	protected function convertUrlIdToKey($urlId)
	{
		$num = new Thrive_Number($urlId);
		$urlKey = $num->convertToBase(self::URL_KEY_NUMBASE);

		return $urlKey;
	}

	/**
	 * @param $urlKey_in string UNTRUSTED [from _GET parameter]
	 */
	public function redirectToLongUrl($urlKey_in)
	{
		$urlKey_s = filter_var($urlKey_in, FILTER_SANITIZE_STRING);
		$longURL = $this->getLongUrl(new Thrive_Number($urlKey_s));

		header('HTTP/1.1 301: Moved Permanently');
		header('Location: ' . $longURL);
		exit;
	}

	/**
	 * @param Thrive_Number $urlKey
	 * @return string
	 * @throws fNoRowsException
	 */
	public function getLongUrl(Thrive_Number $urlKey)
	{
		$urlId = $urlKey->convertFromBase(self::URL_KEY_NUMBASE);
		$sql = <<<SQL
SELECT url FROM urls WHERE id=%s;
SQL;
		$stmt = $this->db->prepare($sql);
		$result = $this->db->query($stmt, $urlId);

		if (!($longURL = $result->fetchScalar()))
		{
			throw new fNoRowsException("No entry for $urlKey");
		}

		return $longURL;
	}

	protected function findUrlKey($longURL)
	{
		$sql = <<<SQL
SELECT id FROM urls WHERE hash=UNHEX(SHA1(%s));
SQL;
		$stmt = $this->db->prepare($sql);
		try
		{
			$result = $this->db->query($stmt, $longURL);
		}
		catch (fSQLException $e)
		{
			return null;
		}

		$urlId = $result->fetchScalar();
		$urlKey = $this->convertUrlIdToKey($urlId);

		return $urlKey;
	}
}
